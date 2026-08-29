<?php
/**
 * Shared helpers for the coping notes store.
 *
 * Everything lives in data/notes.json, inside the website's own folder. There
 * is no database and no outside service. The data folder is closed off by its
 * own .htaccess, so the file is readable by this PHP code and by nobody else.
 *
 * Each entry looks like:
 *   { "id": "...", "note": "...", "status": "pending"|"approved",
 *     "submitted": "2026-08-30T12:00:00+05:30", "decided": null|"..." }
 */

const DATA_DIR    = __DIR__ . '/data';
const NOTES_FILE  = DATA_DIR . '/notes.json';
const CONFIG_FILE = DATA_DIR . '/config.json';
const LOCK_FILE   = DATA_DIR . '/notes.lock';
const WORD_LIMIT  = 50;
const MAX_CHARS   = 2000;   // hard stop, well above the word limit
const MAX_NOTES   = 5000;   // refuse to grow without bound

/** Makes sure the data folder exists and is protected before anything writes. */
function hs_ensure_storage(): void
{
    if (!is_dir(DATA_DIR)) {
        @mkdir(DATA_DIR, 0755, true);
    }
    // If the folder was created fresh, or .htaccess was lost in an upload,
    // put it back. Without it, unapproved submissions become publicly readable.
    $htaccess = DATA_DIR . '/.htaccess';
    if (!file_exists($htaccess)) {
        @file_put_contents($htaccess, "<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n</IfModule>\n");
    }
    if (!file_exists(NOTES_FILE)) {
        @file_put_contents(NOTES_FILE, "[]");
    }
}

/**
 * Reads every entry.
 *
 * A corrupted or unreadable file returns an empty list rather than throwing.
 * The public page showing "no notes yet" is a far better failure than the
 * whole section erroring out.
 */
function hs_load_notes(): array
{
    hs_ensure_storage();
    $raw = @file_get_contents(NOTES_FILE);
    if ($raw === false || trim($raw) === '') {
        return [];
    }
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return [];
    }
    // Tolerate the older { "notes": [...] } shape as well as a bare array.
    if (isset($data['notes']) && is_array($data['notes'])) {
        $data = $data['notes'];
    }
    return array_values(array_filter($data, static function ($e) {
        return is_array($e) && isset($e['note']) && is_string($e['note']);
    }));
}

/**
 * Writes every entry back.
 *
 * Writes to a temporary file and renames it into place. A rename is atomic on
 * the same filesystem, so a visitor reading the file mid-write can never catch
 * it half written. The lock stops two submissions arriving at the same instant
 * from overwriting each other.
 */
function hs_save_notes(array $notes): bool
{
    hs_ensure_storage();

    /* The lock is taken on a separate file, never on notes.json itself.
       Windows refuses to rename over a file that has an open handle, so
       locking the data file and then renaming onto it fails with "Access is
       denied". Linux allows it, which is worse: the bug would hide in
       production and only appear on a Windows machine. */
    $lock = @fopen(LOCK_FILE, 'c');
    if ($lock === false) {
        return false;
    }
    if (!flock($lock, LOCK_EX)) {
        fclose($lock);
        return false;
    }

    $json = json_encode(
        array_values($notes),
        JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );

    /* Every file call is silenced. These endpoints answer in JSON, and a PHP
       warning printed mid-response both corrupts the JSON and sends headers
       early, which stops the error status being set at all. Failures are
       reported through the return value instead. */
    $ok = false;
    if ($json !== false) {
        $tmp = NOTES_FILE . '.tmp';
        if (@file_put_contents($tmp, $json) !== false) {
            $ok = @rename($tmp, NOTES_FILE);
            if (!$ok) {
                @unlink($tmp);
            }
        }
    }

    flock($lock, LOCK_UN);
    fclose($lock);
    return $ok;
}

/** Just the approved ones, newest first. This is all the public page ever sees. */
function hs_approved_notes(): array
{
    $approved = array_filter(hs_load_notes(), static function ($e) {
        return ($e['status'] ?? '') === 'approved';
    });
    usort($approved, static function ($a, $b) {
        return strcmp($b['decided'] ?? '', $a['decided'] ?? '');
    });
    return array_values($approved);
}

function hs_count_words(string $s): int
{
    $s = trim($s);
    if ($s === '') {
        return 0;
    }
    return count(preg_split('/\s+/u', $s));
}

function hs_new_id(): string
{
    return bin2hex(random_bytes(8));
}

function hs_now(): string
{
    return (new DateTimeImmutable('now', new DateTimeZone('Asia/Kolkata')))->format('c');
}

/* ---------------------------------------------------------------------------
   Admin password
   ---------------------------------------------------------------------------
   Stored as a bcrypt hash, never as the password itself. Even someone who got
   hold of config.json could not read the password back out of it.
   --------------------------------------------------------------------------- */

function hs_config(): array
{
    hs_ensure_storage();
    if (!file_exists(CONFIG_FILE)) {
        return [];
    }
    $data = json_decode((string) @file_get_contents(CONFIG_FILE), true);
    return is_array($data) ? $data : [];
}

function hs_has_password(): bool
{
    $c = hs_config();
    return !empty($c['password_hash']);
}

function hs_set_password(string $plain): bool
{
    hs_ensure_storage();
    $config = hs_config();
    $config['password_hash'] = password_hash($plain, PASSWORD_DEFAULT);
    $config['set_at'] = hs_now();
    return @file_put_contents(
        CONFIG_FILE,
        json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    ) !== false;
}

function hs_check_password(string $plain): bool
{
    $c = hs_config();
    if (empty($c['password_hash'])) {
        return false;
    }
    return password_verify($plain, $c['password_hash']);
}

/* ---------------------------------------------------------------------------
   "I can relate" counts
   ---------------------------------------------------------------------------
   The tally lives on the server, in the same notes.json, because it has to add
   up across everyone who visits. Whether a particular person has already
   ticked a note is a different question and is kept in their own browser: it
   is a courtesy to them, not a control, and there is no way to enforce it
   without asking people to identify themselves, which this space refuses to
   do on purpose.
   --------------------------------------------------------------------------- */

/** Adds one to a note's tally. Approved notes only: an unpublished note is not
 *  visible to anyone, so a vote on it could only be forged. */
function hs_add_relate(string $id): ?int
{
    $notes = hs_load_notes();
    foreach ($notes as $i => $entry) {
        if (($entry['id'] ?? '') !== $id) {
            continue;
        }
        if (($entry['status'] ?? '') !== 'approved') {
            return null;
        }
        $count = (int) ($entry['relates'] ?? 0) + 1;
        $notes[$i]['relates'] = $count;
        return hs_save_notes($notes) ? $count : null;
    }
    return null;
}

/** Approved notes, most related to least. Notes nobody has ticked yet are
 *  shuffled rather than left in submission order, so an unticked note is not
 *  permanently buried at the bottom by the accident of when it arrived. */
function hs_ranked_notes(): array
{
    $approved = array_filter(hs_load_notes(), static fn($e) => ($e['status'] ?? '') === 'approved');

    $rated = [];
    $unrated = [];
    foreach ($approved as $e) {
        if ((int) ($e['relates'] ?? 0) > 0) { $rated[] = $e; } else { $unrated[] = $e; }
    }

    usort($rated, static fn($a, $b) => ((int) $b['relates']) <=> ((int) $a['relates']));
    shuffle($unrated);

    return array_merge($rated, $unrated);
}

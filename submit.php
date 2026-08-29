<?php
/**
 * Public endpoint. Receives one note and stores it as pending.
 *
 * Nothing this file writes is ever visible to anybody but Harshita until she
 * approves it in admin.php. There is no path from here to the public page.
 */
require __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');

function hs_fail(string $message, int $code = 400): void
{
    http_response_code($code);
    echo json_encode(['ok' => false, 'error' => $message]);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    hs_fail('Method not allowed', 405);
}

/* A hidden field that people never see and never fill in. Bots fill in every
   field they find, so anything arriving with this set is discarded. It answers
   with success on purpose: telling a bot it failed just invites a retry. */
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    echo json_encode(['ok' => true]);
    exit;
}

$note = trim((string) ($_POST['note'] ?? ''));

if ($note === '') {
    hs_fail('Please write something before sharing.');
}
if (mb_strlen($note) > MAX_CHARS) {
    hs_fail('That is longer than this space can take.');
}
if (hs_count_words($note) > WORD_LIMIT) {
    hs_fail('Please keep it to ' . WORD_LIMIT . ' words or fewer.');
}
if (empty($_POST['consent'])) {
    hs_fail('Please tick the box to say you are happy for this to be published.');
}

/* Control characters serve no purpose in a handwritten note and are a common
   way of smuggling something past a reader who is skimming. Line breaks stay. */
$note = preg_replace('/[^\P{C}\n]+/u', '', $note);
$note = preg_replace('/\n{3,}/', "\n\n", $note);
$note = trim($note);

if ($note === '') {
    hs_fail('Please write something before sharing.');
}

$notes = hs_load_notes();

if (count($notes) >= MAX_NOTES) {
    hs_fail('This space is not accepting new notes just now.', 503);
}

/* Two identical notes in quick succession is almost always a double click or a
   refresh, not two people. Accept it quietly rather than storing it twice. */
foreach (array_slice($notes, -25) as $existing) {
    if (($existing['note'] ?? '') === $note) {
        echo json_encode(['ok' => true]);
        exit;
    }
}

$notes[] = [
    'id'        => hs_new_id(),
    'note'      => $note,
    'status'    => 'pending',
    'submitted' => hs_now(),
    'decided'   => null,
];

if (!hs_save_notes($notes)) {
    hs_fail('That could not be saved just now. Please try again in a moment.', 500);
}

echo json_encode(['ok' => true]);

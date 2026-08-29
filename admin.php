<?php
/**
 * Admin: read submissions, approve, edit, delete.
 *
 * The password check happens here, on the server, before any note text is put
 * into the page. That is the difference between this and every "hide it with
 * JavaScript" approach: someone viewing the page source without logging in
 * gets the login form and nothing else, because nothing else was ever sent.
 */
require __DIR__ . '/lib.php';

session_start();

/* ---------- setup: first visit, no password yet ---------- */
$setup_error = '';
if (!hs_has_password()) {
    if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['new_password'])) {
        $p1 = (string) $_POST['new_password'];
        $p2 = (string) ($_POST['confirm_password'] ?? '');
        if (mb_strlen($p1) < 10) {
            $setup_error = 'Please use at least 10 characters.';
        } elseif ($p1 !== $p2) {
            $setup_error = 'The two passwords do not match.';
        } elseif (!hs_set_password($p1)) {
            $setup_error = 'The password could not be saved. Check the data folder is writable.';
        } else {
            $_SESSION['hs_admin'] = true;
            $_SESSION['hs_token'] = bin2hex(random_bytes(16));
            header('Location: admin.php');
            exit;
        }
    }
    hs_render_setup($setup_error);
    exit;
}

/* ---------- login ---------- */
$login_error = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['password'])) {
    if (hs_check_password((string) $_POST['password'])) {
        // A fresh session id on login, so a session id captured beforehand
        // cannot be reused afterwards.
        session_regenerate_id(true);
        $_SESSION['hs_admin'] = true;
        $_SESSION['hs_token'] = bin2hex(random_bytes(16));
        header('Location: admin.php');
        exit;
    }
    // Slows down anyone trying passwords one after another.
    sleep(1);
    $login_error = 'That password was not right.';
}

if (isset($_GET['logout'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: admin.php');
    exit;
}

if (empty($_SESSION['hs_admin'])) {
    hs_render_login($login_error);
    exit;
}

/* ---------- actions, all requiring the session token ---------- */
$flash = '';
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
    // Without this check, another site could make your browser fire off an
    // approve or a delete while you happen to be logged in here.
    if (!hash_equals($_SESSION['hs_token'] ?? '', (string) ($_POST['token'] ?? ''))) {
        $flash = 'That request could not be verified. Please try again.';
    } else {
        $id     = (string) ($_POST['id'] ?? '');
        $action = (string) $_POST['action'];
        $notes  = hs_load_notes();
        $found  = false;

        foreach ($notes as $i => $entry) {
            if (($entry['id'] ?? '') !== $id) {
                continue;
            }
            $found = true;

            if ($action === 'approve') {
                $notes[$i]['status']  = 'approved';
                $notes[$i]['decided'] = hs_now();
                $flash = 'Published.';
            } elseif ($action === 'unpublish') {
                $notes[$i]['status']  = 'pending';
                $notes[$i]['decided'] = null;
                $flash = 'Taken off the site and put back in the queue.';
            } elseif ($action === 'delete') {
                // Gone for good, as asked: removed from the file, not flagged.
                array_splice($notes, $i, 1);
                $flash = 'Deleted permanently.';
            } elseif ($action === 'edit') {
                $text = trim((string) ($_POST['note'] ?? ''));
                if ($text === '') {
                    $flash = 'A note cannot be empty.';
                    $found = false;
                } elseif (hs_count_words($text) > WORD_LIMIT) {
                    $flash = 'That is over the ' . WORD_LIMIT . ' word limit.';
                    $found = false;
                } else {
                    $notes[$i]['note'] = $text;
                    $flash = 'Saved.';
                }
            }
            break;
        }

        if ($found && !hs_save_notes($notes)) {
            $flash = 'That could not be saved. Check the data folder is writable.';
        }
    }
}

$all      = hs_load_notes();
$pending  = array_values(array_filter($all, fn($e) => ($e['status'] ?? '') !== 'approved'));
$approved = array_values(array_filter($all, fn($e) => ($e['status'] ?? '') === 'approved'));
$token    = $_SESSION['hs_token'] ?? '';

hs_render_admin($pending, $approved, $token, $flash);


/* =====================================================================
   Rendering. Kept at the bottom so the logic above reads in order.
   Every piece of note text goes through htmlspecialchars on the way out.
   ===================================================================== */

function hs_head(string $title): void
{
    ?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?= htmlspecialchars($title) ?></title>
<meta name="robots" content="noindex, nofollow" />
<link rel="icon" type="image/png" href="assets/logo.png" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
<style>
  :root {
    --deep-purple:#5B2E6B; --purple:#7A4D8F; --purple-soft:#B295C4;
    --rose:#D96A9C; --rose-soft:#F2C5D5; --cream:#F8F1E4; --cream-warm:#FDFAF2;
    --charcoal:#2B1E2F; --charcoal-soft:#4A3C50; --muted:#8A7E90; --line:rgba(91,46,107,0.14);
    --font-display:'Cormorant Garamond',Georgia,serif; --font-body:'Inter',system-ui,sans-serif;
    --ease:cubic-bezier(0.25,0.46,0.45,0.94);
  }
  *,*::before,*::after{box-sizing:border-box;}
  body{margin:0;font-family:var(--font-body);font-size:16px;line-height:1.65;color:var(--charcoal);background:var(--cream);-webkit-font-smoothing:antialiased;}
  .wrap{width:100%;max-width:860px;margin:0 auto;padding:0 1.25rem;}
  h1,h2{font-family:var(--font-display);font-weight:500;line-height:1.15;margin:0;color:var(--deep-purple);}
  p{margin:0 0 1em;}
  a{color:var(--deep-purple);}
  header.page-head{padding:3rem 0 1.5rem;}
  .eyebrow{font-family:var(--font-display);font-style:italic;color:var(--rose);font-size:1.05rem;display:block;margin-bottom:0.6rem;}
  header.page-head h1{font-size:clamp(1.9rem,5vw,2.7rem);}
  .topbar{display:flex;justify-content:space-between;align-items:center;gap:1rem;flex-wrap:wrap;padding-bottom:1.5rem;border-bottom:1px solid var(--line);margin-bottom:2rem;}
  section{padding:0 0 3rem;}
  h2.sec{font-size:1.4rem;margin-bottom:0.25rem;}
  .sec-sub{font-size:0.85rem;color:var(--muted);font-style:italic;margin-bottom:1.4rem;}
  .pill{display:inline-block;margin-left:0.55rem;background:var(--rose-soft);color:var(--deep-purple);border-radius:999px;padding:0.1rem 0.65rem;font-size:0.78rem;font-weight:600;vertical-align:middle;}
  .queue{display:grid;gap:1rem;}
  .item{background:var(--cream-warm);border:1px solid var(--line);border-left:3px solid var(--purple-soft);border-radius:14px;padding:1.25rem 1.35rem;}
  .item.live{border-left-color:var(--rose-soft);}
  .item .txt{font-family:var(--font-display);font-style:italic;font-size:1.05rem;line-height:1.75;color:var(--charcoal-soft);margin:0 0 0.8rem;white-space:pre-wrap;}
  .meta{font-size:0.74rem;color:var(--muted);margin-bottom:0.85rem;}
  .acts{display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;}
  .btn{display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1.05rem;font-family:var(--font-body);font-size:0.84rem;font-weight:500;border-radius:999px;border:1px solid transparent;cursor:pointer;transition:background .35s var(--ease),color .35s var(--ease),border-color .35s var(--ease);}
  .btn-primary{background:var(--deep-purple);color:var(--cream-warm);}
  .btn-primary:hover{background:var(--purple);}
  .btn-quiet{background:transparent;color:var(--muted);border-color:var(--line);}
  .btn-quiet:hover{color:var(--deep-purple);border-color:var(--purple-soft);}
  .btn-danger{background:transparent;color:var(--rose);border-color:var(--rose-soft);}
  .btn-danger:hover{background:var(--rose);color:var(--cream-warm);}
  .empty{font-size:0.9rem;color:var(--muted);font-style:italic;}
  form.inline{display:inline;}
  textarea{width:100%;min-height:110px;font-family:var(--font-body);font-size:0.95rem;line-height:1.7;color:var(--charcoal);background:#fff;border:1px solid var(--line);border-radius:12px;padding:0.85rem 1rem;resize:vertical;}
  textarea:focus{outline:none;border-color:var(--purple-soft);box-shadow:0 0 0 4px rgba(122,77,143,0.09);}
  .flash{background:var(--cream-warm);border:1px solid var(--purple-soft);border-radius:12px;padding:0.8rem 1.1rem;margin-bottom:1.75rem;font-size:0.9rem;color:var(--deep-purple);}
  .card{max-width:430px;margin:4.5rem auto;background:var(--cream-warm);border:1px solid var(--line);border-radius:18px;padding:2.25rem 2rem;}
  .card h1{font-size:1.75rem;margin-bottom:0.5rem;}
  .card p{font-size:0.9rem;color:var(--charcoal-soft);}
  label{display:block;font-size:0.85rem;font-weight:500;margin:1.1rem 0 0.4rem;}
  input[type=password]{width:100%;font-family:var(--font-body);font-size:0.95rem;padding:0.7rem 0.9rem;border:1px solid var(--line);border-radius:10px;background:#fff;color:var(--charcoal);}
  input[type=password]:focus{outline:none;border-color:var(--purple-soft);box-shadow:0 0 0 4px rgba(122,77,143,0.09);}
  .err{color:var(--rose);font-size:0.85rem;margin-top:0.9rem;}
  .full{width:100%;justify-content:center;margin-top:1.4rem;padding:0.75rem 1rem;font-size:0.92rem;}
</style>
</head>
<body>
<?php }

function hs_render_setup(string $error): void
{
    hs_head('Set your admin password');
    ?>
  <div class="card">
    <h1>Set your password</h1>
    <p>This is the first time this page has been opened, so there is no password yet. Choose one now. It is stored scrambled, so nobody can read it back out, including me.</p>
    <form method="post">
      <label for="p1">New password</label>
      <input type="password" id="p1" name="new_password" required minlength="10" autocomplete="new-password" />
      <label for="p2">Type it again</label>
      <input type="password" id="p2" name="confirm_password" required minlength="10" autocomplete="new-password" />
      <?php if ($error !== ''): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
      <button type="submit" class="btn btn-primary full">Save password</button>
    </form>
    <p style="margin-top:1.5rem;font-size:0.8rem;color:var(--muted);">At least 10 characters. Do not reuse a password you use elsewhere.</p>
  </div>
</body></html>
    <?php
}

function hs_render_login(string $error): void
{
    hs_head('Admin');
    ?>
  <div class="card">
    <h1>Admin</h1>
    <p>Sign in to read and moderate submissions.</p>
    <form method="post">
      <label for="pw">Password</label>
      <input type="password" id="pw" name="password" required autocomplete="current-password" autofocus />
      <?php if ($error !== ''): ?><p class="err"><?= htmlspecialchars($error) ?></p><?php endif; ?>
      <button type="submit" class="btn btn-primary full">Sign in</button>
    </form>
  </div>
</body></html>
    <?php
}

function hs_render_admin(array $pending, array $approved, string $token, string $flash): void
{
    hs_head('Submissions');
    ?>
  <header class="page-head">
    <div class="wrap">
      <span class="eyebrow">Admin only</span>
      <h1>Shared ways of coping</h1>
    </div>
  </header>

  <div class="wrap">
    <div class="topbar">
      <span style="font-size:0.85rem;color:var(--muted);">Signed in</span>
      <a class="btn btn-quiet" href="admin.php?logout=1">Sign out</a>
    </div>

    <?php if ($flash !== ''): ?>
      <div class="flash"><?= htmlspecialchars($flash) ?></div>
    <?php endif; ?>
  </div>

  <section>
    <div class="wrap">
      <h2 class="sec">Waiting for you <span class="pill"><?= count($pending) ?></span></h2>
      <p class="sec-sub">Only you can see these. Nothing here is on the website.</p>
      <?php if (!$pending): ?>
        <p class="empty">Nothing waiting.</p>
      <?php else: ?>
        <div class="queue">
        <?php foreach (array_reverse($pending) as $e): ?>
          <div class="item">
            <p class="txt"><?= htmlspecialchars($e['note']) ?></p>
            <div class="meta">Submitted <?= htmlspecialchars(hs_pretty($e['submitted'] ?? '')) ?></div>
            <div class="acts">
              <?= hs_action_button($token, $e['id'], 'approve', 'Approve and publish', 'btn-primary') ?>
              <?= hs_action_button($token, $e['id'], 'delete', 'Delete permanently', 'btn-danger', 'Delete this permanently? It cannot be recovered.') ?>
              <button type="button" class="btn btn-quiet" onclick="hsEdit('<?= htmlspecialchars($e['id']) ?>')">Edit</button>
            </div>
            <?= hs_edit_form($token, $e) ?>
          </div>
        <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

  <section>
    <div class="wrap">
      <h2 class="sec">On the website <span class="pill"><?= count($approved) ?></span></h2>
      <p class="sec-sub">These are live and visible to everyone.</p>
      <?php if (!$approved): ?>
        <p class="empty">Nothing published yet.</p>
      <?php else: ?>
        <div class="queue">
        <?php foreach (array_reverse($approved) as $e): ?>
          <div class="item live">
            <p class="txt"><?= htmlspecialchars($e['note']) ?></p>
            <div class="meta">Published <?= htmlspecialchars(hs_pretty($e['decided'] ?? '')) ?></div>
            <div class="acts">
              <?= hs_action_button($token, $e['id'], 'unpublish', 'Take off the site', 'btn-quiet') ?>
              <?= hs_action_button($token, $e['id'], 'delete', 'Delete permanently', 'btn-danger', 'Delete this permanently? It cannot be recovered.') ?>
              <button type="button" class="btn btn-quiet" onclick="hsEdit('<?= htmlspecialchars($e['id']) ?>')">Edit</button>
            </div>
            <?= hs_edit_form($token, $e) ?>
          </div>
        <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>

<script>
  function hsEdit(id) {
    var f = document.getElementById('edit-' + id);
    if (f) { f.hidden = !f.hidden; if (!f.hidden) f.querySelector('textarea').focus(); }
  }
</script>
</body></html>
    <?php
}

function hs_action_button(string $token, string $id, string $action, string $label, string $class, string $confirm = ''): string
{
    $onsubmit = $confirm !== ''
        ? ' onsubmit="return confirm(' . htmlspecialchars(json_encode($confirm), ENT_QUOTES) . ')"'
        : '';
    return '<form method="post" class="inline"' . $onsubmit . '>'
        . '<input type="hidden" name="token" value="' . htmlspecialchars($token) . '" />'
        . '<input type="hidden" name="id" value="' . htmlspecialchars($id) . '" />'
        . '<input type="hidden" name="action" value="' . htmlspecialchars($action) . '" />'
        . '<button type="submit" class="btn ' . htmlspecialchars($class) . '">' . htmlspecialchars($label) . '</button>'
        . '</form>';
}

function hs_edit_form(string $token, array $e): string
{
    return '<form method="post" id="edit-' . htmlspecialchars($e['id']) . '" hidden style="margin-top:1rem;">'
        . '<input type="hidden" name="token" value="' . htmlspecialchars($token) . '" />'
        . '<input type="hidden" name="id" value="' . htmlspecialchars($e['id']) . '" />'
        . '<input type="hidden" name="action" value="edit" />'
        . '<textarea name="note">' . htmlspecialchars($e['note']) . '</textarea>'
        . '<div class="acts" style="margin-top:0.7rem;">'
        . '<button type="submit" class="btn btn-primary">Save changes</button>'
        . '</div></form>';
}

function hs_pretty(string $iso): string
{
    if ($iso === '') {
        return 'date unknown';
    }
    try {
        return (new DateTimeImmutable($iso))->format('j M Y, g:ia');
    } catch (Exception $ex) {
        return 'date unknown';
    }
}

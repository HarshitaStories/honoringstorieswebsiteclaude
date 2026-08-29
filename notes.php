<?php
/**
 * Public endpoint. Returns approved notes only, as JSON.
 *
 * This is the only route by which note text reaches the outside world, and it
 * filters to status === "approved" before anything leaves. Unapproved
 * submissions live in the same file but never pass through here.
 */
require __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');
// The list changes whenever Harshita approves something or somebody ticks a
// note, and a stale cache would make either look as though it had not worked.
header('Cache-Control: no-store, must-revalidate');

$notes = array_map(static function ($e) {
    /* Deliberately narrow.

       The id is sent because a visitor's browser needs it to remember which
       notes they have already ticked. It is a random string and says nothing
       about who wrote the note or when.

       The relate count is NOT sent. It decides the order these arrive in, and
       that ordering is done here, on the server. Sending the number as well
       would put a running tally of other people's agreement beside something
       somebody wrote about a hard day, which turns a quiet gesture into a
       score. It also keeps the tallies from being read straight off the page.

       The submission time is withheld for the reason it always was: on an
       anonymous wall, knowing exactly when something was written is a small
       identifying detail that serves no purpose. */
    return [
        'id'   => $e['id'] ?? '',
        'note' => $e['note'],
    ];
}, hs_ranked_notes());

echo json_encode($notes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

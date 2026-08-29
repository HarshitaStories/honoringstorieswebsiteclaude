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
    /* Deliberately narrow. The id is needed so a visitor's browser can remember
       which notes they have already ticked, and it is a random string that says
       nothing about who wrote the note or when. The submission time is not sent
       at all: on an anonymous wall, knowing exactly when something was written
       is a small identifying detail and serves no purpose here. */
    return [
        'id'      => $e['id'] ?? '',
        'note'    => $e['note'],
        'relates' => (int) ($e['relates'] ?? 0),
    ];
}, hs_ranked_notes());

echo json_encode($notes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

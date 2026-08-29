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
// The approved list changes only when Harshita approves something, but a stale
// cache would make an approval look like it had not worked.
header('Cache-Control: no-store, must-revalidate');

$notes = array_map(static function ($e) {
    // Deliberately narrow: the public gets the words and nothing else. No id,
    // no timestamp, no status. Anonymity is the whole point of this section,
    // and a submission time is a small identifying detail.
    return ['note' => $e['note']];
}, hs_approved_notes());

echo json_encode($notes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

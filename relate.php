<?php
/**
 * Public endpoint. Adds one to a note's "I can relate" tally.
 *
 * There is no authentication, by design: this space does not ask anyone to
 * identify themselves. That means the count is a warm signal rather than a
 * measurement, and it is deliberately not presented as anything more than that.
 * A visitor's browser remembers which notes they have ticked so the button
 * behaves properly for them, but nothing here can prove it.
 */
require __DIR__ . '/lib.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}

$id = trim((string) ($_POST['id'] ?? ''));

// Ids are 16 hex characters. Checking the shape first keeps anything strange
// away from the store entirely.
if (!preg_match('/^[0-9a-f]{16}$/', $id)) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => 'Unknown note']);
    exit;
}

$count = hs_add_relate($id);

if ($count === null) {
    http_response_code(404);
    echo json_encode(['ok' => false, 'error' => 'Unknown note']);
    exit;
}

echo json_encode(['ok' => true, 'relates' => $count]);

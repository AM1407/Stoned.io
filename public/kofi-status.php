<?php
/**
 * Ko-fi payment status check (AJAX endpoint).
 * Called by order-confirmation.php polling JS.
 * Returns {"paid": true/false}.
 */
session_start();
header('Content-Type: application/json');

define('PAID_ORDERS_FILE', __DIR__ . '/../src/paid_orders.json');

$order = $_SESSION['last_order'] ?? null;
if (!$order) {
    echo json_encode(['paid' => false, 'reason' => 'no_session']);
    exit;
}

$email = strtolower(trim($order['email'] ?? ''));
if (!$email) {
    echo json_encode(['paid' => false, 'reason' => 'no_email']);
    exit;
}

if (!file_exists(PAID_ORDERS_FILE)) {
    echo json_encode(['paid' => false]);
    exit;
}

$records = json_decode(file_get_contents(PAID_ORDERS_FILE), true) ?: [];
$paid    = isset($records[$email]) && count($records[$email]) > 0;

echo json_encode(['paid' => $paid]);

<?php
/**
 * Ko-fi Webhook Handler
 *
 * Set this URL in Ko-fi → Settings → API → Webhook URL:
 *   https://yourdomain.com/public/kofi-webhook.php
 *
 * The verification token is loaded from ../.env (never commit real tokens).
 * See .env.example for the required variables.
 */

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$dotenv->required('KOFI_VERIFICATION_TOKEN');

define('KOFI_VERIFICATION_TOKEN', $_ENV['KOFI_VERIFICATION_TOKEN']);
define('PAID_ORDERS_FILE', __DIR__ . '/../src/paid_orders.json');

header('Content-Type: application/json');

// Ko-fi sends a POST with a URL-encoded field called "data" containing JSON
$raw = $_POST['data'] ?? '';
if (!$raw) {
    http_response_code(400);
    echo json_encode(['error' => 'No data received']);
    exit;
}

$payload = json_decode($raw, true);
if (!$payload) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

// Verify the token matches — this proves the request is genuinely from Ko-fi
if (($payload['verification_token'] ?? '') !== KOFI_VERIFICATION_TOKEN) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid verification token']);
    exit;
}

// We only care about shop orders (not donations/subscriptions)
$type  = $payload['type'] ?? '';
$email = strtolower(trim($payload['email'] ?? ''));
$txnId = $payload['kofi_transaction_id'] ?? uniqid('kofi_', true);
$amount = $payload['amount'] ?? '0';

if (!$email) {
    http_response_code(400);
    echo json_encode(['error' => 'No email in payload']);
    exit;
}

// Load existing payment records
$records = [];
if (file_exists(PAID_ORDERS_FILE)) {
    $content = file_get_contents(PAID_ORDERS_FILE);
    $records = json_decode($content, true) ?: [];
}

// Record payment keyed by email (append if multiple purchases)
if (!isset($records[$email])) {
    $records[$email] = [];
}
$records[$email][] = [
    'kofi_transaction_id' => $txnId,
    'type'                => $type,
    'amount'              => $amount,
    'paid_at'             => date('Y-m-d H:i:s'),
];

file_put_contents(PAID_ORDERS_FILE, json_encode($records, JSON_PRETTY_PRINT), LOCK_EX);

http_response_code(200);
echo json_encode(['status' => 'ok', 'email' => $email]);

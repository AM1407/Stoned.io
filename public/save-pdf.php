<?php
/**
 * save-pdf.php — Stoned.io
 *
 * Accepts one PDF at a time (as a base64 data URI) and saves it to
 * storage/pdfs/{orderRef}/ outside the web root.  Called by the
 * order-confirmation page for each generated PDF before the email
 * is dispatched.
 *
 * Expected JSON body:
 *   { "orderRef": "ORD-XXXXXXXX", "filename": "rock-doc-my-rock.pdf", "data": "data:application/pdf;base64,..." }
 */

ob_start();

session_start();

header('Content-Type: application/json');

function jsonOut(bool $ok, string $message): void
{
    ob_clean();
    echo json_encode(['ok' => $ok, 'message' => $message]);
    exit;
}

// ── Method guard ───────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonOut(false, 'Method not allowed');
}

// ── Session guard ──────────────────────────────────────────────────
if (empty($_SESSION['last_order'])) {
    jsonOut(false, 'No active order in session');
}

// ── Parse body ─────────────────────────────────────────────────────
$raw  = file_get_contents('php://input');
$body = json_decode($raw, true);
if (!is_array($body)) {
    jsonOut(false, 'Invalid JSON body');
}

$orderRef = $body['orderRef'] ?? '';
$filename = $body['filename'] ?? '';
$dataUrl  = $body['data']     ?? '';

// ── Validate orderRef matches the session ─────────────────────────
$sessionRef = $_SESSION['last_order']['ref'] ?? '';
if (!$orderRef || $orderRef !== $sessionRef) {
    jsonOut(false, 'Order ref mismatch');
}

// ── Sanitize inputs ───────────────────────────────────────────────
// Allow only alphanumeric, dash, underscore in both names
$safeRef      = preg_replace('/[^a-zA-Z0-9\-_]/', '', $orderRef);
$safeFilename = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $filename);

if (!$safeRef || !$safeFilename || !str_ends_with(strtolower($safeFilename), '.pdf')) {
    jsonOut(false, 'Invalid filename');
}

// ── Decode PDF ────────────────────────────────────────────────────
$prefix = 'data:application/pdf;base64,';
if (strncmp($dataUrl, $prefix, strlen($prefix)) !== 0) {
    jsonOut(false, 'Invalid data URI — must be a PDF data URL');
}

$binary = base64_decode(substr($dataUrl, strlen($prefix)), true);
if ($binary === false || strlen($binary) < 5) {
    jsonOut(false, 'Base64 decode failed');
}

// ── Save to storage (outside web root) ───────────────────────────
$storageDir = __DIR__ . '/../storage/pdfs/' . $safeRef;
if (!is_dir($storageDir) && !mkdir($storageDir, 0750, true)) {
    jsonOut(false, 'Could not create storage directory');
}

$dest = $storageDir . '/' . $safeFilename;
if (file_put_contents($dest, $binary) === false) {
    jsonOut(false, 'Could not write file');
}

jsonOut(true, 'saved');

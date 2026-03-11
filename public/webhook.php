<?php
/**
 * Stripe Webhook Handler — Stoned.io
 *
 * Handles Stripe webhook events for payment processing integration.
 * Since this shop doesn't use a database, we'll use file-based storage
 * to track webhook events and integrate with the existing session-based order system.
 */

function generateSafeFilename($identifier) {
    // Use hash-based filenames to prevent path traversal
    return md5($identifier . '_' . microtime(true)) . '.json';
}

session_start();
require __DIR__ . '/../vendor/autoload.php';

// ── Load environment variables ───────────────────────────────────
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$dotenv->required(['STRIPE_WEBHOOK_SECRET']);

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY'] ?? '');

$endpoint_secret = $_ENV['STRIPE_WEBHOOK_SECRET'];

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';
$event = null;

// ── Webhook signature verification ─────────────────────────────
try {
    $event = \Stripe\Webhook::constructEvent(
        $payload, $sig_header, $endpoint_secret
    );
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    error_log('Stripe webhook error: Invalid payload - ' . $e->getMessage());
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    error_log('Stripe webhook error: Invalid signature - ' . $e->getMessage());
    http_response_code(400);
    exit();
}

// ── Event handling ─────────────────────────────────────────────
error_log('Stripe webhook received: ' . $event->type);

switch ($event->type) {
    case 'checkout.session.completed':
        handleCheckoutSessionCompleted($event->data->object);
        break;
    
    case 'checkout.session.async_payment_succeeded':
        handleAsyncPaymentSucceeded($event->data->object);
        break;
        
    case 'payment_intent.succeeded':
        handlePaymentIntentSucceeded($event->data->object);
        break;
        
    case 'charge.succeeded':
        handleChargeSucceeded($event->data->object);
        break;
        
    default:
        // Handle other event types if needed
        error_log('Stripe webhook: Unhandled event type - ' . $event->type);
        break;
}

http_response_code(200);

// ── Event handler functions ─────────────────────────────────────

function handleCheckoutSessionCompleted($session) {
    $orderRef = $session->metadata->order_ref ?? '';
    $customerEmail = $session->customer_details->email ?? '';
    $sessionId = $session->id;
    $paymentStatus = $session->payment_status;
    
    // Log the event for debugging
    error_log("Checkout session completed - Order: $orderRef, Status: $paymentStatus, Email: $customerEmail");
    
    // Store webhook event for future reference
    storeWebhookEvent($sessionId, 'checkout.session.completed', [
        'order_ref' => $orderRef,
        'customer_email' => $customerEmail,
        'payment_status' => $paymentStatus,
        'amount_total' => $session->amount_total,
        'currency' => $session->currency
    ]);
    
    // If payment was successful, mark the order as paid
    if ($paymentStatus === 'paid') {
        markOrderAsPaid($orderRef, $sessionId);
    }
}

function handleAsyncPaymentSucceeded($session) {
    $orderRef = $session->metadata->order_ref ?? '';
    
    // Mark the order as paid for async payments
    markOrderAsPaid($orderRef, $session->id);
    
    error_log("Async payment succeeded - Order: $orderRef");
}

function handlePaymentIntentSucceeded($paymentIntent) {
    // Log payment intent success for debugging
    error_log("Payment intent succeeded - ID: " . $paymentIntent->id);
}

function handleChargeSucceeded($charge) {
    // Log charge success for debugging
    error_log("Charge succeeded - ID: " . $charge->id);
}

function storeWebhookEvent($sessionId, $eventType, $data) {
    $storageDir = __DIR__ . '/../storage/webhooks';
    
    // Validate Stripe session ID format
    if (!preg_match('/^cs_[a-zA-Z0-9_]+$/', $sessionId)) {
        error_log("Invalid Stripe session ID format: $sessionId");
        return;
    }
    
    // Generate safe filename
    $safeFilename = generateSafeFilename($sessionId);
    
    // Ensure storage directory exists
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0750, true);
    }
    
    $filename = $storageDir . '/' . $safeFilename;
    
    $webhookData = [
        'timestamp' => time(),
        'event_type' => $eventType,
        'session_id' => $sessionId,
        'data' => $data,
        'filename' => $safeFilename
    ];
    
    file_put_contents($filename, json_encode($webhookData, JSON_PRETTY_PRINT));
}

function markOrderAsPaid($orderRef, $sessionId) {
    // Since we don't have a database, we'll create a paid orders file
    $storageDir = __DIR__ . '/../storage/orders';
    
    // Validate order reference format
    if (!preg_match('/^ORD-[A-Z0-9]{8}$/', $orderRef)) {
        error_log("Invalid order reference format: $orderRef");
        return;
    }
    
    // Validate Stripe session ID format
    if (!preg_match('/^cs_[a-zA-Z0-9_]+$/', $sessionId)) {
        error_log("Invalid Stripe session ID format: $sessionId");
        return;
    }
    
    // Generate safe filename
    $safeFilename = generateSafeFilename($orderRef . '_' . $sessionId);
    
    // Ensure storage directory exists
    if (!is_dir($storageDir)) {
        mkdir($storageDir, 0750, true);
    }
    
    $filename = $storageDir . '/' . $safeFilename;
    
    $orderData = [
        'order_ref' => $orderRef,
        'stripe_session_id' => $sessionId,
        'paid_at' => date('Y-m-d H:i:s'),
        'status' => 'paid',
        'filename' => $safeFilename
    ];
    
    file_put_contents($filename, json_encode($orderData, JSON_PRETTY_PRINT));
    
    error_log("Order marked as paid: $orderRef");
}
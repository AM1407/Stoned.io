<?php
ini_set('display_errors', 1); error_reporting(E_ALL);
/**
 * Stripe Checkout — Stoned.io
 *
 * Creates a Stripe Checkout Session from the pending order in $_SESSION
 * and redirects the customer to Stripe's hosted payment page.
 */
session_start();
require __DIR__ . '/../vendor/autoload.php';

// ── Load environment variables ───────────────────────────────────
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$dotenv->required(['STRIPE_SECRET_KEY']);

\Stripe\Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

// ── Guard — must have a pending order ────────────────────────────
if (empty($_SESSION['last_order'])) {
    header('Location: cart.php');
    exit;
}

$order = $_SESSION['last_order'];
$items = $order['items'] ?? [];

if (empty($items)) {
    header('Location: cart.php');
    exit;
}

// ── Build Stripe line items ──────────────────────────────────────
$lineItems = [];
foreach ($items as $ci) {
    $lineItems[] = [
        'price_data' => [
            'currency'     => 'eur',
            'unit_amount'  => (int)($ci['price'] * 100), // cents
            'product_data' => [
                'name'        => $ci['label'],
                'description' => 'Tier ' . $ci['tier'] . ' — ' . ($ci['includes'] ?? ''),
            ],
        ],
        'quantity' => 1,
    ];
}

// ── Determine base URL ───────────────────────────────────────────
$scheme  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host    = $_SERVER['HTTP_HOST'] ?? 'localhost';
$baseUrl = $scheme . '://' . $host . dirname($_SERVER['SCRIPT_NAME']);

// ── Create Checkout Session ──────────────────────────────────────
try {
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card', 'ideal', 'bancontact'],
        'line_items'           => $lineItems,
        'mode'                 => 'payment',
        'customer_email'       => $order['email'] ?? null,
        'success_url'          => $baseUrl . '/order-confirmation.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url'           => $baseUrl . '/cart.php',
        'metadata'             => [
            'order_ref' => $order['ref'] ?? '',
            'total_amount' => $order['total'] ?? 0,
            'items_count' => count($order['items'] ?? []),
            'placed_at' => $order['placed_at'] ?? date('Y-m-d H:i:s'),
        ],
    ]);

    // Store the Stripe session ID so we can verify it later
    $_SESSION['last_order']['stripe_session_id'] = $session->id;

    header('Location: ' . $session->url);
    exit;

} catch (\Stripe\Exception\ApiErrorException $e) {
    // If Stripe fails, redirect back to cart with an error
    $_SESSION['checkout_error'] = 'Payment setup failed: ' . $e->getMessage();
    header('Location: cart.php');
    exit;
}

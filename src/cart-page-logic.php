<?php
/**
 * Cart Page Logic — Stoned.io
 *
 * Handles:
 *  - Reading the session cart
 *  - Loading inventory data
 *  - Assigning random rocks per tier to each cart item
 *  - Providing tier metadata (name, price, contents)
 *  - Sanitising & validating the email on POST
 *  - Honeypot bot detection
 */

session_start();

// ─── Tier metadata ───────────────────────────────────────────────
$tierMeta = [
    1 => [
        'label'   => 'Pebble Package',
        'badge'   => 'Tier 1',
        'price'   => 1,
        'includes'=> 'Photo & name',
    ],
    2 => [
        'label'   => 'Boulder Package',
        'badge'   => 'Tier 2',
        'price'   => 10,
        'includes'=> 'Photo, name & backstory',
    ],
    3 => [
        'label'   => 'ROCKstar Package',
        'badge'   => 'Tier 3',
        'price'   => 20,
        'includes'=> 'Photo, name, backstory & customisation',
    ],
    4 => [
        'label'   => 'Pristine Stone Package',
        'badge'   => 'Tier 4',
        'price'   => 50,
        'includes'=> 'Photo, name, backstory, customisation & adoption certificate PDF',
    ],
];

// ─── Load inventory ──────────────────────────────────────────────
$inventoryPath = __DIR__ . '/inventory.json';
$inventoryRaw  = file_get_contents($inventoryPath);
$inventoryData = json_decode($inventoryRaw, true);
$allRocks      = $inventoryData['products'] ?? $inventoryData;

// Group rocks by tier key
$rocksByTier = [];
foreach ($allRocks as $rock) {
    $tierNum = (int) str_replace('T', '', $rock['tier']);
    $rocksByTier[$tierNum][] = $rock;
}

// ─── Helper: pick random rocks for a tier ────────────────────────
function pickRocksForTier(int $tier, array $rocksByTier): array {
    $pool = $rocksByTier[$tier] ?? [];
    if (empty($pool)) {
        return [];
    }
    // T4 gets 3 rocks, everything else gets 1
    $count = ($tier === 4) ? min(3, count($pool)) : 1;
    $keys  = array_rand($pool, $count);
    if (!is_array($keys)) {
        $keys = [$keys];
    }
    $picked = [];
    foreach ($keys as $k) {
        $picked[] = $pool[$k];
    }
    return $picked;
}

// ─── Resolve cart items ──────────────────────────────────────────
$cartItems   = $_SESSION['cart'] ?? [];
$cartDisplay = []; // enriched items for the template
$cartTotal   = 0;

foreach ($cartItems as $index => &$item) {
    $tier = (int) $item['tier'];

    // Assign rocks once and persist in session
    if (empty($item['assigned_rocks'])) {
        $item['assigned_rocks'] = pickRocksForTier($tier, $rocksByTier);
    }

    $meta = $tierMeta[$tier] ?? $tierMeta[1];

    $cartDisplay[] = [
        'index'    => $index,
        'tier'     => $tier,
        'label'    => $meta['label'],
        'badge'    => $meta['badge'],
        'price'    => $meta['price'],
        'includes' => $meta['includes'],
        'rocks'    => $item['assigned_rocks'],
    ];

    $cartTotal += $meta['price'];
}
unset($item); // break reference

// Write back any newly-assigned rocks
$_SESSION['cart'] = $cartItems;

$cartEmpty = empty($cartDisplay);

// ─── Handle form POST ────────────────────────────────────────────
$formErrors   = [];
$formSuccess  = false;
$sanitisedEmail = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {

    // 1. Honeypot check — the hidden "website" field must be empty
    if (!empty($_POST['website'] ?? '')) {
        // Bot detected — silently pretend success
        $formSuccess = true;
    } else {

        // 2. Sanitise & validate email
        $rawEmail       = $_POST['email'] ?? '';
        $sanitisedEmail = filter_var(trim($rawEmail), FILTER_SANITIZE_EMAIL);

        if (empty($sanitisedEmail) || !filter_var($sanitisedEmail, FILTER_VALIDATE_EMAIL)) {
            $formErrors[] = 'Please enter a valid email address.';
        }

        // 3. If all good, "process" the order (placeholder)
        if (empty($formErrors)) {
            $formSuccess = true;
            // In a real app you'd store the order, send confirmation, etc.
            // For now we just clear the cart
            // $_SESSION['cart'] = [];
        }
    }
}

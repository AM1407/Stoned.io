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

// ─── Ko-fi per-tier product links ────────────────────────────────
// Replace each placeholder with the real Ko-fi product/shop URL
$kofiLinks = [
    1 => 'https://ko-fi.com/s/4e478315d2',
    2 => 'https://ko-fi.com/s/19e52178cc',
    3 => 'https://ko-fi.com/s/92768de6b6',
    4 => 'https://ko-fi.com/s/f5c13a1e85',
];

// ─── Load inventory ──────────────────────────────────────────────
$inventoryPath = __DIR__ . '/inventory.json';
$inventoryRaw  = file_get_contents($inventoryPath);
$inventoryData = json_decode($inventoryRaw, true);
$allRocks      = $inventoryData['products'] ?? $inventoryData;
$customOptions = $inventoryData['customization_options'] ?? [];

// Group rocks by tier key
$rocksByTier = [];
foreach ($allRocks as $rock) {
    $tierNum = (int) str_replace('T', '', $rock['tier']);
    $rocksByTier[$tierNum][] = $rock;
}

// ─── Helper: pick random rocks for a tier ────────────────────────
// Once a tier is assigned, the same rocks are returned forever —
// even if the item is removed and re-added — so users can't cycle
// through random assignments to cherry-pick a favourite.
function pickRocksForTier(int $tier, array $rocksByTier): array {
    // Check the persistent locked pool first
    if (!empty($_SESSION['tier_assignments'][$tier])) {
        $lockedIds = $_SESSION['tier_assignments'][$tier];
        $result    = [];
        foreach ($rocksByTier[$tier] ?? [] as $rock) {
            if (in_array($rock['id'], $lockedIds, true)) {
                $result[] = $rock;
            }
        }
        if (!empty($result)) {
            return $result;
        }
    }

    // First time for this tier — pick randomly
    $pool  = $rocksByTier[$tier] ?? [];
    if (empty($pool)) {
        return [];
    }
    $count = ($tier === 4) ? min(3, count($pool)) : 1;
    $keys  = array_rand($pool, $count);
    if (!is_array($keys)) {
        $keys = [$keys];
    }
    $picked = [];
    foreach ($keys as $k) {
        $picked[] = $pool[$k];
    }

    // Lock the assignment into the session
    $_SESSION['tier_assignments'][$tier] = array_column($picked, 'id');

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

        // 3. Process the order — store to session and redirect to confirmation
        if (empty($formErrors)) {
            $orderRef = 'ORD-' . strtoupper(substr(md5(uniqid('', true)), 0, 8));
            $_SESSION['last_order'] = [
                'ref'             => $orderRef,
                'email'           => $sanitisedEmail,
                'recipient_name'  => htmlspecialchars(trim($_POST['recipient_name']  ?? '')),
                'recipient_email' => filter_var(trim($_POST['recipient_email'] ?? ''), FILTER_SANITIZE_EMAIL),
                'gift_message'    => htmlspecialchars(trim($_POST['gift_message']    ?? '')),
                'items'           => $cartDisplay,
                'total'           => $cartTotal,
                'custom_names'    => $_POST['custom_name'] ?? [],
                'canvas_captures' => $_POST['canvas_capture'] ?? [],
                'kofi_links'      => $kofiLinks,
                'placed_at'       => date('Y-m-d H:i:s'),
            ];
            $_SESSION['cart'] = [];
            header('Location: order-confirmation.php');
            exit;
        }
    }
}

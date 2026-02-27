<?php
session_start();

// 1. Check of er een POST request is met een tier_id
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tier_id'])) {
    
    $tierId = intval($_POST['tier_id']);

    // 2. De "Dave-proof" check: Is het een valide Tier (1 t/m 4)?
    if ($tierId >= 1 && $tierId <= 4) {
        
        // Initialiseer het mandje als dat nog niet bestaat
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // 3. Voeg de Tier toe aan de sessie
        // We slaan de basics op; de 'assigned_rocks' vullen we later op de cart-pagina
        $_SESSION['cart'][] = [
            'tier' => $tierId,
            'added_at' => time(),
            'customised' => false,
            'assigned_rocks' => null 
        ];

        // 4. Redirect naar de winkelwagen
        header('Location: ../public/cart.php');
        exit();
        
    } else {
        // Iemand probeert Dave op te lichten met een illegale Tier
        header('Location: ../public/index.php?error=invalid_tier');
        exit();
    }
} else {
    // Geen directe toegang zonder formulier
    header('Location: ../public/index.php');
    exit();
}
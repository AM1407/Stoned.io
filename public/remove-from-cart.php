<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cart_index'])) {
    $index = (int) $_POST['cart_index'];

    if (isset($_SESSION['cart'][$index])) {
        // Remove the item — re-index the array so keys stay sequential
        array_splice($_SESSION['cart'], $index, 1);

        // NOTE: We deliberately do NOT touch $_SESSION['tier_assignments'].
        // This means if the user re-adds the same tier they'll always get
        // the same rock — no cycling allowed.
    }
}

header('Location: cart.php');
exit();

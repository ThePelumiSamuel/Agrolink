<?php
session_start();

if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
    header('Location: cart.php');
    exit;
}

$product_id = $_POST['product_id'];
$quantity = (int)$_POST['quantity'];

// Ensure the quantity is at least 1
if ($quantity < 1) {
    $quantity = 1;
}

// Update the quantity in the cart
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['quantity'] = $quantity;
    $_SESSION['success_msg'] = "Cart updated successfully!";
} else {
    $_SESSION['error_msg'] = "Product not found in cart!";
}

header('Location: cart.php');
exit;
<?php
session_start();

if (!isset($_POST['product_id'])) {
    header('Location: cart.php');
    exit;
}

$product_id = $_POST['product_id'];

// Remove the product from the cart
if (isset($_SESSION['cart'][$product_id])) {
    unset($_SESSION['cart'][$product_id]);
    $_SESSION['success_msg'] = "Product removed from cart successfully!";
} else {
    $_SESSION['error_msg'] = "Product not found in cart!";
}

header('Location: cart.php');
exit;
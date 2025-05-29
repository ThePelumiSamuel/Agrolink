<?php
session_start();

if (!isset($_POST['product_id'])) {
    header('Location: store.php');
    exit;
}

echo "<pre>";
    print_r($_POST);
echo "</pre>";

$product_id = $_POST['product_id'];
$product_name = $_POST['product_name'];
$product_price = $_POST['product_price'];
$product_quantity = 1; // Default quantity

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the product is already in the cart
if (isset($_SESSION['cart'][$product_id])) {
    // Increment the quantity if the product already exists
    $_SESSION['cart'][$product_id]['quantity'] += 1;
} else {
    // Add the product to the cart
    $_SESSION['cart'][$product_id] = [
        'name' => $product_name,
        'price' => $product_price,
        'quantity' => $product_quantity
    ];
}

$_SESSION['success_msg'] = "Product added to cart successfully!";
header('Location: store.php');
exit;
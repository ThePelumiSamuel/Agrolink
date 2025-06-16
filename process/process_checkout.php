<?php
session_start();
require_once "../classes/Guest.php";

$guest = new Guest();


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    $_SESSION['error_msg'] = "Your cart is empty!";
    header('Location: ../cart.php');
    exit;
}

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['address'])) {
    $_SESSION['error_msg'] = "Please fill in all required fields!";
    header('Location: ../checkout.php');
    exit;
}



// echo "<pre>";
// print_r($_POST);
// print_r($_SESSION['cart']);
// echo "</pre>";
// exit;

// Sanitize and validate input
$name = htmlspecialchars(trim($_POST['name']));
$email = htmlspecialchars(trim($_POST['email']));
$address = htmlspecialchars(trim($_POST['address']));

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error_msg'] = "Invalid email address!";
    header('Location: ../checkout.php');
    exit;
}

$cart = $_SESSION['cart'];
$grand_total = 0;

// Calculate the grand total
foreach ($cart as $product) {
    $grand_total += $product['price'] * $product['quantity'];
}

try {
    // Insert order details
    $order_id = $guest->createOrder($name, $email, $address, $grand_total);
    if ($order_id) {
        $_SESSION['order_id'] = $order_id;

        // Insert order items
        foreach ($cart as $product) {
            $guest->addOrderItem($order_id, $product['name'], $product['price'], $product['quantity']);
        }

        // Redirect to confirm payment page
        header('Location: ../confirm_payment.php');
        exit;
    } else {
        $_SESSION['errormsg'] = "Please try again.";
        header("Location: ../checkout.php");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['error_msg'] = "An error occurred while processing your order: " . $e->getMessage();
    header('Location: ../checkout.php');
    exit;
}
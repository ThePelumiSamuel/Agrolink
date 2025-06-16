<?php
session_start();
require_once "../classes/Utility.php"; // Include your utility class for sanitization
require_once "../classes/Guest.php"; // Include your guest class for database operations
require_once "../classes/Db.php"; // Include your database connection class

if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id']; // Logged-in user's ID
$cart = $_SESSION['cart']; // Cart data from session

if (empty($cart)) {
    echo "Cart is empty.";
    exit;
}

try {
    // $db = new Db(); // Initialize your database connection
    // $conn = $db->dbconn;

    // Begin a transaction
    $conn->beginTransaction();

    // Calculate total price
    $total_price = 0;
    foreach ($cart as $item) {
        $total_price += $item['quantity'] * $item['price'];
    }

    // Insert into `orders` table
    $sql = "INSERT INTO orders (user_id, orders_total_price, status) VALUES (?, ?, 'Pending')";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $total_price]);
    $order_id = $conn->lastInsertId(); // Get the inserted order ID

    // Insert into `order_items` table
    foreach ($cart as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $total_price = $quantity * $price;

        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, total_price) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$order_id, $product_id, $quantity, $price, $total_price]);
    }

    // Commit the transaction
    $conn->commit();

    // Clear the cart
    unset($_SESSION['cart']);

    echo "Order placed successfully!";
    header("Location: order_success.php?order_id=$order_id");
    exit;
} catch (PDOException $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
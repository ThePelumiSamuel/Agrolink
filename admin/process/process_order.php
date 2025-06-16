<?php
require_once "classes/Admin.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id']; // Assume this is passed from the session or form
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $total_price = $_POST['total_price'];

    try {
        $admin = new Admin();
        $sql = "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $admin->dbconn->prepare($sql);
        $stmt->execute([$user_id, $product_id, $quantity, $total_price]);

        echo "Order placed successfully.";
        header('Location: orders.php');
        exit;
    } catch (PDOException $e) {
        echo "Error placing order: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
    exit;
}
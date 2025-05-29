<?php
session_start();
require_once "classes/Farmer.php";

if (!isset($_GET['id'])) {
    $_SESSION['error_msg'] = "Invalid product ID.";
    header('Location: dashboard.php');
    exit;
}

$product_id = $_GET['id'];
$farmer = new Farmer();

try {
    $farmer->deleteProduct($product_id);
    $_SESSION['success_msg'] = "Product deleted successfully!";
    header('Location: dashboard.php');
    exit;
} catch (Exception $e) {
    $_SESSION['error_msg'] = $e->getMessage();
    header('Location: dashboard.php');
    exit;
}
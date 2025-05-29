<?php
session_start();
require_once "classes/Utility.php"; // Include your utility class for sanitization
require_once "classes/Guest.php"; // Include your guest class for database operations
require_once "classes/Farmer.php"; // Include your farmer class for database operations

$vendor = new Farmer;
if (isset($_SESSION['farmeronline'])) {
    $id = $_SESSION['farmeronline'];
    $res = $vendor->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}

$users = new Guest();

// $vendor = new Farmer;
if (isset($_SESSION['useronline'])) {
    $id = $_SESSION['useronline'];
    $deets = $users->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}

if (!isset($_GET['order_id'])) {
    header('Location: store.php');
    exit;
}
require_once "partials/header.php";


$order_id = htmlspecialchars($_GET['order_id']);
?>
<div class="container mt-5 col-4 shadow p-4">
    <h2>Thank You for Your Order!</h2>
    <p>Your order ID is <strong>#<?php echo $order_id; ?></strong>.</p>
    <p>We will process your order shortly.</p>
    <a href="store.php" class="btn btn-primary">Continue Shopping</a>
</div>
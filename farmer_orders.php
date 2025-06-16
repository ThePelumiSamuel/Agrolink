<?php
session_start();
require_once "classes/Farmer.php";
$farmer = new Farmer;

// Check if farmer is logged in
if (!isset($_SESSION['farmeronline'])) {
    header("Location: farmer_login.php");
    exit();
}

$farmer_id = $_SESSION['farmeronline'];
$orders = $farmer->getOrderedProducts($farmer_id);
require_once "partials/header.php";
?>

<div class="container">
    <h2 class="text-center mt-5">Orders for Your Products</h2>
    <table class="table table-bordered table-striped table-hover mt-3">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Product</th>
                <th>Ordered By</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($orders): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_id']) ?></td>
                        <td><?= htmlspecialchars($order['product_name']) ?></td>
                        <td><?= htmlspecialchars($order['user_fname'] . ' ' . $order['user_lname']) ?></td>
                        <td><?= htmlspecialchars($order['quantity']) ?></td>
                        <td><?= htmlspecialchars($order['total_price']) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No orders found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
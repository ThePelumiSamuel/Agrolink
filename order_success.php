<?php
$order_id = $_GET['order_id'];
?>

<div class="container">
    <h3>Order Successful</h3>
    <p>Your order ID is: <?php echo htmlspecialchars($order_id); ?></p>
    <a href="orders.php" class="btn btn-primary">View Orders</a>
</div>
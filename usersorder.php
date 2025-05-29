<?php
session_start();
require_once "classes/Guest.php";
$users = new Guest;
$id = $_SESSION['useronline'];
$deets = $users->getuser($id);
require_once "partials/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md">
            <h2 class="text-center mt-5">My Orders</h2>
            <table class="table table-bordered table-striped table-hover mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $orders = $users->get_order($id);
                    if ($orders) {
                        foreach ($orders as $order) {
                            echo "<tr>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "<td>" . $order['order_id'] . "</td>";
                            echo "<td>" . $order['product_name'] . "</td>";
                            echo "<td>" . $order['quantity'] . "</td>";
                            echo "<td>" . $order['total_price'] . "</td>";
                            echo "<td>" . $order['status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No orders found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php 
    require_once "partials/footer.php";
?>
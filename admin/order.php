<?php
require_once "includes/adminheader.php";
require_once "classes/Admin.php";

$admin = new Admin();
$allOrders = $admin->fetch_orders(); // Fetch all orders from the database
?>

<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="card bg-secondary text-white m-3 mt-5 mb-4">
                <div class="card-header"><h3>All Orders</h3></div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-dark">
                            <?php
                            if (!empty($allOrders)) {
                                $count = 1;
                                foreach ($allOrders as $order) {
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>" . htmlspecialchars($order['user_fname'] . " " . $order['user_lname']) . "</td>
                                        <td>" . htmlspecialchars($order['user_email']) . "</td>
                                        <td>" . htmlspecialchars($order['user_phone']) . "</td>
                                        <td>" . htmlspecialchars($order['product_name']) . "</td>
                                        <td>" . htmlspecialchars($order['order_quantity']) . "</td>
                                        <td>&#8358;" . number_format($order['orders_total_price'], 2) . "</td>
                                        <td>" . htmlspecialchars($order['order_date']) . "</td>
                                        <td>" . htmlspecialchars($order['status']) . "</td>
                                        <td>
                                            <form action='update_order_status.php' method='post' style='display:inline;'>
                                                <input type='hidden' name='order_id' value='" . htmlspecialchars($order['order_id']) . "'>
                                                <button type='submit' class='btn btn-success' " . ($order['status'] === 'Delivered' ? 'disabled' : '') . ">
                                                    Mark as Delivered
                                                </button>
                                            </form>
                                        </td>
                                    </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='10' class='text-center'>No orders found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
session_start();
require_once "classes/Farmer.php";
$vendor = new Farmer;
if (isset($_SESSION['farmeronline'])) {
    $id = $_SESSION['farmeronline'];
    $res = $vendor->getuser($id);




    // Fetch farmer's products
    $products = $vendor->getFarmerProduct($id);



    // Fetch farmer's orders
    $orders = $vendor->getFarmerOrders($id);
}
// echo "<pre>";
// print_r($orders);
// echo "</pre>";
// exit;


require_once "partials/header.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md-3 p-5 mt-5 me-3 shadow bg-light text-center rounded-3">
            <h3>Welcome Farmer</h3>
            <img src="assets/images/farmer (1).png" alt="" class="img-fluid rounded-circle" width="100px" height="1000px">
            <?php
            foreach ($res as $r) {
                echo "<p>$r[username]</p>";
            }
            ?>
            <p>Farmers Account</p>
            <span class="badge text-bg-success">0 farms</span>
            <span class="badge text-bg-info"><?php echo count($products); ?> goods</span>
            <span class="badge text-bg-primary">No orders</span>
            <span class="badge text-bg-warning">No pending orders</span>
            <span class="badge text-bg-danger">No messages</span>
        </div>
        <div class="col-md-8 p-5 mt-5 me-3 shadow bg-light  rounded-3">
            <div class="mb-3 text-right">

                <a href="addproduct.php" class="btn btn-lg hover-outline-success text-end btn-success">Start Selling ></a>
            </div>
            <div class="table-responsive">
                <h5 class="text-center">My Product</h5>
                <table class="table  border-top table-hover table-lg">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">GOODS</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">AMOUNT</th>
                            <th scope="col" colspan="4">ACTIONS</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($products)) {
                            $count = 1;
                            foreach ($products as $product) {
                                echo "<tr>
                <th scope='row'>{$count}</th>
                <td><img src='uploads/{$product['image']}' alt='{$product['name']}' width='50' height='50' ></td>
                <td>{$product['name']}</td>
                <td>{$product['description']}</td>
                <td>{$product['category']}</td>
                <td>{$product['quantity']}</td>
                <td>₦" . number_format($product['price'], 2) . "</td>
                <td class='d-flex justify-content-center'> 
                    <a href='view_product.php?id={$product['id']}' class='btn btn-sm btn-success me-2'>View</a>
                    <a href='edit_product.php?id={$product['id']}' class='btn btn-sm btn-primary me-2'>Edit</a>
                    <a href='delete_product.php?id={$product['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
                </td>
            </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No products found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="table-responsive mt-5">
                <h5 class="text-center">My Orders</h5>
                <table class="table border-top table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Description</th>
                            <th scope="col">Order Date</th>
                            <th scope="col">Total Price</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($orders)) {
                            $count = 1;
                            foreach ($orders as $order) {
                                echo "<tr>
                        <th scope='row'>{$count}</th>
                        <td>{$order['user_fname']}</td>
                        <td>{$order['user_email']}</td>
                        <td>{$order['product_name']}</td>
                        <td>{$order['product_description']}</td>
                        <td>{$order['order_date']}</td>
                        <td>₦" . number_format($order['total_price'], 2) . "</td>
                        <td>
                            <a href='set_delivery_date.php?order_id={$order['order_id']}' class='btn btn-sm btn-primary'>Set Delivery Date</a>
                        </td>
                    </tr>";
                                $count++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No orders found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>
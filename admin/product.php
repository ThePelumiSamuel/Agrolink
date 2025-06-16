<?php
session_start();
require_once "classes/Admin.php";

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}

// Fetch admin details
$admin = new Admin();
$adminDetails = $admin->getAdminById($_SESSION['admin_id']);

// Include the admin header
require_once "includes/adminheader.php";
?>
<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="card bg-secondary text-white m-3 mt-5 mb-4">
                <div class="card-header"><h3>All Product</h3></div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-dark">
                            <?php
                            if (!empty($allproduct)) {
                                $count = 1;
                                foreach ($allproduct as $product) {
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>" . htmlspecialchars($product['name']) . "</td>
                                        <td><img src='../uploads/" . htmlspecialchars($product['image']) . "' alt='" . htmlspecialchars($product['name']) . "' width='80px' height='80px' ></td>
                                        <td>" . htmlspecialchars($product['category']) . "</td>
                                        <td>&#8358;" . number_format($product['price'], 2) . "</td>
                                        <td>
                                            <a href='edit_product.php?id=" . htmlspecialchars($product['id']) . "' class='btn btn-success me-3'>Edit</a>
                                            <a href='delete_product.php?id=" . htmlspecialchars($product['id']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this product?\")'>Delete</a>
                                        </td>
                                    </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='6' class='text-center'>No products found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
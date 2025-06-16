<?php
session_start();
require_once "includes/adminheader.php";
require_once "classes/Admin.php";

$admin = new Admin();
$allUsers = $admin->fetch_users(); // Fetch all users from the database

// Fetch admin details
$adminDetails = $admin->getAdminById($_SESSION['admin_id']);
?>

<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="card bg-secondary text-white m-3 mt-5 mb-4">
                <div class="card-header">
                    <h3>All Users</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th colspan="4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-dark">
                            <?php
                            if (!empty($allUsers)) {
                                $count = 1;
                                foreach ($allUsers as $user) {
                                    echo "<tr>
            <td>{$count}</td>
            <td>" . htmlspecialchars($user['user_fname'] ?? 'N/A')   . " " . ($user['user_lname'] ?? '') . "</td>
            <td>" . htmlspecialchars($user['user_email'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($user['user_phone'] ?? 'N/A') . "</td>
            <td>" . htmlspecialchars($user['user_address'] ?? 'N/A') . "</td>
            <td>
                <a href='edit_user.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='btn btn-success me-3'>Edit</a>
                <a href='delete_user.php?id=" . htmlspecialchars($user['id'] ?? '') . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>
            </td>
        </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
session_start();
require_once "includes/adminheader.php";


require_once "classes/Admin.php";

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin_login.php');
    exit;
}

if (!isset($_SESSION['admin_id'])) {
    echo "Admin ID is not set in the session.";
    echo "<pre>";
    print_r($_SESSION); // Debug session variables
    echo "</pre>";
    exit;
}


$admin = new Admin();
$allFarmers = $admin->fetch_farmers(); // Fetch all farmers from the database
?>

<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="card bg-secondary text-white m-3 mt-5 mb-4">
                <div class="card-header"><h3>Registered Farmers</h3></div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-dark">
                            <?php
                            if (!empty($allFarmers)) {
                                $count = 1;
                                foreach ($allFarmers as $farmer) {
                                    echo "<tr>
                                        <td>{$count}</td>
                                        <td>" . htmlspecialchars($farmer['fullname']) . "</td>
                                        <td>" . htmlspecialchars($farmer['email']) . "</td>
                                        <td>" . htmlspecialchars($farmer['phone']) . "</td>
                                        <td>
                                            <a href='edit_farmer.php?id=" . htmlspecialchars($farmer['id']) . "' class='btn btn-success me-3'>Edit</a>
                                            <a href='block_farmer.php?id=" . htmlspecialchars($farmer['id']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to block this farmer?\")'>Block</a>
                                        </td>
                                    </tr>";
                                    $count++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No farmers found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
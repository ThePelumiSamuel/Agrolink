<?php
session_start();
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

// Fetch admin details
$admin = new Admin();
$adminDetails = $admin->getAdminById($_SESSION['admin_id']);

if (!$adminDetails) {
    // Redirect to login if admin details are not found
    $_SESSION['errormsg'] = "Unable to fetch admin details. Please log in again.";
    header('Location: admin_login.php');
    exit;
}

// echo "<pre>";
//     print_r($_SESSION);
// echo "</pre>";
// exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link href="../assets/fa/css/all.css" rel="stylesheet">
</head>
<body>
    <?php require_once "includes/adminheader.php"; ?>

    <main class="">
        <div class="container-fluid px-4 bg-dark text-white">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <!-- Display Admin Details -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h5>Welcome, <?php echo htmlspecialchars( ucfirst($adminDetails['admin_username']) ); ?>!</h5>
                            <p>Account Created: <?php echo htmlspecialchars($adminDetails['created_at']); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Primary Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Warning Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Success Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Danger Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">View Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
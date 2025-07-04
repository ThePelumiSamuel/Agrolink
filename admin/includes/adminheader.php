<?php
// Ensure session is started
if (!isset($_SESSION)) {
    session_start();
}

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header("Location: admin_login.php");
    exit;
}

// Fetch admin details
require_once "classes/Admin.php";
$admin = new Admin();
$adminDetails = $admin->getAdminById($_SESSION['admin_id']);
?>

<body class="sb-nav-fixed bg-dark text-white">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
        
    </nav>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Agrolink: Admin</title>

    <link href="assets/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link href="assets/fontawesome/css/all.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed bg-dark text-white">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
        <!-- Navbar Brand-->
        <img src="assets/images/fields.png" alt="Logo" width="50" height="34" class="d-inline-block align-text-top">
        Agrolink
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-success" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
         

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($adminDetails['admin_username'] ?? 'Admin'); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user rounded shadow shadow-dark fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion bg-success sb-sidenav-dark " id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">ADMIN</div>
                        <a class="nav-link" href="admin_dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="registeredusers.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Registered Users
                        </a>

                        <a class="nav-link" href="regfarmer.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Registered Farmers
                        </a>
                        <a class="nav-link" href="product.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table "></i></div>
                            Product
                        </a>
                        <a class="nav-link" href="order.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Orders
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php
                    if (isset($adminDetails['admin_username'])) {
                        echo htmlspecialchars(ucfirst($adminDetails['admin_username']));
                    } else {
                        echo "Unknown Admin";
                    }
                    ?>
                    <br>
                    Super Admin
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
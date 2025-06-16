<?php
// session_start();
require_once "classes/Utility.php";
require_once "classes/Guest.php";
require_once "classes/Farmer.php";

$vendor = new Farmer;
if (isset($_SESSION['farmeronline'])) {
    $id = $_SESSION['farmeronline'];
    $res = $vendor->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}


 

 

// // $users = new Guest;
// // $grab = $users->getuser(1);
// // echo "<pre>";
// // print_r($grab);
// // echo "</pre>";
// ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script> <!-- Ensure Bootstrap JS is included -->
    <title>AgroLink-Home</title>
</head>
<body>
    <div class="container-fluid bg-success">
        <div class="container text-white p-2">
            <div class="row">
                <div class="col-md-4  offset-md-8">
                    <i class="fa fa-phone me-2 "></i><a href="#" class="text-white text-decoration-none">08135829683</a>
                    <i class="fa fa-envelope me-2"></i><a href="#" class="text-white text-decoration-none">info@agrolink.com</a>
                </div>
            </div>
        </div>
    </div>

    <!-- nav start -->
    <nav class="navbar navbar-expand-lg bg-white sticky-top shadow">
        <div class="container">
            <a class="navbar-brand active" href="index.php">
                <img src="assets/images/fields.png" alt="Logo" width="50" height="34" class="d-inline-block align-text-top">
                Agrolink
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form class="d-flex m-auto" role="search">
                    <input class="form-control me-2 " type="search" placeholder="Search" aria-label="Search" i >
                    <button class="btn btn-outline-success fa fa-search" type="submit"></button>
                </form>
                <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="aboutus.php">About us</a></li>
                    <li class="nav-item"><a class="nav-link" href="store.php">Store</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-plus"></i> Cart</a></li>


                
            
                        
                 
                        
                        <!-- User Dropdown -->
                    <?php
                    if (isset($_SESSION['useronline'])) {?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="assets/images/guide-1.jpg" width="30" style="border-radius: 50%;"> 
                                Hi <?php echo $deets['user_fname']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile_update.php">My Account</a></li>
                                <li><a class="dropdown-item" href="usersorder.php">My Orders</a></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                    }elseif (isset($_SESSION['farmeronline'])){
                         ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="assets/images/guide-1.jpg" width="30" style="border-radius: 50%;"> 
                                Hi <?php foreach($res as $r){echo $r['username'];}
                                ?>
                                
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
                                <li><a class="dropdown-item" href="update_profile.php">My Account</a></li>
                                <li><a class="dropdown-item" href="farmer_orders.php">My Orders</a></li>
                                <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <?php
                    }else{
                       echo '<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Sign In
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="login.php">As User</a></li>
                                <li><a class="dropdown-item" href="farmer_login.php">As Farmer</a></li>
                               
                            </ul>
                        </li>
                      
                    <li class="nav-item"><a class="btn btn-success" href="register.php">Create an account</a></li>';
                    }
                    ?>
                        
                 
                </ul>
            </div>
        </div>
    </nav>
    <!-- nav end -->



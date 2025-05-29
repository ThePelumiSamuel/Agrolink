<?php
session_start();
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


$users = new Guest;

// $vendor = new Farmer;
if (isset($_SESSION['useronline'])) {
    $id = $_SESSION['useronline'];
    $deets = $users->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}

require_once "partials/header.php";
?>
<div class="container my-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1 class="mb-4">About Us</h1>
            <p class="lead">
                Welcome to <strong>AgroLink</strong>, your trusted platform for connecting farmers with buyers.
                We are dedicated to fostering a sustainable future by bridging the gap between agricultural producers and consumers.
            </p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6">
            <h3>Our Mission</h3>
            <p>
                At AgroLink, our mission is to empower farmers by providing them with a platform to sell their fresh produce directly to buyers.
                We aim to create a transparent and efficient marketplace that benefits both farmers and consumers.
            </p>
        </div>
        <div class="col-md-6">
            <h3>Our Vision</h3>
            <p>
                We envision a world where farmers are fairly compensated for their hard work, and consumers have access to fresh, high-quality produce.
                By leveraging technology, we strive to make this vision a reality.
            </p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-4 text-center">
            <h4>Fresh Produce</h4>
            <p>We ensure that all products listed on our platform are fresh and of the highest quality.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>Fair Pricing</h4>
            <p>Our platform promotes fair pricing, ensuring farmers get the value they deserve.</p>
        </div>
        <div class="col-md-4 text-center">
            <h4>Fast Delivery</h4>
            <p>We work with reliable logistics partners to ensure timely delivery of products.</p>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <h3>Join Us</h3>
            <p>
                Whether you're a farmer looking to sell your produce or a buyer seeking fresh, high-quality products, AgroLink is here for you.
                Together, we can build a sustainable future for agriculture.
            </p>
            <a href="register.php" class="btn btn-success">Get Started</a>
        </div>
    </div>
</div>
<?php
require_once "partials/footer.php";
?>
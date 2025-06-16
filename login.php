<?php
session_start();
require_once "classes/Utility.php";
require_once "classes/Guest.php";
$guest = new Guest;
if(isset($_SESSION["useronline"])) {
    header("Location: index.php");
    exit();
}
require_once "partials/header.php";

?>


<div class="container-fluid">
    <div class="row">
    <form class="col-md-4 offset-md-4 mt-5 mb-5 p-4 p-md-5 bg-white rounded shadow border rounded-3 bg-light" action="process/process_login.php" method="post">
        <div class="mb-3 text-center text-uppercase fw-bold">
        <img src="assets/images/fields.png" alt="Logo" width="50" height="34" class="d-inline-block align-text-top mb-2">
            <h1 class="text-success">User Login</h1>
            <p class="text-muted">Login to your account</p>
            <hr>
        </div>
    <?php
        if(isset($_SESSION["errormsg"])){
            echo "<div class='alert alert-danger text-center'>".$_SESSION["errormsg"]."</div>";
            unset($_SESSION["errormsg"]);
        }
        if(isset($_SESSION["feedback"])){
            echo "<div class='alert alert-success text-center'>".$_SESSION["feedback"]."</div>";
            unset($_SESSION["feedback"]);
        }
       ?>
        <div class="mb-3">
          <input type="email" name="email" class="form-control" id="email" placeholder="Email">
          <label for="email">Enter Email </label>
        </div>
        <div class="mb-3">
          <input type="password" name="pass" class="form-control" id="password" placeholder="Password">
          <label for="password">Password</label>
        </div>
        
        <button class="w-100 btn btn-success custom-btn noround btn-md" type="submit" name="btnlogin">Login!</button>
        <hr class="my-4">
        <small class="text-muted">Login for a personalized experience</small>
        
    </form>
        
    </div>
</div>

<?php

    require_once "partials/footer.php";

?>
<?php
// require_once "user_guard.php";
session_start();
require_once "guest_guard.php";
require_once "partials/header.php";
?>


<div class="container-fluid">
    <div class="row   bg-white rounded shadow">
        
            <div class="col-md-4 regpage  rounded shadow bg-success">
                <div class="p-5 mt-5 ms-5 text-white ">
                <h3 class="text-center me-4 text-mute">Seller Account</h3>
                <p>By clicking on Register account you agree to this and our general terms & conditions</p>
                </div>

            </div>
            <div class="col-md-8   p-5">
                <div class="mb-3  fs-5 fw-5 text-center">
                    <p>Create an Account</p>
                    <?php 
                        if(isset($_SESSION["errormsg"])){
                            echo "<div class='alert alert-danger'><p>" . $_SESSION['errormsg'] . "</p></div>";
                            unset($_SESSION['errormsg']);
                        }
                        if(isset($_SESSION["feedback"])){
                            echo "<div class='alert alert-info'><p>" . $_SESSION['feedback'] . "</p></div>";
                            unset($_SESSION['feedback']);
                        }           
                    ?>
     
                </div>
                
     
                <div class="col-md-7 offset-md-3  p-5 shadow ">
                    <form action="process/process_register.php" method="post">
                        <div class="mb-3">
                            <p>Already have an account? <a href="#" class="text-secondary">login here</a></p>
                        </div>

                        <div class="d-flex">
                            <div class="mb-3 me-2">
                                <label for="fname">First Name</label>
                                <input type="text" name="fname" id="fname" placeholder="First Name" class="form-control">
                            </div>
                            <div class="mb-3 ms-2">
                                <label for="lname">Last Name</label>
                                <input type="text" name="lname" id="lname" placeholder="Last Name" class="form-control">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="phone">phone NUmber</label>
                            <input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="role">Role <small>(User, Farmer)</small></label>
                            <select name="role" id="role" class="form-select form-control">
                                <option value="" selected disabled>Select Role</option>
                                <option value="user" name="role">User</option>
                                <option value="farmer" name="role">Farmer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="address" id="address" placeholder="Address" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="pass1">Password</label>
                            <input type="password" name="pass1" id="pass1" placeholder="Password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="pass2">Confirm Password</label>
                            <input type="password" name="pass2" id="pass2" placeholder="Confirm Password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-success col-12" name="btnreg">Create an Account</button>
                        </div>
                    </form>
                </div>
            </div>
        
    </div>
</div>  



 <?php
     require_once "partials/footer.php";
?>
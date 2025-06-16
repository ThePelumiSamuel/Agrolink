<?php
// require_once "user_guard.php";
session_start();
require_once "classes/Farmer.php";
// $users = new Farmer;
// $id = $_SESSION['farmeronline'];
// $deets = $users->getuser($id);
require_once "partials/header.php";
?>


<div class="container">
    <div class="row  mt-5 bg-white rounded shadow">

        <div class="col-md-5  rounded shadow bg-success">
            <div class="p-5 mt-5 ms-5 text-white mb-3">
                <h3 class="text-center me-4 text-mute">Farm Seller Account</h3>
                <p>By clicking on Register account you agree to this and our general terms & conditions</p>
            </div>

        </div>
        <div class="col-md-7  mb-5 p-5">
            <form action="process/process_farmer_register.php" method="post">
                <div class="col-md-8 offset-md-2 shadow p-5 ">
                    <div class="mb-3">
                        <p>Already have an account? <a href="#" class="text-secondary">login here</a></p>
                    </div>
                    <?php
                      if(isset($_SESSION["errormsg"])){
                        echo "<p class='alert alert-danger'>". $_SESSION["errormsg"] . "</p>";
                        unset($_SESSION['errormsg']);
                      }
                      if(isset($_SESSION["feedback"])){
                        echo "<div class='alert alert-success'><p>". $_SESSION["feedback"] . "</p></div>";
                        unset($_SESSION['feedback']);
                      }
                      ?>

                  
                    <div class="mb-3">
                        <input type="text" name="fullname" id="fullname" placeholder="Full Name" class="form-control  ">
                    </div>
                    
                    <div class="mb-3">
                        <input type="email" name="email" id="email" placeholder="johndeo@gmail.com" class="form-control ">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="phone" id="phone" placeholder="Phone Number" class="form-control ">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="username" id="username" placeholder="Username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="pass" id="pass" placeholder="Password" class="form-control ">
                    </div>
                    <div class="mb-3">
                        <select name="state" id="state" class="form-select mb-3">
                            <option value="">Select State</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Oyo">Oyo</option>
                            <option value="Abuja">Abuja</option>
                            <option value="Kano">Kano</option>
                            <option value="Rivers">Rivers</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <select name="city" id="city" class="form-select mb-3">
                            <option value="">Select City</option>
                            <option value="Lagos">Lagos</option>
                            <option value="Ibadan">Ibadan</option>
                            <option value="Abuja">Abuja</option>
                            <option value="Kano">Kano</option>
                            <option value="Port Harcourt">Port Harcourt</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="address" id="address" placeholder="Address" class="form-control ">
                    </div>
                    
                    <div class="mb-3">
                        <button class="form-control  btn btn-success" name="btnfamreg">Register</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</div>



<?php
require_once "partials/footer.php";

?>
<?php
session_start();
// require_once "user_guard.php"; // This will redirect if not logged in

require_once "classes/Guest.php";
$users = new Guest;
$id = $_SESSION['useronline'];
$deets = $users->getuser($id);

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// exit; // Uncomment this line to debug the session data

require_once "partials/header.php";
?>


<div class="container">
    <div class="row  mt-5">
        <div class="col-md-6 sm shadow p-3 offset-md-3">
            <h2 class="text-center">Update Profile</h2>
            <form action="process/process_profile_update.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" name="fname" value="<?php echo $deets['user_fname']; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" name="lname" value="<?php echo $deets['user_lname']; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" value="<?php echo $deets['user_email']; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" value="<?php echo $deets['user_phone']; ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="" class="form-select">
                        <?php if ($deets['user_role'] == "admin") { ?>
                            <option value="<?php echo $deets['role']; ?>"><?php echo $deets['role']; ?></option>
                            <option value="">Select Role</option>
                            <option value="">Guest</option>
                        <?php } else { ?>
                            <option value="<?php echo $deets['user_role']; ?>"><?php echo $deets['user_role']; ?></option>
                            <option value="">Select Role</option>
                            <option value="">Admin</option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Image upload -->
                <div class="mb-3">
                    <label for="" class="">Profile Picture</label><br />
                    <?php if ($deets['user_profile'] != "") { ?>
                        <img src="uploads/<?php echo $deets['user_profile']; ?>" alt="" class="img-fluid" width="100px" height="100px"><br />
                        <input type="file" name="profile" class="form-control mt-2" accept="image/*">
                    <?php } else { ?>
                        <input type="file" name="profile" class="form-control" accept="image/*">
                    <?php } ?>
                    <div class="row my-5">
        
        <div class="col-sm-12 text-center">
            <button type="submit" class="btn btn-danger custom-btn col-6 noround" id="btnupdate" name="btnupdate">Update Account</button>
        </div>
      </div>
    </div>
</div>

<?php
require_once "partials/footer.php";
?>
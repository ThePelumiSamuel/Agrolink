<?php
session_start();
require_once "classes/Farmer.php";

if (!isset($_SESSION['farmeronline'])) {
    $_SESSION['error_msg'] = "You must be logged in to update your profile.";
    header('Location: login.php');
    exit;
}

$id = $_SESSION['farmeronline'];
$farmer = new Farmer();

// echo "<pre>";
//     print_r($_SESSION);
// echo "</pre>";
// die;

$farmer_details = $farmer->getFarmerDetails($id);
// try {
//     // Fetch farmer details
   
// } catch (Exception $e) {
//     $_SESSION['error_msg'] = "An error occurred while fetching your details: " . $e->getMessage();
//     header('Location: dashboard.php');
//     exit;
// }

require_once "partials/header.php";
?>

<div class="container mt-5">
    <h2>Update Profile</h2>
    <?php
    if (isset($_SESSION['error_msg'])) {
        echo "<div class='alert alert-danger'>" . $_SESSION['error_msg'] . "</div>";
        unset($_SESSION['error_msg']);
    }
    if (isset($_SESSION['success_msg'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['success_msg'] . "</div>";
        unset($_SESSION['success_msg']);
    }
    ?>
  <form action="process/process_update_profile.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" name="fullname" id="name" class="form-control" value="<?php echo htmlspecialchars($farmer_details['fullname']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($farmer_details['email']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($farmer_details['phone']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control" rows="3" required><?php echo htmlspecialchars($farmer_details['address']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="profile_image" class="form-label">Profile Image</label>
        <input type="file" name="profile_image" id="profile_image" class="form-control">
        <?php if (!empty($farmer_details['profile_image'])): ?>
            <img src="uploads/<?php echo htmlspecialchars($farmer_details['profile_image']); ?>" alt="Profile Image" class="img-thumbnail mt-2" width="150">
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn-primary">Update Profile</button>
</form>
</div>

<?php
require_once "partials/footer.php";
?>
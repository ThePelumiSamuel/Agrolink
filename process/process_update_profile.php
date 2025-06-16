<?php
session_start();
require_once "../classes/Farmer.php";

if (!isset($_SESSION['farmeronline'])) {
    $_SESSION['error_msg'] = "You must be logged in to update your profile.";
    header('Location: ../login.php');
    exit;
}

$farmer_id = $_SESSION['farmeronline'];
$farmer = new Farmer();

if (isset($_POST['fullname'], $_POST['email'], $_POST['phone'], $_POST['address'])) {
    $name = htmlspecialchars(trim($_POST['fullname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $profile_image = "";

    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['error_msg'] = "All fields are required.";
        header('Location: ../update_profile.php');
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_msg'] = "Invalid email format.";
        header('Location: ../update_profile.php');
        exit;
    }

    // Handle profile image upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "../uploads/";
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_name = basename($_FILES['profile_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['error_msg'] = "Only JPG, JPEG, and PNG files are allowed.";
            header('Location: ../update_profile.php');
            exit;
        }

        $profile_image = uniqid() . "." . $file_ext;
        $uploaded_file = $upload_dir . $profile_image;

        if (!move_uploaded_file($file_tmp, $uploaded_file)) {
            $_SESSION['error_msg'] = "Failed to upload the profile image.";
            header('Location: ../update_profile.php');
            exit;
        }
    }

    try {
        // Update farmer profile
        $farmer->updateFarmerProfile($farmer_id, $name, $email, $phone, $address, $profile_image);
        $_SESSION['success_msg'] = "Profile updated successfully!";
        header('Location: ../dashboard.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error_msg'] = "An error occurred: " . $e->getMessage();
        header('Location: ../update_profile.php');
        exit;
    }
} else {
    $_SESSION['error_msg'] = "Invalid form submission.";
    header('Location: ../update_profile.php');
    exit;
}
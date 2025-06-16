<?php
session_start();
require_once "../classes/Farmer.php";

if (!isset($_SESSION['farmeronline'])) {
    $_SESSION['error_msg'] = "You must be logged in as a farmer to add a product.";
    header('Location: ../addproduct.php');
    exit;
}

// Validate form inputs
if (!isset($_POST['prod_name'], $_POST['prod_category'], $_POST['prod_price'], $_POST['prod_quantity'], $_POST['prod_desc'])) {
    $_SESSION['farmer_upload_error'] = "All fields are required.";
    header('Location: ../addproduct.php');
    exit;
}

$prod_name = htmlspecialchars(trim($_POST['prod_name']));
$prod_category = htmlspecialchars(trim($_POST['prod_category']));
$prod_price = (float)$_POST['prod_price'];
$prod_quantity = (int)$_POST['prod_quantity'];
$prod_desc = htmlspecialchars(trim($_POST['prod_desc']));
$farmer_id = $_SESSION['farmeronline'];

// Handle file upload
$upload_dir = "../uploads/";
$uploaded_file = "";

if (isset($_FILES['prod_image']) && $_FILES['prod_image']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['prod_image']['tmp_name'];
    $file_name = basename($_FILES['prod_image']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png'];

    if (!in_array($file_ext, $allowed_extensions)) {
        $_SESSION['farmer_upload_error'] = "Only JPG, JPEG, and PNG files are allowed.";
        header('Location: ../addproduct.php');
        exit;
    }

    $uploaded_file = $upload_dir . uniqid() . "." . $file_ext;

    if (!move_uploaded_file($file_tmp, $uploaded_file)) {
        $_SESSION['farmer_upload_error'] = "Failed to upload the product image.";
        header('Location: ../addproduct.php');
        exit;
    }
}

try {
    // Save product to the database
    $farmer = new Farmer();
    $farmer->addProduct($farmer_id, $prod_name, $cart_name, $prod_price, $prod_quantity, $prod_desc, $uploaded_file);

    $_SESSION['farmer_upload'] = "Product added successfully!";
    header('Location: ../dashboard.php');
    exit;
} catch (Exception $e) {
    $_SESSION['farmer_upload_error'] = "An error occurred: " . $e->getMessage();
    header('Location: ../addproduct.php');
    exit;
}
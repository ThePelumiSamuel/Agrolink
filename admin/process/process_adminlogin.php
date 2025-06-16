<?php
session_start();
require_once "../classes/Admin.php";

if (isset($_POST['admin_username'], $_POST['admin_password'])) {
    $username = htmlspecialchars(trim($_POST['admin_username']));
    $password = htmlspecialchars(trim($_POST['admin_password']));

    $admin = new Admin();

    try {
        $adminDetails = $admin->login($username, $password);

        if ($adminDetails) {
            // Store admin details in session
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $adminDetails['admin_id']; // Ensure this matches the column name in your DB
            $_SESSION['admin_username'] = $adminDetails['admin_username'];

            // Redirect to admin dashboard
            header('Location: ../admin_dashboard.php');
            exit;
        } else {
            $_SESSION['errormsg'] = "Invalid username or password.";
            header('Location: ../admin_login.php');
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['errormsg'] = "An error occurred: " . $e->getMessage();
        header('Location: ../admin_login.php');
        exit;
    }
} else {
    $_SESSION['errormsg'] = "Please fill in all fields.";
    header('Location: ../admin_login.php');
    exit;
}
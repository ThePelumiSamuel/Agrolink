<?php
session_start();
require_once "../classes/Utility.php";
require_once "../classes/Farmer.php";

$guest = new Farmer;

echo "<pre>";
print_r($_POST);
echo "</pre>";


if (isset($_POST["btnfamreg"])) {
    # retrieve and sanitize data
    $fullname = Utility::sanitize($_POST["fullname"]);
    $email = Utility::sanitize($_POST["email"]);
    $phone = Utility::sanitize($_POST["phone"]);
    $address = Utility::sanitize($_POST["address"]);
    $username = Utility::sanitize($_POST["username"]);
    $state = Utility::sanitize($_POST["state"]);
    $city = Utility::sanitize($_POST["city"]);
    $pass = $_POST["pass"];
    # validate the form
    if ((trim($fullname) == "") || (trim($email) == "") || (trim($phone) == "") || (trim($username) == "") || (trim($address) == "") || (trim($pass) == "")) {
        $_SESSION["errormsg"] = "All the fields are required";
        header("location:../farmer_register.php");
        exit;
    } elseif ($guest->check_email_exists($email) === true) {
        $_SESSION["errormsg"] = "This email address is already in use";
        header("location:../farmer_register.php"); // <-- fixed redirect
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["errormsg"] = "Please choose a valid email";
        header("location:../farmer_register.php");
        exit;
    } elseif ($guest->check_username_exists($username) === true) {
        $_SESSION["errormsg"] = "This username is already in use";
        header("location:../farmer_register.php");
        exit;
    } else {
        $rsp = $guest->farm_register($fullname, $email, $phone, $username, $pass, $state, $city, $address);
        # check if the registration was successful
        # if yes, redirect to the login page with a success message
        if ($rsp) {
            $_SESSION["feedback"] = "An account has been created for you, please login";
            header("location:../farmer_login.php");
            exit;
        } else {
            $_SESSION["errormsg"] = "Registration failed, try again";
            header("location:../farmer_register.php"); // <-- fixed redirect
            exit;
        }
    }
} else {
    $_SESSION["errormsg"] = "Please complete the form";
    header("location:../farmer_register.php");
    exit;
}



// session_start();
// require_once "../classes/Utility.php";
// require_once "../classes/Farmer.php";

// $farmers = new Farmer;

// if(isset($_POST["btnreg"])){
//    $fullname =Utility::sanitize($_POST["fullname"]);
//     $email =Utility::sanitize ($_POST["email"]);
//     $phone =Utility::sanitize ($_POST["phone"]);
//     $username = $_POST["username"];
//     $pass = $_POST["pass"];
//     $state = $_POST["state"];
//     $city = $_POST["city"];
//     $address = $_POST["address"];
//     echo "<pre>";
//     print_r($_SESSION);
//     echo "</pre>";
//     die();

//     // Check if all fields are filled
//     // Check if password is same

//     if(($fullname)=="" || ($email)=="" || ($phone)=="" || ($username)=="" || ($pass)=="" || ($state)=="" || ($city)=="" || ($address)=="") {
//         $_SESSION["errormsg"] = "All fields are required";
//         header("Location: ../farmer_register.php");
//         exit();
//     }
//     elseif (strlen($pass) < 8) {
//         $_SESSION["errormsg"] = "Password must be at least 8 characters long";
//         header("Location: ../farmer_register.php");
//         exit();
//     }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $_SESSION["errormsg"] = "Invalid email format";
//         header("Location: ../farmer_register.php");
//         exit();
//     }
//     else{
//         $result = $farmers->register($fullname, $email, $phone, $username, $pass, $state, $city, $address);
//         if ($result) {
//                 $_SESSION["success"] = "Account Created Successfully";
//                 header("Location: ../farmer_login.php");
//             }else{
//                 $_SESSION["errormsg"] = "Account Creation Failed";
//                 header("Location: ../farmer_register.php");
//                 exit();
//             }
//         }

// }
// else {
//     $_SESSION["errormsg"] = "Please register to continue";
//     header("Location: ../farmer_register.php");
//     exit();
// }
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

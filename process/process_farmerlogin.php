<?php
session_start();
require_once "../classes/Farmer.php";
$vendor = new Farmer;

if(isset($_POST["btnflogin"])){
    $username = $_POST["username"];
    $pass = $_POST["password"];
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    
    // Check if all fields are filled
    if(($username)=="" || ($pass)=="") {
        $_SESSION["errormsg"] = "All fields are required";
        header("Location: ../farmer_login.php");
        // exit();
       
    
    }
    $rsp = $vendor->login($username,$pass); // go and create a method in the Farmer.php
    if($rsp){// rsp can be the id or false
        $_SESSION["farmeronline"]= $rsp;
        header("location:../dashboard.php");
        exit;
    }else{
        header("location:../farmer_login.php");
    }
}
?>


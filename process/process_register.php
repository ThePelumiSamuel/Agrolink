<?php 

session_start();
require_once "../classes/Utility.php";
require_once "../classes/Guest.php";

$guest = new Guest;

if(isset($_POST["btnreg"])){
    # retrieve and sanitize data
    $fname=Utility::sanitize($_POST["fname"]);
    $lname=Utility::sanitize($_POST["lname"]);
    $email=Utility::sanitize($_POST["email"]);
    $phone=Utility::sanitize($_POST["phone"]);
    $address=Utility::sanitize($_POST["address"]);
    $pass1=$_POST["pass1"];
    $pass2=$_POST["pass2"];
    # validate the form
    if((trim($fname)=="") || (trim($lname)=="") || (trim($email)=="") || (trim($phone)=="") || (trim($address)=="") ||(trim($pass1)=="")){
        $_SESSION["errormsg"]="All the fields are required";
        header("location:../register.php");
        exit;
    }elseif($pass1 != $pass2){
            $_SESSION["errormsg"]="The two password must match";
            header("location:../register.php");
            exit; 
        }elseif($guest->check_email_exists($email)===true){
            $_SESSION["errormsg"]="This email address is already in use";
            header("location:../register.php");
            exit; 
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION["errormsg"]="Please choose a valid email";
            header("location:../register.php");
            exit; 
        }else{
            $rsp = $guest->register($fname, $lname, $email, $phone, $address, $pass1);
            # check if the registration was successful
            if($rsp){
                $_SESSION["feedback"] = "An account has been created for you, please login";
                header("location:../index.php");
                exit;
            }else{
                $_SESSION["errormsg"]="Registration failed, try again";
                header("location:../register.php");
                exit; 
            }
        }
    }else{
    $_SESSION["errormsg"]= "Please complete the form";
    header("location:../register.php");
    exit;
    }
?>
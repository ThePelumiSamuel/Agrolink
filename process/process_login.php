<?php
    session_start();
    require_once "../classes/Guest.php";
    $guest = new Guest;

    if(isset($_POST["btnlogin"])){
    
        $email = $_POST["email"];
        $pass = $_POST["pass"];
        $rsp = $guest->login($email,$pass); // go and create a method in the Guest.php
        if($rsp){// rsp can be the id or false
            $_SESSION["useronline"]= $rsp;

            header("location:../index.php");
            exit;
        }else{
            header("location:../login.php");
        }

    }else{
        $_SESSION["errormsg"]= "Please complete the form";
        header('locatoin:../index.php');
        exit;
    }

?>
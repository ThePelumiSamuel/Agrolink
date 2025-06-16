<?php
    session_start();
    if(!isset($_SESSION['useronline'])){
        echo "You need to be online";
        exit;
    }
    require_once "../classes/Guest.php";


    if(isset($_POST['fname'])){
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $phone = $_POST['phone'];
        $profile = $_POST['profile'];

        echo "<pre>";
            print_r($_POST);
        echo "</pre>";
            
        
    
        $guest = new Guest;
        $check = $guest->update_profile($fname, $lname,$phone,$profile, $_SESSION['useronline']);
        echo "Your profile has been updated";
    }else{
        echo "Access Denied";
    }
?>
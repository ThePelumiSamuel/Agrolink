<?php
    if(isset($_SESSION['useronline'])){
        header("location: dashboard.php");
        exit;
    }

    if(isset($_SESSION['farmeronline'])){
        header("location: dashboard.php");
        exit;
    }

?>
<?php
    session_start();
    require_once "classes/Guest.php";
    $guest = new Guest;
    $guest->logout();
    header("location:index.php");
    exit;

?>
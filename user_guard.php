<?php
session_start();
if (!isset($_SESSION['useronline'])) {
    $_SESSION['errormsg'] = "You must be logged in to view this page";
    header("location:index.php");
    exit;
}

if (!isset($_SESSION['farmeronline'])) {
    $_SESSION['errormsg'] = "You must be logged in to view this page";
    header("location:index.php");
    exit;
}

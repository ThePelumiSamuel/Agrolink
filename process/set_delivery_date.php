<?php
session_start();
require_once "../classes/Delivery.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $delivery_date = $_POST['delivery_date'];

    $delivery = new Delivery();
    $result = $delivery->set_delivery_date($order_id, $delivery_date);

    if ($result) {
        $_SESSION['feedback_msg'] = "Delivery date set successfully!";
        header("Location: ../dashboard.php");
    } else {
        $_SESSION['error_msg'] = "Failed to set delivery date.";
        header("Location: ../set_delivery_date.php?order_id=$order_id");
    }
    exit;
}
?>
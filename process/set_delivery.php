<?php
session_start();
require_once "../classes/Delivery.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];
    $delivery_address = htmlspecialchars(trim($_POST['delivery_address']));
    $delivery_date = $_POST['delivery_date'];
    $delivery_notes = htmlspecialchars(trim($_POST['delivery_notes']));

    $delivery = new Delivery();
    $result = $delivery->set_delivery($order_id, $delivery_address, $delivery_date, $delivery_notes);

    if ($result) {
        $_SESSION['feedback_msg'] = "Delivery details set successfully!";
        header("Location: farmer_dashboard.php");
    } else {
        $_SESSION['error_msg'] = "Failed to set delivery details.";
        header("Location: set_delivery.php");
    }
    exit;
}
?>
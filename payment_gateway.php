<?php
session_start();
require_once "classes/Payment.php";

if (!isset($_SESSION['order_id'])) {
    $_SESSION['error_msg'] = "No order found for payment.";
    header("Location: confirm_payment.php");
    exit;
}

$order_id = $_SESSION['order_id'];

try {
    $payment = new Payment();

    // Fetch order details
    $order_details = $payment->get_order_details($order_id);

    if (!$order_details) {
        $_SESSION['error_msg'] = "Order not found.";
        header("Location: confirm_payment.php");
        exit;
    }

    // Initialize payment (e.g., with Paystack)
    $email = $order_details['customer_email'];
    $amount = $order_details['orders_total_price'];
    $reference = uniqid("PAY_");

    $payment_response = $payment->paystack_initialize($email, $amount, $reference);

    if ($payment_response['status']) {
        // Redirect to Paystack payment page
        header("Location: " . $payment_response['data']['authorization_url']);
        exit;
    } else {
        $_SESSION['error_msg'] = "Payment initialization failed.";
        header("Location: confirm_payment.php");
        exit;
    }
} catch (Exception $e) {
    $_SESSION['error_msg'] = "Error initializing payment: " . $e->getMessage();
    header("Location: confirm_payment.php");
    exit;
}
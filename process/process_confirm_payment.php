<?php
session_start();
require_once "../classes/Payment.php"; // Include the Payment class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['order_id']) || empty($_POST['order_id'])) {
        $_SESSION['error_msg'] = "Invalid request. Order ID is missing.";
        header("Location: ../confirm_payment.php");
        exit;
    }

    $order_id = $_POST['order_id'];

    // Store the order ID in the session for the payment process
    $_SESSION['order_id'] = $order_id;

    try {
        // Initialize the Payment class
        $payment = new Payment();

        // Fetch order details using the order ID
        $order_details = $payment->get_order_details($order_id);

        // echo "<pre>";
        // print_r($order_details);
        // echo "</pre>";
        // exit;

        if (!$order_details) {
            $_SESSION['error_msg'] = "Order not found.";
            header("Location: ../confirm_payment.php");
            exit;
        }

        if (!isset($_SESSION['order_id'])) {
            $_SESSION['error_msg'] = "No order found to confirm.";
            header("Location: checkout.php");
            exit;
        }

        $order_id = $_SESSION['order_id'];
        echo "Order ID: " . htmlspecialchars($order_id); // Debugging: Check the order ID

        // Prepare payment details
        $email = $order_details['customer_email'];
        $amount = $order_details['total_price']; // Paystack expects kobo
        $reference = uniqid("AGRO_");
        $_SESSION['ref'] = $reference;

        if (empty($email) || empty($amount)) {
            $_SESSION['error_msg'] = "Order details missing (email or amount).";
            header("Location: ../confirm_payment.php");
            exit;
        }

        // Initialize payment (e.g., with Paystack)
        $callback_url = "http://localhost/Agrolink%20project/delivery_details.php";
$payment_response = $payment->paystack_initialize($email, $amount, $reference, $callback_url);

        // Debug: See the full response from Paystack
        // echo "<pre>"; print_r($payment_response); echo "</pre>"; exit;

        if ($payment_response && $payment_response->status) {
            header("Location: " . $payment_response->data->authorization_url);
            exit;
        } else {
            $_SESSION['error_msg'] = "Payment initialization failed. Please try again.";
            header("Location: ../confirm_payment.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['error_msg'] = "Error processing payment: " . $e->getMessage();
        header("Location: ../confirm_payment.php");
        exit;
    }
} else {
    $_SESSION['error_msg'] = "Invalid request method.";
    header("Location: ../confirm_payment.php");
    exit;
}

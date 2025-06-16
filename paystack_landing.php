<?php
session_start();
require_once "classes/Payment.php";
require_once "classes/Delivery.php";

// Check if the reference is provided in the query string
if (isset($_GET['reference'])) {
    $ref = $_GET['reference'];
    $_SESSION['ref'] = $ref; // Store the reference in the session for future use
} elseif (isset($_SESSION['ref'])) {
    $ref = $_SESSION['ref'];
} else {
    $_SESSION['error_msg'] = "No payment reference found.";
    header("Location: confirm_payment.php");
    exit;
}

$pay = new Payment();
$delivery = new Delivery();

// Verify the payment with Paystack
$rsp = $pay->paystack_verify($ref);

if ($rsp && $rsp->status) {
    $paystatus = "paid";
    $amt_deducted = $rsp->data->amount / 100; // Convert from kobo to naira
    $guestid = $_SESSION['useronline'];
    $orderid = $_SESSION['order_id'];
    $data = json_encode($rsp);

    // Insert payment into the database
    $payid = $pay->insert_payment($amt_deducted, $guestid, $ref, $orderid);
    if ($payid) {
        // Fetch delivery details
        $delivery_details = $delivery->get_delivery_by_order($orderid);
        if (!$delivery_details) {
            // Get address from order or user
            $order_details = $pay->get_order_details($orderid);
            $delivery_address = $order_details['delivery_address'] ?? 'No address provided';
            $delivery_date = date('Y-m-d');
            $delivery_notes = 'Order paid, delivery initialized.';
            $delivery->set_delivery($orderid, $delivery_address, $delivery_date, $delivery_notes);
            $success = $delivery->set_delivery($orderid, $delivery_address, $delivery_date, $delivery_notes);
            if (!$success) {
                die("Failed to insert delivery record for order $orderid");
            }

            // Fetch again after creating
            $delivery_details = $delivery->get_delivery_by_order($orderid);
        }
        if ($delivery_details) {
            $_SESSION['delivery_details'] = $delivery_details;
            $_SESSION['feedback'] = "Payment was successful. Delivery details fetched.";
        } else {
            $_SESSION['error_msg'] = "Payment was successful, but delivery details could not be fetched.";
        }
    } else {
        $paystatus = "failed";
        $_SESSION['error_msg'] = "Payment verification failed.";
    }

    // Redirect to the delivery details page
    header("Location: delivery_details.php");
    exit;
} else {
    $_SESSION['error_msg'] = "Payment verification failed. Please try again.";
    header("Location: confirm_payment.php");
    exit;
}

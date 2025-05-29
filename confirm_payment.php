<?php
session_start();
require_once "classes/Guest.php";
require_once "classes/Farmer.php";
require_once "classes/Payment.php";
$vendor = new Farmer;
if (isset($_SESSION['farmeronline'])) {
    $id = $_SESSION['farmeronline'];
    $res = $vendor->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}

$users = new Guest();

// $vendor = new Farmer;
if (isset($_SESSION['useronline'])) {
    $id = $_SESSION['useronline'];
    $deets = $users->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}


require_once "partials/header.php"; // Include the header file


// Check if the order ID is set in the session
if (!isset($_SESSION['order_id'])) {
    $_SESSION['error_msg'] = "No order found to confirm.";
    header("Location: checkout.php");
    exit;
}

$order_id = $_SESSION['order_id'];

try {
  $guest = new Guest();
  $order_details = $guest->get_orderbyid($order_id); // Fetch order details using the Guest class

  echo "<pre>";
  print_r($order_details); // Debugging: Check the structure of the returned data
  echo "</pre>";
  // exit; // Uncomment this to stop execution and debug the output

  if (!$order_details) {
      $_SESSION['error_msg'] = "Order not found.";
      header("Location: checkout.php");
      exit;
  }
} catch (Exception $e) {
  $_SESSION['error_msg'] = "Error fetching order details: " . $e->getMessage();
  header("Location: checkout.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="assets/css/styles.css"> <!-- Add your CSS file -->
</head>
<body>
    <div class="container col-md-6 offset-md-3 mt-5 shadow p-4 bg-light rounded ">
        <h3>Confirm Your Order</h3>

        <?php if (isset($_SESSION['error_msg'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo htmlspecialchars($_SESSION['error_msg']); 
            unset($_SESSION['error_msg']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['feedback_msg'])): ?>
        <div class="alert alert-success">
            <?php 
            echo htmlspecialchars($_SESSION['feedback_msg']); 
            unset($_SESSION['feedback_msg']); // Clear the message after displaying
            ?>
        </div>
    <?php endif; ?>
        <div class="order-summary">
            <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order_details['order_id'] ?? 'N/A'); ?></p>
            <p><strong>Total Amount:</strong> NGN <?php echo number_format($order_details['total_price'] ?? 0, 2); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($order_details['status'] ?? 'N/A'); ?></p>
        </div>

        <form action="process/process_confirm_payment.php" method="post">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_details['order_id'] ?? ''); ?>">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    </div>
</body>
</html>
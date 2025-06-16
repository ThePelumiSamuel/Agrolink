<?php
session_start();

if (!isset($_SESSION['delivery_details'])) {
    $_SESSION['error_msg'] = "No delivery details found.";
    header("Location: confirm_payment.php");
    exit;
}

if ($delivery_details) {
    $_SESSION['delivery_details'] = $delivery_details;
    $_SESSION['feedback'] = "Payment was successful. Delivery details fetched.";
    header("Location: delivery_details.php");
    exit;
}

echo "<pre>";
print_r($_SESSION['delivery_details']);
echo "</pre>";
exit;

$delivery_details = $_SESSION['delivery_details'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Details</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Delivery Details</h3>
        <p><strong>Delivery Address:</strong> <?php echo htmlspecialchars($delivery_details['delivery_address']); ?></p>
        <p><strong>Delivery Status:</strong> <?php echo htmlspecialchars($delivery_details['delivery_status']); ?></p>
        <p><strong>Delivery Date:</strong> <?php echo htmlspecialchars($delivery_details['delivery_date']); ?></p>
        <p><strong>Notes from Farmer:</strong> <?php echo htmlspecialchars($delivery_details['delivery_notes']); ?></p>
        <a href="dashboard.php" class="btn btn-primary">Go to Dashboard</a>
    </div>
</body>
</html>
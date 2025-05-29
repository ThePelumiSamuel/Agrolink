<?php
session_start();
require_once "classes/Delivery.php";

if (!isset($_GET['order_id'])) {
    $_SESSION['error_msg'] = "No order selected.";
    header("Location: dashboard.php");
    exit;
}

$order_id = $_GET['order_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Delivery Date</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Set Delivery Date</h3>
        <form action="process/set_delivery_date.php" method="POST">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <div class="mb-3">
                <label for="delivery_date" class="form-label">Delivery Date</label>
                <input type="date" name="delivery_date" id="delivery_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Set Delivery Date</button>
        </form>
    </div>
</body>
</html>
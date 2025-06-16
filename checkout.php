<?php
session_start();
require_once "classes/Utility.php";
require_once "classes/Guest.php";

$users = new Guest;
if (isset($_SESSION['useronline'])) {
    $id = $_SESSION['useronline'];
    $deets = $users->getuser($id);
}
require_once "partials/header.php";
?>

<div class="container mt-5">
    <h2>Checkout</h2>


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


    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        

        <?php
// echo "<pre>";
// print_r($_SESSION['cart']);
// echo "</pre>";
?>
        <div class="row">
            <div class="col-md-8">
                <h4>Order Summary</h4>
                <ul class="list-group mb-4">
                    <?php
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $product_id => $product) {
                        $total = $product['price'] * $product['quantity'];
                        $grand_total += $total;
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6><?php echo htmlspecialchars($product['name']); ?></h6>
                                <small>Price: ₦<?php echo number_format($product['price'], 2); ?> x <?php echo $product['quantity']; ?></small>
                            </div>
                            <span>₦<?php echo number_format($total, 2); ?></span>
                        </li>
                        <?php
                    }
                    ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong>Grand Total</strong>
                        <strong>₦<?php echo number_format($grand_total, 2); ?></strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-4">
                <h4>Billing Details</h4>
                <form action="process/process_checkout.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
    <?php else: ?>
        <p>Your cart is empty. <a href="store.php">Continue Shopping</a></p>
    <?php endif; ?>
</div>

<?php
require_once "partials/footer.php";
?>
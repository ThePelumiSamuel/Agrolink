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
   <h2>Your Cart</h2>
   
   <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
      <div class="row">
      <?php
   if (isset($_SESSION["errormsg"])) {
      echo "<p class='alert alert-danger'>" . $_SESSION["errormsg"] . "</p>";
      unset($_SESSION['errormsg']);
   }
   if (isset($_SESSION["feedback"])) {
      echo "<p class='alert alert-danger'>" . $_SESSION["feedback"] . "</p>";
      unset($_SESSION['feedback']);
   }
   ?>
         <?php
         $grand_total = 0;
         foreach ($_SESSION['cart'] as $product_id => $product) {
            $total = $product['price'] * $product['quantity'];
            $grand_total += $total;
         ?>
            <div class="col-md-4 mb-4">
               <div class="card shadow-sm">
                  <div class="card-body">
                     <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                     <p class="card-text">
                        <strong>Price:</strong> ₦<?php echo number_format($product['price'], 2); ?><br>
                        <strong>Quantity:</strong> <?php echo $product['quantity']; ?><br>
                        <strong>Total:</strong> ₦<?php echo number_format($total, 2); ?>
                     </p>
                     <form action="update_cart.php" method="POST" class="d-inline">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1" class="form-control form-control-sm d-inline-block" style="width: 60px;">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                     </form>
                     <form action="remove_from_cart.php" method="POST" class="d-inline">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                     </form>
                  </div>
               </div>
            </div>
         <?php
         }
         ?>
      </div>
      <div class="text-end">
         <h4><strong>Grand Total:</strong> ₦<?php echo number_format($grand_total, 2); ?></h4>
         <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
      </div>
   <?php else: ?>
      <div class="col-md-12 text-center">
         <p>Your cart is empty.</p>
      </div>
   <?php endif; ?>
</div>

<?php
require_once "partials/footer.php";
?>
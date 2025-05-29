<?php
session_start();
require_once "classes/Utility.php";
require_once "classes/Guest.php";
require_once "classes/Farmer.php";
$users = new Guest;

// Fetch all products
$products = $users->getAllProducts();
// $vendor = new Farmer;
if (isset($_SESSION['useronline'])) {
    $id = $_SESSION['useronline'];
    $deets = $users->getuser($id);
} else {
    // $username = $_SESSION['farmeronline'];
    // $vendors = $vendor->getuser($id);
}
// require_once "user_guard.php";
require_once "partials/header.php";



?>

<!-- banner start -->
<div class="banner">
    <div class="overlay"></div>
    <div class="hero-content">
        <h1>Connecting Farmers with Buyers for a Sustainable Future!</h1>
        <p>Join AgroLink today to sell fresh farm produce directly to customers. Get the best prices and fast delivery!
        </p>
        <div class="hero-buttons">
            <a href="store.php" class="btn btn-success p-2">Start buying</a>
        </div>
    </div>
</div>

<!-- banner end -->

<!-- section one start -->
<div class="container my-5">
    <ul class="nav nav-underline">
        <li class="nav-item">
            <a class="nav-link text-secondary" aria-current="page" href="#">Most Recent</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="#">Seeds</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="#">Perishable</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="#">Processed</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="#">Root and Tubers</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-secondary" href="#">Grains</a>
        </li>
    </ul>
    <hr>
    <div class="row ms-5">
        <?php
        if ($products) {
            $count = 0; // Counter to limit the number of displayed products
            foreach ($products as $product) {
                if ($count >= 12) {
                    break; // Stop displaying products after 12
                }
                $count++;
                ?>
                <div class="col-md-3 mt-3">
                    <div class="product-div p-3 border rounded">
                        <div class="product-image mb-2">
                            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                 style="width: 100%; height: 200px; object-fit: cover;" 
                                 alt="<?php echo htmlspecialchars($product['name']); ?>">
                        </div>
                        <div class="product-info">
                            <h6 class="fw-bold"><?php echo htmlspecialchars($product['name']); ?></h6>
                            <p class="text-muted mb-1">
                                <strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?><br>
                                <strong>Price:</strong> ₦<?php echo number_format($product['price'], 2); ?><br>
                                <strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?>
                            </p>
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['name']); ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='col-12 text-center'><p>No products available.</p></div>";
        }
        ?>
    </div>
    <div class="text-center mt-5">
        <a href="store.php" class="btn btn-outline-success col-2">View More</a>
    </div>
</div>

<!-- section one end -->

<!-- section Two start -->
<div class="container-fluid bg-success">
    <div class="container p-5  d-flex">
        <div class="col-md-6 p-5 text-white">
            <h1 class="pt-3">What our users have to say!</h1>
            <a href="#" class="btn btn-light">Sign up to buy</a>
        </div>
        <div class="col-md-6 bg-white p-5 rounded ">
            <p class="">The site is very fantastic. I recommend it to anyone who wants to do business with Agriple. But
                you must be serious minded. Thank you Agriple for the wonderful opportunity to do business with you.</p>
            <div class="tw-flex tw-flex-row tw-space-x-3">
                <div class="tw-flex tw-flex-col">
                    <span class="tw-font-bold tw-text-lg"><strong>Mr Levi</strong></span><br>
                    <span class="tw-text-sm">Crayfish farmer, PortHarcourt</span>
                </div>
            </div>

        </div>

    </div>
</div>
<!-- section Two end -->

<!-- section three start -->
<div class="container-fluid bg-lightgreen">
    <div class="container">
        <div class="text-center m-5">
            <small class="text-secondary">THE NUMBER SAY IT ALL</small>
            <h1>Why choose Agrolink</h1>
        </div>
        <div class="col-md-12 p-5 text-center d-flex">
            <div class="col-md-4 mb-3">
                <h1 class="text-success">1600+</h1>
                <p>Farmers</p>
                <img src="assets/images/farmer (1).png" class="img-fluid" width="100" alt="">

            </div>
            <div class="col-md-4 mb-3">
                <h1 class="text-success">1600+</h1>
                <p>Customers</p>
                <img src="assets/images/people.png" class="img-fluid" width="100" alt="">

            </div>
            <div class="col-md-4 mb-3">
                <h1 class="text-success">1600+</h1>
                <p>Product Shipped</p>
                <img src="assets/images/basket-fruit.png" class="img-fluid" width="100" alt="">

            </div>
        </div>
    </div>
</div>

<!-- section three end -->


<!-- section four start -->
<div class="container-fluid d-flex bg-success">
    <div class="col-md-6  ">
        <img src="assets/images/farmland.jpg" class="img-fluid rounded" hight="20" alt="">
    </div>
    <div class="col-md-6 mb-3 m-2 p-3">
        <h1 class="m-5 p-2  text-white">Join over 1600 farmers selling today!</h1>
        <a href="#" class="btn btn-light mx-5">Sign up to sell</a>
    </div>
</div>
<!-- section four end -->

<?php

require_once "partials/footer.php";

?>
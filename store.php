<?php
session_start();
require_once "classes/Guest.php";
require_once "classes/Farmer.php";
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


// Fetch all products
$products = $users->getAllProducts();

// Fetch all categories
$categories = $users->getCategories();

require_once "partials/header.php";
?>

<div class="help-banner">
    <div class="overlay"></div>
    <div class="help-content d-flex text-decoration-none text-white">
        <h1><a href=""><strong>Store > </strong></a></h1>
        <h1><a href=""><strong>Home</strong></a></h1>
    </div>
</div>
<div class="container">
    <div class="row d-flex mt-5">

        <!-- Categories Sidebar -->
        <div class="col-md-3 shadow p-4">
            <div class="mb-3">
                <h6><small>Categories</small></h6>
            </div>
            <?php
            if ($categories) {
                foreach ($categories as $category) {
                    echo "<div class='mb-3'>
                            <input type='checkbox' name='category[]' id='category_{$category['id']}' value='{$category['id']}'>
                            <label for='category_{$category['id']}'>" . htmlspecialchars($category['cart_name']) . "</label>
                        </div>";
                }
            } else {
                echo "<div class='mb-3'>
                        <label for=''>No Category Found</label>
                    </div>";
            }
            ?>
        </div>

        <!-- Products Section -->
        <div class="col-md-8 mb-3 d-flex m-1">
            <div class="container my-5">
                <div class="row ms-5">
                    <?php
                    if ($products) {
                        foreach ($products as $product) {
                    ?>
                            <div class="col-md-4 mt-3">
                                <div class="product-div p-3 border rounded">
                                    <div class="product-image mb-2">
                                        <img src="uploads/<?php echo htmlspecialchars($product['image'] ?? ''); ?>"
                                            style="width: 100%; height: 200px; object-fit: cover;"
                                            alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
                                    </div>
                                    <div class="product-info">
                                        <h6 class="fw-bold"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h6>
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
            </div>
        </div>
    </div>
</div>

<?php
require_once "partials/footer.php";
?>
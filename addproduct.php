<?php
session_start();
require_once "classes/Farmer.php";
$vendor = new Farmer;
if (isset($_SESSION['farmeronline'])) {
    $id = $_SESSION['farmeronline'];
    $res = $vendor->getuser($id);

    // Fetch categories
    $categories = $vendor->getCategories();
}
require_once "partials/header.php";
?>

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="col-md mb-3 d-flex shadow p-3 mb-5 bg-white rounded">
                <div class="col-mb-4 p-4 mb-3">
                    <p><strong>INSTRUCTION</strong></p>
                    <ul class="list-group list-group-flush">
                        <li>Select your farm product name from the list in the box containing product names.
                        </li>
                        <li><strong>Note:</strong> If your farm product is not listed in the box, click on the button beside the box to create it. You will be required to enter the product's name and select the category it belongs to. When you submit the form, your product will now be among the listed products in the product box, so go ahead and select it.</li>
                        <li>Enter the price (per kilogram) in the price box, and the quantity available in the quantity box.</li>
                        <li>Complete the process by entering the description specific to your product e.g the specie, color etc, upload up to five different images for your product.</li>
                        <li>Submit the form, and your goods will be sent for verification by the administrator.</li>
                        <li>Remember, the better the price, the faster you sell.</li>
                    </ul>
                </div>
                <div class="vr"></div>
                <div class="col-md-8  p-4 mb-3">
                    <?php
                    if (isset($_SESSION['farmer_upload'])) { ?>
                        <p class="alert alert-success">
                            <?php
                            echo $_SESSION['farmer_upload'];
                            unset($_SESSION['farmer_upload']);
                            ?>
                        </p>
                    <?php
                    }
                    if (isset($_SESSION['farmer_upload_error'])) { ?>
                        <p class="alert alert-danger">
                            <?php
                            echo $_SESSION['farmer_upload_error'];
                            unset($_SESSION['farmer_upload_error']);
                            ?>
                        </p>
                    <?php
                    }
                    ?>
                    <form action="process/process_addproduct.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="prod_name"><strong>Product Name</strong></label>
                            <input name="prod_name" id="prod_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prod_category">Category:</label>
                            <select name="prod_category" id="prod_category" required class="form-select">
                                <option value="" disabled selected>Select a Category</option>
                                <?php
                                if ($categories) {
                                    foreach ($categories as $category) {
                                        echo '<option value="' . htmlspecialchars($category['cart_name']) . '">' . htmlspecialchars($category['cart_name']) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No categories available</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="prod_price"><strong>Price per Unit (in Naira)</strong></label>
                            <input type="number" name="prod_price" id="prod_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prod_quantity"><strong>Available Quantity</strong></label>
                            <input type="number" name="prod_quantity" id="prod_quantity" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prod_desc"><strong>Product Description</strong></label>
                            <textarea name="prod_desc" id="prod_desc" cols="30" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="prod_image"><strong>Upload Product Image</strong></label>
                            <input type="file" name="prod_image" id="prod_image" class="form-control" required>
                        </div>
                        <button class="btn btn-success" type="submit">Create Product</button>
                    </form>

                </div>

            </div>

        </div>
    </div>
</div>
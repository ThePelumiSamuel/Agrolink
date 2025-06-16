<?php
session_start();
require_once "classes/Farmer.php";

require_once "partials/header.php";

if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$product_id = $_GET['id'];
$farmer = new Farmer();
$product = $farmer->getProductById($product_id);
$categories = $farmer->getCategories();


if (isset($_POST['name'], $_POST['description'], $_POST['category'], $_POST['quantity'], $_POST['price'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $description = htmlspecialchars(trim($_POST['description']));
    $category = htmlspecialchars(trim($_POST['category']));
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $image = null;

    // Handle image upload if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = "uploads/";
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png'];

        if (!in_array($file_ext, $allowed_extensions)) {
            $_SESSION['error_msg'] = "Only JPG, JPEG, and PNG files are allowed.";
            header('Location: edit_product.php?id=' . $product_id);
            exit;
        }

        $image = uniqid() . "." . $file_ext;
        $uploaded_file = $upload_dir . $image;

        if (!move_uploaded_file($file_tmp, $uploaded_file)) {
            $_SESSION['error_msg'] = "Failed to upload the product image.";
            header('Location: edit_product.php?id=' . $product_id);
            exit;
        }
    }

    try {
        $farmer->updateProduct($product_id, $name, $description, $category, $quantity, $price, $image);
        $_SESSION['success_msg'] = "Product updated successfully!";
        header('Location: dashboard.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['error_msg'] = $e->getMessage();
        header('Location: edit_product.php?id=' . $product_id);
        exit;
    }
}
?>

<form method="POST" enctype="multipart/form-data" class=" container mt-4 mb-4 p-4 border rounded shadow bg-light">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="3" required><?php echo htmlspecialchars($product['description']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
        <select name="category" id="category" class="form-select" required>
            <option value="" disabled>Select a Category</option>
            <?php
            foreach ($categories as $cat) {
                $selected = $product['category'] == $cat['cart_name'] ? 'selected' : ''; // Pre-select the current category
                echo "<option value='" . htmlspecialchars($cat['cart_name']) . "' $selected>" . htmlspecialchars($cat['cart_name']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo $product['quantity']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" name="price" id="price" class="form-control" value="<?php echo $product['price']; ?>" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Product Image (Optional)</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary w-100">Update Product</button>
</form>
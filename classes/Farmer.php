<?php
require_once "Db.php";

class Farmer extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    public function farm_register($fullname, $email, $phone, $username, $pass, $state, $city, $address)
    {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO farmers SET fullname=?, email=?, phone=?, username=?, password=?, state=?, city=?, address=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$fullname, $email, $phone, $username, $hashed, $state, $city, $address]);
        $id = $this->dbconn->lastInsertId();
        return $id; # di will be 0 on failure and >0 on success

    }
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";

    public function check_username_exists($username)
{
    try {
        $sql = "SELECT * FROM farmers WHERE username = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$username]);
        $farmer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $farmer ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}



    public function insertCategories()
    {
        try {
            $categories = [
                "Seeds",
                "Perishables",
                "Processed",
                "Root and Tuber",
                "Grains"
            ];

            $sql = "INSERT INTO categories(cart_name) VALUES (?)";
            $stmt = $this->dbconn->prepare($sql);

            foreach ($categories as $category) {
                $stmt->execute([$category]);
            }

            return "Categories inserted successfully";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function addProduct($farmer_id, $prod_name, $cart_name, $prod_price, $prod_quantity, $prod_description, $prod_image)
    {
        try {
            $sql = "INSERT INTO products (farmer_id, name, category, price, quantity, description, image, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$farmer_id, $prod_name, $cart_name, $prod_price, $prod_quantity, $prod_description, $prod_image]);
        } catch (PDOException $e) {
            throw new Exception("Error adding product: " . $e->getMessage());
        }
    }



    public function getCategories()
    {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($categories) {
                return $categories;
            } else {
                return false; // No categories found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function login($username, $pass)
    {
        try {

            $sql = "SELECT * FROM farmers WHERE username=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$username]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                $stored_hash = $data['password'];
                $check = password_verify($pass, $stored_hash); // returns true or false
                if ($check) {
                    return $data['id'];
                } else {
                    $_SESSION["errormsg"] = "Invalid Password";
                    return false;
                }
            } else {
                $_SESSION["errormsg"] = "Invalid Username";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getuser($id)
    {
        try {
            $sql = "SELECT * FROM farmers WHERE id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $farmers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($farmers) {
                return $farmers;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function checkEmail($email)
    {
        try {
            $sql = "SELECT * FROM farmers WHERE email=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getAllProducts()
    {
        try {
            $sql = "SELECT * FROM products";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProduct($id)
    {
        try {
            $sql = "SELECT * FROM product WHERE id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product) {
                return $product;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProductsByCategory($catid)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_cat_id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$catid]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProductsBySearch($search)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_name LIKE ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute(['%' . $search . '%']);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProductsByPrice($price)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_price <= ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$price]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getProductsByStatus($status)
    {
        try {
            $sql = "SELECT * FROM products WHERE status=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$status]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function getProductsByFarmer($farmerid)
    {
        try {
            $sql = "SELECT * FROM products WHERE farmer_id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$farmerid]);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($products) {
                return $products;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }




public function getFarmerProduct($farmer_id)
{
    try {
        $sql = "SELECT * FROM products WHERE farmer_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$farmer_id]);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products;
    } catch (PDOException $e) {
        throw new Exception("Error fetching farmer products: " . $e->getMessage());
    }
}



    public function updateFarmerProfile($id, $fullname, $email, $phone, $address, $profile_image = null)
    {
        try {
            if ($profile_image) {
                $sql = "UPDATE farmers SET fullname = ?, email = ?, phone = ?, address = ?, profile_image = ? WHERE id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$fullname, $email, $phone, $address, $profile_image, $id]);
            } else {
                $sql = "UPDATE farmers SET fullname = ?, email = ?, phone = ?, address = ? WHERE id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$fullname, $email, $phone, $address, $id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Error updating farmer profile: " . $e->getMessage());
        }
    }



    public function getFarmerDetails($farmer_id)
    {
        try {
            $sql = "SELECT fullname, email, phone, address FROM farmers WHERE id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$farmer_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching farmer details: " . $e->getMessage());
        }
    }

    public function check_email_exists($email)
{
    try {
        $sql = "SELECT * FROM farmers WHERE email = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$email]);
        $farmer = $stmt->fetch(PDO::FETCH_ASSOC);
        return $farmer ? true : false;
    } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
    }
}

    public function getProductById($product_id)
    {
        try {
            $sql = "SELECT * FROM products WHERE id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$product_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single product as an associative array
        } catch (PDOException $e) {
            throw new Exception("Error fetching product: " . $e->getMessage());
        }
    }


    public function updateProduct($product_id, $name, $description, $category, $quantity, $price, $image = null)
    {
        try {
            if ($image) {
                // Update product with a new image
                $sql = "UPDATE products SET name = ?, description = ?, category = ?, quantity = ?, price = ?, image = ? WHERE id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$name, $description, $category, $quantity, $price, $image, $product_id]);
            } else {
                // Update product without changing the image
                $sql = "UPDATE products SET name = ?, description = ?, category = ?, quantity = ?, price = ? WHERE id = ?";
                $stmt = $this->dbconn->prepare($sql);
                $stmt->execute([$name, $description, $category, $quantity, $price, $product_id]);
            }
        } catch (PDOException $e) {
            throw new Exception("Error updating product: " . $e->getMessage());
        }
    }

    public function deleteProduct($product_id)
    {
        try {
            $sql = "DELETE FROM products WHERE id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$product_id]);
            return true; // Return true if the product was successfully deleted
        } catch (PDOException $e) {
            throw new Exception("Error deleting product: " . $e->getMessage());
        }
    }


    public function getFarmerOrders($farmer_id) {
        try {
            $sql = "SELECT 
                        orders.order_id,
                        orders.order_date,
                        orders.total_price,
                        users.username AS user_fname,
                        users.email AS user_email,
                        products.name AS product_name,
                        products.description AS product_description
                    FROM orders
                    INNER JOIN products ON orders.product_id = products.id
                    INNER JOIN users ON orders.user_id = users.id
                    WHERE products.farmer_id = ?";
                    
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$farmer_id]);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all orders as an associative array
        } catch (PDOException $e) {
            error_log("Error fetching farmer orders: " . $e->getMessage());
            return [];
        }
       
    }
    public function getOrderedProducts($farmer_id)
{
    try {
        $sql = "SELECT 
                    order_items.order_item_id,
                    orders.order_id,
                    order_items.quantity,
                    order_items.total_price,
                    products.name AS product_name,
                    users.user_fname,
                    users.user_lname
                FROM order_items
                JOIN products ON order_items.product_name = products.name
                JOIN orders ON order_items.order_id = orders.order_id
                JOIN users ON orders.user_id = users.user_id
                WHERE products.farmer_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$farmer_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
        return [];
    }
}
}

// $farmers = new Farmer;   
// echo $farmers->add_product("Pawpaw","seeds","3000","1 basket of Pawpaw", "ife.png");

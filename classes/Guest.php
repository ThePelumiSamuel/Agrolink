<?php
require_once "Db.php";

class Guest extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    public function logout()
    {
        unset($_SESSION['useronline']);
        session_destroy();
    }


    public function register($fname, $lname, $email, $phone, $address, $pass)
    {
        $hashed = password_hash($pass, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users SET user_fname=?, user_lname=?, user_email =?, user_phone=?, user_address=?, user_pwd=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$fname, $lname, $email, $phone, $address, $hashed]);
        $id = $this->dbconn->lastInsertId();
        return $id; # di will be 0 on failure and >0 on success
    }

    public function check_email_exists($email)
    {
        $sql = "SELECT * FROM users WHERE user_email=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    public function order($user_id, $prod_id, $qty, $total)
    {
        $sql = "INSERT INTO orders SET user_id=?, prod_id=?, order_qty=?, order_total=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$user_id, $prod_id, $qty, $total]);
        return true;
    }
    public function get_order($user_id)
    {
        $sql = "SELECT * FROM orders WHERE user_id=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$user_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update_profile($fname, $lname, $phone, $profile, $id)
    {
        $sql = "UPDATE users SET user_fname=?, user_lname=?, user_phone=?, user_profile=? WHERE user_id=?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$fname, $lname, $phone, $profile, $id]);
        return true;
    }

    public function get_active_category($cart_id)
    {
        try {
            $sql = "SELECT * FROM categories WHERE cart_name=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$cart_id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function get_active_product()
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_status=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute(['1']);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_id($id)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_category($catid)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_cat_id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$catid]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_search($search)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_name LIKE ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute(['%' . $search . '%']);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_price($price)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_price <= ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$price]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_price_range($min, $max)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_price BETWEEN ? AND ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$min, $max]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function get_product_by_rating($rating)
    {
        try {
            $sql = "SELECT * FROM products WHERE prod_rating >= ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$rating]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }



    // public function register($fname,$lname,$email,$phone,$role,$pass){
    //     try{
    //         $hashed = password_hash($pass, PASSWORD_DEFAULT);
    //         $sql = "INSERT INTO users SET user_fname=?,user_lname=?,user_email=?,user_phone=?,user_role=?, user_pwd=?";
    //         $stmt=$this->dbconn->prepare($sql);
    //         $stmt->execute([$fname,$lname,$email,$phone,$role,$hashed]);
    //         $id=$this->dbconn->lastInsertId();
    //         if($stmt){
    //             return "Account Created Successfully";
    //         }else{
    //             return "Account Creation Failed";
    //         }
    //     }catch(PDOException $e){
    //         echo $e->getMessage();
    //         return false;
    //     }
    // }




    public function login($email, $pass)
    {
        try {

            $sql = "SELECT * FROM users WHERE user_email=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) {
                $stored_hash = $data['user_pwd'];
                $check = password_verify($pass, $stored_hash); // returns true or false
                if ($check) {
                    return $data['user_id'];
                } else {
                    $_SESSION["errormsg"] = "Invalid Password";
                    return false;
                }
            } else {
                $_SESSION["errormsg"] = "Invalid Email";
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
            $sql = "SELECT * FROM users WHERE user_email=?";
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

    public function getuser($id)
    {
        try {
            $sql = "SELECT * FROM users WHERE user_id=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$id]);
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($users) {
                return $users;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }


    public function createOrder($name, $email, $address, $grand_total)
{
    try {
        $sql = "INSERT INTO orders (customer_name, customer_email, customer_address, total_price, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$name, $email, $address, $grand_total]);
        return $this->dbconn->lastInsertId(); // Return the order ID
    } catch (PDOException $e) {
        throw new Exception("Error creating order: " . $e->getMessage());
    }
}



    public function addOrderItem($order_id, $product_name, $product_price, $product_quantity)
{
    try {
        $sql = "INSERT INTO order_items (order_id, product_name, price, quantity, total_price, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->dbconn->prepare($sql);
        $total_price = $product_price * $product_quantity;
        $stmt->execute([$order_id, $product_name, $product_price, $product_quantity, $total_price]);
    } catch (PDOException $e) {
        throw new Exception("Error adding order item: " . $e->getMessage());
    }
}



    public function getAllProducts()
    {
        try {
            $sql = "SELECT * FROM products ";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($products) {
                return $products;
            } else {
                return false; // No products found
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
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

        // echo '<pre>';
        // print_r($categories);
        // echo '</pre>';
        // exit;
    }


    public function insert_order($item, $guest, $amt, $size)
    {
        try {
            $sql = "INSERT INTO orders SET order_itemid=?,order_by=?,order_amt=?,order_size=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$item, $guest, $amt, $size]);
            return $this->dbconn->lastInsertId(); //we are returning the orderid so that it can be saved in session at the receiving page
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return false;
        }
    }
    public function get_orderbyid($order_id)
{
    try {
        $sql = "SELECT * FROM orders WHERE order_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}
}  // $user = new User;
// echo $user -> register("ife","olu","ife@i","12345","user","ifeolu1234");

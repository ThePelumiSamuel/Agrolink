<?php
require_once "Db.php";

class Admin extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    public function register($username, $password,)
    {
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin (admin_username, admin_password) VALUES (?, ?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$username, $hashed]);
            $id = $this->dbconn->lastInsertId();
            if ($stmt) {
                return "Account Created Successfully";
            } else {
                return "Account Creation Failed";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function login($username, $password)
    {
        try {
            $sql = "SELECT * FROM admin WHERE admin_username = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$username]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                // Verify the password
                if (password_verify($password, $data["admin_password"])) {
                    return $data; // Return the entire admin record
                } else {
                    return false; // Invalid password
                }
            } else {
                return false; // Admin not found
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    // public function fetch_product(){
    //     try{
    //         $sql = "SELECT * FROM product";
    //         $stmt= $this->dbconn->prepare($sql);
    //         $stmt->execute();
    //         $data=$stmt->fetchAll(PDO::FETCH_ASSOC);
    //         return $data;
    //     }catch(PDOException $e){
    //         //echo $e->getMessage();
    //         return false;
    //     }
    // } 


    public function getAdminById($admin_id)
    {
        try {
            $sql = "SELECT admin_id, admin_username, created_at FROM admin WHERE admin_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$admin_id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch admin details as an associative array
        } catch (PDOException $e) {
            throw new Exception("Error fetching admin details: " . $e->getMessage());
        }
    }


    public function getAdminByUsername($username)
    {
        try {
            $sql = "SELECT * FROM admin WHERE admin_username = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch admin details as an associative array
        } catch (PDOException $e) {
            throw new Exception("Error fetching admin details: " . $e->getMessage());
        }
    }

    public function fetch_product()
    {
        try {
            $sql = "SELECT id, name, image, category, price FROM products"; // Adjust column names and table name as per your DB
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all products as an associative array
        } catch (PDOException $e) {
            throw new Exception("Error fetching products: " . $e->getMessage());
        }
    }


    public function fetch_farmers()
    {
        try {
            $sql = "SELECT id, fullname, email, phone FROM farmers"; // Adjust column names as per your DB
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all farmers as an associative array
        } catch (PDOException $e) {
            throw new Exception("Error fetching farmers: " . $e->getMessage());
        }
    }


    public function fetch_users()
{
    try {
        $sql = "SELECT user_id, user_fname, user_lname, user_email, user_phone, user_address FROM users"; // Adjust column names as per your DB
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all users as an associative array
    } catch (PDOException $e) {
        throw new Exception("Error fetching users: " . $e->getMessage());
    }
}


public function fetch_orders()
{
    try {
        $sql = "SELECT 
                    order_id AS order_id,
                    users.user_fname,
                    users.user_lname,
                    users.user_email,
                    users.user_phone,
                    products.name AS product_name,
                    products.price AS product_price,
                    order_quantity,
                    orders_total_price,
                    orders.order_date,
                    orders.status
                FROM orders
                INNER JOIN users ON orders.user_id = users.user_id
                INNER JOIN products ON orders.product_id = products.id
                ORDER BY orders.order_date DESC";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all orders as an associative array
    } catch (PDOException $e) {
        throw new Exception("Error fetching orders: " . $e->getMessage());
    }
}




}
// $admin = new Admin;
//     echo $admin -> login('samuel', 12345678);

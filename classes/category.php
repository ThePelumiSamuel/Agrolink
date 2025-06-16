<?php
require_once "Db.php";

class Category extends Db{
    private $dbconn;

    public function __construct(){
        $this->dbconn=$this->connect();
    }

    public function insertCategories() {
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

}
$category = new Category;
$category->insertCategories();


?>
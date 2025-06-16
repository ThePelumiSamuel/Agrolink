<?php
require_once "Db.php";
class Delivery extends Db
{
    private $dbconn; // Declare the $dbconn property
    public function __construct()
    {
        $this->dbconn = $this->connect();
    }
    public function get_delivery_by_order($orderid)
{
    try {
        $sql = "SELECT * FROM delivery WHERE order_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$orderid]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
    } catch (PDOException $e) {
        error_log("Error fetching delivery: " . $e->getMessage());
        return false;
    }
    
}


    public function set_delivery($orderid, $delivery_address, $delivery_date, $delivery_notes)
    {
        try {
            $sql = "INSERT INTO delivery (order_id, delivery_address, delivery_date, delivery_notes) 
                    VALUES (?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE 
                    delivery_address = VALUES(delivery_address), 
                    delivery_date = VALUES(delivery_date), 
                    delivery_notes = VALUES(delivery_notes)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$orderid, $delivery_address, $delivery_date, $delivery_notes]);
            return true;
        } catch (PDOException $e) {
            error_log("Error setting delivery: " . $e->getMessage());
            return false;
        }
    }


    public function set_delivery_date($orderid, $delivery_date)
    {
        try {
            $sql = "UPDATE delivery SET delivery_date = ? WHERE order_id = ?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$delivery_date, $orderid]);
            return true;
        } catch (PDOException $e) {
            error_log("Error setting delivery date: " . $e->getMessage());
            return false;
        }
    }
}

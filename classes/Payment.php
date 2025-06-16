<?php
require_once "Db.php";

class Payment extends Db{

    private $dbconn;

    public function __construct(){
        $this->dbconn = $this->connect();
    }

    public function update_payment($paystatus,$data,$ref){
        try {
            $sql = "UPDATE payment SET payment_satus = ?, payment_data=? WHERE payment_ref=?";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$paystatus,$data,$ref]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }


    public function paystack_initialize($email, $amount, $reference) {
        // Example implementation for Paystack initialization
        $url = "https://api.paystack.co/transaction/initialize";
        $fields = [
            'email' => $email,
            'amount' => $amount * 100, // Convert to kobo
            'reference' => $reference,
            'callback_url' => "http://localhost/Agrolink%20project/paystack_landing.php"
        ];
        $headers=['Content-Type: application/json', 'Authorization: Bearer sk_test_b7f8fb5d063aa891cad6e936240acc86b7945f89'
        ];
        // step1: initialize
        $curlobj = curl_init($url);
        // step2: set option
        curl_setopt($curlobj, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);

        // step3: Execiute & receive reponse
        $apirsp = curl_exec($curlobj);

        // step 4 & 5:
        if($apirsp){
            curl_close($curlobj);
            return json_decode($apirsp);
        }else{
            $r = curl_error($curlobj);
            // echo 
            return false;
        }
    }
    //     $fields_string = http_build_query($fields);

    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         "Authorization: Bearer sk_test_b7f8fb5d063aa891cad6e936240acc86b7945f89",
    //         "Cache-Control: no-cache",
    //     ]);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     $result = curl_exec($ch);
    //     curl_close($ch);

    //     return json_decode($result, true);
    // }

  
    public function paystack_verify($ref) {
        $url = "https://api.paystack.co/transaction/verify/$ref";
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer sk_test_b7f8fb5d063aa891cad6e936240acc86b7945f89' 
        ];
    
        $curlobj = curl_init($url);
        curl_setopt($curlobj, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);
    
        $apirsp = curl_exec($curlobj);
    
        if ($apirsp) {
            curl_close($curlobj);
            return json_decode($apirsp); // Return as an object
        } else {
            curl_close($curlobj);
            return false;
        }
    }

    // public function paystack_initialize_step1($email,$amt,$ref){
    //     $url = "https://api.paystack.co/transaction/initialize";
    //     $fields = [
    //         'email' => $email,
    //         'amount' => $amt*100,
    //         'reference' => $ref,
    //         'callback_url' => "http://localhost/Agrolink/paystack_landing.php"
    //       ];
    //       $headers=['Content-Type: application/json', 'Authorization: Bearer sk_test_b7f8fb5d063aa891cad6e936240acc86b7945f89'
    //     ];
    //     // step1: initialize
    //     $curlobj = curl_init($url);
    //     // step2: set option
    //     curl_setopt($curlobj, CURLOPT_CUSTOMREQUEST, 'POST');
    //     curl_setopt($curlobj, CURLOPT_POSTFIELDS, json_encode($fields));
    //     curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curlobj, CURLOPT_HTTPHEADER, $headers);
    //     curl_setopt($curlobj, CURLOPT_SSL_VERIFYPEER, false);

    //     // step3: Execiute & receive reponse
    //     $apirsp = curl_exec($curlobj);

    //     // step 4 & 5:
    //     if($apirsp){
    //         curl_close($curlobj);
    //         return json_decode($apirsp);
    //     }else{
    //         $r = curl_error($curlobj);
    //         // echo 
    //         return false;
    //     }
    // }

    public function get_order_details($order_id)
{
    try {
        $sql = "SELECT * FROM orders WHERE order_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->execute([$order_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception("Error fetching order details: " . $e->getMessage());
    }
}


    public function insert_payment($amt, $guestid, $ref, $orderid) {
        try {
            $sql = "INSERT INTO payment (payment_amt, payment_guestid, payment_ref, payment_orderid) 
                    VALUES (?, ?, ?, ?)";
            $stmt = $this->dbconn->prepare($sql);
            $stmt->execute([$amt, $guestid, $ref, $orderid]);
            return $this->dbconn->lastInsertId();
        } catch (PDOException $e) {
            // Log the error for debugging
            error_log("Error inserting payment: " . $e->getMessage());
            return false;
        }
    }


    
}
?>
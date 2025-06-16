<?php
    class Utility{
        public static function sanitize($evilstring){
            $safestr = addslashes($evilstring);
            $safestr = htmlentities($safestr);
            return $safestr;
        }

        public static function fetch_properties(){
            // step1 : initialise curl
            try{
                $curlobj = curl_init();
                $url = "http:/localhost/property/api/v1/listall.php";
                // step2: set options using function curl_setopt()
                curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true); // true will return data and not print it out
                curl_setopt($curlobj, CURLOPT_URL, $url);
    
                // step3: execute the curl session
                $response = curl_exec($curlobj);
    
                //step 4: cloe the opened curl session
                curl_close($curlobj);
    
                // step5: do whatever you want to do with the response
                $obj_rsp = json_decode($response);
                return $obj_rsp;
            }catch(PDOException $e){
                echo curl_error($curlobj);
                echo $e->getMessage();
                return false;
            }
           
        }
       
    }


?>
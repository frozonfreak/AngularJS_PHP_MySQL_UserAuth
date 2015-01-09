<?php
  
class User_Components {
  
    // constructor
    function __construct() {
        require_once 'config.php';
        require_once 'db_components.php';
    }
  
    // destructor
    function __destruct() {
        
    }
  
    // Connecting to database
    public function registerUserDetails($userName, $firstName, $lastName, $email, $dob) {
        
        $user_db = new DB_UserComponents();

        $res = $user_db->registerUserDetails($userName, $firstName, $lastName, $email, $dob);
        if($res["status"] == 0){
            $response = array("status" => 0,
                               "message"=> $res["message"]);
        }
        else{
            $response = array("status" => 1,
                               "message"=> $res["message"]);
        }

        return $response;
    }
 
} 
?>
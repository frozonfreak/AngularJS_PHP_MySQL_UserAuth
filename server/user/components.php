<?php
  
class User_Components {
  
    // constructor
    function __construct() {
        require_once 'config.php';
        require_once 'db.php';
    }
  
    // destructor
    function __destruct() {
        
    }
  
    // Connecting to database
    public function registerUserDetails($userName, $firstName, $lastName, $email, $dob) {
        
        $user_db = new DB_UserComponents();

        $res = $user_db -> registerUserDetails($userName, $firstName, $lastName, $email, $dob);
        if($res){
            $response = array("status" => 0,
                               "message"=> "Success");
        }
        else{
            $response = array("status" => 1,
                               "message"=> "All fields needs to be set");
        }

        return $response;
    }
 
} 
?>
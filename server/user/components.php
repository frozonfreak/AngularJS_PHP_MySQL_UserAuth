<?php
  
class User_Components {
  
    // constructor
    function __construct() {
        require_once 'config.php';
        require_once 'db_components.php';
        include_once 'session/session.php';
        require_once 'security/security.php';
        require_once 'mail/mailer.php';
    }
  
    // destructor
    function __destruct() {
        
    }
  
    // Connecting to database
    public function registerUserDetails($userName, $firstName, $lastName, $password, $email, $dob) {
        
        $user_db      = new DB_UserComponents();
        $app_security = new App_Security();
        $mailer       = new Mailer();

        $res = $app_security->checkValidEmail($email);
        if($res["status"] == 0){
            $res = $user_db->checkIfUserExists($email);
            if($res["status"] == 0){
                $res = $user_db->registerUserDetails($userName, $firstName, $lastName, $password, $email, $dob);
                if($res["status"] == 0){
                    if(DEFAULT_SEND_EMAIL_VERIFICATION){
                        $res = $mailer->sendUserRegistrationEmail($userName, $firstName, $lastName, $email);
                        if($res["status"] == 0){
                            $response = array("status" => 0,
                                           "message"=> $res["message"]);
                        }
                        else{
                            $response = array("status" => 1,
                                           "message"=> "Registered succesfully, mail failed");   
                        }
                    }
                    else{
                        $response = array("status" => 0,
                                       "message"=> $res["message"]);
                    }
                }
                else{
                    $response = array("status" => 1,
                                       "message"=> $res["message"]);
                }
            }
            else{
                $response = array("status" => 1,
                                   "message"=> "User exists");
            }
        }
        else{
            $response = array("status" => 1,
                              "message"=> "Invalid Email");
        }
        return $response;
    }
    
    public function verifyUserLogin($userName, $userPassword){
        $user_db = new DB_UserComponents();
        $session = new Session();

        $res = $user_db->verifyUserLogin($userName, $userPassword); 
        if($res["status"] == 0){
            $res = $session->createSession($userName);
            if($res["status"] == 0){
                $response = array("status" => 0,
                                  "message"=> $res["message"]); 
            }
            else{
                $response = array("status" => 1,
                                  "message"=> $res["message"]); 
            }
        }  
        else{
            $response = array("status" => 1,
                              "message"=> "Invalid Login");   
        }
        return $response;
    }
} 
?>
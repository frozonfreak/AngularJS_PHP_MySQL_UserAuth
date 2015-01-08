<?php
  
class DB_Connect {
  
    // constructor
    function __construct() {
        
    }
  
    // destructor
    function __destruct() {
        // $this->close();
    }
  
    // Connecting to database
    public function connect() {
        require_once 'config.php';
        // connecting to mysql
        try 
        {
            $con = new PDO('mysql:host=localhost;dbname=db_name', DB_USER, DB_PASSWORD);
            
            //Display connection detail
            //echo ("Connection Detail: " . $con);
           // return database handler
            return $con;
        }
        catch(Exception $e){
            die("Unable to connect: " . $e->getMessage());
        }
    }
  
    // Closing database connection
    public function close($con) {
        $con = null;
    }
  
} 
?>
<?php
	
class DB_UserComponents{
	
	//Database connection string
	private $db;

	function __construct(){
		require_once 'config.php';
	}

	//destructor
	function __destruct() {
		 
	}

	public function registerUserDetails($userName, $firstName, $lastName, $password, $email, $dob){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "INSERT INTO user_details(user_name, user_first_name, user_last_name, user_pass, user_email, user_email_verified, first_login, reset_pass, user_dob, user_role, user_registration_date) 
					values (:user_name, :user_first_name, :user_last_name, :user_pass, :user_email, :user_email_verified, :first_login, :reset_pass, :user_dob, :user_role, NOW())";
			$res = $db->prepare($sql);
			$res->execute(array(':user_name' => $userName, ':user_first_name' => $firstName, ':user_last_name' => $lastName, ':user_pass' => $password, ':user_email' => $email, ':user_email_verified' => DEFAULT_EMAIL_VERIFIED, ':first_login' => true, ':reset_pass' => DEFAULT_RESET_PASS, ':user_dob' => $dob, ':user_role' => DEFAULT_USER_ROLE));
			$db = null;
			if($res){
				$response = array("status" => 0,
			    	             "message"=>$res);
			}
			else{
				$response = array("status" => 1,
			    	             "message"=>"Error Inserting into DB");
			}
		}
		catch(Exception $e){
				$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error Updating to DB'));
		}
		return $response;
	}

	public function checkIfUserNotExists($userEmail){

		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = $db->prepare("SELECT * FROM user_details WHERE user_email = :user_email");
			$sql->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
		
			if(!$row){
				$response = array("status" => 0,
			                 "message"=> "no user found");
			}
			else{
				$response = array("status" => 1,
			                 "message"=> "user found");
			}
			//var_dump(json_encode($response));
			//return $response;
		}
		catch(Exception $e){
			$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error retrieving data from database'));
		}

		return $response;
	}

	public function checkIfUserExists($userEmail){

		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = $db->prepare("SELECT * FROM user_details WHERE user_email = :user_email");
			$sql->bindParam(':user_email', $userEmail, PDO::PARAM_STR);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
		
			if($row){
				$response = array("status" => 0,
			                 "message"=> "user found");
			}
			else{
				$response = array("status" => 1,
			                 "message"=> "no user found");
			}
			//var_dump(json_encode($response));
			//return $response;
		}
		catch(Exception $e){
			$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error retrieving data from database'));
		}

		return $response;
	}

	public function verifyUserLogin($userName, $userPass){

		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = $db->prepare("SELECT * FROM user_details WHERE user_name = :user_name AND user_pass = :user_pass");
			$sql->bindParam(':user_name', $userName, PDO::PARAM_STR);
			$sql->bindParam(':user_pass', $userPass, PDO::PARAM_STR);
			$sql->execute();
			$row = $sql->fetch(PDO::FETCH_ASSOC);
		
			if($row){
				$response = array("status" => 0,
			                 "message"=> "user found");
			}
			else{
				$response = array("status" => 1,
			                 "message"=> "no user found");
			}
			//var_dump(json_encode($response));
			//return $response;
		}
		catch(Exception $e){
			$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error retrieving data from database'));
		}

		return $response;
	}

	public function updateUserPasswordToDB($user_email, $user_pass){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "UPDATE user_details SET user_pass=:user_pass WHERE user_email=:user_email";
			$res = $db->prepare($sql);
			$res->execute(array(':user_pass' => $user_pass, ':user_email' => $user_email));
			$db = null;
			if($res->rowCount()){
				$response = array("status" => 0,
			                 "message"=> "user updated");
			}
			else{
				$response = array("status" => 1,
			                 "message"=> "user update failed");
			}
		}
		catch(Exception $e){
			$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error retrieving data from database'));
		}
		return $response;
	}

	public function updateUserPasswordByReset($email, $token, $password){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "UPDATE user_details SET user_pass=:user_pass WHERE user_email=:user_email AND user_pass=:pass_token";
			$res = $db->prepare($sql);
			$res->execute(array(':user_pass' => $password, ':user_email' => $email, ':pass_token'=>$token));

			$db = null;
			if($res->rowCount()){
				$response = array("status" => 0,
			                 "message"=> "user password updated");
			}
			else{
				$response = array("status" => 1,
			                 "message"=> "Password reset failed");
			}
		}
		catch(Exception $e){
			$response = array("status" => 1,
			                 "message"=>(($e->getMessage()!=null) ? $e->getMessage() : 'Error retrieving data from database'));
		}
		return $response;
	}
	public function archiveTask($taskID){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "UPDATE tasklist SET archive=1 WHERE id=?";
			$res = $db->prepare($sql);
			$res->execute(array($taskID));
			$db = null;
			return 1;
		}
		catch(Exception $e){
			return $e;
		}
	}
	public function deleteTask($taskID){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "DELETE FROM tasklist WHERE id=?";
			$res = $db->prepare($sql);
			$res->execute(array($taskID));
			$db = null;
			return 1;
		}
		catch(Exception $e){
			return $e;
		}
	}
	public function retriveAllTasks(){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "SELECT * FROM tasklist WHERE archive = 0";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$response = $stmt->fetchAll();
			$db = null;
	
			//var_dump(json_encode($response));
			return $response;
		}
		catch(Exception $e){
			return $e;
		}
	}
	
}
?>
<?php
	
class Session{


	function __construct(){
		require_once 'config.php';
		require_once 'db_session.php';
	}

	//destructor
	function __destruct() {
		 
	}

	public function isValidSession($session_id){
		$db_cac_session  = new DB_CAC_Session();

		$res = $db_cac_session->checkIfSessionExist($session_id);
		if($res[0] == "1"){	
			$res1 = $db_cac_session->getSessionTime($session_id);
			if(time() - $res1[0] < 1800){
				$response = array("status" => 0,
	            	          	  "message"=> "Valid Session");
			}
			else{
				$response = array("status" => 1,
	            	          	  "message"=> "Invalid Session");
			}
		}
		else{
			$response = array("status" => 1,
	                      	  "message"=> "Invalid Session");
		}
		return $response;
	}

	public function createSession($userName){

		$db_cac_session  = new DB_CAC_Session();

		$remote_addr = ((isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:'');
		$remote_host = ((isset($_SERVER['REMOTE_HOST']))?$_SERVER['REMOTE_HOST']:'');
		$remote_port = ((isset($_SERVER['REMOTE_PORT']))?$_SERVER['REMOTE_PORT']:'');
		$remote_user = ((isset($_SERVER['REMOTE_USER']))?$_SERVER['REMOTE_USER']:'');
		$user_agent  = ((isset($_SERVER['HTTP_USER_AGENT']))?$_SERVER['HTTP_USER_AGENT']:'');

		$session_id = uniqid().uniqid();

		$res = $db_cac_session -> createSessionInDB($userName, $remote_addr, $remote_host, $remote_port, $remote_user, $user_agent, $session_id);
		if($res){
			$response = array("status" => 0,
	                      	  "message"=> $session_id);
		}
		else{
			$response = array("status" => 1,
	                      	  "message"=> "Session Creation Failed");
		}

		return $response;
	}

	public function isValidBackendSession(){
		if(!isset($_SESSION["login_session_id"]))
			return false;
		else 
			return true;
	}
}
?>
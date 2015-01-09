<?php
	
class DB_Session{
	
	//Database connection string
	private $db;

	function __construct(){
		require_once 'config.php';
	}

	//destructor
	function __destruct() {
		 
	}
	public function checkIfSessionExist($session_id){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "SELECT COUNT(session_id) FROM user_session WHERE session_id = :session_id";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':session_id' => $session_id));
			$response = $stmt->fetch();
			$db = null;
	
			//var_dump(json_encode($response));
			return $response;
		}
		catch(Exception $e){
			return $e;
		}
	}

	public function getSessionTime($session_id){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "SELECT session_time FROM user_session WHERE session_id = :session_id";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':session_id' => $session_id));
			$response = $stmt->fetch();
			$db = null;
	
			//var_dump(json_encode($response));
			return $response;
		}
		catch(Exception $e){
			return $e;
		}
	}

	public function createSessionInDB($userName, $remote_addr, $remote_host, $remote_port, $remote_user, $user_agent, $session_id){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "INSERT INTO user_session(session_id, user_name, remote_host, remote_port, remote_user, remote_addr, user_agent, session_date, session_time) values (:session_id, :user_name, :remote_host, :remote_port, :remote_user, :remote_addr, :user_agent, NOW(), :session_time)";
			$response = $db->prepare($sql);
			$response->execute(array(':session_id' => $session_id, ':user_name' => $userName, ':remote_host' => $remote_host, ':remote_port' => $remote_port, ':remote_user' => $remote_user, ':remote_addr' => $remote_addr, ':user_agent'=> $user_agent, ':session_time' => time()));
			$db = null;
			return 1;
		}
		catch(Exception $e){
			return $e;
		}
	}
}
?>
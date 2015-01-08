<?php
	
class DB_Functions{
	
	//Database connection string
	private $db;

	function __construct(){
		require_once 'config.php';
	}

	//destructor
	function __destruct() {
		 
	}

	public function storeTaskDetails($name, $details='', $deadLine){
		try{
			$db = new PDO(DB_STRING, DB_USER, DB_PASSWORD);
			$sql = "INSERT INTO tasklist(name, details, progress, archive, lastedit, deadline, date) values (:name, :details, 0, 0, NOW(), :deadLine, NOW())";
			$response = $db->prepare($sql);
			$response->execute(array(':name' => $name, ':details' => $details, ':deadLine' => $deadLine));
			$db = null;
			return 1;
		}
		catch(Exception $e){
			return $e;
		}
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
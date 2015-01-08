<?php

	include_once 'db_function.php';
	$db = new DB_Functions();
	$res = $db->retriveAllTasks();

	if($res)
	    $response = array("status" => 0,
	                      "message"=> "Success",
	                      "data"   => $res);
	else
	    $response = array("status" => 1,
	                      "message"=> "Error retrieving from to DB");

	echo json_encode($response);
?>
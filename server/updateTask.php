<?php

	//Decode received JSON data
	$data = file_get_contents("php://input");
	$receivedData = json_decode($data);

	include_once 'db_function.php';
	include_once 'user/components.php';
	include_once 'session/session.php';
	
	$db = new DB_Functions();
	$user = new User_Components();
	$session = new Session();

	if(isset($receivedData->{"type"})){
		$response = '';
		switch ($receivedData->{"type"}) {
		    case 'newTask':
		        if(isset($receivedData->{"taskName"})){
		        	$taskName 	= $receivedData->{"taskName"};
		        	$taskDetail = $receivedData->{"taskDetail"};
		        	$taskDeadLine = $receivedData->{"deadLine"};
		        	$res = $db->storeTaskDetails($taskName, $taskDetail, $taskDeadLine);

		        	if($res)
		        	    $response = array("status" => 0,
		        	                      "message"=> "Success");
		        	else
		        	    $response = array("status" => 1,
		        	                      "message"=> "Error updating to DB");
		        }
		        else{
		        	$response = array("status" => 1,
	                      "message"=> "All fields needs to be set");
		        }
		        echo json_encode($response);
		    break;
		    
		    case 'registerUser':
		    	if(isset($receivedData->{"userName"}) && 
		    		isset($receivedData->{"firstName"}) &&
		    		isset($receivedData->{"lastName"}) &&
		    		isset($receivedData->{"email"}) &&
		    		isset($receivedData->{"dob"}) &&
		    		isset($receivedData->{"password"}) &&
		    		isset($receivedData->{"verifyPassword"})){
		    		
		    		$userName 	= $receivedData->{"userName"};
		    		$firstName 	= $receivedData->{"firstName"};
		    		$lastName 	= $receivedData->{"lastName"};
		    		$email 		= $receivedData->{"email"};
		    		$dob 		= $receivedData->{"dob"};
		    		
		    		if(strcmp($receivedData->{"password"}, $receivedData->{"verifyPassword"}) == 0){
			        	
			        	$res = $user->registerUserDetails($userName, $firstName, $lastName, $email, $dob);

			        	if($res)
			        	    $response = array("status" => 0,
			        	                      "message"=> "Success");
			        	else
			        	    $response = array("status" => 1,
			        	                      "message"=> "Error updating to DB");
			        }
			        else{
			        	$response = array("status" => 1,
	                      "message"=> "Password mismatch");	
			        }
		        }
		        else{
		        	$response = array("status" => 1,
	                      "message"=> "All fields needs to be set");
		        }
		        echo json_encode($response);
		    break;

		}
	}
	else {

	    $response = array("status" => 1,
	                      "message"=> "All fields needs to be set");
	    echo json_encode($response);
	}
?>
<?php

	//Decode received JSON data
	$data = file_get_contents("php://input");
	$receivedData = json_decode($data);

	include_once 'user/components.php';
	include_once 'session/session.php';
	
	$user = new User_Components();
	$session = new Session();

	if(isset($receivedData->{"type"})){
		$response = '';
		switch ($receivedData->{"type"}) {

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
		    		$password   = $receivedData->{"password"};

		    		if(strcmp($receivedData->{"password"}, $receivedData->{"verifyPassword"}) == 0){
			        	
			        	$res = $user->registerUserDetails($userName, $firstName, $lastName, $password, $email, $dob);

			        	if($res["status"] == 0)
			        	    $response = array("status" => 0,
			        	                      "message"=> $res["message"]);
			        	else
			        	    $response = array("status" => 1,
			        	                      "message"=> $res["message"]);
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

		    case 'verifyUserLogin':
		    	if(isset($receivedData->{"userName"}) && 
		    		isset($receivedData->{"password"})){

		    		$userName 	= $receivedData->{"userName"};
		    		$password   = $receivedData->{"password"};

		    		$res = $user->verifyUserLogin($userName, $password);

		    		if($res["status"] == 0)
		    		    $response = array("status" => 0,
		    		                      "message"=> $res["message"]);
		    		else
		    		    $response = array("status" => 1,
		    		                      "message"=> $res["message"]);

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
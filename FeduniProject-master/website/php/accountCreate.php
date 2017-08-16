<?php
   include("config.php");
   session_start();
	
	// Create an account
    $email = $_GET['email'];
    $password = $_GET['password'];
    $firstName = $_GET['firstName'];
    $lastName = $_GET['lastName'];

	// Grabs the email that has been inputted and compares it with emails from pre-existing accounts
	$stmt = $db->prepare("SELECT email FROM client WHERE email = ?");
	$stmt -> execute(array($email));

	// Checks to see if the email in the form already exists
	if($stmt->rowCount() == 1)
	{
		 // Refuse the account creation
		echo "An account already exists for that email address";
	}
	else
	{
		//Prepare sql statement for creating a new client then insert
		$stmt = $db->prepare("INSERT INTO client(clientID, email, clientFirstName, clientLastName, clientPassword, `FKgroup`) 
							VALUES (NULL, :email, :firstName, :lastName, :password, NULL) ");
		$stmt->execute(array(':email' => $email, ':firstName' => $firstName, ':lastName' => $lastName, ':password' => $password));
	  
		//Checks to see if data insertion was successful
		if($stmt->rowCount() == 1) 
		{
			// Handles data insertion success
			$_SESSION['userID'] = $db->lastInsertId();;  
			echo "success";
		}
		else
		{
			// Notifies the user of the failure
			echo ("There was an issue creating your account");
		}
	}
	
?>
<?php
	// Connects to the database
   include("config.php");
   
   // Starts the session
   session_start();

	
	// Create an account
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Grabs the email that has been inputted and compares it with emails from preesisting accounts
		$stmt = $db->prepare("SELECT email FROM client WHERE email = ?");
		$stmt -> execute(array($_POST['email']));
	
		// Checks to see if the email in the form already exists
		if($stmt->rowCount() == 1) // Refuse the account creation
		{
			// Notifies the user of the failure and redicts them to the Create Account page
			echo ("<SCRIPT LANGUAGE='JavaScript'>
					window.alert('Email already exists')
					window.location.href='../createAccountLogin.html';
					</SCRIPT>");
		}
		else	// Proceed with account creation
		{
			// Grabs all values from the form and selects the corresponding fields in the database
			$stmt = $db->prepare("INSERT INTO client(clientID, email, clientFirstName, clientLastName, clientPassword, `FKgroup`) 
								VALUES (NULL, :email, :firstname, :lastname, :password, NULL) ");
			
			// Inserts the new values into the database
		
			$stmt->execute(array(':email' => $_POST['email'], 
								':firstname' => $_POST['firstname'], 
								':lastname' => $_POST['lastname'], 
								':password' => $_POST['password']));
		  
			// Checks to see if data insertion was successful
			if($stmt->rowCount() == 1) 
			{
				// Handles data insertion success
				$result = $stmt->fetch(PDO::FETCH_ASSOC); 
				$_SESSION['userID'] = $result['clientID'];  

				// Notify the user of the success and redicts them to the Home page
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Account creation successful')
						window.location.href='../php/login_user.php?email=".$_POST['email']."&password=".$_POST['password']."';
						</SCRIPT>");
			}
			else // Handles data insertion failure
			{
				// Notifies the user of the failure and redicts them to the Create Account page
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Failed to create Account.')
						window.location.href='../createAccountLogin';
						</SCRIPT>");
			}
		}
	}
	//Pickels. (2011). Stack Overflow. Accessible from http://stackoverflow.com/questions/5443568/javascript-windows-alert-with-redirect-function
?>
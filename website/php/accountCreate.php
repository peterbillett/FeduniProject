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
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>An account already exists for that email address</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
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
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>There was an issue creating your account</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
		}
	}
	
?>
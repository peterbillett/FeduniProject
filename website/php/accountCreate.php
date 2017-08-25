<?php
   include("config.php");
   session_start();

	//Checks if the entered email already has an account
	$stmt = $db->prepare("SELECT email FROM client WHERE email = ?");
	$stmt -> execute(array($_GET['email']));

	if ($stmt->rowCount() == 1) {
		//Refuse the account creation if an account already exists
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>An account already exists for that email address</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	} else {
		//Hash the password
		$hashedPassword = password_hash($_GET['password'], PASSWORD_DEFAULT);

		//Create the new account
		$stmt = $db->prepare("INSERT INTO client(clientID, email, clientFirstName, clientLastName, clientPassword, `FKgroup`) 
							VALUES (NULL, :email, :firstName, :lastName, :password, NULL) ");
		$stmt->execute(array(':email' => $_GET['email'], ':firstName' => $_GET['firstName'], ':lastName' => $_GET['lastName'], ':password' => $hashedPassword));
	  
		//Checks to see if data insertion was successful (If successful; assign the id to the session and return success)
		if($stmt->rowCount() == 1) {
			$_SESSION['userID'] = $db->lastInsertId();
			$_SESSION['accountType'] = 1;
			echo "success";
		} else {
			//Notifies the user of the failure
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
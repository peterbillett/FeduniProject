<?php
   include("config.php");

   	//Password must be between 6-15 char, at least 1 number and at least 1 letter
	if (preg_match('/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/', $_POST['email'])
		&& preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%^&*]{6,50}$/', $_POST['password'])
		&& $_POST['password'] == $_POST['passwordConfirm']
		&& preg_match('/^[A-Za-z]\w{1,50}$/', $_POST['firstName'])
		&& preg_match('/^[A-Za-z]\w{1,50}$/', $_POST['lastName'])) {

   		///Checks if the entered email already has an account
		$stmt = $db->prepare("SELECT email FROM client WHERE email = ?");
		$stmt -> execute(array($_POST['email']));

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
			$hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
			$unlockKey = "A".rand(1, 10000000);

			//Create the new account
			$stmt = $db->prepare("INSERT INTO client(clientID, email, clientFirstName, clientLastName, clientPassword, accountType, FKgroup) 
								VALUES (NULL, :email, :firstName, :lastName, :password, :accountType, NULL) ");
			$stmt->execute(array(':email' => $_POST['email'], ':firstName' => $_POST['firstName'], ':lastName' => $_POST['lastName'], ':password' => $hashedPassword, ':accountType' => $unlockKey));
		  
			//Checks to see if data insertion was successful (on success queue email for the user confirmation to prevent spam)
			if($stmt->rowCount() == 1) {
				$itemID = $db->lastInsertId();
	      		$stmt = $db->prepare("INSERT INTO emailqueue(referenceNum,emailType) VALUES(:referenceNum,:emailType)");
	         	$stmt->execute(array(':referenceNum' => $itemID, ':emailType' => "2"));
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
	} else {
		//Notifies the user of the failure
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <b>Invalid data sent when creating account</b>
              <p>Please check the data entered was correct before trying again</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>
<?php
	// Connects to the database
   include("config.php");
   
   // Starts the session
   session_start();

	
	// Create a volunteer group
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Grabs the name of the organisation that has been inputted and compares it with names from pre-existing accounts
		$stmt = $db->prepare("SELECT name FROM organisation WHERE UCASE(name) = UCASE(?)");
		$stmt -> execute(array($_POST['name']));
	
		// Checks to see if the organisation name in the form already exists
		if($stmt->rowCount() == 1) // Refuse the group creation
		{
			// Notifies the user of the failure and redicts them to the Volunteer Organisation page
			echo ("<SCRIPT LANGUAGE='JavaScript'>
					window.alert('Volunteer Organisation Name already exists')
					window.location.href='../website/createVolOrgAccount.html';
					</SCRIPT>");
		}
		else	// Proceed with volunteer group creation
		{
			// Grabs all values from the form and selects the corresponding fields in the database
			$stmt = $db->prepare("INSERT INTO organisation(groupID, name, Information, currentNews) 
								VALUES (NULL, :name, :information, NULL) ");
			
			// Inserts the new values into the database
			$stmt->execute(array(':name' => $_POST['volOrgName'],
								':information' => $_POST['volOrgInformation']));
		  
			// Checks to see if data insertion was successful
			if($stmt->rowCount() == 1) 
			{
				// Handles data insertion success
				$result = $stmt->fetch(PDO::FETCH_ASSOC); 
				$_SESSION['userID'] = $result['clientID'];  

				// Notify the user of the success and redicts them to the Home page
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Volunteer Group creation successful')
						window.location.href='../allOrgs.html';
						</SCRIPT>");
			}
			else	// Handles data insertion failure
			{
				// Notifies the user of the failure and redicts them to the Volunteer Organisation page
				echo ("<SCRIPT LANGUAGE='JavaScript'>
						window.alert('Failed to create Volunteer Group')
						window.location.href='../website/createVolOrgAccount.html';
						</SCRIPT>");
			}
		}
	}
	// References
	// Pickels. (2011). Stack Overflow. Accessed on (2017), May 21, at http://stackoverflow.com/questions/5443568/javascript-windows-alert-with-redirect-function.
?>

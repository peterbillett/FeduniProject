<?php
	include("config.php");
	session_start();

	//If the user is logged in then link the organisation to the user
	if(isset($_SESSION['userID'])) {
		$stmt = $db -> prepare ('UPDATE client SET FKgroup=? WHERE clientID=?');
		$stmt -> execute (array($_GET['groupID'], $_SESSION['userID']));
		
		if($stmt -> rowCount() > 0) {
			//Update the users items to include their organisation and return success
			//$stmt = $db -> prepare ('UPDATE item SET organisation=? WHERE clientID=?');
			//$stmt -> execute (array($_GET['groupID'], $_SESSION['userID']));
			echo "success";	
		} else {
			//Notify the user of the failure
			echo "Error: There was an error linking the organisation to your account";
		}
	} else {
		//Notify the user they are not logged in
		echo "Error: You must be logged in to link an organisation to your account";
	}
?>

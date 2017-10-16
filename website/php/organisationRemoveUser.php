<?php
	include("config.php");
	session_start();

	//Check if the user is logged in
	if(isset($_SESSION['userID'])) {
		//Check if the user has the correct privilges to remove users from their organisation
		if ($_SESSION['accountType'] === "3") { //If admin then only check the organisation exists
	      	$stmt = $db->prepare("SELECT groupID FROM organisation WHERE groupID=?");
	      	$stmt->execute(array($_POST['groupID']));
	   	} elseif ($_SESSION['accountType'] === "2") { //Else if they are an org owner make sure it is for the org that is being edited
	      	$stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=? AND organisation.groupID=?");
	      	$stmt->execute(array($_SESSION['userID'],$_POST['groupID']));
	   	} else {
	      	return;
	   	}
   
   		//If they have permission then unlink all of the users items from the organisation and remove the user from the organisation
   		if ($stmt->rowCount() > 0) {
   			$stmt = $db -> prepare ('UPDATE item SET organisation=NULL WHERE FKclient=? AND organisation=?');
      		$stmt -> execute (array($_POST['userID'],$_POST['groupID']));
  			$stmt = $db -> prepare ('UPDATE client SET FKgroup=NULL WHERE clientID=? AND FKgroup=?');
  			$stmt -> execute (array($_POST['userID'],$_POST['groupID']));
      	}
	}
?>
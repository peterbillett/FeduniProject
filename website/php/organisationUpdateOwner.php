<?php
	include("config.php");
	session_start();

	//Check if the user is logged in
	if(isset($_SESSION['userID'])) {
		//Check if the user has the correct privilges to change the organisation owner
		if ($_SESSION['accountType'] === "3") { //If admin then only check the organisation exists
	      	$stmt = $db->prepare("SELECT groupID FROM organisation WHERE groupID=?");
	      	$stmt->execute(array($_POST['groupID']));
	   	} elseif ($_SESSION['accountType'] === "2") { //Else if they are an org owner make sure it is for the org that is being edited
	      	$stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=? AND organisation.groupID=?");
	      	$stmt->execute(array($_SESSION['userID'],$_POST['groupID']));
	   	} else {
	      	return;
	   	}
   
   		//If they have permission then update the old owner to a normal account and promote the new owner
   		if ($stmt->rowCount() > 0) {
			$stmt = $db -> prepare ('UPDATE client SET accountType=1 WHERE FKgroup=? AND accountType=2');
      		$stmt -> execute (array($_POST['groupID']));
			$stmt = $db -> prepare ('UPDATE client SET accountType=2 WHERE clientID=? AND FKgroup=? AND accountType<3');
      		$stmt -> execute (array($_POST['userID'],$_POST['groupID']));
      		if ($_SESSION['accountType'] === "2" && $_POST['userID'] != $_SESSION['userID']) { //If they were the org owner then set their session as a normal user
      			$_SESSION['accountType'] = "1";
      		}
      		date_default_timezone_set('Australia/Melbourne');
	        $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
	        $updateClientSeen->execute(array($_SESSION['userID']));
      	}
	}
?>
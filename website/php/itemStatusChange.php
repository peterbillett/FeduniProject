<?php
	include("config.php");
	session_start();

	if(isset($_SESSION['userID'])){
		if ($_GET['status'] == 3){
			$status = 0;
		} else {
			$status = $_GET['status'];
		}

		if(empty($_GET['id']) || empty($_GET['status'])){
			echo "Error: Invalid status update call";
		} else {
			$stmt = $db->prepare("UPDATE item SET finished=? WHERE itemID=?");
			$stmt->execute(array($status, $_GET['id']));
			if ($stmt->rowCount() > 0){
				$stmt = $db->prepare("UPDATE item SET lastModifiedTime=now() WHERE itemID=?");
         		$stmt->execute(array($_GET['id'])); 
				echo "success";
			} else {
				echo "Error: Could not update the items status";
			}
		}
	} else {
		echo "Error: You are not logged in";
	}

?>
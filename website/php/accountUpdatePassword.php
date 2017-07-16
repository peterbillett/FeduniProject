<?php
	session_start();
	include("config.php");

	if (isset($_SESSION['userID'])){
		$stmt = $db->prepare("UPDATE client SET clientPassword=? WHERE clientID=?");
		$stmt->execute(array($_GET['newPassword'], $_SESSION['userID']));
      	if($stmt->rowCount() == 0){
      		echo 'Error: There was an error updating your password';
      	} else {
      		echo 'success';
      	}
	} else {
		echo 'Error: You must be logged in to update your password';
	}
?>
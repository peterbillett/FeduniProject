<?php
   	include("config.php");
   	session_start();

   	//Unlock new accounts by updating their accountType from the randomly calculated key to 1 then return success (or failed if it was unsuccessful)
    $stmt = $db->prepare("UPDATE client SET accountType=? WHERE accountType=?");
    $stmt->execute(array('1',$_POST['id']));
	if($stmt->rowCount() > 0) {
		echo 'success';
	} else {
		echo 'failed';
	}
?>
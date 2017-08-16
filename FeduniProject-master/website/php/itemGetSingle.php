<?php
	include("config.php");
	$stmt = $db->prepare("SELECT itemID, name, description, finished FROM item WHERE itemID=?");
	$stmt->execute(array($_GET['id']));
	
	if($stmt->rowCount() > 0) { 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	} else {
		echo 'Failed';
	}
?>
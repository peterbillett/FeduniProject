<?php
	include("config.php");

	$stmt = $db->prepare("SELECT name, groupID, Information FROM organisation WHERE groupID=?");
	$stmt->execute(array($_GET['id']));
	
	if($stmt->rowCount() > 0) { 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	} else {
		json_encode (json_decode ("{}"));
	}
?>
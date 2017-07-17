<?php
	include("config.php");
	include("updateItemFinished.php");
	session_start();
			
	if (empty($_GET['type'])) {
  		$stmt = $db->query('SELECT itemID, name, description, finished, FKtagID, category FROM item WHERE finished < 2');
   	} else {
   		$stmt = $db->prepare("SELECT itemID, name, description, finished, FKtagID, category FROM item WHERE finished < 2 AND category=?");
   		$stmt->execute(array($_GET['type']));
   	}

	if($stmt->rowCount() > 0) { 
		$rows = array();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		json_encode (json_decode ("{}"));
	}
?>
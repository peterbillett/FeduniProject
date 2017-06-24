<?php
	include("config.php");
	session_start();
			
	if (empty($_GET['type'])) {
  		$stmt = $db->query('SELECT itemID, name, description, finished, FKtagID, category FROM item WHERE finished < 2');
   } else {
   		$stmt = $db->prepare("SELECT itemID, name, description, finished, FKtagID, category FROM item WHERE finished < 2 AND category=?");
   		$stmt->execute(array($_GET['type']));
   }

	$rows = array();
	if($stmt->rowCount() > 0) { 
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>
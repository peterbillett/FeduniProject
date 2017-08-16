<?php
	// Connects to the database
	include("config.php");

  	$stmt = $db->query('SELECT name, groupID, Information FROM organisation');
   	$stmt->execute();

	$rows = array();
	if($stmt->rowCount() > 0) { 
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>

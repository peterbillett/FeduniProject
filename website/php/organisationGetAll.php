<?php
	// Connects to the database
	include("config.php");

	//Select all organisations
  	$stmt = $db->query('SELECT name, groupID, Information FROM organisation');
   	$stmt->execute();

	$rows = array();
	//If there were results then encode them to json and return them
	if($stmt->rowCount() > 0) { 
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>

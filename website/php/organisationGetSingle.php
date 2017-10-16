<?php
	include("config.php");

	//If an id is passed
	if(!empty($_GET['id'])){
		//Select that orgnisations name, groupID and information
		$stmt = $db->prepare("SELECT name, groupID, Information FROM organisation WHERE groupID=?");
		$stmt->execute(array($_GET['id']));
		
		//If a result is found then encode it into JSON and return it
		if($stmt->rowCount() > 0) { 
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			echo json_encode($row);
		}
	}
?>
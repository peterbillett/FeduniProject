<?php
	include("config.php");
	include("updateItemFinished.php");
	
	$stmt = $db->prepare("SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag on item.FKTagID = tag.tagID WHERE itemID=?");
	$stmt->execute(array($_GET['id']));
	
	if($stmt->rowCount() > 0) { 
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	} else {
		json_encode (json_decode ("{}"));
	}
?>
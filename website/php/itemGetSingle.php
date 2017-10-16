<?php
	include("config.php");
	include("updateItemFinished.php");
	
	//Get the items details
	$stmt = $db->prepare("SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag on item.FKTagID = tag.tagID WHERE itemID=?");
	$stmt->execute(array($_GET['id']));
	
	if($stmt->rowCount() > 0) { //If the item was found then encode and return the results in json
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo json_encode($row);
	} else {
		json_encode (json_decode ("{}")); //Else return an empty json file
	}
?>
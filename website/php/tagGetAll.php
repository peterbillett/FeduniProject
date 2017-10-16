<?php
	include("config.php");
	//Get all tags that are currently being used by items
	//Also return the number of items each tag, that is used, has.
	//If a type has been sent through then filter this list on items that match that category (Supplying, Request)
	if ($_GET['type'] == "") {
		$stmt = $db->prepare("SELECT tag.*, count(item.itemID) AS totalItems FROM item LEFT JOIN tag ON item.FKTagID = tag.tagID WHERE item.finished < 2 GROUP BY tag.tagID");
	} else {
		$stmt = $db->prepare("SELECT tag.*, count(item.itemID) AS totalItems FROM item LEFT JOIN tag ON item.FKTagID = tag.tagID WHERE item.finished < 2 AND item.category=? GROUP BY tag.tagID");
		$stmt->execute(array($_GET['type']));
	}
	$stmt->execute();

	//On success return array of tags else return nothing
	$rows = array(); 
	if($stmt->rowCount() > 0) {
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>
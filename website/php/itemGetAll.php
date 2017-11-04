<?php
	include("config.php");
	include("updateItemFinished.php");
	
	if ($_GET['type'] == "") { //Get all items
  		$stmt = $db->query('SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag ON item.FKTagID = tag.tagID WHERE finished < 2 ORDER BY item.itemID ASC');
   	} else { //Get all items filtered by the type (request, supplying)
   		$stmt = $db->prepare("SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag ON item.FKTagID = tag.tagID WHERE finished < 2 AND category=? ORDER BY item.itemID ASC");
   		$stmt->execute(array($_GET['type']));
   	}

	if($stmt->rowCount() > 0) { //If returns are returned then encode them into json and return them, else create a blank json file
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>
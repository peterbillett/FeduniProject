<?php
	include("config.php");
	include("updateItemFinished.php");
	
	if ($_GET['type'] == "null") {
  		$stmt = $db->query('SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag ON item.FKTagID = tag.tagID WHERE finished < 2 ORDER BY item.itemID ASC');
   	} else {
   		$stmt = $db->prepare("SELECT item.itemID, item.name, item.description, item.finished, item.FKtagID, item.category, tag.name imgTag FROM item INNER JOIN tag ON item.FKTagID = tag.tagID WHERE finished < 2 AND category=? ORDER BY item.itemID ASC");
   		$stmt->execute(array($_GET['type']));
   	}

	if($stmt->rowCount() > 0) { 
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		json_encode (json_decode ("{}"));
	}
?>
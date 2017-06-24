<?php
	include("config.php");
	//$stmt = $db->prepare("SELECT * FROM tag");
	$stmt = $db->prepare("SELECT tag.*, count(item.itemID) AS totalItems FROM item LEFT JOIN tag ON item.FKTagID = tag.tagID WHERE item.finished < 2 GROUP BY tag.tagID");
	$stmt->execute();

	$rows = array(); 
	if($stmt->rowCount() > 0) {
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		echo json_encode($rows);
	} else {
		echo "";
	}
?>
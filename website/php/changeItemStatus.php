<?php
	include("config.php");
	session_start();

	if(empty($_GET['id']) || empty($_GET['status'])){
		header("Location: ../allListings.html");
	}

	$stmt = $db->prepare("UPDATE item SET finished=? WHERE itemID=?");
	$stmt->execute(array($_GET['status'], $_GET['id']));
	$affected_rows = $stmt->rowCount();

	header("Location: ../item.html?item=".$_GET['id']);

?>
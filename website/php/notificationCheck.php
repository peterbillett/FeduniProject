<?php
   	include("config.php");
   	session_start();
   	//Check if the user is logged in
   	if(isset($_SESSION['userID'])){
   		//Check if there have been any items created since the last check whose tag matches a notification tag for the user
	   	$getNotification = $db->prepare('SELECT itemID, name FROM item INNER JOIN notification ON item.FKTagID = notification.FKTag WHERE notification.FKClient = ? AND finished = 0 AND item.FKclient != ? AND item.lastModifiedTime > ? ORDER BY endtime ASC LIMIT 1');
	   	$getNotification->execute(array($_SESSION['userID'],$_SESSION['userID'],$_GET['notificationTime']));
		$notificationResult = $getNotification->fetch(PDO::FETCH_ASSOC);
		//If a result is returned then create an alert to send to the user
		if ($notificationResult){
			echo '<div class="alert alert-info alert-dismissible overlayAlert fade in" role="alert">
		       	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          	<span aria-hidden="true">×</span>
		       	</button>';
		       	//Option to open the item modal onclick, shows the item name and a dismiss button
		       	echo '<span class="pointer" onclick="getItemModal('.$notificationResult['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails">
		          	<strong><p>New notification!</p></strong>';
		          	echo 'Item: '.$notificationResult['name'];
		        echo '</span>
		        <p><button type="button" class="btn btn-info" data-dismiss="alert">Dismiss</button></p>
		    </div>';
		}
	} else { //If the user is not loggeed in then tell the client to not keep checking
		echo 'STOP';
	}
?>
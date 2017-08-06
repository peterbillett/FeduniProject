<?php
   	include("config.php");
   	session_start();
   	if(isset($_SESSION['userID'])){
	   	$getNotification = $db->prepare('SELECT itemID, name FROM item INNER JOIN notification ON item.FKTagID = notification.FKTag WHERE notification.FKClient = ? AND finished = 0 AND item.FKclient != ? AND item.lastModifiedTime > ? ORDER BY endtime ASC LIMIT 1');
	   	$getNotification->execute(array($_SESSION['userID'],$_SESSION['userID'],$_GET['notificationTime']));
		$notificationResult = $getNotification->fetch(PDO::FETCH_ASSOC);
		if ($notificationResult){
			echo '<div class="alert alert-info alert-dismissible overlayAlert fade in" role="alert">
		       	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          	<span aria-hidden="true">×</span>
		       	</button>
		       	<span class="pointer" onclick="getItemModal('.$notificationResult['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails">
		          	<strong><p>New notification!</p></strong>';
		          	echo 'Item: '.$notificationResult['name'];
		        echo '</span>
		        <p><button type="button" class="btn btn-info" data-dismiss="alert">Dismiss</button></p>
		    </div>';
		}
	} else {
		echo 'STOP';
	}
?>
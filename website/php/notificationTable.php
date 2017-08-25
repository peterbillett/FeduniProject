<?php
	include("config.php");
	include("updateItemFinished.php");
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	if(isset($_SESSION['userID'])){
		date_default_timezone_set('Australia/Melbourne');
		$updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
	    $updateClientSeen->execute(array($_SESSION['userID']));

	    $getUsersTags = $db->prepare('SELECT * FROM tag INNER JOIN notification on tag.tagID = notification.FKTag WHERE notification.FKClient = ?');
        $getUsersTags->execute(array($_SESSION['userID']));
        echo '<div class="panel-group">
	        <div class="panel panel-default">
	        	<div onclick="changeNotificationCollase()" class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseNotifications">
	                <h4 class="panel-title">
	                    <a class="accordion-toggle" data-parent="#panel-group">Your notifications</a>
	                </h4>
	            </div>';

				if ($getUsersTags->rowCount()){
					$getNotifications = $db->prepare('SELECT itemID, name, finished, category, FKTagID FROM item INNER JOIN notification ON item.FKTagID = notification.FKTag WHERE notification.FKClient = ? AND finished < 2 AND item.FKclient != ? ORDER BY endtime ASC LIMIT 25');
			        $getNotifications->execute(array($_SESSION['userID'],$_SESSION['userID']));
			        $notificationResults = $getNotifications->fetchAll(PDO::FETCH_ASSOC);

			        $usersTagsResults = $getUsersTags->fetchAll(PDO::FETCH_ASSOC);
			        echo '<div class="panel-title" unselectable="on" onselectstart="return false;" onmousedown="return false;" id="notificationTagFilters">';
			        foreach ($usersTagsResults as $col) {
			        	$tagCount = 0;
			        	foreach ($notificationResults as $row) {
				        	if ($col['tagID'] == $row['FKTagID']) {
				        		$tagCount++;
				        	}
			        	}
			        	echo '<b style="display:inline-block;" class="pointer" id="'.$col['tagID'].'" onclick="filterNotificationTable('."'".$col['tagID']."'".')">'.$col['name'].': <span class="badge dontHideBadge">'.$tagCount.'</span></b> ';
			        }
			        if ($_GET['collapsed'] == "true") {
	                	echo '</div> <div id="collapseNotifications" class="panel-collapse collapse">';
		            } else {
		            	echo '</div> <div id="collapseNotifications" class="panel-collapse collapse in">';
		            }
		            echo'<ul class="list-group scrollable-menu scrollbar">';                                      
		                foreach ($notificationResults as $row) {
	                        echo '<li id="'.$row['FKTagID'].'" class="list-group-item ';
	                        switch ($row['finished']) {
	                            case "0":
	                                echo 'available" value="available">';
	                                break;
	                            case "1":
	                                echo 'wanted" value="wanted">';
	                                break;
	                        }
	                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;">';
	                        if ($row['category'] == "Supplying") {
	                        	echo '<span class="glyphicon glyphicon-gift dontHideBadge"></span> ';
	                        } else {
	                        	echo '<span class="fa fa-shopping-cart dontHideBadge"></span> ';
	                        }
	                        echo $row['name'].'</span></button></li>';
	                    }
        			} else {
		                echo '<div id="collapseNotifications" class="panel-collapse collapse in">
	                		<ul class="list-group scrollable-menu scrollbar">
				                <li class="list-group-item">
				                	<p class="testing">You have not set any tags to be notified about</p>
				                </li>';
			        }
				}
				echo '</ul>
            </div>
            <div class="notificationUpdateTime" id="lastUpdatedTime"></div>
        </div>
    </div><br>';
?>
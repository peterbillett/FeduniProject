<?php
	include("config.php");
	include("updateItemFinished.php");
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	//If the user is logged in
	if(isset($_SESSION['userID'])){
		date_default_timezone_set('Australia/Melbourne');
		$updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
	    $updateClientSeen->execute(array($_SESSION['userID']));

	    //Select all tags that the user has selected to be notified about
	    $getUsersTags = $db->prepare('SELECT * FROM tag INNER JOIN notification on tag.tagID = notification.FKTag WHERE notification.FKClient = ?');
        $getUsersTags->execute(array($_SESSION['userID']));
        echo '<div class="panel-group">
	        <div class="panel panel-default">
	        	<div onclick="changeNotificationCollase()" class="panel-heading" unselectable="on" onselectstart="return false;" onmousedown="return false;" data-toggle="collapse" href="#collapseNotifications">
	                <h4 class="panel-title">
	                    <a class="accordion-toggle" data-parent="#panel-group">Your notifications</a>
	                </h4>
	            </div>';

	            //If at least one tag is returned
				if ($getUsersTags->rowCount()){
					//Select the latest 25 items that match the user notifications and are not finished
					$getNotifications = $db->prepare('SELECT itemID, name, finished, category, FKTagID FROM item INNER JOIN notification ON item.FKTagID = notification.FKTag WHERE notification.FKClient = ? AND finished < 2 AND item.FKclient != ? ORDER BY endtime ASC LIMIT 25');
			        $getNotifications->execute(array($_SESSION['userID'],$_SESSION['userID']));
			        $notificationResults = $getNotifications->fetchAll(PDO::FETCH_ASSOC);

			        $usersTagsResults = $getUsersTags->fetchAll(PDO::FETCH_ASSOC);
			        echo '<div class="panel-title" unselectable="on" onselectstart="return false;" onmousedown="return false;" id="notificationTagFilters">';
			        //For each tag count the number of items that use that tag
			        foreach ($usersTagsResults as $col) {
			        	$tagCount = 0;
			        	foreach ($notificationResults as $row) {
				        	if ($col['tagID'] == $row['FKTagID']) {
				        		$tagCount++;
				        	}
			        	}
			        	//Print filter icon for that tag with the number of items in that tag (filters the items in the table below)
			        	echo '<b style="display:inline-block;" class="pointer" id="'.$col['tagID'].'" onclick="filterNotificationTable('."'".$col['tagID']."'".')">'.$col['name'].': <span class="badge dontHideBadge">'.$tagCount.'</span></b> ';
			        }
			        //Check if the table should be collapsed
			        if ($_GET['collapsed'] == "true") {
	                	echo '</div> <div id="collapseNotifications" class="panel-collapse collapse">';
		            } else {
		            	echo '</div> <div id="collapseNotifications" class="panel-collapse collapse in">';
		            }
		            //Create a list of items
		            echo'<ul class="list-group scrollable-menu scrollbar">';     
		            	//For each item                                 
		                foreach ($notificationResults as $row) {
		                	//Create a list item for the item with the colour matching its status
	                        echo '<li id="'.$row['FKTagID'].'" class="list-group-item ';
	                        switch ($row['finished']) {
	                            case "0":
	                                echo 'available" value="available">';
	                                break;
	                            case "1":
	                                echo 'wanted" value="wanted">';
	                                break;
	                        }
	                        //Make it a button (Shows the item name and item type) that on click opens the item modal for that item 
	                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails"><span class="dontHideBadge" style="display: flex;">';
	                        if ($row['category'] == "Supplying") {
	                        	echo '<span class="glyphicon glyphicon-gift dontHideBadge"></span> ';
	                        } else {
	                        	echo '<span class="fa fa-shopping-cart dontHideBadge"></span> ';
	                        }
	                        echo $row['name'].'</span></button></li>';
	                    }
        			} else { //If no tags were returned then print that
		                echo '<div id="collapseNotifications" class="panel-collapse collapse in">
	                		<ul class="list-group scrollable-menu scrollbar">
				                <li class="list-group-item">
				                	<p class="testing">You have not set any tags to be notified about</p>
				                </li>';
			        }
				}
				//Create the spot where the time this table was updated can go
				echo '</ul>
            </div>
            <div class="notificationUpdateTime" id="lastUpdatedTime"></div>
        </div>
    </div><br>';
?>
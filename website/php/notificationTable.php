<?php
	include("config.php");
	if (session_status() == PHP_SESSION_NONE) {
	    session_start();
	}

	if(isset($_SESSION['userID'])){
		$updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
	    $updateClientSeen->execute(array($_SESSION['userID']));

		$getNotifications = $db->prepare('SELECT itemID, name, finished, category FROM item A INNER JOIN notification B ON A.FKTagID = B.FKTag WHERE B.FKClient = ? AND finished < 2 ORDER BY itemID DESC LIMIT 25');
        $getNotifications->execute(array($_SESSION['userID']));
        $notificationResults = $getNotifications->fetchAll(PDO::FETCH_ASSOC);
		echo '<div class="panel-group">
	        <div class="panel panel-default">
				<div class="panel-heading testing" data-toggle="collapse" href="#collapseNotifications">
	                <h4 class="panel-title">
	                    <a class="accordion-toggle" data-parent="#panel-group">Your notifications</a>
	                </h4>
	            </div>
	            <div id="collapseNotifications" class="panel-collapse collapse in">
	                <ul class="list-group scrollable-menu scrollbar">';                                        
	                foreach ($notificationResults as $row) {
                        echo '<li class="list-group-item ';
                        switch ($row['finished']) {
                            case "0":
                                echo 'available" value="available">';
                                break;
                            case "1":
                                echo 'wanted" value="wanted">';
                                break;
                        }
                        echo '<button type="button" class="table-button" onclick="getItemModal('.$row['itemID'].')" data-toggle="modal" data-target="#modal-modalDetails">'.$row['name'].'</button></li>';
	                }
	                echo'</ul>
	            </div>               
	        </div>
	    </div>
	    </div>';
	}
?>
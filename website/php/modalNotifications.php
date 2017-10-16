<?php
	include("config.php");
	session_start();

	//Create modal
	echo '<div class="modal-dialog">
		<div class="modal-content">

      		<div class="modal-header background-color-blue">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
        		<span class="modalTitle">Notification Settings</span>
      		</div>

	      	<div class="modal-body testing">';
			if (isset($_SESSION['userID'])){ //Check the user is logged in
				//Get all of the tags that the user has turned on for notifications
				$userTags = array();
				$stmt = $db->prepare('SELECT tagID FROM tag INNER JOIN notification on tag.tagID = notification.FKTag WHERE notification.FKClient = ?');
    			$stmt->execute(array($_SESSION['userID']));
    			$stmt = array_values($stmt->fetchAll(PDO::FETCH_ASSOC));
    			//loop all of these tags and add them to an array
    			foreach ($stmt as $row) {
					$userTags[] = $row['tagID'];
				}

				echo '<table class="table-sm" style="width:100%;">';
				//Get all tags and loop for each showing the tags name and a switch to turn on/off the tag notification
				foreach($db->query('SELECT * FROM tag') as $row) {
					echo '<tr>
						<td class="notificationChangeTable" style="text-align: right;"><b>'.$row['name'].'&nbsp;</b></td>
						<td class="notificationChangeTable" style="text-align: left;"><label class="switch">';
						  	echo '<input id="notificationCheckBox'.$row['tagID'].'" value="'.$row['tagID'].'" type="checkbox"';
							if (in_array($row['tagID'], $userTags)) { //If the current tag is in the array of tags that the user has turned on then set the checkbox to checked (on)
								echo ' checked';
							}
							//Show the slider for the checkbox (css)
							echo '>
						  	<span class="slider round"></span>
						</label></td>
					<tr>';
				}
				echo '</table>';

				//Messages can be sent to this span
				echo '<span id="notificationMsgID"></span>
				</div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      	</div>';
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	                <p>YOU MUST BE LOGGED IN TO UPDATE YOUR NOTIFICATIONS</p>
	            </div>
				</div>
		      	<div class="modal-footer testing">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      	</div>';
			}
		echo '</div>
	</div>';
?>
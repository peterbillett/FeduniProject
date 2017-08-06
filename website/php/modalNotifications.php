<?php
	include("config.php");
	session_start();
	echo '<div class="modal-dialog">
		<div class="modal-content">

      		<div class="modal-header background-color-blue">
        		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="modalTitle">&times;</span></button>
        		<span class="modalTitle">Notification Settings</span>
      		</div>

	      	<div class="modal-body testing">';
			if (isset($_SESSION['userID'])){
				$userTags = array();
				$stmt = $db->prepare('SELECT * FROM tag INNER JOIN notification on tag.tagID = notification.FKTag WHERE notification.FKClient = ?');
    			$stmt->execute(array($_SESSION['userID']));
    			if($stmt->rowCount() > 0) {
					echo '<table class="table table-striped" style="width:100%;">
					<tbody>
						<tr>
					    	<td colspan="2"><b>CURRENT NOTIFICATIONS</b></td>
					 	</tr>';
        				$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
                		foreach ($stmt as $row) {
                			$userTags[] = $row['tagID'];
							echo '<tr>
								<td style="text-align: right; padding-right: 5px; width: 50%;">'.$row['name'].'</td>
								<td style="text-align: left; width: 50%;"><button type="button" class="btn btn-default" onclick="removeNotification('.$row['tagID'].')">Remove</button></td>
							</tr>';
						}
					echo '</tbody>
					</table>';
				}
				$stmt = $db->prepare("SELECT * FROM tag WHERE tagID NOT IN ( '" . implode($userTags, "', '") . "' )");
				$stmt->execute(array($_SESSION['userID']));
				if($stmt->rowCount() > 0) {
					echo '<table class="table" style="width:100%;">
						<tbody>
							<tr class="active">
								<td><b>Add new notification</b></td>
							</tr>
							<tr>
								<td>
									<select id="notificationTags" class="form-control" name="notificationTags">';
										$stmt = $stmt->fetchAll(PDO::FETCH_ASSOC);
					            		foreach ($stmt as $row) {
					            			echo '<option value="'.$row['tagID'].'">'.$row['name'].'</option>';
					            		}
									echo '</select>
								</td>
							</tr>
							<tr>
								<td><button class="btn btn-primary" onclick="addNotification()">Add Notification</button></td>
							</tr>
						</tbody>
					</table>';
				}
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
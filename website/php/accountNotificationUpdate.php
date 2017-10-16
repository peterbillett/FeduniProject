<?php
	include("config.php");
	session_start();

	//Check if the user is logged in
	if (isset($_SESSION['userID'])){
		if ($_POST['status'] == "false") { //If the status is false then remove the notification for that tag/user
			$stmt = $db -> prepare ('DELETE FROM notification WHERE FKclient = ? AND FKTag = ?');
			$stmt -> execute (array($_SESSION['userID'], $_POST['id']));

			////Checks to see if data deletion was successful
			if ($stmt->rowCount() == 1) {
				echo 'success';
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                  <span aria-hidden="true">×</span>
	               </button>
	                  <p>There was an issue removing the notification</p>
	                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
	            </div>';
			}
		} else { //else add a notification for that tag/user
			$stmt = $db->prepare("INSERT INTO notification(FKClient, FKTag) VALUES (:FKClient, :FKTag)");
			$stmt->execute(array(':FKClient' => $_SESSION['userID'], ':FKTag' => $_POST['id']));
	  
			//Checks to see if data insertion was successful
			if($stmt->rowCount() == 1) {
				echo 'success';
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                  <span aria-hidden="true">×</span>
	               </button>
	                  <p>There was an issue setting the new notification</p>
	                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
	            </div>';
			}
		}	
	} else {
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>You must be logged in to remove notifications</p>
              <p>Please refresh the page</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>
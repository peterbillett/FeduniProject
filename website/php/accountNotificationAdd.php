<?php
	include("config.php");
	session_start();

	if (isset($_SESSION['userID'])){
		$stmt = $db->prepare("SELECT * FROM notification WHERE FKTag = ? AND FKClient = ?");
		$stmt -> execute(array($_GET['id'], $_SESSION['userID']));

		if($stmt->rowCount() > 0) {
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>You already have that notification!</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
		} else {
			$stmt = $db->prepare("INSERT INTO notification(FKClient, FKTag) VALUES (:FKClient, :FKTag)");
			$stmt->execute(array(':FKClient' => $_SESSION['userID'], ':FKTag' => $_GET['id']));
	  
			//Checks to see if data insertion was successful
			if($stmt->rowCount() == 1) {
				echo 'SUCCESS';
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
              <p>You must be logged in to set notifications</p>
              <p>Please refresh the page</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>
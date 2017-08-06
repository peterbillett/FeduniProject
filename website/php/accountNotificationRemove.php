<?php
	include("config.php");
	session_start();

	if (isset($_SESSION['userID'])){
		$stmt = $db -> prepare ('DELETE FROM notification WHERE FKclient = ? AND FKTag = ?');
		$stmt -> execute (array($_SESSION['userID'], $_GET['id']));
		if ($stmt->rowCount() == 1) {
			echo 'SUCCESS';
		} else {
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>There was an issue removing the notification</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
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
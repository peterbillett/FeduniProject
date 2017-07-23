<?php
	include("config.php");
	session_start();

	if(isset($_SESSION['userID'])) {
		$stmt = $db -> prepare ('DELETE FROM item WHERE FKclient=?');
		$stmt -> execute (array($_SESSION['userID']));

		$stmt = $db -> prepare ('DELETE FROM notification WHERE FKclient=?');
		$stmt -> execute (array($_SESSION['userID']));

		$stmt = $db -> prepare ('DELETE FROM client WHERE clientID=?');
		$stmt -> execute (array($_SESSION['userID']));
		
		if($stmt -> rowCount() > 0) {
			session_destroy();
			echo "success";	
		} else {
			//Notify the user of the failure
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Error: There was an error deleting your account</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
		}
	} else {
		//Notify the user they are not logged in
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You must be logged in to delete your account</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>

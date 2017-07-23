<?php
	include("config.php");
	session_start();

	if(isset($_SESSION['userID'])) {
		$stmt = $db -> prepare ('UPDATE client SET FKgroup = NULL WHERE clientID=?');
		$stmt -> execute (array($_SESSION['userID']));
		
		if($stmt -> rowCount() > 0) {
			echo "success";	
		} else {
			//Notify the user of the failure
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Error: There was an error leaving the organisation</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
		}
	} else {
		//Notify the user they are not logged in
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You must be logged in to leave the organisation</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>

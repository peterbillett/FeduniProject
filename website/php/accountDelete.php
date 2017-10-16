<?php
	include("config.php");
	session_start();

	//Check the user is logged in
	if(isset($_SESSION['userID'])) {
		//Delete the users items, notifications and account
		if($_SESSION['userID'] === $_POST['id'] || $_SESSION['accountType'] === "3"){
			$stmt = $db -> prepare ('DELETE FROM item WHERE FKclient=?');
			$stmt -> execute (array($_POST['id']));

			$stmt = $db -> prepare ('DELETE FROM notification WHERE FKclient=?');
			$stmt -> execute (array($_POST['id']));

			$stmt = $db -> prepare ('DELETE FROM client WHERE clientID=?');
			$stmt -> execute (array($_POST['id']));
			
			if($stmt -> rowCount() > 0) {
				if ($_SESSION['userID'] === $_POST['id']) {
					session_destroy();
				}
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
			//Notify the user they do not have permission to delete the account
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
		       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		          <span aria-hidden="true">×</span>
		       </button>
		          <p>Error: You do not have permission to delete this account</p>
		          <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
		    </div>';
		}
	} else {
		//Notify the user they are not logged in
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You are not logged in.</p>
              <p>Please refresh the page then try again</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>

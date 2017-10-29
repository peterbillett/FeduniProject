<?php
	include("config.php");
	session_start();

	//Check the user is logged in. An account is required to make changes to an items status 
	if(isset($_SESSION['userID'])){
		if ($_POST['status'] == 3){ //Change status 3 to 0 to be read by the database correctly
			$status = "0";
		} else {
			$status = $_POST['status'];
		}

		if(empty($_POST['id']) || empty($_POST['status'])){ //Check if the required values are missing
			echo "Error: Invalid status update call";
		} else {
			//Update the items status to the new status
      		$stmt = $db->prepare("UPDATE item SET finished=? WHERE itemID=?");
      		$stmt->execute(array($status, $_POST['id']));
			if ($stmt->rowCount() > 0){ //Upon success update the items last modified time to the current time and return success
				$stmt = $db->prepare("UPDATE item SET lastModifiedTime=now() WHERE itemID=?"); 
         		$stmt->execute(array($_POST['id'])); 
				echo "success";
			} else { //On failure report error
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                  <span aria-hidden="true">×</span>
	               </button>
	                  <p>Error: Could not update the items status</p>
	                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
	            </div>';
			}
		}
	} else { //Else report error
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You are not logged in</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}

?>
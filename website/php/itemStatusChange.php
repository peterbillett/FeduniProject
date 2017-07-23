<?php
	include("config.php");
	session_start();

	if(isset($_SESSION['userID'])){
		if ($_GET['status'] == 3){
			$status = 0;
		} else {
			$status = $_GET['status'];
		}

		if(empty($_GET['id']) || empty($_GET['status'])){
			echo "Error: Invalid status update call";
		} else {
			$stmt = $db->prepare("UPDATE item SET finished=? WHERE itemID=?");
			$stmt->execute(array($status, $_GET['id']));
			if ($stmt->rowCount() > 0){
				$stmt = $db->prepare("UPDATE item SET lastModifiedTime=now() WHERE itemID=?");
         		$stmt->execute(array($_GET['id'])); 
				echo "success";
			} else {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
	               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                  <span aria-hidden="true">×</span>
	               </button>
	                  <p>Error: Could not update the items status</p>
	                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
	            </div>';
			}
		}
	} else {
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You are not logged in</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}

?>
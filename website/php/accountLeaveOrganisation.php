<?php
	include("config.php");
	session_start();

	//Check if the user is logged in
	if(isset($_SESSION['userID'])) {
		//Update the users organisation to null
		
		$stmt = $db->prepare("SELECT FKgroup FROM client WHERE clientID = ?");
        $stmt->execute(array($_SESSION['userID']));
        $groupID = $stmt->fetch(PDO::FETCH_ASSOC);

		$stmt = $db->prepare("SELECT clientID FROM client WHERE FKgroup = ?");
        $stmt->execute(array($groupID['FKgroup']));
		if ($stmt->rowCount() > 1) {
			$stmt = $db -> prepare ('UPDATE client SET FKgroup=NULL, accountType=1 WHERE clientID=?');
      		$stmt -> execute (array($_SESSION['userID']));
		} else {
			$stmt = $db -> prepare ('UPDATE client SET FKgroup=NULL, accountType=1 WHERE clientID=?');
      		$stmt -> execute (array($_SESSION['userID']));

		    $stmt = $db -> prepare ('UPDATE item SET organisation=NULL, lastModifiedTime=now() WHERE organisation=?');
		    $stmt -> execute (array($groupID['FKgroup']));

		    $stmt = $db->prepare("DELETE FROM organisation WHERE groupID=:id");
		    $stmt->bindValue(':id', $groupID['FKgroup'], PDO::PARAM_STR);
		    if ($_SESSION['accountType'] === "2") {
      			$_SESSION['accountType'] = "1";
      		}
		}
		
		//On success return success
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

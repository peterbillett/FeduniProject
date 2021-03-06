<?php
   session_start();
   include("config.php");

   	if(isset($_SESSION['userID'])) {
		if($_SERVER["REQUEST_METHOD"] == "POST") {

			// Checks if that organisation name already exists
			$stmt = $db->prepare("SELECT name FROM organisation WHERE UCASE(name) = UCASE(?)");
			$stmt -> execute(array($_POST['volOrgName']));
		
			// Checks to see if the organisation name in the form already exists
			if($stmt->rowCount() == 1) {
				echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
		               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                  <span aria-hidden="true">×</span>
		               </button>
		                  <p>Error: Volunteer Organisation Name already exists</p>
		                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
		            </div>';
			} else {
				// Inserts the new values into the database
				$stmt = $db->prepare("INSERT INTO organisation(name, Information, address) VALUES (:name, :information, :address) ");
				$stmt->execute(array(':name' => $_POST['volOrgName'], ':information' => $_POST['volOrgInformation'], ':address' => $_POST['volOrgAddress']));
			  
				// Checks to see if data insertion was successful
				if($stmt->rowCount() == 1) {
					$insertId = $db->lastInsertId();
					//If it was successful then update the client to an org owner
					$stmt = $db -> prepare ('UPDATE client SET FKgroup=?, accountType=2 WHERE clientID=?');
					$stmt -> execute (array($insertId, $_SESSION['userID']));
					echo $insertId;	
				} else {
					echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
		               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		                  <span aria-hidden="true">×</span>
		               </button>
		                  <p>Error: Failed to create the new volunteer group</p>
		                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
		            </div>';
				}
			}
		} else {
			echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Error: The message received was not a POST</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
		}
	} else {
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You must be logged in to create an volunteer group</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>

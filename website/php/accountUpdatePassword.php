<?php
	session_start();
	include("config.php");

	if (isset($_SESSION['userID'])){
    $hashedPassword = password_hash($_GET['newPassword'], PASSWORD_DEFAULT);
		$stmt = $db->prepare("UPDATE client SET clientPassword=? WHERE clientID=?");
		$stmt->execute(array($hashedPassword, $_SESSION['userID']));
      	if($stmt->rowCount() == 0){
      		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Error: There was an error updating your password</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
      	} else {
      		echo 'success';
      	}
	} else {
		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">×</span>
           </button>
              <p>Error: You must be logged in to update your password</p>
              <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
        </div>';
	}
?>
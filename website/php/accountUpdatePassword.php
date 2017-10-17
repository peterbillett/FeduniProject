<?php
	session_start();
	include("config.php");

  //Check the user is logged in
	if (isset($_SESSION['userID'])){
    //Password must be between 6-15 char, at least 1 number and at least 1 letter
    if (preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])[a-zA-Z0-9!@#$%^&*]{6,50}$/', $_POST['newPassword'])
    && $_POST['newPassword'] == $_POST['passwordConfirm']) {
      //Get the password for the user
      $stmt = $db->prepare("SELECT clientPassword FROM client WHERE clientID=?");
      $stmt->execute(array($_SESSION['userID']));
      if($stmt->rowCount() == 1) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        //Confirm the current password entered matches the current password in the database
        if (password_verify($_POST['oldPassword'], $result['clientPassword'])) {
          //If it matches then hash the new password and update the users password to it
          $hashedPassword = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
          $stmt = $db->prepare("UPDATE client SET clientPassword=? WHERE clientID=?");
          $stmt->execute(array($hashedPassword, $_SESSION['userID']));
          if($stmt->rowCount() > 0){ //On successful update return success else return the relevant error
            echo 'success';
            date_default_timezone_set('Australia/Melbourne');
            $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
            $updateClientSeen->execute(array($_SESSION['userID']));
          } else {
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                 </button>
                    <b>Error: There was an error updating your password</b>
                    <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
              </div>';
          }
        } else {
          echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
             </button>
                <b>Your current password is incorrect.</b>
                <p>Please correct it then try again.</p>
                <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
          </div>';
        }
      } else {
        echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
             </button>
                <b>Error: Unable to access account information.</b>
                <p>Please try again later</p>
                <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
          </div>';
      }
  	} else {
  		echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
             </button>
                <b>Invalid data sent when creating account</b>
                <p>Please check the data entered was correct before trying again</p>
                <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
          </div>';
  	}
  } else {
    echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
             </button>
                <b>You must be logged in to update your password!</b>
                <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
          </div>';
  }
?>
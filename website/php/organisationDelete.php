<?php
   include("config.php");
   session_start();

   //Check if the user is not logged in, if they are not logged in then report error
   if (!isset($_SESSION['userID'])) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You are not logged in.</p>
            <p>Please reload the page</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
      return;
   }

   //Check if they are an admin or the organisations owner and return the organisations details
   if ($_SESSION['accountType'] === "3") {
      $stmt = $db->prepare("SELECT groupID FROM organisation WHERE groupID=?");
      $stmt->execute(array($_POST['id']));
   } elseif ($_SESSION['accountType'] === "2") {
      $stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=? AND organisation.groupID=?");
      $stmt->execute(array($_SESSION['userID'],$_POST['id']));
   } else { //If they are not an admin or org owner then report error
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You do not have permission to delete organisations.</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
      return;
   }
   
   //If an organisation was not returned report error
   if ($stmt->rowCount() == 0) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You can not remove someone els'."'".'s organisation</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      //Update the org owner to a normal account 
      $stmt = $db -> prepare ('UPDATE client SET accountType=1 WHERE FKgroup=? AND accountType<3');
      $stmt -> execute (array($_POST['id']));
      //Update all clients org that are in this org to null
      $stmt = $db -> prepare ('UPDATE client SET FKgroup=NULL WHERE FKgroup=?');
      $stmt -> execute (array($_POST['id']));
      //Update all items linked to the org to null (the org link)
      $stmt = $db -> prepare ('UPDATE item SET organisation=NULL WHERE organisation=?');
      $stmt -> execute (array($_POST['id']));
      //Delete the org
      $stmt = $db->prepare("DELETE FROM organisation WHERE groupID=:id");
      $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
      $stmt->execute();
      //On success return success
      if ($stmt->rowCount() > 0) {
         echo "success";
      } else { //Else report error
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to remove organisation</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
   }
?>
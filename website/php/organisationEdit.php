<?php
   include("config.php");
   session_start();

   //Check if the user is not logged in, if they arnt then report error
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
            <p>You do not have permission to edit organisations.</p>
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
            <p>You cannot edit someone else'."'".'s organisation</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else { //Else update the organisation with the passed information
      $stmt = $db->prepare("UPDATE organisation SET name=?, Information=?, currentNews=?, address=?, lastModified=now() WHERE groupID=?");
      $stmt->execute(array($_POST['name'], $_POST['description'], $_POST['currentNews'], $_POST['address'], $_POST['id']));

      //if the update failed the report error
      if ($stmt->rowCount() == 0) {
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to edit organisation</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      } else { //Else return success
         echo "success";
         date_default_timezone_set('Australia/Melbourne');
         $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
         $updateClientSeen->execute(array($_SESSION['userID']));
      }
   }
?>
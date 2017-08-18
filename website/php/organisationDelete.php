<?php
   include("config.php");
   session_start();

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

   if ($_SESSION['accountType'] === "3") {
      $stmt = $db->prepare("SELECT groupID FROM organisation WHERE groupID=?");
      $stmt->execute(array($_GET['id']));
   } elseif ($_SESSION['accountType'] === "2") {
      $stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=? AND organisation.groupID=?");
      $stmt->execute(array($_SESSION['userID'],$_GET['id']));
   } else {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You do not have permission to delete organisations.</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
      return;
   }
   
   if ($stmt->rowCount() == 0) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You can not remove someone els'."'".'s organisation</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      $stmt = $db -> prepare ('UPDATE client SET FKgroup=NULL WHERE FKgroup=?');
      $stmt -> execute (array($_GET['id']));
      $stmt = $db -> prepare ('UPDATE item SET organisation=NULL WHERE organisation=?');
      $stmt -> execute (array($_GET['id']));
      $stmt = $db->prepare("DELETE FROM organisation WHERE groupID=:id");
      $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
      $stmt->execute();
      if ($stmt->rowCount() > 0) {
         echo "success";
      } else {
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
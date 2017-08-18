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
            <p>You do not have permission to edit organisations.</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
      return;
   }
   
   if ($stmt->rowCount() == 0) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You cannot edit someone else'."'".'s organisation</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt = $db->prepare("UPDATE organisation SET name=?, Information=?, currentNews=? WHERE groupID=?");
      $stmt->execute(array($_GET['name'], $_GET['description'], $_GET['currentNews'], $_GET['id']));

      if ($stmt->rowCount() == 0) {
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to edit organisation</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      } else {
         echo "success";
      }
   }
?>
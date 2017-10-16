<?php
   include("config.php");
   include("updateItemFinished.php");
   session_start();

   //Check if the user is logged in
   if(!isset($_SESSION['userID'])){
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You must be logged in before you can edit your listings.</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
      return;
   }

   //If the user is an admin select the item
   if ($_SESSION['accountType'] === "3"){
      $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=?");
      $stmt->execute(array($_POST['id']));
   } elseif ($_SESSION['accountType'] === "2"){ //If the user is an organisation owner select the item if it is from the same organisation
      $stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=?");
      $stmt->execute(array($_SESSION['userID']));
      $clientOrg = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND organisation=?");
      $stmt->execute(array($_POST['id'],$clientOrg['groupID']));
      if($stmt->rowCount() == 0){ //If it is not linked to an organisation, check if the user owns the item
         $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND FKclient=?");
         $stmt->execute(array($_POST['id'],$_SESSION['userID']));
      }
   } else { //if they are a basic user then check if they own the item
      $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND FKclient=?");
      $stmt->execute(array($_POST['id'],$_SESSION['userID']));
   }
   
   if($stmt->rowCount() == 0) { //If nothing was selected then they dont have permission or it doesnt exist
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You cannot edit someone else'."'".'s item</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {//Update the item with the new information
      $stmt = $stmt->fetch(PDO::FETCH_ASSOC);
      $stmt = $db->prepare("UPDATE item SET name=?, description=?, category=?, endtime=?, lastModifiedTime=now() WHERE itemID=?");
      $stmt->execute(array($_POST['title'], $_POST['description'], $_POST['category'], date('Y-m-d h:m:s', strtotime($_POST['endtime'])), $_POST['id']));

      if($stmt->rowCount() == 0){
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to edit listing</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      } else { //On success
         echo "success";
         date_default_timezone_set('Australia/Melbourne');
         $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
         $updateClientSeen->execute(array($_SESSION['userID']));
      }
   }
?>
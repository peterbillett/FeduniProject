<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You must be logged in to create an item</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      if ($_GET['linkToOrg'] == "true") {
         $stmt = $db->prepare("SELECT FKGroup FROM client WHERE clientID=?");
         $stmt->execute(array($_SESSION['userID']));
         $groupID = $stmt->fetch(PDO::FETCH_ASSOC);
         $groupID = $groupID['FKGroup'];
      } else {
         $groupID = NULL;
      }

      if ($_GET['mapLocation'] == '[Org]') {
         if ($groupID != NULL){
            $stmt = $db->prepare("SELECT address FROM organisation WHERE groupID = ?");
            $stmt->execute(array($groupID));
            $address = $stmt->fetch(PDO::FETCH_ASSOC);
            $address = $address['address'];
         } else {
            $address = NULL;
         }
      } elseif ($_GET['mapLocation'] == "NULL") {
         $address = NULL;
      } else {
         $address = $_GET['mapLocation'];
      }

      if ($_GET['perishable'] == "true") {
         $perishable = true;
      } else {
         $perishable = false;
      }
      
      $stmt = $db->prepare("INSERT INTO item(name,endtime,description,category,FKclient,organisation,FKTagID,perishable,location)
                           VALUES(:name,:endtime,:description,:category,:FKclient,:organisation,:FKTagID,:perishable,:location)");
      $stmt->execute(array(':name' => $_GET['title'], ':endtime' => date('Y-m-d h:m:s', strtotime($_GET['endtime'])), ':description' => $_GET['description'],
                          ':category' => $_GET['category'],':FKclient' => $_SESSION['userID'], ':organisation' => $groupID, ':FKTagID' => $_GET['tagID'],
                           ':perishable' => $perishable, ':location' => $address));
      $insertId = $db->lastInsertId();

      if($stmt->rowCount() == 0){
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to create item</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
      else{
         echo $insertId;
      }
   }
?>
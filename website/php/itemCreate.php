<?php
   include("config.php");
   session_start();

   //Check the user is logged in
   if(!isset($_SESSION['userID'])) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You must be logged in to create an item</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      //Get the number of items made by the user with in the last 5 minutes
      $stmt = $db->prepare("SELECT itemID FROM `item` WHERE dateCreated > DATE_SUB(NOW(),INTERVAL 500 MINUTE) AND FKclient = ?");
      $stmt->execute(array($_SESSION['userID']));

      //If the number of items created by that user within the last 5 minutes is greater, then report they have made too many items
      if (intval($stmt->rowCount()) > 4) {
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>You have made too many items in the last 5 minutes...</p>
               <p>Please wait a few minutes before trying again</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      } else {
         //Check for the users organisation if they choose to link it
         if ($_POST['linkToOrg'] == "true") {
            $stmt = $db->prepare("SELECT FKGroup FROM client WHERE clientID=?");
            $stmt->execute(array($_SESSION['userID']));
            $groupID = $stmt->fetch(PDO::FETCH_ASSOC);
            $groupID = $groupID['FKGroup'];
         } else {
            $groupID = NULL;
         }

         //If they choose to link the address to the organisation then get the address from the organisation, else set the address to the custom address or null
         if ($_POST['mapLocation'] == '[Org]') {
            if ($groupID != NULL){
               $stmt = $db->prepare("SELECT address FROM organisation WHERE groupID = ?");
               $stmt->execute(array($groupID));
               $address = $stmt->fetch(PDO::FETCH_ASSOC);
               $address = $address['address'];
            } else {
               $address = NULL;
            }
         } elseif ($_POST['mapLocation'] == "Null") {
            $address = NULL;
         } else {
            $address = $_POST['mapLocation'];
         }

         //Check if the item is perishable
         if ($_POST['perishable'] == "true") {
            $perishable = true;
         } else {
            $perishable = false;
         }
         
         //Create the item
         $stmt = $db->prepare("INSERT INTO item(name,endtime,description,category,FKclient,organisation,FKTagID,perishable,location)
                              VALUES(:name,:endtime,:description,:category,:FKclient,:organisation,:FKTagID,:perishable,:location)");
         $stmt->execute(array(':name' => $_POST['title'], ':endtime' => date('Y-m-d h:m:s', strtotime($_POST['endtime'])), ':description' => $_POST['description'],
                             ':category' => $_POST['category'],':FKclient' => $_SESSION['userID'], ':organisation' => $groupID, ':FKTagID' => $_POST['tagID'],
                              ':perishable' => $perishable, ':location' => $address));
         $insertId = $db->lastInsertId(); //Get the items id

         //Check if it failed
         if($stmt->rowCount() == 0){
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Failed to create item</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
         }
         else{ //On success return the itemid and create an email queue item for that items notiification
            echo $insertId;
            $stmt = $db->prepare("INSERT INTO emailqueue(referenceNum,emailType) VALUES(:referenceNum,:emailType)");
            $stmt->execute(array(':referenceNum' => $insertId, ':emailType' => 1));
            date_default_timezone_set('Australia/Melbourne');
            $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
            $updateClientSeen->execute(array($_SESSION['userID']));
         }
      }      
   }
?>
<?php
   include("config.php");
   session_start();

   //Check the user is logged in
   if(!isset($_SESSION['userID'])){
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>You are not logged in.</p>
               <p>Please reload the page</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      //If the users account if higher than basic access then select the item else they must also own the item
      //If the user is an admin then select the item
      if ($_SESSION['accountType'] === "3"){
         $stmt = $db->prepare("SELECT itemID, image FROM item WHERE itemID=?");
         $stmt->execute(array($_POST['id']));
      } elseif ($_SESSION['accountType'] === "2"){ //If the user is the owner of an organisation confirm the item is linked to the organisation
         $stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=?");
         $stmt->execute(array($_SESSION['userID']));
         $clientOrg = $stmt->fetch(PDO::FETCH_ASSOC);
         $stmt = $db->prepare("SELECT itemID, image FROM item WHERE itemID=? AND organisation=?");//If they are linked select it
         $stmt->execute(array($_POST['id'],$clientOrg['groupID']));
         if($stmt->rowCount() == 0){ //If they are not linked then check if they own the item
            $stmt = $db->prepare("SELECT itemID, image FROM item WHERE itemID=? AND FKclient=?");
            $stmt->execute(array($_POST['id'],$_SESSION['userID']));
         }
      } else { //If they are a basic user then confirm they own the item
         $stmt = $db->prepare("SELECT itemID, image FROM item WHERE itemID=? AND FKclient=?");
         $stmt->execute(array($_POST['id'],$_SESSION['userID']));
      }
      
      if($stmt->rowCount() == 0){ //If no item was returned then they dont own it or they it doesnt exist
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>You can not remove someone els'."'".'s listing</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
      else{ //Delete the image and the database item
         $DBimage = $stmt->fetch(PDO::FETCH_ASSOC);
         $stmt = $db->prepare("DELETE FROM item WHERE itemID=:id");
         $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
         $stmt->execute();
         unlink("../uploads/".$DBimage['image']) or die();
         if($stmt->rowCount() > 0){
            echo "success";
         }
         else{
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Failed to remove listing</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
         }
      }
   }
?>
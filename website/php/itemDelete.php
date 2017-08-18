<?php
   include("config.php");
   session_start();

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
      
      if ($_SESSION['accountType'] > 1){
         $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=?");
         $stmt->execute(array($_GET['id']));
      } else {
         $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=? AND itemID=?");
         $stmt->execute(array($_SESSION['userID'],$_GET['id']));
      }

      if ($_SESSION['accountType'] === "3"){
         $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=?");
         $stmt->execute(array($_GET['id']));
      } elseif ($_SESSION['accountType'] === "2"){
         $stmt = $db->prepare("SELECT groupID FROM organisation LEFT JOIN client ON client.FKgroup = organisation.groupID WHERE client.clientID=?");
         $stmt->execute(array($_SESSION['userID']));
         $clientOrg = $stmt->fetch(PDO::FETCH_ASSOC);
         $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND organisation=?");
         $stmt->execute(array($_GET['id'],$clientOrg['groupID']));
         if($stmt->rowCount() == 0){
            $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND FKclient=?");
            $stmt->execute(array($_GET['id'],$_SESSION['userID']));
         }
      } else {
         $stmt = $db->prepare("SELECT itemID FROM item WHERE itemID=? AND FKclient=?");
         $stmt->execute(array($_GET['id'],$_SESSION['userID']));
      }
      
      if($stmt->rowCount() == 0){
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>You can not remove someone els'."'".'s listing</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
      else{
         $stmt = $db->prepare("DELETE FROM item WHERE itemID=:id");
         $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
         $stmt->execute();
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
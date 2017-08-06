<?php
   include("config.php");
   include("updateItemFinished.php");
   session_start();

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

   $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=? AND itemID=?");
   $stmt->execute(array($_SESSION['userID'], $_GET['id']));
   if($stmt->rowCount() == 0) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You can not edit someone else'."'".'s listing</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   } else {
      $stmt = $db->prepare("UPDATE item SET name=?, description=?, category=?, endtime=? WHERE itemID=?");
      $stmt->execute(array($_GET['title'], $_GET['description'], $_GET['category'], date('Y-m-d h:m:s', strtotime($_GET['endtime'])), $_GET['id']));

      if($stmt->rowCount() == 0){
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to edit listing</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      } else {     
         $stmt = $db->prepare("UPDATE item SET lastModifiedTime=now() WHERE itemID=?");
         $stmt->execute(array($_GET['id']));    
         echo "success";
      }
   }
?>
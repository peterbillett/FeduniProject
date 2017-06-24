<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])){
      echo "You must be logged in before you can edit your listings.";
      return;
   }

   $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=? AND itemID=?");
   $stmt->execute(array($_SESSION['userID'],$_GET['id']));
   if($stmt->rowCount() == 0) {
      echo "You can not edit someone else's listing";
   } else {
      $stmt = $db->prepare("UPDATE item SET name=?, description=?, category=? WHERE itemID=?");
      $stmt->execute(array($_GET['title'],$_GET['description'],$_GET['category'], $_GET['id']));

      if($stmt->rowCount() == 0){
         echo "Failed to edit listing";
      } else {         
         echo "success";
      }
   }
?>
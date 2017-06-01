<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])){
      echo "You must be logged in to remove listings";
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=? AND itemID=?");
      $stmt->execute(array($_SESSION['userID'],$_GET['id']));
      if($stmt->rowCount() == 0){
         echo "You can not remove someone else's listing";
      }
      else{
         $stmt = $db->prepare("DELETE FROM item WHERE itemID=:id");
         $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
         $stmt->execute();
         if($stmt->rowCount() > 0){
            echo "success";
         }
         else{
            echo "Failed to remove listing";
         }
      }
   }
?>
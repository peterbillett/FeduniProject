<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
         window.alert('You must be logged in before you can remove your listings.')
         window.location.href='../createAccountLogin.html';
         </SCRIPT>");
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=?");
      $stmt->execute(array($_SESSION['userID']));
      if($stmt->rowCount() == 0){
         echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('You can not remove someone else's listing.')
            window.location.href='../item.html?id=".$_GET['id']."';
            </SCRIPT>");
      }
      else{
         $stmt = $db->prepare("DELETE FROM item WHERE itemID=:id");
         $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
         $stmt->execute();
         if($stmt->rowCount() == 0){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('Failed to remove listing.')
               window.location.href='../item.html?id=".$_GET['item']."';
               </SCRIPT>");
         }
         else{         
            echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('Listing removed.')
               window.location.href='../index.html';
               </SCRIPT>");
         }
      }
   }
?>
<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
         window.alert('You must be logged in before you can edit your listings.')
         window.location.href='../createAccountLogin.html';
         </SCRIPT>");
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $stmt = $db->prepare("SELECT itemID FROM item WHERE FKclient=?");
      $stmt->execute(array($_SESSION['userID']));
      if($stmt->rowCount() == 0){
         echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('You can not edit someone else's listing.')
            window.location.href='../item.html?id=".$_GET['id']."';
            </SCRIPT>");
      }
      else{
         $stmt = $db->prepare("UPDATE item SET name=?, description=?, category=? WHERE itemID=?");
         $stmt->execute(array($_POST['title'],$_POST['description'],$_POST['category'], $_GET['id']));

         if($stmt->rowCount() == 0){
            echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('Failed to edit listing.')
               window.location.href='../item.html?item=".$_GET['id']."';
               </SCRIPT>");
         }
         else{         
            echo ("<SCRIPT LANGUAGE='JavaScript'>
               window.alert('Listing updated.')
               window.location.href='../item.html?item=".$_GET['id']."';
               </SCRIPT>");
         }
      }
   }
?>
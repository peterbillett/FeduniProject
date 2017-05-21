<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])){
      echo ("<SCRIPT LANGUAGE='JavaScript'>
         window.alert('You must login before creating a listing.')
         window.location.href='../createAccountLogin.html';
         </SCRIPT>");
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $stmt = $db->prepare("SELECT FKGroup FROM client WHERE clientID=?");
      $stmt->execute(array($_SESSION['userID']));
      $groupID = $stmt->fetch(PDO::FETCH_ASSOC);

      $stmt = $db->prepare("INSERT INTO item(name,endtime,description,category,FKclient,organisation,FKTagID)
                           VALUES(:name,:endtime,:description,:category,:FKclient,:organisation,:FKTagID)");
      $stmt->execute(array(':name' => $_POST['title'], ':endtime' => date('Y-m-d h:m:s', strtotime($_POST['endtime'])), ':description' => $_POST['description'],
                           ':category' => $_POST['category'],':FKclient' => $_SESSION['userID'], ':organisation' => $groupID['FKGroup'], ':FKTagID' => $_POST['tagID']));
      $insertId = $db->lastInsertId();

      if($stmt->rowCount() == 0){
         echo ("<SCRIPT LANGUAGE='JavaScript'>
            window.alert('Failed to create listing.')
            window.location.href='../createListing.html';
            </SCRIPT>");
      }
      else{         
         header("location: ../item.html?item=".$insertId);
      }
   }
?>
<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])) {
      echo 'failed';
   } else {
      $stmt = $db->prepare("SELECT FKGroup FROM client WHERE clientID=?");
      $stmt->execute(array($_SESSION['userID']));
      $groupID = $stmt->fetch(PDO::FETCH_ASSOC);

      $stmt = $db->prepare("INSERT INTO item(name,endtime,description,category,FKclient,organisation,FKTagID)
                           VALUES(:name,:endtime,:description,:category,:FKclient,:organisation,:FKTagID)");
      $stmt->execute(array(':name' => $_GET['title'], ':endtime' => date('Y-m-d h:m:s', strtotime($_GET['endtime'])), ':description' => $_GET['description'],
                           ':category' => $_GET['category'],':FKclient' => $_SESSION['userID'], ':organisation' => $groupID['FKGroup'], ':FKTagID' => $_GET['tagID']));
      $insertId = $db->lastInsertId();

      if($stmt->rowCount() == 0){
         echo 'failed';
      }
      else{         
         echo $insertId;
      }
   }
?>
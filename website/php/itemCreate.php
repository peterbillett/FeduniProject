<?php
   include("config.php");
   session_start();

   if(!isset($_SESSION['userID'])) {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>You muat be logged in to create an account</p>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
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
         echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">×</span>
            </button>
               <p>Failed to create item</p>
               <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
         </div>';
      }
      else{         
         echo $insertId;
      }
   }
?>
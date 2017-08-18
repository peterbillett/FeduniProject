<?php
   include("config.php");
   session_start();

  if (isset($_SESSION['userID'])){
      if ($_SESSION['accountType'] === "3"){
         $stmt = $db->prepare("INSERT INTO homepagenews(title,news) VALUES(:title,:description)");
         $stmt->execute(array(':title' => $_GET['title'], ':description' => $_GET['description']));
         $insertId = $db->lastInsertId();
         if($stmt->rowCount() == 0){
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Failed to create homepage message</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
         }
         else{
            echo "success";
         }
      }
   }
?>
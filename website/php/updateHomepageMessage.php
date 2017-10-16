<?php
   include("config.php");
   session_start();

   //Check the user is logged in
  if (isset($_SESSION['userID'])) {
      //Check the users id
      if ($_SESSION['accountType'] === "3") {
         //Insert into the homepage news the title and description that the request sent
         $stmt = $db->prepare("INSERT INTO homepagenews(title,news) VALUES(:title,:description)");
         $stmt->execute(array(':title' => $_POST['title'], ':description' => $_POST['description']));
         if ($stmt->rowCount() == 0) { //On failure report error
            echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
               </button>
                  <p>Failed to create homepage message</p>
                  <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
            </div>';
         } else { //Else return success
            echo "success";
            date_default_timezone_set('Australia/Melbourne');
            $updateClientSeen = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
            $updateClientSeen->execute(array($_SESSION['userID']));
         }
      }
   }
?>
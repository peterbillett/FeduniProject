<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST['email'];
      $password = $_POST['password'];
   }
   else{
      $email = $_GET['email'];
      $password = $_GET['password'];
   }
   $stmt = $db->prepare("SELECT clientID, accountType FROM client WHERE email=? AND clientPassword=?");
   $stmt->execute(array($email,$password));

   if($stmt->rowCount() == 1) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION['userID'] = $result['clientID'];
      $_SESSION['accountType'] = $result['accountType'];
      $stmt = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
      $stmt->execute(array($result['clientID']));
      echo "success";
   }else {
      echo '<br><div class="alert alert-danger alert-dismissible fade in" role="alert">
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
         </button>
            <p>Opps! The email or password was incorrect.</p>
            <h4>Please check your details then try again.</h4>
            <p><button type="button" class="btn btn-danger" data-dismiss="alert">Dismiss</button></p>
      </div>';
   }
?>
<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $stmt = $db->prepare("SELECT clientID FROM client WHERE email=?");
      $stmt->execute(array($_POST['email']));

      if($stmt->rowCount() == 1) {
         $result = $stmt->fetch(PDO::FETCH_ASSOC); 
         $_SESSION['userID'] = $result['clientID'];       
         header("location: ../index.html");
      }else {
         header("location: ../createAccountLogin.html");
         //$error = "Your Login Name or Password is invalid";
      }
   }
?>
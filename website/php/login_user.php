<?php
   include("config.php");
   session_start();

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $stmt = $db->prepare("SELECT clientID FROM client WHERE email=?");
      $stmt->execute(array($_POST['email']));

      if($stmt->rowCount() == 1) {
         //echo"GOOD";
         //echo $stmt['clientID'];
         //print_r($stmt);
         //echo('<p>success');
         $_SESSION['login_user'] = $_POST['email'];         
         header("location: ../index.html");
      }else {
         header("location: ../createAccountLogin.html");
         //echo('<p>failed');
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
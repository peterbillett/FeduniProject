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
   $stmt = $db->prepare("SELECT clientID FROM client WHERE email=? AND clientPassword=?");
   $stmt->execute(array($email,$password));

   if($stmt->rowCount() == 1) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION['userID'] = $result['clientID'];
      $stmt = $db->prepare("UPDATE client SET lastseen=now() WHERE clientID=?");
      $stmt->execute(array($result['clientID']));
      echo "success";
   }else {
      echo "The email or password was incorrect";
   }
?>
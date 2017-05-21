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
      echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('Login was successful.')
                  window.location.href='../index.html';
                  </SCRIPT>");
      header("location: ../index.html");
   }else {
      echo ("<SCRIPT LANGUAGE='JavaScript'>
                  window.alert('The entered details do not match any account.')
                  window.location.href='../createAccountLogin';
                  </SCRIPT>");
      header("location: ../createAccountLogin.html");
   }
?>
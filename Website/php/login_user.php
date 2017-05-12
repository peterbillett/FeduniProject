<?php
   include("config.php");
   session_start();

   if (isset($_REQUEST)) {
   //if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      @$myusername = mysqli_real_escape_string($db,$_POST['email']);
      @$mypassword = mysqli_real_escape_string($db,md5($_POST['password'])); 
      //and clientPassword = '$mypassword'
      $sql = "SELECT clientID FROM client WHERE email = '$myusername'";
      $result = mysqli_query($db,$sql);
      @$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $active = $row['active'];
      
      @$count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
      
      if($count == 1) {
         //session_register("myusername");
         $_SESSION['login_user'] = $myusername;         
         header("location: ../index.html");
      }else {
         header("location: ../createAccountLogin.html");
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
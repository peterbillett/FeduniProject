<?php
   include("config.php");
   session_start();

   echo("Test0");
   echo($_SERVER["REQUEST_METHOD"]);
   echo("testAfter");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      @$sentName = mysqli_real_escape_string($db,$_POST['title']);
      @$sentEndTime = mysqli_real_escape_string($db,$_POST['endtime']); 
      @$sentCategory = mysqli_real_escape_string($db,$_POST['category']); 
      @$sentDescription = mysqli_real_escape_string($db,$_POST['description']); 
      @$sentFKClient = mysqli_real_escape_string($db,$_POST['FKclient']); 
      @$sentOrganisation = mysqli_real_escape_string($db,$_POST['organisation']); 
      @$sentFKTagID = mysqli_real_escape_string($db,$_POST['tagID']);
      echo("$sentName");

      echo("Test1");
      $sql = "SELECT clientID FROM client WHERE email = 'gerdington@gmail.com'";
      $result = mysqli_query($db,$sql);
      echo("Test2");
      
      if(mysqli_num_rows($result) == 1) {
         $sql = "INSERT INTO item (name, endtime, category, description, FKclient, organisation, FKTagID) VALUES ('itemName', '2017-04-14 00:00:00', 'request', 'Desc', '4', '1', '6')";       
         $result = mysqli_query($db,$sql);
         if($result){
         }
         else{
            $error = "Failed to create new listing";
         }
         //header("location: ../index.html");
      }else {
         //header("location: ../createListing.html");
         $error = "Your Login Name or Password is invalid";
      }
   }
?>
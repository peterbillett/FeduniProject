<?php
   session_start();
   
   //Destory the session
   if(session_destroy()) {
      header("Location: ../index.html");
   }
?>
<?php
   session_start();
   
   // destroys the session forcing the user to logout
   if(session_destroy()) {
      header("Location: login.php");
   }
?>
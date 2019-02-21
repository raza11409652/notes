<?php
    $loggedInFlag=false;
   if(isset($_SESSION) && isset($_SESSION['userEmail']) && isset($_SESSION['loggedIn'])==true)
   {
    $loggedInFlag=true;
   }else{
       $loggedInFlag=false;
       #user is not logged In
      # die(header('Location: '.$_SERVER['PHP_SELF'])); 
   }
?>
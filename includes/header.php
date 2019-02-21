<?php
include_once "sessionHandler.php";
#echo $loggedInFlag;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notes Keeper By Hackdroid</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="assets/themes/default.css">
    <link rel="stylesheet" href="assets/themes/default.date.css">
    <link rel="stylesheet" href="assets/themes/default.time.css">
  
  </head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg   " id="mainNav">
      <div class="container">
        <a class="navbar-brand " href="#page-top">Notes Keeper</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span>Menu</span>
        <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="nav-link" href="./">Home</a>
            </li>

          <li class="nav-item <?php if($loggedInFlag ==true){echo "hide";} ?>">
              <a class="nav-link btn btn-outline-white " href="?view=login">Login</a>
            </li>
            <li class="nav-item <?php if($loggedInFlag ==true){echo "hide";} ?>">
              <a class="nav-link btn btn-outline-yellow" href="?view=register">register</a>
            </li>
          <li class="nav-item <?php if($loggedInFlag !=true){echo "hide";} ?>">
            <div class="dropdown padding-right">
              <a class="nav-link btn btn-outline-white dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 Your Account
              </a>

              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="?view=account">
                  <i class="fas fa-file"></i>  Your Keeper
                </a>
                <a class="dropdown-item" href="?view=profile">
                    <i class="fa fa-user"></i> Profile
                  </a>
                <a class="dropdown-item" href="?view=loggedOut">
                  <i class="fas fa-sign-out-alt"></i> Log out
                </a>
              </div>
            </div>
          </li>
          
            
           
          </ul>
        </div>
      </div>
    </nav>
  

<?php
//Start Session
session_start();

//If in main directory
if (getcwd() == "/var/www/html") {
  $filler = "";
}
//Else not in main directory
else {
  $filler = "/..";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Placeholder Restaurant</title>

  <!-- Include Files -->
  <?php require_once __DIR__ . "/../config/js_config.php"; ?>
  <?php require_once __DIR__ . "/../config/css_config.php"; ?>
</head>

<body class="grey lighten-2">
  <nav class="brand z-depth-2">

    <div class="nav-wrapper">
      <h3 class="brand-logo white-text center" style="display: inline; font-size: 40px;"><b>Placeholder Restaurant</b></h3>

      <!-- Home Button (always active) -->
      <ul id="nav-mobile" class="left">
        <a href=<?php echo $filler . "/Index.php"; ?>><i class="material-icons">home</i></a>
      </ul>

      <!-- If logged in to an account -->
      <?php if (isset($_SESSION["loggedin"])) : ?>

        <!-- Show these banner links -->
        <ul id="nav-mobile" class="right">
          <li><b><a href=<?php echo $filler . "/user/edit.php"; ?>>Edit Account</a></b></li>
          <li><b><a href=<?php echo $filler . "/user/history.php"; ?>>Fuel Quote History</a></b></li>
          <li><b><a href="/login/logout.php">Sign Out</a></b></li>
        </ul>

      <?php endif ?>

    </div>
  </nav>


  <main>





    <body>

    </body>
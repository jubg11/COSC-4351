<?php
//Start Session
session_start();
?>

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Placeholder Restaurant</title>


  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection" />
  <link rel="stylesheet" href="/config/css.css">
</head>

<body class="grey darken-2">

  <!-- Nav Bar -->
  <nav class="z-depth-2" id="header">

    <!-- Left Section -->
    <ul class="left">
      <a href="/Index.php"><i class="material-icons">home</i></a>
    </ul>

    <!-- Right Section -->
    <ul class="right" id="nav-mobile">

      <!--Not Logged in to an account-->
      <?php if (strcmp($_SESSION["Signed"], "in") != 0) : ?>
        <li>
          <a href="/login/login.php">Log In</a>
        </li>
        <li>
          <a href="/login/register.php">Register</a>
        </li>

        <!--Logged in to an account-->
      <?php else : ?>
        <li>
          <a href="/user/edit.php">Edit Account</a>
        </li>
        <li>
          <a href="/user/view.php">View Account</a>
        </li>
        <li>
          <a href="/user/past.php">Reservations</a>
        </li>
        <li>
          <a href="/login/logout.php">Logout</a>
        </li>
      <?php endif ?>
    </ul>

    <!-- Middle Section -->
    <?php if (strcmp($_SESSION["Signed"], "in") != 0) : ?>
      <h1>Placeholder Restaurant</h1>
    <?php else : ?>
      <h1 style="padding: 0px 0px 0px clamp(0vw, 18vw, 24vw);">Placeholder Restaurant</h1>
    <?php endif ?>
  </nav>


  <?php if (strcmp($_SESSION["Signed"], "in") == 0) : ?>
    <div class="grey darken-1 z-depth-1">
      <h4>Hello <?php echo ($_SESSION["Name"]); ?></h4>
    </div>
  <?php endif ?>


  <main>
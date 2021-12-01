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
      <?php if (!isset($_SESSION["loggedin"])) : ?>
        <li>
          <a href="/login/login.php">Log In</a>
        </li>
        <li>
          <a href="/login/register.php">Register</a>
        </li>

        <!--Logged in to an account-->
      <?php else : ?>
        <li>
          <a href="/login/logout.php">Edit Account</a>
        </li>
        <li>
          <a href="/login/logout.php">View Account</a>
        </li>
        <li>
          <a href="/login/logout.php">Logout</a>
        </li>
      <?php endif ?>
    </ul>

    <!-- Middle Section -->
    <h1>Placeholder Restaurant</h1>
  </nav>


  <main>
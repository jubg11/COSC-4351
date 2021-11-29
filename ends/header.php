<?php
//Start Session
session_start();
?>

<head>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Placeholder Restaurant</title>

  <!-- Include Styling Files -->
  <?php require_once __DIR__ . "/../config/config.php"; ?>
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
      <li>
        <a href="/login/login.php">Log In</a>
      </li>
      <li>
        <a href="/login/register.php">Register</a>
      </li>
    </ul>

    <!-- Middle Section -->
    <h1>Placeholder Restaurant</h1>


  </nav>


  <main>
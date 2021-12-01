<?php

// Redirect if already logged in
if (isset($_SESSION["loggedin"])) {
    header("location: ../Index.php");
    exit;
}

// Add Register class
require_once __DIR__ . "/../class/classRegister.php";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg = new Register($_POST);
}

//--------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html>

<!--Include Files-->
<?php require_once __DIR__ . "/../ends/header.php"; ?>



<!--Input Form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="white z-depth-2 center">

    <!--Header Text-->
    <nav class="brand">
        <h2>Create Account</h2>
    </nav>
    <p class="center">Please fill this form out to create an account.</p>

    <!--Error Text-->
    <?php if (!empty($reg->register_err)) : ?>
        <span class="red-text"><?php echo $reg->register_err; ?></span>
    <?php endif ?>

    <!--Form Input: Login Credentials-->
    <?php require_once __DIR__ . "/../form/login.php"; ?>

    <!-- Form Input: Personal Info -->
    <?php require_once __DIR__ . "/../form/personal.php"; ?>


    <div class="container">
        <label style="color: grey; font-size: 20px;"><?php echo $reg->success;  ?></label><br>
        <input type="submit" class="btn brand" value="Create">
        <p>Already have an account? <a href="login.php">Log in now</a> </p>
    </div>

</form>



<script src="/script/sameFunction.js"></script>
<?php require_once __DIR__ . "/../ends/footer.php"; ?>

</html>
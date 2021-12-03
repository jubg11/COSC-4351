<?php

//Start Session
session_start();

// Redirect if not logged in
if (strcmp($_SESSION["Signed"], "in") != 0) {
    header("location: ../Index.php");
    exit;
}

// Add Edit class
require_once __DIR__ . "/../class/classEdit.php";

$reg = new Edit;
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reg->UpdateAttempt();
    $reg->ShowAccount();
} else {
    $reg->ShowAccount();
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
        <h2>Edit Account</h2>
    </nav>
    <p class="center">Please make any desired changes your account.</p>

    <!--Error Text-->
    <?php if (!empty($reg->register_err)) : ?>
        <span class="red-text"><?php echo $reg->register_err; ?></span>
    <?php endif ?>

    <!--Form Input: Login Credentials-->
    <?php require_once __DIR__ . "/../form/login.php"; ?>

    <!-- Form Input: Personal Info -->
    <?php require_once __DIR__ . "/../form/personal.php"; ?>


    <div class="container">
        <input type="submit" class="btn brand" value="Submit Changes">
    </div>

</form>



<script src="/script/sameFunction.js"></script>
<?php require_once __DIR__ . "/../ends/footer.php"; ?>

</html>
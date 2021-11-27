<?php
session_start();
?>

<!DOCTYPE html>
<html>

<!--Include Header Files-->
<?php require_once __DIR__ . "/ends/header_welcome.php"; ?>
<?php require_once __DIR__ . "/functions/time_hello.php"; ?>

<!--Not Logged in to an account-->
<?php if (!isset($_SESSION["loggedin"])) : ?>

	<!--Display Card-->
	<div class="container center">
		<div class="card z-depth-2">

			<!--Display Card Buttons-->
			<div class="card-action z-depth-0">
				<a href="login/login.php" class="btn-large brand">Log In</a>
				<a href="login/cregister.php" class="btn-large brand">Register</a>
			</div>

			<!--Display Card Image-->
			<div class="card-image">
				<img src="img/Fuel.jpg">
			</div>


		</div>
	</div>

	<!--Logged in to an account-->
<?php else : ?>
	<div>
		<?php require __DIR__ . "/user/view.php"; ?>
	</div>

<?php endif ?>

<!--Include Footer File-->
<?php require_once __DIR__ . "/ends/footer_welcome.php"; ?>

</html>
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<!--Include Header Files-->
<?php require_once __DIR__ . "/ends/header.php"; ?>

<div class="container center" id="#card">

    <div class="card z-depth-2">

        <!--Display Card Image-->
        <div class="card-image center">
            <img src="/img/intro.jpg">
        </div>

        <!--Display Card Buttons-->
        <div class="card-action z-depth-0 center">
            <a class="btn brand" href="">Schedule Reservation</a>
        </div>

    </div>
</div>

<!--Include Footer File-->
<?php require_once __DIR__ . "/ends/footer.php"; ?>

</html>
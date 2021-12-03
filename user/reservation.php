<?php

//Start Session
session_start();

// Add Edit class
require_once __DIR__ . "/../class/classReservation.php";

$res = new Reservation;
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Search"]) {
    $res->SearchAttempt();

    $checkpoint = 1;
    unset($_POST["Search"]);
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && !$_POST["Search"]) {
    $hold = $res->CheckHighTraffic();
    if ($hold > 0) {
        echo ("<script>
        alert('Due to high demand, to finalize this appointment a hold of $" . $hold . " will be placed');
        </script>");
    }
    if (strcmp($_SESSION["Signed"], "in") != 0) {
        echo ("<script>
        alert('Please consider creating an account to have a more complete experience.');
        </script>");
    }
    $res->ReservationAttempt();
    if (strcmp($_SESSION["Signed"], "in") == 0) {
        $res->ShowUserDetails();
    }
} else {
    if (strcmp($_SESSION["Signed"], "in") == 0) {
        $res->ShowUserDetails();
    }
    $checkpoint = 0;
}

?>

<!DOCTYPE html>
<html>

<!--Include Files-->
<?php require_once __DIR__ . "/../ends/header.php"; ?>


<!-- Search Results -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="max-width: initial;">
    <?php require_once __DIR__ . "/../form/reserve.php"; ?>

    <div class="div-mid" style="width: 40%;">
        <table>
            <thead>
                <nav class="brand">
                    <h2>Reservations Found</h2>
                </nav>
                <?php if (!empty($res->search_err)) : ?>
                    <p class="red-text center"><?php echo $res->search_err; ?></p>
                <?php endif  ?>
                <tr>
                    <th>Reservation Time</th>
                    <th>Table Size</th>
                </tr>
            </thead>
            <tbody class="view">
                <?php if ($checkpoint >= 1) : ?>
                    <?php foreach ($res->rows as $row) : ?>
                        <tr>
                            <td>
                                <?php $temp = new DateTime($row["reservation_time"]); ?>
                                <?php echo $temp->format('F jS h:iA'); ?>
                            </td>
                            <td><?php echo ($row["seats"]); ?></td>
                            <td>
                                <input type="hidden" value="<?php echo $temp->format('Y-m-d'); ?>" name="Reserve_Date">
                                <button type="submit" value="<?php echo ($row["table_id"]) ?> " name="Reserve_ID" class="btn brand right">Reserve</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</form>

<?php require_once __DIR__ . "/../ends/footer.php"; ?>

</html>
<?php

//Start Session
session_start();

// Redirect if not logged in
if (strcmp($_SESSION["Signed"], "in") != 0) {
    header("location: ../Index.php");
    exit;
}

// Add Edit class
require_once __DIR__ . "/../class/classPast.php";

$past = new Past;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $past->DeleteReservation();
    $past->ShowCurrent();
}
//--------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html>

<!--Include Files-->
<?php require_once __DIR__ . "/../ends/header.php"; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="max-width: initial; margin:initial;">
    <div class="div-left" style="width:30%;">
        <table>
            <thead>
                <nav class="brand">
                    <h2>Current Reservations</h2>
                </nav>
                <tr>
                    <th>
                        Date
                    </th>
                    <th>
                        Time
                    </th>
                    <th>
                        Table Size
                    </th>
                    <th>
                        Guests
                    </th>
                </tr>
            </thead>
            <tbody class="view">
                <?php if (!empty($past->now_err)) : ?>
                    <p class="red-text center"><?php echo $past->now_err; ?></p>
                <?php endif  ?>

                <?php foreach ($past->now as $row_now) : ?>
                    <tr>
                        <td>
                            <?php $temp1 = new DateTime($row_now["reservation_time"]); ?>
                            <?php echo $temp1->format('F jS'); ?>
                        </td>
                        <td>
                            <?php echo $temp1->format('h:iA'); ?>
                        </td>
                        <td><?php echo ($row_now["seats"]); ?></td>
                        <td><?php echo ($row_now["guests"]); ?></td>
                        <td>
                            <input type="hidden" value="<?php echo $temp1->format('Y-m-d'); ?>" name="Reserve_Date">
                            <button type="submit" value="<?php echo ($row_now["table_id"]) ?> " name="Reserve_ID" class="btn brand right">Cancel</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</form>


<div class="div-right" style="width:30%;">
    <table>
        <thead>
            <nav class="brand">
                <h2>Past Reservations</h2>
            </nav>
            <tr>
                <th>
                    Date
                </th>
                <th>
                    Time
                </th>
                <th>
                    Table Size
                </th>
                <th>
                    Guests
                </th>
            </tr>
        </thead>
        <tbody class="view">
            <?php if (!empty($past->past_err)) : ?>
                <p class="red-text center"><?php echo $past->past_err; ?></p>
            <?php endif  ?>

            <?php foreach ($past->past as $row_past) : ?>
                <tr>
                    <td>
                        <?php $temp2 = new DateTime($row_past["reservation_time"]); ?>
                        <?php echo $temp2->format('F jS'); ?>
                    </td>
                    <td>
                        <?php echo $temp2->format('h:iA'); ?>
                    </td>
                    <td><?php echo ($row_past["seats"]); ?></td>
                    <td><?php echo ($row_past["guests"]); ?></td>
                    <td>
                        <input type="hidden" value="<?php echo $temp2->format('Y-m-d'); ?>" name="Reserve_Date">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<?php require_once __DIR__ . "/../ends/footer.php"; ?>

</html>
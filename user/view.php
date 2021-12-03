<?php

//Start Session
session_start();

// Redirect if not logged in
if (strcmp($_SESSION["Signed"], "in") != 0) {
    header("location: ../Index.php");
    exit;
}

// Add Edit class
require_once __DIR__ . "/../class/classView.php";

$account = new View;
$account->ShowDetails();

//--------------------------------------------------------------------------------------------------
?>

<!DOCTYPE html>
<html>

<!--Include Files-->
<?php require_once __DIR__ . "/../ends/header.php"; ?>

<!--Error Text-->
<?php if (!empty($account->show_err)) : ?>
    <span class="red-text"><?php echo $account->show_err; ?></span>
<?php endif ?>

<!-- User Info -->
<div class="div-left">
    <table>
        <thead>
            <nav class="brand">
                <h2>Personal Data</h2>
            </nav>
        </thead>
        <tbody class="view">
            <tr>
                <td>User Email:</td>
                <td><?php echo ($account->rows["user_email"]); ?></td>
            </tr>
            <tr>
                <td>Name:</td>
                <td><?php echo ($account->rows["name"]); ?></td>
            </tr>
            <tr>
                <td>Phone Number:</td>
                <td><?php echo ($account->rows["phone_num"]); ?></td>
            </tr>
            <tr>
                <td>Payment Method:</td>
                <td><?php echo ($account->rows["payment_method"]); ?></td>
            </tr>
            <tr>
                <td>Preferred Diner #:</td>
                <td><?php echo ($account->rows["preferred_diner_num"]); ?></td>
            </tr>
            <tr>
                <td>Points:</td>
                <td><?php echo ($account->rows["earned_points"]); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Shipping Address -->
<div class="div-mid">
    <table>
        <thead>
            <nav class="brand">
                <h2>Shipping Data</h2>
            </nav>
        </thead>
        <tbody class="view">
            <tr>
                <td>Street Address:</td>
                <td><?php echo ($account->rows["street_add"]); ?></td>
            </tr>
            <tr>
                <td>Street Address 2:</td>
                <td><?php echo ($account->rows["street_add2"]); ?></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><?php echo ($account->rows["city"]); ?></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><?php echo ($account->rows["state"]); ?></td>
            </tr>
            <tr>
                <td>Zip:</td>
                <td><?php echo ($account->rows["zip"]); ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Billing Address -->
<div class="div-right">
    <table>
        <thead>
            <nav class="brand">
                <h2>Billing Data</h2>
            </nav>
        </thead>
        <tbody class="view">
            <tr>
                <td>Street Address:</td>
                <td><?php echo ($account->rows["b_street_add"]); ?></td>
            </tr>
            <tr>
                <td>Street Address 2:</td>
                <td><?php echo ($account->rows["b_street_add2"]); ?></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><?php echo ($account->rows["b_city"]); ?></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><?php echo ($account->rows["b_state"]); ?></td>
            </tr>
            <tr>
                <td>Zip:</td>
                <td><?php echo ($account->rows["b_zip"]); ?></td>
            </tr>
        </tbody>
    </table>
</div>


<?php require_once __DIR__ . "/../ends/footer.php"; ?>

</html>
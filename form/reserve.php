<?php
$a = new DateTime();
$a->sub(new DateInterval('PT6H'));
$days = [];
$date = [];
$period = new DatePeriod(
    $a, // Start date of the period
    new DateInterval('P1D'), // Define the intervals as Periods of 1 Day
    6 // Apply the interval 6 times on top of the starting date
);
foreach ($period as $day) {
    $days[] = $day->format('l, M d');
    $date[] = $day->format('Y-m-d');
}
?>



<div class="white div-left">
    <!--Header Text-->
    <nav class="brand">
        <h2>Reservation Form</h2>
    </nav>
    <p class="center">Please provide search parameters for possible reservations.</p>
    <small style="text-align: center; display:block;">Hours of Operation: 10:00 (10AM) to 22:00 (10PM).</small>
    <!-- Form Input: Personal Info-->
    <div class="input-field left-align">
        <span class="red-text"><?php echo $res->name_err; ?></span>
        <input type="text" name="Name" value="<?php echo $_POST["Name"]; ?>" placeholder="Name" id="input_text" data-length="50" maxlength="50" <?php if (strcmp($_SESSION["Signed"], "in") == 0) echo ("readonly"); ?>>
    </div>
    <div class="input-field left-align">
        <span class="red-text"><?php echo $res->phone_err; ?></span>
        <input type="text" name="Phone" value="<?php echo $_POST["Phone"]; ?>" placeholder="Phone Number, ex: 123-456-7890" id="input_text" data-length="12" maxlength="12" <?php if (strcmp($_SESSION["Signed"], "in") == 0) echo ("readonly"); ?>>
    </div>
    <div class="input-field left-align">
        <span class="red-text"><?php echo $res->email_err; ?></span>
        <input type="email" name="Email" value="<?php echo $_POST["Email"]; ?>" placeholder="Email" id="input_text" data-length="50" maxlength="50" <?php if (strcmp($_SESSION["Signed"], "in") == 0) echo ("readonly"); ?>>
    </div>
    <!-- Form Input: Reservation Info-->
    <div class="input-field left-align">
        <select name="Date" id="date" value="<?php echo $_POST["Date"]; ?>">
            <?php for ($i = 0, $j = count($days); $i < $j; $i++) : ?>
                <option value=<?php echo ($date[$i]); ?>> <?php echo ($days[$i]); ?></option>
            <?php endfor ?>
        </select>
    </div>
    <div class="input-field left-align">
        <select name="Time" id="time" value="<?php echo $_POST["Time"]; ?>">
            <option value="10:00:00">10:00AM</option>
            <option value="11:00:00">11:00AM</option>
            <option value="12:00:00">12:00PM</option>
            <option value="13:00:00">1:00PM</option>
            <option value="14:00:00">2:00PM</option>
            <option value="15:00:00">3:00PM</option>
            <option value="16:00:00">4:00PM</option>
            <option value="17:00:00">5:00PM</option>
            <option value="18:00:00">6:00PM</option>
            <option value="19:00:00">7:00PM</option>
            <option value="20:00:00">8:00PM</option>
            <option value="21:00:00">9:00PM</option>
        </select>
    </div>
    <div class="input-field left-align">
        <span class="red-text"><?php echo $res->guests_err; ?></span>
        <input type="number" name="Guests" value="<?php echo $_POST["Guests"]; ?>" placeholder="Guests" data-length="2" maxlength="2" step="1" max=52 min=0>
    </div>
    <div class="center">
        <input type="submit" class="btn brand" value="Search" name="Search">
    </div>
</div>
<!--Form Input: Login Credentials-->
<div class="input-field left-align">
    <span class="red-text"><?php echo $reg->email_err; ?></span>
    <input type="email" name="Email" value="<?php echo $_POST["Email"]; ?>" placeholder="Email" id="input_text" data-length="50" maxlength="50">
</div>

<div class="input-field left-align">
    <span class="red-text"><?php echo $reg->pass_err; ?></span>
    <input type="password" name="Pass" value="<?php echo $_POST["Pass"]; ?>" placeholder="Password" id="input_text" data-length="50" maxlength="50">
</div>
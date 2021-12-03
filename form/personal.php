    <!-- Form Input: Personal Info -->
    <div class="input-field left-align">
        <span class="red-text"><?php echo $reg->name_err; ?></span>
        <input type="text" name="Name" value="<?php echo $_POST["Name"]; ?>" placeholder="Name" id="input_text" data-length="50" maxlength="50">
    </div>
    <div class="input-field left-align">
        <span class="red-text"><?php echo $reg->phone_err; ?></span>
        <input type="text" name="Phone" value="<?php echo $_POST["Phone"]; ?>" placeholder="Phone Number, ex: 123-456-7890" id="input_text" data-length="12" maxlength="12">
    </div>
    <div class="input-field left-align">
        <span class="red-text"><?php echo $reg->payment_err; ?></span>
        <input type="text" name="Payment_Method" value="<?php echo $_POST["Payment_Method"]; ?>" placeholder="Payment Method" list="Payment_Method" require>
    </div>

    <br>

    <!-- Form Input: Shipping Address -->
    <h3>Shipping Address</h3>

    <div id="shipping">
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->s_add1_err; ?></span>
            <input type="text" name="S_Add1" value="<?php echo $_POST["S_Add1"]; ?>" placeholder="Street Address" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->s_add2_err; ?></span>
            <input type="text" name="S_Add2" value="<?php echo $_POST["S_Add2"]; ?>" placeholder="Street Address 2 (optional)" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->s_city_err; ?></span>
            <input type="text" name="S_City" value="<?php echo $_POST["S_City"]; ?>" placeholder="City" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->s_state_err; ?></span>
            <input type="text" name="S_State" onfocus="this.value=''" value="<?php echo $_POST["S_State"]; ?>" placeholder="State" list="state" data-length="2" maxlength="2">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->s_zip_err; ?></span>
            <input type="text" name="S_Zip" value="<?php echo $_POST["S_Zip"]; ?>" placeholder="Zip/Postal Code" id="input_text" data-length="10" maxlength="10">
        </div>

    </div>

    <br>

    <!-- Form Input: Billing Address -->
    <h3>Billing Address</h3>

    <label for="SameAdd" class="left" style="padding-left: 20px;">
        <input type="checkbox" id="SameAdd" name="SameAdd" value="true" class="filled-in" onclick="sameFunction()">
        <span>Same as Shipping</span>
    </label>

    <br>

    <div id="billing">
        <div class="input-field left-align">

            <span class="red-text"><?php echo $reg->b_add1_err; ?></span>
            <input type="text" name="B_Add1" value="<?php echo $_POST["B_Add1"]; ?>" placeholder="Street Address" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->b_add2_err; ?></span>
            <input type="text" name="B_Add2" value="<?php echo $_POST["B_Add2"]; ?>" placeholder="Street Address 2 (optional)" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->b_city_err; ?></span>
            <input type="text" name="B_City" value="<?php echo $_POST["B_City"]; ?>" placeholder="City" id="input_text" data-length="50" maxlength="50">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->b_state_err; ?></span>
            <input type="text" name="B_State" onfocus="this.value=''" value="<?php echo $_POST["B_State"]; ?>" placeholder="State" list="state" data-length="2" maxlength="2">
        </div>
        <div class="input-field left-align">
            <span class="red-text"><?php echo $reg->b_zip_err; ?></span>
            <input type="text" name="B_Zip" value="<?php echo $_POST["B_Zip"]; ?>" placeholder="Zip/Postal Code" id="input_text" data-length="10" maxlength="10">
        </div>
    </div>

    <datalist id="Payment_Method">
        <option value="Cash"></option>
        <option value="Credit"></option>
        <option value="Check"></option>
    </datalist>
    <datalist id="state">
        <option value="AL">Alabama</option>
        <option value="AK">Alaska</option>
        <option value="AZ">Arizona</option>
        <option value="AR">Arkansas</option>
        <option value="CA">California</option>
        <option value="CO">Colorado</option>
        <option value="CT">Connecticut</option>
        <option value="DE">Delaware</option>
        <option value="DC">District of Columbia</option>
        <option value="FL">Florida</option>
        <option value="GA">Georgia</option>
        <option value="HI">Hawaii</option>
        <option value="ID">Idaho</option>
        <option value="IL">Illinois</option>
        <option value="IN">Indiana</option>
        <option value="IA">Iowa</option>
        <option value="KS">Kansas</option>
        <option value="KY">Kentucky</option>
        <option value="LA">Louisiana</option>
        <option value="ME">Maine</option>
        <option value="MD">Maryland</option>
        <option value="MA">Massachusetts</option>
        <option value="MI">Michigan</option>
        <option value="MN">Minnesota</option>
        <option value="MS">Mississippi</option>
        <option value="MO">Missouri</option>
        <option value="MT">Montana</option>
        <option value="NE">Nebraska</option>
        <option value="NV">Nevada</option>
        <option value="NH">New Hampshire</option>
        <option value="NJ">New Jersey</option>
        <option value="NM">New Mexico</option>
        <option value="NY">New York</option>
        <option value="NC">North Carolina</option>
        <option value="ND">North Dakota</option>
        <option value="OH">Ohio</option>
        <option value="OK">Oklahoma</option>
        <option value="OR">Oregon</option>
        <option value="PA">Pennsylvania</option>
        <option value="RI">Rhode Island</option>
        <option value="SC">South Carolina</option>
        <option value="SD">South Dakota</option>
        <option value="TN">Tennessee</option>
        <option value="TX">Texas</option>
        <option value="UT">Utah</option>
        <option value="VT">Vermont</option>
        <option value="VA">Virginia</option>
        <option value="WA">Washington</option>
        <option value="WV">West Virginia</option>
        <option value="WI">Wisconsin</option>
        <option value="WY">Wyoming</option>
    </datalist>
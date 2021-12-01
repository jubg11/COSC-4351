<?php

class Register
{
    public $email_err = "";
    public $pass_err = "";
    public $name_err = "";
    public $phone_err = "";
    public $payment_err = "";

    public $s_add1_err = "";
    public $s_add2_err = "";
    public $s_city_err = "";
    public $s_state_err = "";
    public $s_zip_err = "";

    public $b_add1_err = "";
    public $b_add2_err = "";
    public $b_city_err = "";
    public $b_state_err = "";
    public $b_zip_err = "";

    public $register_err = "";
    public $success = "";

    public function __construct()
    {
        // Trigger function automatically upon creation
        $this->RegisterAttempt();
    }

    private function registrationValidate()
    {
        $flag = 0;

        // Check if email is empty
        $_POST["Email"] = trim($_POST["Email"]);
        if (empty($_POST["Email"])) {
            $this->email_err = "Please enter an Email.";
            $flag++;
        }

        // Check if email already taken
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT user_email FROM sys.customer_info WHERE user_email = ? ";
        $stmt = $link->prepare($sql);
        $email = $_POST["Email"];
        $stmt->bind_param('s', $email);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows() >= 1) {
                $this->email_err = "An account already exists with that Email.";
                $flag++;
            }
        }
        $stmt->close();
        $link->close();

        // Check if Password is empty
        $_POST["Pass"] = trim($_POST["Pass"]);
        if (empty($_POST["Pass"])) {
            $this->pass_err = "Please enter a Password.";
            $flag++;
        }
        // Check if Password is not following rules
        elseif (!preg_match("/^.{6,50}$/", $_POST["Pass"])) {
            $this->pass_err = "Please enter a valid Password. Minimum 6 character length.";
            $flag++;
        }


        // Check if Name is empty
        $_POST["Name"] = trim($_POST["Name"]);
        if (empty($_POST["Name"])) {
            $this->name_err = "Please enter a Name.";
            $flag++;
        }
        // Check if Name is not following rules
        elseif (!preg_match("/^[a-zA-Z]{1,25}\s?[a-zA-Z]{1,25}$/", $_POST["Name"])) {
            $this->name_err = "Please enter a valid Name.";
            $flag++;
        }

        // Check if Phone is empty
        $_POST["Phone"] = trim($_POST["Phone"]);
        if (empty($_POST["Phone"])) {
            $this->phone_err = "Please enter a Phone Number.";
            $flag++;
        }
        // Check if Phone is not following rules
        elseif (!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST["Phone"])) {
            $this->phone_err = "Please enter a valid phone number. xxx-xxx-xxxx format";
            $flag++;
        }


        // Check if Payment is empty
        $_POST["Payment_Method"] = trim($_POST["Payment_Method"]);
        if (empty($_POST["Payment_Method"])) {
            $this->payment_err = "Please select a payment method.";
            $flag++;
        }

        // Check if Add1 is empty
        $_POST["S_Add1"] = trim($_POST["S_Add1"]);
        if (empty($_POST["S_Add1"])) {
            $this->s_add1_err = "Please enter an Address.";
            $flag++;
        }
        // Check if Add1 is not following rules
        elseif (!preg_match("/^.{1,50}$/", $_POST["S_Add1"])) {
            $this->s_add1_err = "Please enter a valid Address.";
            $flag++;
        }

        // Check if Add2 is not following rules
        if (!preg_match("/^.{0,50}$/", $_POST["S_Add2"])) {
            $this->s_add2_err = "Please enter a valid Secondary Address.";
            $flag++;
        }

        // Check if City is empty
        $_POST["S_City"] = trim($_POST["S_City"]);
        if (empty($_POST["S_City"])) {
            $this->s_city_err = "Please enter a City.";
            $flag++;
        }
        // Check if City is not following rules
        elseif (!preg_match("/^.{1,50}$/", $_POST["S_City"])) {
            $this->s_city_err = "Please enter a valid City.";
            $flag++;
        }

        // Check if State is empty
        $_POST["S_State"] = trim($_POST["S_State"]);
        if (empty($_POST["S_State"])) {
            $this->s_state_err = "Please select a State.";
            $flag++;
        }
        // Check if State is not following rules
        elseif (!preg_match("/^[a-zA-Z]{2}$/", $_POST["S_State"])) {
            $this->s_state_err = "Please enter a valid State Code.";
            $flag++;
        }

        // Check if Zip is empty
        $_POST["S_Zip"] = trim($_POST["S_Zip"]);
        if (empty($_POST["S_Zip"])) {
            $this->s_zip_err = "Please enter a Zip.";
            $flag++;
        }
        // Check if Zip is not following rules
        elseif (!preg_match("/^\b\d{5}(-\d{4})?\b$/", $_POST["S_Zip"])) {
            $this->s_zip_err = "Please enter a valid Zip.";
            $flag++;
        }



        // If Same as Shipping is checked for Billing
        if ($_POST["SameAdd"])
            return $flag;


        // Check if Add1 is empty
        $_POST["B_Add1"] = trim($_POST["B_Add1"]);
        if (empty($_POST["B_Add1"])) {
            $this->b_add1_err = "Please enter an Address.";
            $flag++;
        }
        // Check if Add1 is not following rules
        elseif (!preg_match("/^.{1,50}$/", $_POST["B_Add1"])) {
            $this->b_add1_err = "Please enter a valid Address.";
            $flag++;
        }

        // Check if Add2 is not following rules
        if (!preg_match("/^.{0,50}$/", $_POST["B_Add2"])) {
            $this->b_add2_err = "Please enter a valid Secondary Address.";
            $flag++;
        }

        // Check if City is empty
        $_POST["B_City"] = trim($_POST["B_City"]);
        if (empty($_POST["B_City"])) {
            $this->b_city_err = "Please enter a City.";
            $flag++;
        }
        // Check if City is not following rules
        elseif (!preg_match("/^.{1,50}$/", $_POST["B_City"])) {
            $this->b_city_err = "Please enter a valid City.";
            $flag++;
        }

        // Check if State is empty
        $_POST["B_State"] = trim($_POST["B_State"]);
        if (empty($_POST["B_State"])) {
            $this->b_state_err = "Please select a State.";
            $flag++;
        }
        // Check if State is not following rules
        elseif (!preg_match("/^\w{2}$/", $_POST["B_State"])) {
            $this->b_state_err = "Please enter a valid State Code.";
            $flag++;
        }

        // Check if Zip is empty
        $_POST["B_Zip"] = trim($_POST["B_Zip"]);
        if (empty($_POST["B_Zip"])) {
            $this->b_zip_err = "Please enter a Zip.";
            $flag++;
        }
        // Check if Zip is not following rules
        elseif (!preg_match("/^\b\d{5}(?:-\d{4})?\b$/", $_POST["B_Zip"])) {
            $this->b_zip_err = "Please enter a valid Zip.";
            $flag++;
        }

        return $flag;
    }

    public function RegisterAttempt()
    {
        if ($this->registrationValidate() == 0) {

            // Insert Login & Personal Data to DB
            require __DIR__ . "/../config/db_connect.php";

            $sql = "INSERT INTO sys.customer_info (user_email, user_password, name, payment_method, phone_num) 
                VALUES (?, ?, ?, ?, ?)";
            $stmt = $link->prepare($sql);
            $email = $_POST["Email"];

            // Hash the password
            $pass = password_hash($_POST["Pass"], PASSWORD_DEFAULT);

            $name = $_POST["Name"];
            $phone = $_POST["Phone"];
            $payment = $_POST["Payment_Method"];

            $stmt->bind_param("sssss", $email, $pass, $name, $payment, $phone);

            if ($stmt->execute()) {
                $stmt->close();
                $link->close();

                // Snag newly created ID
                require __DIR__ . "/../config/db_connect.php";

                $sql = "SELECT user_id FROM sys.customer_info WHERE user_email = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($id);
                $stmt->fetch();
                $_SESSION["ID"] = $id;

                $stmt->close();
                $link->close();
                // Insert Shipping Data
                require __DIR__ . "/../config/db_connect.php";

                $sql = "INSERT INTO sys.shipping_addr (user_id, street_add, street_add2, city, state, zip)
                VALUES (?, ?, ?, ? ,? ,?)";
                $stmt = $link->prepare($sql);
                $add1 =  $_POST["S_Add1"];
                $add2 =  $_POST["S_Add2"];
                $city =  $_POST["S_City"];
                $state =  $_POST["S_State"];
                $zip =  $_POST["S_Zip"];
                $stmt->bind_param("ssssss", $id, $add1, $add2, $city, $state, $zip);

                if ($stmt->execute()) {
                    $stmt->close();
                    $link->close();

                    // Insert Billing Data
                    require __DIR__ . "/../config/db_connect.php";

                    $sql = "INSERT INTO sys.billing_addr (user_id, street_add, street_add2, city, state, zip)
                    VALUES (?, ?, ?, ? ,? ,?)";
                    $stmt = $link->prepare($sql);

                    if ($_POST["SameAdd"]) {
                        $add1 =  $_POST["S_Add1"];
                        $add2 =  $_POST["S_Add2"];
                        $city =  $_POST["S_City"];
                        $state =  $_POST["S_State"];
                        $zip =  $_POST["S_Zip"];
                        $stmt->bind_param("ssssss", $id, $add1, $add2, $city, $state, $zip);
                    } else {
                        $add1 =  $_POST["B_Add1"];
                        $add2 =  $_POST["B_Add2"];
                        $city =  $_POST["B_City"];
                        $state =  $_POST["B_State"];
                        $zip =  $_POST["B_Zip"];
                        $stmt->bind_param("ssssss", $id, $add1, $add2, $city, $state, $zip);
                    }

                    if ($stmt->execute()) {
                        $stmt->close();
                        $link->close();
                        // Redirect user to welcome page
                        echo ("<script>
                        alert('Account has been created.');
                        </script>");
                    } else {
                        $this->register_err = "Error completing account.";
                    }
                } else {
                    $this->register_err = "Error completing account.";
                }
            } else {
                $this->register_err = "Error completing account.";
            }
            $stmt->close();
            $link->close();
        }
    }
}

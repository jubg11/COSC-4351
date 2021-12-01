<?php





class Register
{
    public $user_err = "";
    public $pass_err = "";
    public $register_err = "";
    public $success = "";

    public function __construct($u, $p)
    {
        $this->RegisterAttempt(trim($u), $p);
    }

    private function Validate($user, $pass)
    {
        $flag = 0;


        return $flag;
    }

    public function RegisterAttempt($u, $p)
    {
        if ($this->Validate($u, $p) == 3) {
            require __DIR__ . "/../config/db_connect.php";

            $hash = password_hash($p, PASSWORD_DEFAULT);
            $sql = "INSERT INTO login (Username, Password) 
                VALUES ( ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("ss", $u, $hash);

            if ($stmt->execute()) {
                $this->success = "Successfully created account.<br> Go to Login Page.";
                unset($_POST);
            } else {
                $this->register_err = "Error creating account.";
            }
            $stmt->close();
            $link->close();
        }
    }
}




class FuelForm
{
    public $gallons_err;
    public $address_err;
    public $date_err;
    public $costpergal;
    public $total;
    public $success;
    public $submission_err;

    public function __construct($gal, $date, $int)
    {
        if ($int == 1) {
            $this->Calculate($gal, $date);
        } elseif ($int == 2) {
            $this->Order($gal, $date);
        }
    }

    private function Validate($gal, $date)
    {
        $flag = 0;

        // Check if Gallons is empty
        if (empty($gal)) {
            $this->gallons_err = "Please enter a Gallon Amount.";
        }
        // Check if Gallons is not following rules
        elseif (!preg_match("/^\d{1,10}$/", $gal)) {
            $this->gallons_err = "Please enter a valid Gallon Amount.";
        } else {
            $flag++;
        }

        require __DIR__ . "/../config/db_connect.php";
        $sql = "SELECT address1, address2, state FROM client_info WHERE Username = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);

        if ($stmt->execute()) {
            $stmt->store_result();

            if ($stmt->num_rows() == 1) {
                // Store data in variable
                $stmt->bind_result($addr1, $addr2, $state);
                $stmt->fetch();
                $_SESSION["address1"] = $addr1;
                $_SESSION["address2"] = $addr2;
                $_SESSION["state"] = $state;
            } else {
                $this->address_err = "No Address Found";
                $flag--;
            }
        }
        $stmt->close();
        $link->close();


        // Check if Date is empty
        if (empty($date)) {
            $this->date_err = "Please enter a Delivery Date.";
        }
        // Check if Date is not following rules
        elseif (!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $date)) {
            $this->date_err = "Please enter a valid Delivery Date.";
        } else {
            $flag++;
        }
        return $flag;
    }

    //new: add $state as a parameter
    public function Calculate($gal, $date)
    {
        if ($this->Validate($gal, $date) == 2) {

            $this->total = $this->Pricing($gal) * $gal;
            return 1;
        }
        return 0;
    }

    //new: function to calculate suggested price/gal
    public function Pricing($gal)
    {
        $this->costpergal = 1.5;
        // setting location factor
        if ($_SESSION["state"] == 'TX') {
            $loc_factor = .02;
        } else {
            $loc_factor = .04;
        }

        // setting rate history factor
        $history = new FuelHistory();
        if ($history->ShowHistory() == false) {
            $rh_factor = 0;
        } else {
            $rh_factor = .01;
        }

        // setting gallons requested factor
        if ($gal > 1000) {
            $gal_factor = .02;
        } else {
            $gal_factor = .03;
        }

        $cp_factor = .1;

        $margin = $this->costpergal * ($loc_factor - $rh_factor + $gal_factor + $cp_factor);
        $this->costpergal = $this->costpergal + $margin;
        return $this->costpergal;
    }

    //new: add $state as a parameter
    public function Order($gal, $date)
    {
        if ($this->Calculate($gal, $date) == 1) {

            require __DIR__ . "/../config/db_connect.php";
            $sql = "INSERT INTO fuel_orders (User, gallons, delivery_address, delivery_date, pricepergal, total_due)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssd", $_SESSION["username"], $gal, $_SESSION["address1"], $date, $this->costpergal, $this->total);

            if ($stmt->execute()) {
                $this->success = "Order placed successfully.";
            } else {
                $this->submission_err = "Error completing order.";
            }
            $stmt->close();
            $link->close();
        }
    }
}

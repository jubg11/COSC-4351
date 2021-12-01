<?php 

class Edit
{
    public $pass_err = "";
    public $name_err = "";
    public $add1_err = "";
    public $add2_err = "";
    public $city_err = "";
    public $state_err = "";
    public $zip_err = "";
    public $row = "";

    public $register_err = "";
    public $success = "";

    public function __construct()
    {
        $this->ShowAccount();
    }

    private function Validate($pass, $name, $add1, $add2, $city, $state, $zip)
    {
        $flag = 0;

        // Check if Password is inputted
        if (!empty($pass)) {
            // Check if Password is not following rules
            if (!preg_match("/^.{2,45}$/", $pass)) {
                $this->pass_err = "Please enter a valid Password.";
            } else {
                $flag++;
            }
        } else {
            $flag++;
        }

        // Check if Name is empty
        if (empty($name)) {
            $this->name_err = "Please enter a Name.";
        }
        // Check if Name is not following rules
        elseif (!preg_match("/^.{1,50}$/", $name)) {
            $this->name_err = "Please enter a valid Name.";
        } else {
            $flag++;
        }

        // Check if Add1 is empty
        if (empty($add1)) {
            $this->add1_err = "Please enter an Address.";
        }
        // Check if Add1 is not following rules
        elseif (!preg_match("/^.{1,100}$/", $add1)) {
            $this->add1_err = "Please enter a valid Address.";
        } else {
            $flag++;
        }

        // Check if Add2 is not following rules
        if (!preg_match("/^.{0,100}$/", $add2)) {
            $this->add2_err = "Please enter a valid Secondary Address.";
        } else {
            $flag++;
        }

        // Check if City is empty
        if (empty($city)) {
            $this->city_err = "Please enter a City.";
        }
        // Check if Name is not following rules
        elseif (!preg_match("/^.{1,100}$/", $city)) {
            $this->city_err = "Please enter a valid City.";
        } else {
            $flag++;
        }

        // Check if State is empty
        if (empty($state)) {
            $this->state_err = "Please select a State.";
        }
        // Check if State is not following rules
        elseif (!preg_match("/^\w{2}$/", $state)) {
            $this->state_err = "Please enter a valid State.";
        } else {
            $flag++;
        }

        // Check if Zip is empty
        if (empty($zip)) {
            $this->zip_err = "Please enter a Zip.";
        }
        // Check if Zip is not following rules
        elseif (!preg_match("/^\b\d{5}(?:-\d{4})?\b$/", $zip)) {
            $this->zip_err = "Please enter a valid Zip.";
        } else {
            $flag++;
        }

        return $flag;
    }


    public function EditAccount($pass, $name, $add1, $add2, $city, $state, $zip)
    {
        $pass = $pass;
        $name = trim($name);
        $add1 = trim($add1);
        $add2 = trim($add2);
        $city = trim($city);
        $state = trim($state);
        $zip = trim($zip);

        if ($this->Validate($pass, $name, $add1, $add2, $city, $state, $zip) == 7) {
            require __DIR__ . "/../config/db_connect.php";

            if (!empty($pass)) {
                $phash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "UPDATE login SET Password = ? WHERE Username = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("ss", $phash, $_SESSION["username"]);

                if ($stmt->execute()) {
                    $this->success = "Saved changes.";
                } else {
                    $this->register_err = "Error saving changes.";
                }

                $stmt->close();
                $link->close();
            }


            require __DIR__ . "/../config/db_connect.php";
            $sql = "UPDATE client_info SET fullname = ?, address1 = ?, address2 = ?, city = ?, state = ?, zipcode = ? WHERE Username = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssss", $name, $add1, $add2, $city, $state, $zip, $_SESSION["username"]);

            if ($stmt->execute()) {
                $this->success = "Saved changes.";
            } else {
                $this->register_err = "Error saving changes.";
            }
            $stmt->close();
            $link->close();
        }
    }

    public function ShowAccount()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT fullname, address1, address2, city, state, zipcode FROM client_info WHERE Username = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->row = $result->fetch_array(MYSQLI_ASSOC);
        } else {
            $this->register_err = "Error loading account.";
        }
        $stmt->close();
        $link->close();
    }
}

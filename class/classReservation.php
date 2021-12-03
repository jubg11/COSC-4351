<?php


class Reservation
{
    public $name_err = "";
    public $phone_err = "";
    public $email_err = "";
    public $guests_err = "";

    public $rows;
    public $row_count;
    public $show_err;
    public $search_err;

    public function reservationValidate()
    {
        $flag = 0;

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

        // Check if email is empty
        $_POST["Email"] = trim($_POST["Email"]);
        if (empty($_POST["Email"])) {
            $this->email_err = "Please enter an Email.";
            $flag++;
        }

        // Check if guests is empty
        $_POST["Guests"] = trim($_POST["Guests"]);
        if (empty($_POST["Guests"])) {
            $this->guests_err = "Please enter the amount of guests (including yourself).";
            $flag++;
        }
        // Check if guests is not following rules
        elseif ($_POST["Guests"] < 0 || $_POST["Guests"] > 52) {
            $this->guests_err = "Please enter a valid amount of guests. Max Capacity: 52.";
            $flag++;
        }

        return $flag;
    }

    public function SearchAttempt()
    {
        if ($this->reservationValidate() == 0) {
            require __DIR__ . "/../config/db_connect.php";

            $sql = "SELECT * FROM sys.reservation_tables WHERE reservation_time = ? 
            AND seats >= ?
            AND reserved = 0";
            $stmt = $link->prepare($sql);
            $this->datetime = $_POST["Date"] . " " . $_POST["Time"];
            $stmt->bind_param("ss", $this->datetime,  $_POST["Guests"]);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $this->rows = $result->fetch_all(MYSQLI_ASSOC);

                if ($stmt->affected_rows == 0) {
                    $this->CombineCalculate();
                    echo "exiting combine";
                }
            }
            $stmt->close();
            $link->close();
        }
    }

    public function ShowUserDetails()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT c.user_email, c.name, c.payment_method, c.phone_num
        FROM sys.customer_info AS c 
        WHERE c.user_id = ?;";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["ID"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->rows = $result->fetch_array(MYSQLI_ASSOC);
            $_POST["Email"] = $this->rows["user_email"];
            $_POST["Name"] = $this->rows["name"];
            $_POST["Payment_Method"] = $this->rows["payment_method"];
            $_POST["Phone"] = $this->rows["phone_num"];
        } else {
            $this->show_err = "Error obtaining account details.";
        }

        $stmt->close();
        $link->close();
    }

    public function CheckHighTraffic()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT * FROM sys.high_traffic_days WHERE date = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_POST["Reserve_Date"]);

        $d_hold = 0;
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows() == 1) {
                $stmt->bind_result($d_id, $d_name, $d_hold, $d_date);
                $stmt->fetch();
            }
        }

        $stmt->close();
        $link->close();
        return $d_hold;
    }


    public function ReservationAttempt()
    {

        require __DIR__ . "/../config/db_connect.php";

        $extra = "";
        if (strcmp($_SESSION["Signed"], "in") == 0) {
            $extra = ", user_id = ? ";
        }

        $sql = "UPDATE sys.reservation_tables 
            SET name = ?, phone_num = ?, email = ?, guests = ?, reserved = '1'" . $extra .
            "WHERE table_id = ?";
        $stmt = $link->prepare($sql);

        if (strcmp($_SESSION["Signed"], "in") == 0) {
            $stmt->bind_param("ssssss", $_POST["Name"], $_POST["Phone"], $_POST["Email"], $_POST["Guests"], $_SESSION["ID"], $_POST["Reserve_ID"]);
        } else {
            $stmt->bind_param("sssss", $_POST["Name"], $_POST["Phone"], $_POST["Email"], $_POST["Guests"], $_POST["Reserve_ID"]);
        }

        if ($stmt->execute()) {
            $stmt->close();
            $link->close();
            echo ("<script>
            alert('Reservation has been created.');
            </script>");
        } else {
            echo ("<script>
            alert('Failed to create Reservation');
            </script>");
        }
        $stmt->close();
        $link->close();
    }

    private function CombineCalculate()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT SUM(seats) AS maximum_seats FROM sys.reservation_tables WHERE reservation_time = ? 
        AND seats < ?
        AND reserved = 0";
        $stmt = $link->prepare($sql);
        $this->datetime = $_POST["Date"] . " " . $_POST["Time"];
        $stmt->bind_param("ss", $this->datetime,  $_POST["Guests"]);

        if ($stmt->execute()) {
            $stmt->bind_result($this->row_count);
            $stmt->fetch();
            print_r($this->row_count);
            // if ($stmt->affected_rows == 0) {
            //     $this->CombineCalculate();
            // }
        }
        $stmt->close();
        $link->close();
    }
}

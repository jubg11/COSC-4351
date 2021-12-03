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
                }
            } else {
                $this->search_err = "Could not find any reservations.";
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

    public function CheckHighTraffic($reserve)
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT * FROM sys.high_traffic_days WHERE date = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $reserve);

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

    public function ComboReserve($temp)
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
            $stmt->bind_param("ssssss", $_POST["Name"], $_POST["Phone"], $_POST["Email"], $_POST["Guests"], $_SESSION["ID"], $temp);
        } else {
            $stmt->bind_param("sssss", $_POST["Name"], $_POST["Phone"], $_POST["Email"], $_POST["Guests"], $temp);
        }

        if ($stmt->execute()) {
            $stmt->close();
            $link->close();
            return true;
        } else {
            $stmt->close();
            $link->close();
            return false;
        }
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

            if ($this->row_count < $_POST["Guests"]) {
                echo ("<script>
                alert('Could not find any reservations to fit number of guests.');
                </script>");
                return;
            }

            require __DIR__ . "/../config/db_connect.php";

            $sql = "SELECT * FROM sys.reservation_tables WHERE reservation_time = ? 
                AND seats < ?
                AND reserved = 0
                ORDER BY seats DESC";
            $stmt = $link->prepare($sql);
            $this->datetime = $_POST["Date"] . " " . $_POST["Time"];
            $stmt->bind_param("ss", $this->datetime,  $_POST["Guests"]);

            if ($stmt->execute()) {
                $results = $stmt->get_result();
                $this->results = $results->fetch_all(MYSQLI_ASSOC);

                $table_id = [];
                $table_size = [];
                foreach ($this->results as $x) {
                    $table_id[] = $x["table_id"];
                    $table_size[] = $x["seats"];
                }


                $taken_id = [];
                $people = $_POST["Guests"];
                while ($people > 0) {
                    $table_id = array_values($table_id);
                    $table_size = array_values($table_size);

                    if ($people >= 8) {
                        $max = max($table_size);
                        $i = array_search($max, $table_size);

                        $people = $people - $max;
                        $taken_id[] = $table_id[$i];
                        unset($table_id[$i]);
                        unset($table_size[$i]);
                        continue;
                    } elseif ($people <= 2) {
                        $min = min($table_size);
                        $i = array_search($min, $table_size);

                        $people = $people - $min;
                        $taken_id[] = $table_id[$i];
                        unset($table_id[$i]);
                        unset($table_size[$i]);
                        continue;
                    } elseif ($people <= 4) {
                        if (array_search(4, $table_size) !== false) {
                            $i = array_search(4, $table_size);

                            $people = $people - 4;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        } else {
                            $min = min($table_size);
                            $i = array_search($min, $table_size);

                            $people = $people - $min;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        }
                    } elseif ($people <= 6) {
                        if (array_search(6, $table_size) !== false) {
                            $i = array_search(6, $table_size);

                            $people = $people - 6;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        } else {
                            $max = max($table_size);
                            $i = array_search($max, $table_size);

                            $people = $people - $max;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        }
                    } elseif ($people < 8) {
                        if (array_search(8, $table_size) !== false) {
                            $i = array_search(8, $table_size);

                            $people = $people - 8;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        } else {
                            $max = max($table_size);
                            $i = array_search($max, $table_size);

                            $people = $people - $max;
                            $taken_id[] = $table_id[$i];
                            unset($table_id[$i]);
                            unset($table_size[$i]);
                            continue;
                        }
                    }
                }

                $taken_id;
                $count = 0;
                foreach ($taken_id as $combo_id) {
                    $this->ComboReserve($combo_id);
                    $count++;
                }
                if ($this->CheckHighTraffic($_POST["Date"]) > 0) {
                    echo ("<script>
                    alert('Due to high demand, to finalize this appointment a hold of $" . $hold . " will be placed');
                    </script>");
                }
                echo ("<script>
                alert('Reservation has been created. " . $count . " tables have been combined to accomodate this request.');
                </script>");
            }
        }
        $stmt->close();
        $link->close();
    }
}

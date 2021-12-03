<?php

class Past
{
    public $now;
    public $past;
    public $now_err = "";
    public $past_err = "";

    public function __construct()
    {
        $this->ShowCurrent();
        $this->ShowPast();
    }

    public function ShowCurrent()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT *
            FROM sys.reservation_tables
            WHERE user_id = ? AND reserved = 1
            ORDER BY reservation_time";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["ID"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->now = $result->fetch_all(MYSQLI_ASSOC);

            if ($stmt->affected_rows == 0) {
                $this->now_err = "No current reservations found.";
            }
        } else {
            $this->now_err = "Error obtaining current reservations.";
        }

        $stmt->close();
        $link->close();
    }

    public function ShowPast()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT *
            FROM sys.reservation_archive
            WHERE user_id = ?
            OR email = ?
            ORDER BY reservation_time";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $_SESSION["ID"], $_SESSION["Email"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->past = $result->fetch_all(MYSQLI_ASSOC);

            if ($stmt->affected_rows == 0) {
                $this->past_err = "No past reservations found.";
            }
        } else {
            $this->past_err = "Error obtaining past reservations.";
        }

        $stmt->close();
        $link->close();
    }


    public function DeleteReservation()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "UPDATE sys.reservation_tables
            SET name = null, phone_num = null, email = null, guests = null, user_id = null, reserved = 0 
            WHERE user_id = ? AND table_id = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("ss", $_SESSION["ID"], $_POST["Reserve_ID"]);

        if ($stmt->execute()) {

            echo ("<script>
            alert('Reservation has been canceled successfully.');
            </script>");
        } else {
            echo ("<script>
            alert('Problem canceling reservation. Try again later.');
            </script>");
        }

        $stmt->close();
        $link->close();
    }
}

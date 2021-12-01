<?php

class FuelHistory
{
    public $rows;
    public $show_err;

    public function __construct()
    {
        $this->ShowHistory();
    }

    public function ShowHistory()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT gallons, delivery_address, delivery_date, pricepergal, total_due FROM fuel_orders WHERE User = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->rows = $result->fetch_all(MYSQLI_ASSOC);
            //new: if no history, this->rows has a value of false, so:
            if ($result->num_rows == 0) {
                $this->show_err = "No history found.";
                return false;
            } else {

                return true;
            }
        } else {
            $this->show_err = "Error creating account.";
        }

        $stmt->close();
        $link->close();
    }
}

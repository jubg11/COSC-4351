<?php

class View
{
    public $rows;
    public $show_err;

    public function __construct()
    {
        $this->ShowDetails();
    }

    public function ShowDetails()
    {
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT c.user_email, c.name, c.payment_method, c.phone_num, c.preferred_diner_num, c.earned_points
            ,s.street_add, s.street_add2, s.city, s.state, s.zip
            ,b.b_street_add, b.b_street_add2, b.b_city, b.b_state, b.b_zip
            FROM sys.customer_info AS c 
            LEFT JOIN sys.shipping_addr AS s
            ON (c.user_id = s.user_id)
            INNER JOIN sys.billing_addr AS b
            ON (c.user_id = b.user_id)
            WHERE c.user_id = ?;";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["ID"]);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $this->rows = $result->fetch_array(MYSQLI_ASSOC);
        } else {
            $this->show_err = "Error obtaining account details.";
        }

        $stmt->close();
        $link->close();
    }
}

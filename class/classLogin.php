<?php


class Login
{
    public $email_err = "";
    public $pass_err = "";
    public $login_err = "";

    public function __construct()
    {
        $this->LoginAttempt();
    }

    private function loginValidate()
    {
        $flag = 0;

        // Check if email is empty
        $_POST["Email"] = trim($_POST["Email"]);
        if (empty($_POST["Email"])) {
            $this->email_err = "Please enter an Email.";
            $flag++;
        }

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

        return $flag;
    }

    public function LoginAttempt()
    {
        if ($this->loginValidate() == 0) {
            require __DIR__ . "/../config/db_connect.php";

            $sql = "SELECT user_id, user_password, name FROM sys.customer_info WHERE user_email = ?";
            $stmt = $link->prepare($sql);
            $email = $_POST["Email"];
            $stmt->bind_param("s", $email);

            if ($stmt->execute()) {
                $stmt->store_result();

                if ($stmt->num_rows() == 1) {

                    // Store data in session variables
                    $stmt->bind_result($id, $pass, $name);
                    $stmt->fetch();

                    // Verifies if the input password matches the hashed password
                    if (password_verify($_POST["Pass"], $pass)) {

                        // Password is correct, so start a new session
                        session_start();

                        //bind vars to session
                        $_SESSION["ID"] = $id;
                        $_SESSION["Email"] = $email;
                        $_SESSION["Name"] = $name;
                        $_SESSION["Signed"] = "in";

                        // Redirect user to welcome page
                        header("location: ../Index.php");
                    } else {
                        $this->login_err = "Invalid Username or Password";
                    }
                } else {
                    $this->login_err = "Invalid Username or Password";
                }
            }
            $stmt->close();
            $link->close();
        }
    }
}

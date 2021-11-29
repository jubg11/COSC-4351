<?php
class Users {
  //CONNECT DATABASE
  private $pdo = null;
  private $stmt = null;
  public $error = null;
  function __construct () {
    try {
      $this->pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
      );
    } catch (Exception $ex) { exit($ex->getMessage()); }
  }

  //CLOSE CONNECTION
  function __destruct () {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  //GET USER
  function get ($id) {
    $sql = sprintf("SELECT * FROM `customer_info` WHERE `user_%s`=?", is_numeric($id)?"id":"email");
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute([$id]);
    return $this->stmt->fetch();
  }

  //REGISTER NEW USER
  function register ($email, $pass, $cpass, $name, $mail, $bill, $payment) {
	  
	  //CHECK EMAIL REGEX IN HTML
	  
    //CHECK IF USER REGISTERED
    $check = $this->get($email);
    if (is_array($check)) {
      $this->error = "$email is already registered." ;
      return false;
    }
 
	/*
	if (!preg_match("/^.{2,45}$/", $pass)) {
		$this->error = "Please enter a valid password between 2 and 255 characters.";
		return false;
	}
	*/
 
    //CHECK PASSWORD
    if ($pass != $cpass) {
      $this->error = "Passwords do not match.";
      return false;
    }
	
	/*
	if (!preg_match("/^[\w\s]{2,45}$/", $name)) {
		$this->error = "Please enter a valid name between 2 and 255 characters.";
		return false;
	}
	*/

    //INSERT INTO DATABASE
    try {
      $this->stmt = $this->pdo->prepare(
        "INSERT INTO `customer_info` (`user_email`, `user_password`, `name`, 'mailing_address', 'billing_address', payment_method') VALUES (?,?,?,?,?,?)"
      );
      $this->stmt->execute([$email, password_hash($pass, PASSWORD_DEFAULT), $name, $mail, $bill, $payment]);
    } catch (Exception $ex) {
      $this->error = $ex->getMessage();
      return false;
    }
  }
}

// (F) DATABASE SETTINGS - CHANGE TO YOUR OWN!
define("DB_HOST", "database-4351.ctkzz4wlfaku.us-east-2.rds.amazonaws.com");
define("DB_NAME", "COSC4351");
define("DB_CHARSET", "utf8");
define("DB_USER", "admin");
define("DB_PASSWORD", "cosc4351");

// (G) NEW USER OBJECT
$USR = new Users();
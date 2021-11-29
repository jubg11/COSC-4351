<?php


class Login{
    public $user_err = "";
    public $pass_err = "";
    public $login_err = "";

    public function __construct($u,$p){
        $this->LoginAttempt(trim($u) , $p);   
    }

    private function Validate($user,$pass){
        $flag = 0;

        // Check if Username is empty
        if(empty($user) ){
            $this->user_err = "Please enter a Username.";
        } 
        // Check if Username is not following rules
        elseif(!preg_match("/^\w{2,45}$/", $user) ){
            $this->user_err = "Please enter a valid Username.";
        }
        else{
            $flag++;
        }

        // Check if Password is empty
        if(empty($pass) ){
            $this->pass_err = "Please enter a Password.";
        } 
        // Check if Password is not following rules
        elseif(!preg_match("/^.{2,45}$/", $pass) ){
            $this->pass_err = "Please enter a valid Password.";
        }
        else{
            $flag++;
        }

        return $flag;
    }

    public function LoginAttempt($u, $p){
        if( $this->Validate($u,$p) == 2  ){
            require __DIR__ . "/../config/db_connect.php";

            $sql = "SELECT Acc_Type, Password FROM login WHERE Username = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("s", $u);

            if($stmt->execute() ){
                $stmt->store_result();

                if($stmt->num_rows() == 1){
                    
                    // Store data in session variables
                    $stmt->bind_result($accType, $password);
                    $stmt->fetch();
                    
                    //verifies if the input password matches the hashed password
                    if (password_verify($p, $password)) {
                    
                        // Password is correct, so start a new session
                        session_start();
                        
                        //bind vars to session
                        $_SESSION["acc_type"] = $accType;
                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $u;

                        // Redirect user to welcome page
                        header("location: ../Index.php"); 
                        
                    } else {
                        $this->login_err = "Invalid Username or Password";
                    }
                    
                }else{
                    $this->login_err = "Invalid Username or Password";
                }
                
            }
            $stmt->close();
            $link->close();
        }
    }
}


class Register{
    public $user_err = "";
    public $pass_err = "";
    public $register_err = "";
    public $success = "";

    public function __construct($u,$p){
        $this->RegisterAttempt(trim($u) , $p);   
    }

    private function Validate($user,$pass){
        $flag = 0;

        // Check if Username is empty
        if(empty($user) ){
            $this->user_err = "Please enter a Username.";
        } 
        // Check if Username is not following rules
        elseif(!preg_match("/^\w{2,45}$/", $user) ){
            $this->user_err = "Please enter a valid Username.";
        }
        else{
            $flag++;
        }

        //Check if Username already taken
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT * FROM login WHERE Username = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $user);

        if($stmt->execute()){
            $stmt->store_result();

            if($stmt->num_rows() >= 1){
                $this->user_err = "Username already taken.";
            }else{
                $flag++;
            }
        }
        $stmt->close();
        $link->close();

        // Check if Password is empty
        if(empty($pass) ){
            $this->pass_err = "Please enter a Password.";
        } 
        // Check if Password is not following rules
        elseif(!preg_match("/^.{2,45}$/", $pass) ){
            $this->pass_err = "Please enter a valid Password.";
        }
        else{
            $flag++;
        }
        return $flag;
    }

    public function RegisterAttempt($u, $p){
        if( $this->Validate($u,$p) == 3  ){
            require __DIR__ . "/../config/db_connect.php";

            $hash = password_hash($p, PASSWORD_DEFAULT);
            $sql = "INSERT INTO login (Username, Password) 
                VALUES ( ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("ss", $u, $hash);

            if($stmt->execute() ){
                $this->success = "Successfully created account.<br> Go to Login Page.";
                unset($_POST);
            }else{
                $this->register_err = "Error creating account.";
            }
            $stmt->close();
            $link->close();
        }
    }
}

class RegisterTwo{
    public $name_err = "";
    public $add1_err = "";
    public $add2_err = "";
    public $city_err = "";
    public $state_err = "";
    public $zip_err = "";
    public $register_err = "";

    public function __construct($name, $add1, $add2, $city, $state, $zip){
        $this->RegisterTwoAttempt(trim($name), trim($add1), trim($add2), trim($city), trim($state), trim($zip) );   
    }

    private function Validate($name, $add1, $add2, $city, $state, $zip){
        $flag = 0;

        // Check if Name is empty
        if(empty($name) ){
            $this->name_err = "Please enter a Name.";
        } 
        // Check if Name is not following rules
        elseif(!preg_match("/^.{1,50}$/", $name) ){
            $this->name_err = "Please enter a valid Name.";
        }
        else{
            $flag++;
        }

        // Check if Add1 is empty
        if(empty($add1) ){
            $this->add1_err = "Please enter an Address.";
        } 
        // Check if Add1 is not following rules
        elseif(!preg_match("/^.{1,100}$/", $add1) ){
            $this->add1_err = "Please enter a valid Address.";
        }
        else{
            $flag++;
        }

        // Check if Add2 is not following rules
        if(!preg_match("/^.{0,100}$/", $add2) ){
            $this->add2_err = "Please enter a valid Secondary Address.";
        }
        else{
            $flag++;
        }

        // Check if City is empty
        if(empty($city) ){
            $this->city_err = "Please enter a City.";
        } 
        // Check if City is not following rules
        elseif(!preg_match("/^.{1,100}$/", $city) ){
            $this->city_err = "Please enter a valid City.";
        }
        else{
            $flag++;
        }

        // Check if State is empty
        if(empty($state) ){
            $this->state_err = "Please select a State.";
        } 
        // Check if State is not following rules
        elseif(!preg_match("/^\w{2}$/", $state) ){
            $this->state_err = "Please enter a valid State.";
        }
        else{
            $flag++;
        }

        // Check if Zip is empty
        if(empty($zip) ){
            $this->zip_err = "Please enter a Zip.";
        } 
        // Check if Zip is not following rules
        elseif(!preg_match("/^\b\d{5}(?:-\d{4})?\b$/", $zip) ){
            $this->zip_err = "Please enter a valid Zip.";
        }
        else{
            $flag++;
        }

        return $flag;
    }

    public function RegisterTwoAttempt($name, $add1, $add2, $city, $state, $zip){
        if( $this->Validate($name, $add1, $add2, $city, $state, $zip) == 6  ){
            require __DIR__ . "/../config/db_connect.php";

            $sql = "INSERT INTO client_info (Username, fullname, address1, address2, city, state, zipcode) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssss", $_SESSION["username"] , $name, $add1, $add2, $city, $state, $zip);

            if($stmt->execute() ){
                $stmt->close();
                $link->close();

                //------------------------------------------------
                require __DIR__ . "/../config/db_connect.php";

                $sql = "UPDATE login SET Acc_Type = 1 WHERE Username = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("s", $_SESSION["username"] );

                if($stmt->execute() ){
                    $_SESSION["acc_type"] = 1;
                }else{
                    $this->register_err = "Error completing account.";
                }
                //---------------------------------------------------------

                // Redirect user to welcome page
                header("location: ../Index.php");
            }else{
                $this->register_err = "Error completing account.";
            }
            $stmt->close();
            $link->close();
            //-----------------------------------------------------------------
            
        }
    }
}


class FuelForm{
    public $gallons_err;
    public $address_err;
    public $date_err;
    public $costpergal;
    public $total;
    public $success;
    public $submission_err;

    public function __construct($gal, $date, $int){
        if($int == 1){
            $this->Calculate($gal, $date);
        }elseif($int == 2){
            $this->Order($gal, $date);
        }
    }

    private function Validate($gal, $date){
        $flag = 0;

        // Check if Gallons is empty
        if(empty($gal) ){
            $this->gallons_err = "Please enter a Gallon Amount.";
        } 
        // Check if Gallons is not following rules
        elseif(!preg_match("/^\d{1,10}$/", $gal) ){
            $this->gallons_err = "Please enter a valid Gallon Amount.";
        }
        else{
            $flag++;
        }

        require __DIR__ . "/../config/db_connect.php";
        $sql = "SELECT address1, address2, state FROM client_info WHERE Username = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"] );

        if($stmt->execute() ){
            $stmt->store_result();

            if($stmt->num_rows() == 1){             
                // Store data in variable
                $stmt->bind_result($addr1, $addr2, $state);
                $stmt->fetch();
                $_SESSION["address1"] = $addr1;
                $_SESSION["address2"] = $addr2;
                $_SESSION["state"] = $state;
            }else{
                $this->address_err = "No Address Found";
                $flag--;
            }
        }
        $stmt->close();
        $link->close();


        // Check if Date is empty
        if(empty($date) ){
            $this->date_err = "Please enter a Delivery Date.";
        } 
        // Check if Date is not following rules
        elseif(!preg_match("/^\d{4}\-\d{2}\-\d{2}$/", $date) ){
            $this->date_err = "Please enter a valid Delivery Date.";
        }
        else{
            $flag++;
        }
        return $flag;
    }

    //new: add $state as a parameter
    public function Calculate($gal,$date){
        if($this->Validate( $gal, $date ) == 2){
            
            $this->total = $this->Pricing($gal) * $gal;
            return 1;
        }
        return 0;
    }

    //new: function to calculate suggested price/gal
    public function Pricing($gal){
        $this->costpergal = 1.5;
        // setting location factor
        if($_SESSION["state"] == 'TX'){
            $loc_factor=.02;
        }
        else{
            $loc_factor=.04;
        }

        // setting rate history factor
        $history = new FuelHistory();               
        if ($history->ShowHistory() == false){
            $rh_factor = 0;
        }
        else{
            $rh_factor = .01;
        }

        // setting gallons requested factor
        if ($gal > 1000){
            $gal_factor = .02;
        }
        else{
            $gal_factor = .03;
        }

        $cp_factor = .1;

        $margin = $this->costpergal*($loc_factor - $rh_factor + $gal_factor + $cp_factor);
        $this->costpergal = $this->costpergal + $margin;
        return $this->costpergal;
    }

    //new: add $state as a parameter
    public function Order($gal,$date){
        if($this->Calculate($gal,$date) == 1){

            require __DIR__ . "/../config/db_connect.php";
            $sql = "INSERT INTO fuel_orders (User, gallons, delivery_address, delivery_date, pricepergal, total_due)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssd", $_SESSION["username"] , $gal, $_SESSION["address1"] , $date, $this->costpergal, $this->total);

            if($stmt->execute() ){
                $this->success = "Order placed successfully.";
            }else{
                $this->submission_err = "Error completing order.";
            }
            $stmt->close();
            $link->close();
        }
    }
}


class Edit{
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

    public function __construct(){
        $this->ShowAccount();
    }

    private function Validate($pass, $name, $add1, $add2, $city, $state, $zip){
        $flag = 0;

        // Check if Password is inputted
        if(!empty($pass) ){                    
            // Check if Password is not following rules
            if(!preg_match("/^.{2,45}$/", $pass) ){
                $this->pass_err = "Please enter a valid Password.";
            }
            else{
                $flag++;
            }
        }
        else{
            $flag++;
        }

        // Check if Name is empty
        if(empty($name) ){
            $this->name_err = "Please enter a Name.";
        } 
        // Check if Name is not following rules
        elseif(!preg_match("/^.{1,50}$/", $name) ){
            $this->name_err = "Please enter a valid Name.";
        }
        else{
            $flag++;
        }

        // Check if Add1 is empty
        if(empty($add1) ){
            $this->add1_err = "Please enter an Address.";
        } 
        // Check if Add1 is not following rules
        elseif(!preg_match("/^.{1,100}$/", $add1) ){
            $this->add1_err = "Please enter a valid Address.";
        }
        else{
            $flag++;
        }

        // Check if Add2 is not following rules
        if(!preg_match("/^.{0,100}$/", $add2) ){
            $this->add2_err = "Please enter a valid Secondary Address.";
        }
        else{
            $flag++;
        }

        // Check if City is empty
        if(empty($city) ){
            $this->city_err = "Please enter a City.";
        } 
        // Check if Name is not following rules
        elseif(!preg_match("/^.{1,100}$/", $city) ){
            $this->city_err = "Please enter a valid City.";
        }
        else{
            $flag++;
        }

        // Check if State is empty
        if(empty($state) ){
            $this->state_err = "Please select a State.";
        } 
        // Check if State is not following rules
        elseif(!preg_match("/^\w{2}$/", $state) ){
            $this->state_err = "Please enter a valid State.";
        }
        else{
            $flag++;
        }

        // Check if Zip is empty
        if(empty($zip) ){
            $this->zip_err = "Please enter a Zip.";
        } 
        // Check if Zip is not following rules
        elseif(!preg_match("/^\b\d{5}(?:-\d{4})?\b$/", $zip) ){
            $this->zip_err = "Please enter a valid Zip.";
        }
        else{
            $flag++;
        }

        return $flag;
    }


    public function EditAccount($pass, $name, $add1, $add2, $city, $state, $zip){
        $pass = $pass; 
        $name = trim($name); 
        $add1 = trim($add1); 
        $add2 = trim($add2); 
        $city = trim($city); 
        $state = trim($state); 
        $zip = trim($zip);

        if( $this->Validate($pass, $name, $add1, $add2, $city, $state, $zip) == 7 ){
            require __DIR__ . "/../config/db_connect.php";

            if( !empty($pass)){
                $phash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "UPDATE login SET Password = ? WHERE Username = ?";
                $stmt = $link->prepare($sql);
                $stmt->bind_param("ss", $phash, $_SESSION["username"]);

                if($stmt->execute() ){
                    $this->success = "Saved changes.";
                }else{
                    $this->register_err = "Error saving changes.";
                }

                $stmt->close();
                $link->close();
            }


            require __DIR__ . "/../config/db_connect.php";
            $sql = "UPDATE client_info SET fullname = ?, address1 = ?, address2 = ?, city = ?, state = ?, zipcode = ? WHERE Username = ?";
            $stmt = $link->prepare($sql);
            $stmt->bind_param("sssssss", $name, $add1, $add2, $city, $state, $zip, $_SESSION["username"]);

            if($stmt->execute() ){
                $this->success = "Saved changes.";
            }else{
                $this->register_err = "Error saving changes.";
            }
            $stmt->close();
            $link->close();
        }
    }

    public function ShowAccount(){
        require __DIR__ . "/../config/db_connect.php";
        
        $sql = "SELECT fullname, address1, address2, city, state, zipcode FROM client_info WHERE Username = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);

        if($stmt->execute() ){
            $result = $stmt->get_result();
            $this->row = $result->fetch_array(MYSQLI_ASSOC);
        }else{
            $this->register_err = "Error loading account.";
        }
        $stmt->close();
        $link->close();
    }


}

class FuelHistory{
    public $rows;
    public $show_err;

    public function __construct(){
        $this->ShowHistory();
    }

    public function ShowHistory(){
        require __DIR__ . "/../config/db_connect.php";

        $sql = "SELECT gallons, delivery_address, delivery_date, pricepergal, total_due FROM fuel_orders WHERE User = ?";
        $stmt = $link->prepare($sql);
        $stmt->bind_param("s", $_SESSION["username"]);

        if($stmt->execute() ){
            $result = $stmt->get_result();
            $this->rows = $result->fetch_all(MYSQLI_ASSOC);
            //new: if no history, this->rows has a value of false, so:
            if($result->num_rows == 0){
                $this->show_err = "No history found.";      
                return false;                       
            }
            else{

                return true;
            }
        }
        else{
            $this->show_err = "Error creating account.";
        }
            
        $stmt->close();
        $link->close();
    }

}


?>
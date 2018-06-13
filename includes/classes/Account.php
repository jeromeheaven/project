<?php
class Account {
  private $con;
  private $errorArray;

  public function __construct($con) {
    $this->con = $con;
    $this->errorArray = array();
    //set error array to empty array
  }

  public function login($uname, $pwd) {

  $pwd = md5($pwd);
  //encrypt the password

$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$uname' AND password='$pwd'");
  //check if it exists in the table

if(mysqli_num_rows($query) == 1) {
  return true;
  //if you find one row true
}
else {
  array_push($this->errorArray, Constants::$loginFailed);
  return false;
  //if its anything other than one row than false
    }
}


  public function register($uname,$fname,$lname,$em,$em2,$pwd,$pwd2) {
    $this-> validateUsername($uname);
    $this->validatefirstName($fname);
    $this->validatelastName($lname);
    $this->validateEmails($em,$em2);
    $this->validatePasswords($pwd,$pwd2);


if(empty($this->errorArray) == true) {
// Insert into the database
return $this->insertUserDetails($uname, $fname, $lname, $em, $pwd) ;
}
else {
  return false;
  }


}
//potentially add one more closing curly brace here

  public function getError($error) {
    if(!in_array($error, $this->errorArray)) {
      //checking to see if there is an error in the errorArray
      //if there is
      $error = "";
    }

    return "<span class='errorMessage'>$error</span>";
  }

private function insertUserDetails($uname, $fname, $lname, $em, $pwd) {
$encryptedPw = md5($pwd); // encrypts password for better security
$profilePic ="assets/images/profile-pics/mens_profile.png";
$date = date("Y-m-d");

$result = mysqli_query($this->con, "INSERT INTO users VALUES ('', '$uname', '$fname', '$lname', '$em', '$encryptedPw', '$date', '$profilePic')");

return $result;

}

  private function validateUsername($uname) {

      if(strlen($uname) > 30 || strlen($uname) < 3) {
        array_push($this->errorArray, Constants::$userNameCharacters);
        return;
      }

      $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM users WHERE username= '$uname'");
      if(mysqli_num_rows($checkUsernameQuery)!= 0) {
       array_push($this->errorArray, Constants:: $usernameTaken);
       return;
      }
  }


  private function validatefirstName($fname) {
    if(strlen($fname) > 30 || strlen($fname) < 2) {
      array_push($this->errorArray, Constants::$firstNameCharacters);
      return;

    }

  }

  private function validatelastName($lname) {
    if(strlen($lname) > 30 || strlen($lname) < 2) {
      array_push($this->errorArray, Constants::$lastNameCharacters);
      return;

    }

  }

  private function validateEmails($em,$em2) {
    if($em != $em2) {
      array_push($this->errorArray, Constants::$emailsDoNotMatch);
      return ;
      }

    if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
      //check to see if this is a valid email(uses @gmail.com etc)
      array_push($this->errorArray, Constants::$emailInvalid);
      return ;
    }

    $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM users WHERE email= '$em'");
    if(mysqli_num_rows($checkEmailQuery)!= 0) {
     array_push($this->errorArray, Constants::$emailTaken);
     return;
    }
  }

private function validatePasswords($pwd,$pwd2) {

  if($pwd != $pwd2) {
  array_push($this->errorArray, Constants::$passwordsDoNotMatch);
  return ;
  //check if passwords match
}

if(preg_match('/[^A-Za-z0-9]/', $pwd)) {
  //check if password has valid characters
  array_push($this->errorArray, Constants::$passwordNotAlphanumber);
return ;
  }

  if(strlen($pwd) > 30 || strlen($pwd) < 3) {
    array_push($this->errorArray, Constants::$passwordCharacters);
    return;
    //checks password length
    }

  }

}


 ?>

<?php


function cleanFormPassword($inputText) {
  $inputText = strip_tags($inputText);
  return $inputText;

}

//Make create account login clean
function cleanFormUsername($inputText) {
  $inputText = strip_tags($inputText);
  //example <blah> etc won't be present
  $inputText = str_replace(" ", "", $inputText);
  //replaces every space we find and replace it with normal. eg. john smith would be johnsmith
  return $inputText;
}

function cleanFormString($inputText) {
  $inputText = strip_tags($inputText);
  $inputText = str_replace(" ", "", $inputText);
  $inputText = ucfirst(strtolower($inputText));
  /*
  uppercases the first letter just in case user leaves it lower cased.
  str to lower so it starts always as lower case
*/

  return $inputText;
}




if(isset($_POST['registerButton'])) {
  //cleans field to make it workable if you make a mistake
$username = cleanFormUsername($_POST['username']);

$firstName = cleanFormString($_POST['firstName']);

$lastName = cleanFormString($_POST['lastName']);

$email = cleanFormString($_POST['email']);

$email2 = cleanFormString($_POST['email2']);

$password = cleanFormPassword($_POST['password']);

$password2 = cleanFormPassword($_POST['password2']);

//runs the register function
$wasSuccessful = $account->register($username,$firstName,$lastName,$email,$email2,$password,$password2);

if($wasSuccessful) {
  $_SESSION['userLoggedIn'] = $username;
  header("Location: index.php");
  //if this is successful then send them to the home page

    }

}
 ?>

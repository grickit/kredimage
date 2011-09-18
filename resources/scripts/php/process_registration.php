<?php

function validateUsername($username) {
  if(strlen($username) <= 3) { return "Your username must be between 4 and 20 characters long"; }
  if(strlen($username) > 20) { return "Your username must be between 4 and 20 characters long"; }
  if(preg_match('/^[a-zA-Z0-9*_-]+$/',$username) == 0) { return "Usernames can only use A-Z a-z 0-9 _ - *"; }

  $db_server = mysql_connect('localhost','root','square1');
  if(!$db_server) die("Couldn't connect to MySQL server: ".mysql_error());
  mysql_select_db('kredimage') or die("Couldn't select user_registration table: ".mysql_error());

  $username = mysql_real_escape_string($username);
  $query = "SELECT id FROM user_registration WHERE username='$username'";

  $result = mysql_query($query);
  if(!$result) die("Couldn't lookup username: ".mysql_error());

  $results = mysql_num_rows($result);
  if ($results >= 1) {
    return "That username is taken. Sorry.";
  }

  mysql_close($db_server);
  return false;
}

function validatePassword($password) {
  if(strlen($password) <= 7) { return "Password must be between 8 and 20 characters long."; }
  if(strlen($password) > 20) { return "Password must be between 8 and 20 characters long."; }
  if(preg_match('/^[a-zA-Z0-9*_-]+$/',$password) == 0) { return "Passwords can only use A-Z a-z 0-9 _ - *"; }
  return false;
}

function validateConfirm($password,$confirm) {
  if($confirm != $password) { return "Passwords don't match."; }
  return false;
}

function validateEmail($email) {
  if(strlen($email) > 100) { return "Email address can't be over 100 characters long."; }
  if(preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email) == 0) { return "That doesn't look like a valid email address."; }
  return false;
}

function validateBirthYear($birthyear,$year) {
  if(preg_match('/^[0-9][0-9][0-9][0-9]$/',$birthyear) == 0) { return "Please enter the long (four digit) form of the year you were born."; }
  if(($year - $birthyear) >= 120) { return "The year you entered is impossibly old."; }
  if(($year - $birthyear) < 0 ) { return "The year you entered is in the future"; }
  return false;
}

function commitRegistration($username,$password,$email,$birthyear) {
  include("secrets.php");

  $randsalt = rand(0,999);

  $uniqueid = sha1($username.$randsalt);
  $validationcode = sha1($uniqueid);
  $hashedpass = sha1($passsalt1.$password.$passsalt2);
  $regiyear = date('Y');
  $regimonth = date('m');
  $regiday = date('d');
  $regiaddr = $_SERVER['REMOTE_ADDR'];
  $terms = 1;
  $validated = 0;

  $db_server = mysql_connect('localhost',$db_user,$db_pass);
  if(!$db_server) die("Couldn't connect to MySQL server: ".mysql_error());
  mysql_select_db('kredimage') or die("Couldn't select user_registration table: ".mysql_error());

  $uniqueid = mysql_real_escape_string($uniqueid);
  $username = mysql_real_escape_string($username);
  $hashedpass = mysql_real_escape_string($hashedpass);
  $email = mysql_real_escape_string($email);
  $birthyear = mysql_real_escape_string($birthyear);
  $regiyear = mysql_real_escape_string($regiyear);
  $regimonth = mysql_real_escape_string($regimonth);
  $regiday = mysql_real_escape_string($regiday);
  $regiaddr = mysql_real_escape_string($regiaddr);
  $terms = mysql_real_escape_string($terms);
  $validationcode = mysql_real_escape_string($validationcode);
  $validated = mysql_real_escape_string($validated);

  $query = "INSERT INTO user_registration VALUES(NULL,'$uniqueid','$username','$hashedpass','$email',$birthyear,$regiyear,$regimonth,$regiday,'$regiaddr',$terms,'$validationcode',$validated)";
  $result = mysql_query($query);
  if(!$result) die("Couldn't commit registration: ".mysql_error());

  mysql_close($db_server);
}
?>
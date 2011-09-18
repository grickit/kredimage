<?php
  include("secrets.php"); //DB_USER,DB_PASS,PASSSALT1,PASSSALT2

  function connectToDatabase() {
    $db_server = mysql_connect('localhost',DB_USER,DB_PASS);
    if(!$db_server) die("Couldn't connect to MySQL server: ".mysql_error());
    mysql_select_db('kredimage') or die("Couldn't select user_registration table: ".mysql_error());
    return $db_server;
  }

  function hashPassword($password) {
    return sha1(PASSSALT1.$password.PASSSALT2);
  }

  function testLogin($username,$hashedpass) {
    $username = mysql_real_escape_string($username);
    $hashedpass = mysql_real_escape_string($hashedpass);

    $query = "SELECT * FROM user_registration WHERE username='$username' && hashedpass='$hashedpass'";
    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());
    $results = mysql_num_rows($result);

    return $results;
  }
?>
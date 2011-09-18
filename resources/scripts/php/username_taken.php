<?php
  include("database.php");

  $username = $_GET['username'];
  if(!$username == "") {
    $db_server = connectToDatabase();

    $username = mysql_real_escape_string($username);
    $query = "SELECT id FROM user_registration WHERE username='$username'";

    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());

    $results = mysql_num_rows($result);
    if ($results >= 1) {
      echo "That username is taken. Sorry.";
    }

    mysql_close($db_server);
  }
?>
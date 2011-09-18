<?php
include("secrets.php");

$username = $_GET['username'];
if(!$username == "") {
  $db_server = mysql_connect('localhost',$db_user,$db_pass);
  if(!$db_server) die("Couldn't connect to MySQL server: ".mysql_error());
  mysql_select_db('kredimage') or die("Couldn't select user_registration table: ".mysql_error());

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
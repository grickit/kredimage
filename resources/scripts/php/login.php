<?php
  session_start();
  session_regenerate_id();
  if(isset($_COOKIE['uniqueid'])) { // Transfer cookies to session
    $_SESSION['uniqueid'] = $_COOKIE['uniqueid'];
  }
  if(isset($_SESSION['username']) && isset($_SESSION['hashedpass'])) {
    $db_server = connectToDatabase();
    $loginTest = getLogin($_SESSION['username'],$_SESSION['hashedpass']);
    if (mysql_num_rows($loginTest) == 1) {
      $loginData = mysql_fetch_array($loginTest,MYSQL_ASSOC);
      $logged_in = true;
    }
    else {
      $logged_in = false;
      session_start();
      session_destroy();
    }
    mysql_close($db_server);
  }
?>
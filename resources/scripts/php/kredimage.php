<?php
  include("database.php");

  function sendTo($location) {
    header('Location: ' . $location);
    exit();
  }

  function sendToLogin($message) {
    sendTo('login.php?error=' . $message);
  }

  $storage_directory = $_SERVER['DOCUMENT_ROOT'].'/kredimage_storage/';
  if ( !file_exists($storage_directory) ) {
    mkdir ($storage_directory, 0775);
  }

  session_start();
  session_regenerate_id();
  if(isset($_COOKIE['uniqueid'])) { // Transfer cookies to session
    $_SESSION['uniqueid'] = $_COOKIE['uniqueid'];
  }
  if(isset($_SESSION['username']) && isset($_SESSION['hashedpass'])) {
    $db_server = connectToDatabase();
    if (testLogin($_SESSION['username'],$_SESSION['hashedpass']) == 1) {
      // Look up account info
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
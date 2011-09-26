<?php
  include_once("database.php");

  function sendTo($location) {
    header('Location: ' . $location);
    exit();
  }

  function sendToLogin($message) {
    sendTo('login.php?error=' . $message);
  }


  if ( !file_exists($storage_directory) ) {
    mkdir ($storage_directory, 0775);
  }

  if ( !file_exists($full_directory) ) {
    mkdir ($full_directory, 0775);
  }

  if ( !file_exists($small_directory) ) {
    mkdir ($small_directory, 0775);
  }

  if ( !file_exists($thumb_directory) ) {
    mkdir ($thumb_directory, 0775);
  }

  if ( !file_exists($storage_directory.".htaccess") ) {
    $htaccess = "<LIMIT GET POST>
order deny,allow
deny from all
allow from none
</LIMIT>";
    file_put_contents($storage_directory.".htaccess",$htaccess);
  }
?>
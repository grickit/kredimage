<?php
  include_once("database.php");

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
?>
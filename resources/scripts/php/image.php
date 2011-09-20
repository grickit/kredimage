<?php
  $storage_directory = $_SERVER['DOCUMENT_ROOT'].'/kredimage_storage/';
  $contents = file_get_contents($storage_directory."foo");
  $contents = base64_decode($contents);
  header("Content-type: image");
  echo $contents;
  exit();
?>
<?php

  define("DB_ADDR","localhost");
  define("DB_USER","root");
  define("DB_PASS","square1");
  define("DB_NAME","kredimage");
  define("PASSSALT1","tomato");
  define("PASSSALT2","(:P)");

  $storage_directory = $_SERVER['DOCUMENT_ROOT'].'/kredimage_storage/';
  $full_directory = $storage_directory."full/";
  $small_directory = $storage_directory."small/";
  $thumb_directory = $storage_directory."thumb/";

?>
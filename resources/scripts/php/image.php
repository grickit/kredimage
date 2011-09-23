<?php
  include("secrets.php");

  if (isset($_GET['id'])) {
    $contents = file_get_contents($full_directory.$_GET['id']);
    $contents = base64_decode($contents);
    header("Content-type: image");
    echo $contents;
    exit();
  }
?>
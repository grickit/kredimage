<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Kredimage</title>
    <link rel="stylesheet" type="text/css" href="resources/styles/style.css">
  </head>
  <body>
    <div id="main_container">

      <div id="head_container">
	<div id="head_content">
	  <img id="kredimage_logo" src="" width="145" height="45" alt="Kredimage" style="margin-top: 5px; margin-left: 5px; float: left;">
	  <form id="search_form" method="get" action="">
	  </form>
	  <?php
	    if ($logged_in == true) {
	      include("mini_profile.php");
	    }
	    elseif ($mini_login == true) {
	      include("mini_login.php");
	    }
	  ?>
        </div>
      </div>
      <div id="page_container">
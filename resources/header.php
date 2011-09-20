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
	  <image id="kredimage_logo" src="" width="145" height="45" alt="Kredimage" style="margin-top: 5px; margin-left: 5px; float: left;">
	  <form id="search_form" method="get" action="">
	    <input id="search_box" name="search_terms" type="text">
	    <a id="search_submit" href="#" onclick="this.parentNode.submit()">Search</a>
	  </form>

	  <?php
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

	    if ($logged_in == true) {
	      include("mini_profile.php");
	    }
	    else {
	      include("mini_login.php");
	    }
	  ?>

        </div>
      </div>

      <div id="page_container">
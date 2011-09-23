<?php include("resources/scripts/php/kredimage.php"); ?>
<?php // Functions
  function processCredentials($username,$password) {
    $db_server = connectToDatabase();
    $hashedpass = hashPassword($password);

    if (mysql_num_rows(getLogin($username,$hashedpass)) == 1) {
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['hashedpass'] = $hashedpass;

      sendTo('upload.php');
    }
    else {
      session_start();
      session_destroy(); //just in case
      return "Login incorrect.";
    }

    mysql_close($db_server);
  }
?>
<?php // Processing the login
  if(isset($_GET['login'])) {
    if(isset($_POST['l_username']) && isset($_POST['l_password'])) {
      $attempted_username = $_POST['l_username'];
      $error = processCredentials($_POST['l_username'],$_POST['l_password']);
    }
    else {
      $error = "Please enter your credentials.";
    }
  }

  if(isset($_GET['logout'])) {
    session_start();
    session_destroy();
    $error = "You have logged out.";
  }

  if (isset($_GET['error']) && !isset($error)) {
    $error = $_GET['error'];
  }

  if($error == '') { $error = '<br>'; }
?>
<?php
  include("resources/scripts/php/login.php");
  include("resources/header.php");
?>
<style type="text/css">@import url("resources/styles/login.css");</style>
<div id="login_page">
  <p><span style="font-size: 28px;">Log in to your Kredimage account</span></p>
    <div id="login_form_container">
      <form id="login_form" method="post" action="login.php?login">
	<span class="error"><?php echo $error; ?></span>
	<label for="l_username">Username:</label><input id="l_username" name="l_username" type="text" class="text" value="<?php echo $attempted_username ?>"><br>
	<label for="l_password">Password:</label><input id="l_password" name="l_password" type="password" class="text"><br>
	<input id="l_remember" name="l_remember" type="checkbox"> Remember me<br>
	<input type="submit" value="Login">
      </form>
    </div>
    <div id="register_blurb">
      <p>Don't have an account? Why not? Kredimage is free and awesome. We're offended that you haven't tried it yet.</p>
      <p>But we forgive you. Just head over to our <a href="register.php">registration page</a>.</p>
  </div>
</div>
<?php include("resources/footer.html"); ?>
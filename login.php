<?php
  include("resources/scripts/php/database.php");

  function registerBlurb() {
  echo "
    <div id=\"register_blurb\">
      <p>Don't have an account? Why not? Kredimage is free and awesome. We're offended that you haven't tried it yet.</p>
      <p>But we forgive you. Just head over to our <a href=\"register.php\">registration page</a>.</p>
    </div>";
  }

  function processCredentials($username,$password) {
    $db_server = connectToDatabase();

    $hashedpass = hashPassword($password);
    $username = mysql_real_escape_string($username);
    $hashedpass = mysql_real_escape_string($hashedpass);

    $query = "SELECT * FROM user_registration WHERE username='$username' && hashedpass='$hashedpass'";
    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());
    $results = mysql_num_rows($result);

    if ($results == 1) {
      session_start();
      $results = mysql_fetch_row($result);
      $_SESSION['uniqueid'] = $results[1];
      $_SESSION['username'] = $results[2];

      if($_POST['l_remember'] == true) {
	return "Will remember";
      }
    }
    else {
      session_start();
      session_destroy(); //just in case
      return "Login incorrect.";
    }

    mysql_close($db_server);
  }
?>

<?php
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

  if($error == '') {
    $error = '<br>';
  }
?>

<?php include("resources/header.php"); ?>

<style type="text/css">@import url("resources/styles/login.css");</style>
<div id="login_page">
  <p><span style="font-size: 28px;">Log in to your Kredimage account</span></p>
    <div id="login_form_container">
      <form id="login_form" method="post" action="login.php?login=1">
	    <span class="error"><?php echo $error; ?></span>
	    <label for="l_username">Username:</label><input id="l_username" name="l_username" type="text" class="text" value="<?php echo $attempted_username ?>"><br>
	    <label for="l_password">Password:</label><input id="l_password" name="l_password" type="password" class="text"><br>
	    <input id="l_remember" name="l_remember" type="checkbox"> Remember me<br>
	    <input type="submit">
      </form>
    </div>
  <?php registerBlurb(); ?>
</div>
<?php include("resources/footer.html"); ?>
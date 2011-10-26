<?php
  include("resources/scripts/php/kredimage.php");
  include("resources/scripts/php/login.php");
  if ($logged_in == true) { sendTo('upload.php'); }
?>
<?php // Functions
  function validateUsername($username) {
    if(strlen($username) <= 3) { return "Your username must be between 4 and 20 characters long"; }
    if(strlen($username) > 20) { return "Your username must be between 4 and 20 characters long"; }
    if(preg_match('/^[a-zA-Z0-9*_-]+$/',$username) == 0) { return "Usernames can only use A-Z a-z 0-9 _ - *"; }

    $db_server = connectToDatabase();
    if(!$db_server) die("Couldn't connect to MySQL server: ".mysql_error());

    $username = mysql_real_escape_string($username);
    $query = "SELECT id FROM user_registration WHERE username='$username'";

    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());

    $results = mysql_num_rows($result);
    if ($results >= 1) {
      return "That username is taken. Sorry.";
    }

    mysql_close($db_server);
    return false;
  }

  function validatePassword($password) {
    if(strlen($password) <= 7) { return "Password must be between 8 and 20 characters long"; }
    if(strlen($password) > 20) { return "Password must be between 8 and 20 characters long"; }
    if(preg_match('/^[a-zA-Z0-9*_-]+$/',$password) == 0) { return "Passwords can only use A-Z a-z 0-9 _ - *"; }
    return false;
  }

  function validateConfirm($password,$confirm) {
    if($confirm != $password) { return "Passwords don't match"; }
    return false;
  }

  function validateEmail($email) {
    if(strlen($email) > 100) { return "Email address can't be over 100 characters long"; }
    if(preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/',$email) == 0) { return "That doesn't look like a valid email address"; }
    return false;
  }

  function validateBirthYear($birthyear,$year) {
    if(preg_match('/^[0-9][0-9][0-9][0-9]$/',$birthyear) == 0) { return "Please enter the long (four digit) form of the year you were born"; }
    if(($year - $birthyear) >= 120) { return "The year you entered is impossibly old"; }
    if(($year - $birthyear) < 0 ) { return "The year you entered is in the future"; }
    return false;
  }

  function commitRegistration($username,$password,$email,$birthyear) {
    $randsalt = rand(0,999);

    $validationcode = sha1($username.$randsalt);
    $hashedpass = hashPassword($password);
    $regiyear = date('Y');
    $regimonth = date('m');
    $regiday = date('d');
    $regiaddr = $_SERVER['REMOTE_ADDR'];
    $terms = 1;
    $validated = 0;

    $db_server = connectToDatabase();

    $username = mysql_real_escape_string($username);
    $hashedpass = mysql_real_escape_string($hashedpass);
    $email = mysql_real_escape_string($email);
    $birthyear = mysql_real_escape_string($birthyear);
    $regiyear = mysql_real_escape_string($regiyear);
    $regimonth = mysql_real_escape_string($regimonth);
    $regiday = mysql_real_escape_string($regiday);
    $regiaddr = mysql_real_escape_string($regiaddr);
    $terms = mysql_real_escape_string($terms);
    $validationcode = mysql_real_escape_string($validationcode);
    $validated = mysql_real_escape_string($validated);

    $query = "INSERT INTO user_registration VALUES(NULL,'$username','$hashedpass','$email',$birthyear,$regiyear,$regimonth,$regiday,'$regiaddr',$terms,'$validationcode',$validated)";
    $result = mysql_query($query);
    if(!$result) die("Couldn't commit registration: ".mysql_error());

    mysql_close($db_server);
  }
?>
<?php // Processing the registration
  if(isset($_GET['process'])) {
    $username = $_POST['f_username'];
    $password = $_POST['f_password'];
    $confirm = $_POST['f_confirm'];
    $email = $_POST['f_email_address'];
    $birthyear = $_POST['f_birth_year'];

    $username_error = validateUsername($username);
    $password_error = validatePassword($password);
    $confirm_error = validateConfirm($password,$confirm);
    $email_address_error = validateEmail($email);
    $birth_year_error = validateBirthYear($birthyear,2011);

    if($username_error != false || $password_error != false || $confirm_error != false || $email_addres_error != false || $birth_year_error != false) {
      $error = "There were problems with your registration. Please review them below.";
    }
    elseif ($_POST['f_terms'] != true) {
      $error = "You must agree to our terms and be at least 13 years old.";
    }
    else {
      commitRegistration($username,$password,$email,$birthyear);
      sendTo('login.php');
    }

  }
?>
<?php // Content
  include("resources/header.php");
?>
<script type="text/javascript" src="resources/scripts/js/ajax.js"></script>
<script type="text/javascript" src="resources/scripts/js/registration_client_side.js"></script>
<style type="text/css">@import url("resources/styles/register.css");</style>
<div id="registration_page">
  <p><span style="font-size: 28px;">Register for Kredimage - entirely free!</span>
  </p>

  <p>
    <form id="registration_form" method="post" action="register.php?process">
    <span id="error" class="error"><?php echo $error; ?></span>

	  <label for="f_username">Username:</label>
	  <input id="f_username" name="f_username" type="text" class="text" onChange="usernameValidate()" value="<?php echo $username; ?>">
	  <span id="e_username" class="error"><?php echo $username_error; ?></span>

	  <label for="f_password">Password:</label>
	  <input id="f_password" name="f_password" type="password" class="text" onChange="passwordValidate()">
	  <span id="e_password" class="error"><?php echo $password_error; ?></span>

	  <label for="f_confirm">Confirm Password:</label>
	  <input id="f_confirm" name="f_confirm" type="password" class="text" onChange="confirmValidate()">
	  <span id="e_confirm" class="error"><?php echo $confirm_error; ?></span>

	  <label for="f_email_address">Email Address:</label>
	  <input id="f_email_address" name="f_email_address" type="text" class="text" onChange="emailAddressValidate()" value="<?php echo $email; ?>">
	  <span id="e_email_address" class="error"><?php echo $email_address_error; ?></span>

	  <label for="f_birth_year">Year of birth:</label>
	  <input id="f_birth_year" name="f_birth_year" type="text" class="text" onChange="birthYearValidate()" value="<?php echo $birthyear; ?>">
	  <span id="e_birth_year" class="error"><?php echo $birth_year_error; ?></span><br>
	  <a href="">Is my year of birth really your business?</a>

      <p>
	<div id="terms">
	  <? include("resources/documents/terms.html"); ?>
	</div>
      </p>

      <input id="f_terms" name="f_terms" type="checkbox">I agree to the above terms and I am 13 years of age or older<br>
      <input type="submit" onClick="validateAll()"><br>
    </form>
  </p>
</div>
<?php include("resources/footer.html"); ?>
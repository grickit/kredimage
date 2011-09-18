<?php
  if(isset($_GET['process'])) {
    $username = $_POST['f_username'];
    $password = $_POST['f_password'];
    $confirm = $_POST['f_confirm'];
    $email = $_POST['f_email_address'];
    $birthyear = $_POST['f_birth_year'];

    include("resources/scripts/php/process_registration.php");

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
      header('Location: login.php');
      exit();
    }

  }
?>

<?php include("resources/header.php"); ?>

<script type="text/javascript" src="resources/scripts/js/ajax.js"></script>
<script type="text/javascript" src="resources/scripts/js/registration_client_side.js"></script>
<style type="text/css">@import url("resources/styles/register.css");</style>
<div id="registration_page">
  <p><span style="font-size: 28px;">Register for Kredimage - entirely free!</span>
    <ul>
      <li>Share your artwork with others</li>
      <li>Earn "kredibility" from people who love your art or for helping out around the community</li>
      <li>Self moderating system mitigates the problem of people copying your artwork</li>
    </ul>
  </p>

  <p>
    <form id="registration_form" method="post" action="register.php?process=1">
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
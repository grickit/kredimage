function usernameValidate() {
  username = document.getElementById("f_username").value
  username_regex = /^[a-zA-Z0-9*_-]+$/

  request = ajaxGetRequest("resources/scripts/php/username_taken.php?username="+username)

  request.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
	if (this.responseText != null) {
	  taken = this.responseText

	  if (username.length <= 3) {
	    document.getElementById("e_username").innerHTML = "Your username must be between 4 and 20 characters long"
	    document.getElementById("e_username").className = "error";
	    return false
	  }

	  else if (username.length > 20) {
	    document.getElementById("e_username").innerHTML = "Your username must be between 4 and 20 characters long"
	    document.getElementById("e_username").className = "error";
	    return false
	  }

	  else if (username_regex.test(username) == false) {
	    document.getElementById("e_username").innerHTML = "Usernames can only use A-Z a-z 0-9 _ - *"
	    document.getElementById("e_username").className = "error";
	    return false
	  }

	  else if (taken != "") {
	    document.getElementById("e_username").innerHTML = taken
	    document.getElementById("e_username").className = "error";
	    return false
	  }

	  else {
	    document.getElementById("e_username").innerHTML = "Good!"
	    document.getElementById("e_username").className = "";
	    return true
	  }
	}
      }
    }
  }
  request.send(null)
  return true
}

function passwordValidate() {
  password = document.getElementById("f_password").value
  password_regex = /^[a-zA-Z0-9*_-]+$/
  if (password.length <= 7) {
    document.getElementById("e_password").innerHTML = "Password must be between 8 and 20 characters long"
    document.getElementById("e_password").className = "error";
    return false
  }

  else if (password.length > 20) {
    document.getElementById("e_password").innerHTML = "Password must be between 8 and 20 characters long"
    document.getElementById("e_password").className = "error";
    return false
  }

  else if (password_regex.test(password) == false) {
    document.getElementById("e_password").innerHTML = "Passwords can only use A-Z a-z 0-9 _ - *"
    document.getElementById("e_password").className = "error";
    return false
  }
  else {
    document.getElementById("e_password").innerHTML = "Good!"
    document.getElementById("e_password").className = "";
    return true
  }
}

function confirmValidate() {
  confirm = document.getElementById("f_confirm").value
  password = document.getElementById("f_password").value
  if (password != confirm) {
    document.getElementById("e_confirm").innerHTML = "Passwords don't match"
    document.getElementById("e_confirm").className = "error";
    return false
  }
  else if (passwordValidate() == false) {
    document.getElementById("e_confirm").innerHTML = "There's a problem with your password above"
    document.getElementById("e_confirm").className = "error";
    return false
  }
  else {
    document.getElementById("e_confirm").innerHTML = "Good!"
    document.getElementById("e_confirm").className = "";
    return true
  }
}

function emailAddressValidate() {
  email = document.getElementById("f_email_address").value
  email_regex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/
  if (email_regex.test(email) == false) {
    document.getElementById("e_email_address").innerHTML = "That doesn't look like a valid email address"
    document.getElementById("e_email_address").className = "error";
    return false
  }
  else if (email.length > 100) {
    document.getElementById("e_email_address").innerHTML = "Email addresses can't be over 100 characters long"
    document.getElementById("e_email_address").className = "error";
    return false
  }
  else {
    document.getElementById("e_email_address").innerHTML = "Good!"
    document.getElementById("e_email_address").className = "";
    return true
  }
}

function birthYearValidate() {
  birthyear = document.getElementById("f_birth_year").value
  year = 2011
  difference = year - birthyear
  year_regex = /^[0-9][0-9][0-9][0-9]$/
  if (year_regex.test(birthyear) == false) {
    document.getElementById("e_birth_year").innerHTML = "Please enter the long (four digit) form of the year you were born"
    document.getElementById("e_birth_year").className = "error";
    return false
  }
  else if (difference >= 120) {
    document.getElementById("e_birth_year").innerHTML = "The year you entered is impossibly old"
    document.getElementById("e_birth_year").className = "error";
    return false
  }
  else if (difference < 0) {
    document.getElementById("e_birth_year").innerHTML = "The year you entered is in the future"
    document.getElementById("e_birth_year").className = "error";
    return false
  }
  else {
    document.getElementById("e_birth_year").innerHTML = "Good!"
    document.getElementById("e_birth_year").className = "";
    return true
  }
}

function validateAll() {
  usernameValid = usernameValidate()
  passwordValid = passwordValidate()
  confirmValid = confirmValidate()
  emailAddressValid = emailAddressValidate()
  birthYearValid = birthYearValidate()

  if ((usernameValid && passwordValid && confirmValid && emailAddressValid && birthYearValid) == true) {
    document.getElementById("registration_form").submit()
  }
}

function age_warning() {
  var e = document.getElementById("age_warning");
  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}
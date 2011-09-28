<div id="login_container">
  <form style="margin-top: 1px;" id="login_form" method="post" action="login.php?login&referer=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">
	<input id="l_username" name="l_username" id="l_username" type="text" class="text" placeholder="username"><br>
	<input id="l_password" name="l_password" id="l_password" type="password" class="text" placeholder="password"><br>
	<div style="float: left;"><input id="l_remember" name="l_remember" type="checkbox"> Remember me<br></div>
	<input style="margin-left: 25px;" type="submit" value="Login">
  </form>
</div>
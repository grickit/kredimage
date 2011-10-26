<div id="login_container">
  <a href="profile.php?a=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a><br>
  <a href="login.php?logout&referer=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a>
</div>
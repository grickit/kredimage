<div id="login_container">
  <a href="search.php?mode=user&user=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a><br>
  <a href="upload.php">Upload</a><br>
  <a href="login.php?logout&referer=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Logout</a>
</div>
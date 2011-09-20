<div id="login_container">
  <a href="profile.php?a=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a><br>
  <a href="control_panel.php">Messages (0)</a><br>
  <a href="kredibility.php?a=<?php echo $_SESSION['username']; ?>">Kredibility (5430)</a><br>
  <a href="login.php?logout">Logout</a>
</div>
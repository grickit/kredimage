<?php
  include_once("scripts/php/database.php");
  $db_server = connectToDatabase();

  if (testLogin($_SESSION['username'],$_SESSION['hashedpass']) == 1) {
    // Look up account info
  }
  else {
    session_start();
    session_destroy();
    header('Location: login.php');
    exit();
  }

  mysql_close($db_server);
?>

<div id="login_container">
  <a href="profile.php?a=<?php echo $_SESSION['username']; ?>"><?php echo $_SESSION['username']; ?></a><br>
  <a href="control_panel.php">Messages (0)</a><br>
  <a href="kredibility.php?a=<?php echo $_SESSION['username']; ?>">Kredibility (5430)</a><br>
  <a href="login.php?logout=1">Logout</a>
</div>
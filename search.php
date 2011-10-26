<?php
  include("resources/scripts/php/kredimage.php"); 
  include("resources/scripts/php/login.php");
?>
<?php // Functions

?>
<?php // Processing the page
  $db_server = connectToDatabase();

?>
<?php
  $mini_login = true;
  include("resources/header.php");
?>
<style type="text/css">@import url("resources/styles/art.css");</style>

<?php include("resources/footer.html"); ?>
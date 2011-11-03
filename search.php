<?php
  include("resources/scripts/php/kredimage.php");
  include("resources/scripts/php/login.php");
?>
<?php // Functions

?>
<?php // Processing the page
  $db_server = connectToDatabase();

  $mode = "all";
  if(isset($_GET['mode'])) $mode = $_GET['mode'];
?>
<?php
  $mini_login = true;
  include("resources/header.php");
?>
<style type="text/css">@import url("resources/styles/art.css");</style>
<?php
  switch($mode) {
    case "all":
      $query = "SELECT * FROM image_stats ORDER BY id DESC";
      $result = mysql_query($query);
      while ($row = mysql_fetch_assoc($result)) {
	echo '<img src="images/thumb/'.$row['id'].'.png">';
      }
      break;
  }
?>
<?php include("resources/footer.html"); ?>
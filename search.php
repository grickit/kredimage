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
<style type="text/css">@import url("resources/styles/search.css");</style>
<div id="search_page">
  <?php
    if(isset($_GET['error'])) echo '<p class="error">'.$_GET['error'].'</p>';
    if($logged_in != true) { echo '<p>Have you considered <a href="register.php">registering an account?</a></p>'; }

    switch($mode) {
      case "all":
	$query = "SELECT * FROM image_stats ORDER BY id DESC";
	$result = mysql_query($query);
	break;
      case "user":
	$query = "SELECT image_stats.id, image_stats.name FROM image_stats,image_upload,user_registration WHERE image_stats.id = image_upload.id AND image_upload.owner = user_registration.id AND user_registration.username = '".$_GET['user']."' ORDER BY image_stats.id DESC";
	$result = mysql_query($query);
	break;
    }
    if($result) {
      while ($row = mysql_fetch_assoc($result)) {
	echo '<a class="thumb" href="art.php?id='.$row['id'].'"><img src="images/thumb/'.$row['id'].'.png">'.$row['name'].'</a>';
      }
    }
    else {
      echo "There was an error getting the search results: ".mysql_error();
    }
  ?>
</div>
<?php include("resources/footer.html"); ?>
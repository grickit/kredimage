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
    switch($mode) {
      case "all":
	$query = "SELECT * FROM image_stats ORDER BY id DESC";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
	  echo '<a class="thumb" href="art.php?id='.$row['id'].'"><img src="images/thumb/'.$row['id'].'.png">'.$row['name'].'</a>';
	}
	break;
    }
  ?>
</div>
<?php include("resources/footer.html"); ?>
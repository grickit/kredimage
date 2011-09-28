<?php include("resources/scripts/php/kredimage.php"); ?>
<?php // Functions

?>
<?php // Processing the page
  $image_id;
  if(isset($_GET['id'])) {
    $image_id = $_GET['id'];
  }
  else {
    sendTo("upload.php");
  }
?>
<?php
  include("resources/scripts/php/login.php");
  include("resources/header.php");
?>
<style type="text/css">@import url("resources/styles/art.css");</style>
<div id="art_container">
  <a href="images/full/<?php echo $image_id; ?>.png"><img src="images/small/<?php echo $image_id; ?>.png"></a>
</div>
<div id="stats_page">
  <span style="font-size: 24px;">Image Title</span><br>
  by <a href="profile.php?a=foo">Foo</a><br>
  <p>Lorem ipsum foo bar baz</p>
</div>
<?php include("resources/footer.html"); ?>
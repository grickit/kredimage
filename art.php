<?php
  include("resources/scripts/php/kredimage.php"); 
  include("resources/scripts/php/login.php");
?>
<?php // Functions

?>
<?php // Processing the page
  $db_server = connectToDatabase();

  if(isset($_GET['id']) && is_numeric($_GET['id']) && file_exists($full_directory.$_GET['id'])) {
    $image_id = $_GET['id'];
    $image_id_db = mysql_real_escape_string($image_id);

    $query = "SELECT user_registration.username, user_registration.id FROM user_registration, image_upload WHERE image_upload.id = '$image_id_db' AND user_registration.id = image_upload.owner";
    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());
    $row = mysql_fetch_array($result);
    $owner_username = $row['username'];
    $owner_id = $row['id'];
    $query = "SELECT name, description FROM image_stats WHERE id = '$image_id_db'";
    $result = mysql_query($query);
    if(!$result) die("Couldn't lookup username: ".mysql_error());
    $row = mysql_fetch_array($result);
    $image_title = $row['name'];
    $image_desc = $row['description'];
  }
  else {
    sendTo("upload.php");
  }

  if(isset($_GET['comment']) && isset($_POST['c_text'])) {
    if($logged_in == true) {
      $text = $_POST['c_text'];
      $query = "INSERT INTO image_comments VALUES (NULL,'$image_id','$owner_id','$text')";
      $result = mysql_query($query);
    }
  }
?>
<?php
  $mini_login = true;
  include("resources/header.php");
?>
<style type="text/css">@import url("resources/styles/art.css");</style>
<div id="art_container">
  <a href="images/full/<?php echo $image_id; ?>.png"><img src="images/small/<?php echo $image_id; ?>.png"></a>
</div>
<div id="stats_page">
  <span style="font-size: 24px;"><?php echo $image_title; ?></span><br>
  by <a href="profile.php?a=<?php echo $owner_username; ?>"><?php echo $owner_username; ?></a><br>
  <p><?php echo $image_desc; ?></p>
</div>

<div id="comments_page">

  <div id="ad_section">
    <img src="resources/images/fake_ad.png" alt="fake advertisement">
  </div>

  <div id="comment_entry_area">
    <form id="content_entry_form" method="POST" action="art.php?id=<?php echo $image_id ?>&comment">
      <textarea name="c_text"></textarea>
      <input type="submit" name="c_submit" value="Submit">
    </form>
  </div>
</div>
<?php include("resources/footer.html"); ?>
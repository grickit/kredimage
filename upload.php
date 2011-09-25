<?php
  include("resources/scripts/php/kredimage.php");
  include("resources/scripts/php/login.php");
  if ($logged_in != true) { sendToLogin('You must be logged in to upload images.'); }
?>
<?php // Process the upload
  $error = '<br>';

  if (isset($_GET['upload'])) {
    if($_FILES["u_file"]["error"] > 0) {
      $error = "Error: " . $_FILES["u_file"]["error"] . "<br>";
    }
    else {
      $type = $_FILES["u_file"]["type"];
      if(($type != "image/jpeg") && ($type != "image/png") && ($type != "image/gif")) {
	$error = "Unknown filetype " . $type . "<br>";
      }
      else {

	$db_server = connectToDatabase();
	$owner = $loginData['id'];
	$uploadyear = date('Y');
	$uploadmonth = date('m');
	$uploadday = date('d');
	$uploadaddr = $_SERVER['REMOTE_ADDR'];
	$uploadtype = $type;

	$owner = mysql_real_escape_string($owner);
	$uploadyear = mysql_real_escape_string($uploadyear);
	$uploadmonth = mysql_real_escape_string($uploadmonth);
	$uploadday = mysql_real_escape_string($uploadday);
	$uploadaddr = mysql_real_escape_string($uploadaddr);
	$uploadtype = mysql_real_escape_string($uploadtype);

	$query = "INSERT INTO image_upload VALUES(NULL,'$owner','$uploadyear','$uploadmonth','$uploadday','$uploadaddr','$uploadtype')";
	$result = mysql_query($query);
	if(!$result) die("Couldn't commit registration: ".mysql_error());

	$id = mysql_insert_id($db_server);

	$contents = file_get_contents($_FILES["u_file"]["tmp_name"]);
	file_put_contents($full_directory.$id,$contents);
	sendTo("resources/scripts/php/image.php?id=$id");
      }
    }
  }
?>
<?php include("resources/header.php"); ?>
<style type="text/css">@import url("resources/styles/upload.css");</style>
<div id="upload_page">
<p><span style="font-size: 28px;">Upload an image to your Kredimage account</span></p>
  <span class="error"><?php echo $error; ?></span>
  <div id="upload_form_container">
    <form id="upload_form" method="post" action="upload.php?upload" enctype="multipart/form-data">
      <input id="u_file" name="u_file" type="file"><br>
      <input id="u_submit" type="submit" value="Upload">
    </form>
  </div>
</div>
<?php include("resources/footer.html"); ?>
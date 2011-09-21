<?php include("resources/scripts/php/kredimage.php"); ?>

<?php
  $error = '<br>';

  if (isset($_GET['upload'])) {
    if($_FILES["u_file"]["error"] > 0) {
      $error = "Error: " . $_FILES["u_file"]["error"] . "<br>";
    }
    else {
      $type = $_FILES["u_file"]["type"];
      if(($type != "image/jpeg") && ($type != "image/png") && ($type != "image/gif")) {
	$error = "Unknown filetype " . $_FILES["u_file"]["type"] . "<br>";
      }
      else {
	$contents = file_get_contents($_FILES["u_file"]["tmp_name"]);
	$base64 = base64_encode($contents);
	file_put_contents($storage_directory."foo",$base64);
	sendTo("resources/scripts/php/image.php");
      }
    }
  }
?>

<?php
  include("resources/header.php");
  if ($logged_in != true) { sendToLogin('You must be logged in to upload images.'); }
?>

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
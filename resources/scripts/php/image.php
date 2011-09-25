<?php
  include("secrets.php");

  function loadImage($location) {
    $contents = file_get_contents($location);
    return imagecreatefromstring($contents);
  }

  function getImageInfo($location) { return getimagesize($location); }

  function getImageType($location) {
    $image_info = getImageInfo($location);
    return $image_info[2];
  }

  function getImageMime($location) {
    $image_info = getImageInfo($location);
    return image_type_to_mime_type($image_info[2]);
  }

  function getImageWidth($image) { return imagesx($image); }

  function getImageHeight($image) { return imagesy($image); }

  function resizeImage($image,$image_type,$width,$height) {
    $resized = imagecreatetruecolor($width,$height);
    $transparency = imagecolortransparent($image);

    if($transparency >= 0) {
      $transparent_color = imagecolorsforindex($image,$transparency);
      $transparency = imagecolorallocate($resized,$transparent_color['red'],$transparent_color['green'],$transparent_color['blue']);
      imagefill($resized,0,0,$transparency);
      imagecolortransparent($resized,$transparency);

    }
    elseif($image_type == IMAGETYPE_PNG) {
      $transparency_color = imagecolorallocatealpha($resized,0,0,0,127);
      imagefill($resized,0,0,$transparency_color);
    }
    imagecopyresampled($resized,$image,0,0,0,0,$width,$height,getImageWidth($image),getImageHeight($image));
    return $resized;
  }

  function resizeImageToWidth($image,$image_type,$width) {
    $percent = $width / getImageWidth($image);
    $height = getImageHeight($image) * $percent;
    return resizeImage($image,$image_type,$width,$height);
  }

  function resizeImageToHeight($image,$image_type,$height) {
    $percent = $height / getImageHeight($image);
    $width = getImageWidth($image) * $percent;
    return resizeImage($image,$image_type,$width,$height);
  }

  function resizeImageToNumber($image,$image_type,$number) {
    if ((getImageWidth($image) > $number) || (getImageHeight($image) > $number)) {
      if (getImageWidth($image) >= getImageHeight($image)) {
	return resizeImageToWidth($image,$image_type,$number);
      }
      else {
	return resizeImageToHeight($image,$image_type,$number);
      }
    }
    else {
      return $image;
    }
  }

  function outputImage($image,$image_type) {
    if( $image_type == IMAGETYPE_JPEG ) { imagejpeg($image); }
    elseif( $image_type == IMAGETYPE_GIF ) { imagegif($image); }
    elseif( $image_type == IMAGETYPE_PNG ) { imagepng($image); }
  }

  function loadAndOutputImage($location) {
    header("Content-type: ".getImageMime($location));
    $image = loadImage($location);
    $image_type = getImageType($location);
    imagealphablending($image,false);
    imagesavealpha($image,true);
    outputImage($image,$image_type);
    exit();
  }

  function loadResizeAndOutputImage($location,$number) {
    header("Content-type: ".getImageMime($location));
    $image = loadImage($location);
    $image_type = getImageType($location);
    $image = resizeImageToNumber($image,$image_type,$number);
    imagealphablending($image,false);
    imagesavealpha($image,true);
    outputImage($image,$image_type);
    exit();
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_GET['json'])) {
      // TODO: Echo information about the image in JSON format
    }
    else {
      if (isset($_GET['small'])) {
	if (file_exists($small_directory.$id)) {
	  loadAndOutputImage($small_directory.$id);
	}
	else {
	  loadResizeAndOutputImage($full_directory.$id,600);
	}
      }

      elseif (isset($_GET['thumb'])) {
	if (file_exists($thumb_directory.$id)) {
	  loadAndOutputImage($thumb_directory.$id);
	}
	else {
	  loadResizeAndOutputImage($full_directory.$id,90);
	}
      }

      else {
	loadAndOutputImage($full_directory.$id);
      }
    }
  }
?>
<?php
  include("secrets.php");

  function loadImage($location) { // Load image from file
    $contents = file_get_contents($location);
    return imagecreatefromstring($contents);
  }

  function getImageInfo($location) { return getimagesize($location); } // Get metadata about the image

  function getImageType($location) { // Extract the filetype from the metadata
    $image_info = getImageInfo($location);
    return $image_info[2];
  }

  function getImageMime($location) { // Convert filetype to mimetype
    $image_info = getImageInfo($location);
    return image_type_to_mime_type($image_info[2]);
  }

  function getImageWidth($image) { return imagesx($image); } // Get the width of the image

  function getImageHeight($image) { return imagesy($image); } // Get the height of the image

  function resizeImage($image,$image_type,$width,$height) { // Resize the image
    $resized = imagecreatetruecolor($width,$height); # Create a blank canvas
    $transparency = imagecolortransparent($image);

    if($transparency >= 0) { # If the image already has a transparent color, inject it into the canvas
      $transparent_color = imagecolorsforindex($image,$transparency);
      $transparency = imagecolorallocate($resized,$transparent_color['red'],$transparent_color['green'],$transparent_color['blue']);
      imagefill($resized,0,0,$transparency);
      imagecolortransparent($resized,$transparency);
    }
    elseif($image_type == IMAGETYPE_PNG) { # All pngs need a base transparency
      $transparency_color = imagecolorallocatealpha($resized,0,0,0,127);
      imagefill($resized,0,0,$transparency_color);
    }
    imagecopyresampled($resized,$image,0,0,0,0,$width,$height,getImageWidth($image),getImageHeight($image)); # Copy the image onto the canvas
    return $resized;
  }

  function resizeImageToWidth($image,$image_type,$width) { // Resize the image proportionally to a specific width
    $percent = $width / getImageWidth($image);
    $height = getImageHeight($image) * $percent;
    return resizeImage($image,$image_type,$width,$height);
  }

  function resizeImageToHeight($image,$image_type,$height) { // Resize the image proportionally to a specific height
    $percent = $height / getImageHeight($image);
    $width = getImageWidth($image) * $percent;
    return resizeImage($image,$image_type,$width,$height);
  }

  function resizeImageToNumber($image,$image_type,$number) { // Resize the image proportionally so that the largest dimension equals a given number
    if ((getImageWidth($image) > $number) || (getImageHeight($image) > $number)) { # This function is used blindly, and may not be needed
      if (getImageWidth($image) >= getImageHeight($image)) { # Do we use width or height?
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

  function outputImage($image,$image_type) { // Put the image to the browser
    if($image_type == IMAGETYPE_JPEG) { imagejpeg($image); }
    elseif($image_type == IMAGETYPE_GIF) { imagegif($image); }
    elseif($image_type == IMAGETYPE_PNG) { imagepng($image); }
  }

  function saveImage($image,$image_type,$location) { // Save the image to a file
    if($image_type == IMAGETYPE_JPEG) { imagejpeg($image,$location); }
    elseif($image_type == IMAGETYPE_GIF) { imagegif($image,$location); }
    elseif($image_type == IMAGETYPE_PNG) { imagepng($image,$location); }
  }

  function loadAndOutputImage($location) { // Load an image and output it
    header("Content-type: ".getImageMime($location));
    echo file_get_contents($location);
    exit();
  }

  function loadResizeOutputAndSaveImage($location,$number,$location2) { // Load an image, resize it, output it, and save it
    header("Content-type: ".getImageMime($location));
    $image = loadImage($location);
    $image_type = getImageType($location);
    $image = resizeImageToNumber($image,$image_type,$number);
    imagealphablending($image,false);
    imagesavealpha($image,true);
    outputImage($image,$image_type);
    saveImage($image,$image_type,$location2);
    exit();
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_GET['json'])) { # Want json?
      // TODO: Echo information about the image in JSON format
      $image = loadImage($full_directory.$id);
      header('Content-type: application/json');
      echo "{\n";
      echo "  \"image ".$id."\": {\n";
      echo "    \"width\": \"".getImageWidth($image)."\"\n";
      echo "    \"height\": \"".getImageheight($image)."\"\n";
      echo "  }\n";
      echo "}\n";
      exit();
    }
    else {
      if (isset($_GET['small'])) { # Want small?
	if (file_exists($small_directory.$id)) { # Already have small?
	  loadAndOutputImage($small_directory.$id);
	}
	else {
	  loadResizeOutputAndSaveImage($full_directory.$id,600,$small_directory.$id); # Make small
	}
      }

      elseif (isset($_GET['thumb'])) { # Want thumbnail?
	if (file_exists($thumb_directory.$id)) { # Already have thumbnail?
	  loadAndOutputImage($thumb_directory.$id);
	}
	else {
	  loadResizeOutputAndSaveImage($full_directory.$id,120,$thumb_directory.$id); # Make thumbnail
	}
      }

      else {
	loadAndOutputImage($full_directory.$id);
      }
    }
  }
?>
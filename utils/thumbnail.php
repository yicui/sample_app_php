<?php
  function make_thumbnail($portraitURL, $thumbnailURL, $resize_width, $resize_height, $isCut) {
    // image types
    $type = substr(strrchr($portraitURL, "." ), 1);

    // initialize
    if ($type == "jpg") $im = imagecreatefromjpeg ($portraitURL);
    if ($type == "gif") $im = imagecreatefromgif ($portraitURL);
    if ($type == "png") $im = imagecreatefrompng ($portraitURL);

    if(!$im) {
      // Create a default image reporting thumbnail unavailable.
      // The uploaded file might be a fake, or legitimate image of ancient formats. We just don't know.
      $im  = imagecreatetruecolor(300, 400);
      $bgc = imagecolorallocate($im, 255, 255, 255);
      $tc  = imagecolorallocate($im, 0, 0, 0);

      magefilledrectangle($im, 0, 0, 300, 400, $bgc);

      imagestring($im, 4, 50, 150, 'Thumbnail Not Available', $tc);
      imagejpeg($im, $thumbnailURL);
      imagedestroy($im);
      return;
    }

    $width = imagesx ($im);
    $height = imagesy ($im);
    $resize_ratio = ($resize_width) / ($resize_height);
    // Ratio of the uploaded image
    $ratio = ($width) / ($height);
    if (($isCut) == 1) // crop
      if ($ratio >= $resize_ratio) { // picture too wide
        $newimg = imagecreatetruecolor ($resize_width, $resize_height);
        imagecopyresampled ($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, (($height) * $resize_ratio), $height);
        imagejpeg($newimg, $thumbnailURL) or die("Failed to create thumbnail");
      }
      else { // picture too tall
      $newimg = imagecreatetruecolor ($resize_width, $resize_height);
      imagecopyresampled ($newimg, $im, 0, 0, 0, 0, $resize_width, $resize_height, $width, (($width) / $resize_ratio));
      imagejpeg($newimg, $thumbnailURL) or die("Failed to create thumbnail");
    } 
    else { // not crop, which results in a smaller thumbnail
      if ($ratio >= $resize_ratio) {
        $newimg = imagecreatetruecolor ($resize_width, ($resize_width) / $ratio);
        imagecopyresampled ($newimg, $im, 0, 0, 0, 0, $resize_width, ($resize_width) / $ratio, $width, $height);
        imagejpeg($newimg, $thumbnailURL) or die("Failed to create thumbnail");
      }
      if ($ratio < $resize_ratio) {
        $newimg = imagecreatetruecolor (($resize_height) * $ratio, $resize_height);
        imagecopyresampled ($newimg, $im, 0, 0, 0, 0, ($resize_height) * $ratio, $resize_height, $width, $height);
        imagejpeg($newimg, $thumbnailURL) or die("Failed to create thumbnail");
      }
    }
    imagedestroy($im);
  }
?>


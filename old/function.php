<?php session_start();


date_default_timezone_set('Asia/Colombo');
/**
 * Image resize while uploading
 * @author Resalat Haque
 * @link http://www.w3bees.com/2013/03/resize-image-while-upload-using-php.html
 */
 
/**
 * Image resize
 * @param int $width
 * @param int $height
 */
function resize($width, $height){

	if ($_SESSION["tmp_img_path"]==""){	
		$curdatetime=date("Y-m-d H:m:s");
		$curdatetime1=str_replace("-","_", $curdatetime);  
		$curdatetime2=str_replace(" ","_", $curdatetime1);  
		$curdatetime3=str_replace(":","_", $curdatetime2);  
		$path1="upload/".$curdatetime3."/";
		$_SESSION["tmp_img_path"]=$path1;
	}	
	
	if (!file_exists($_SESSION["tmp_img_path"])) {
		
    	mkdir($_SESSION["tmp_img_path"], 0777, true);
	}		
	/* Get original image x y*/
	list($w, $h) = getimagesize($_FILES['image']['tmp_name']);
	/* calculate new image size with ratio */
	$ratio = max($width/$w, $height/$h);
	$h = ceil($height / $ratio);
	$x = ($w - $width / $ratio) / 2;
	$w = ceil($width / $ratio);
	/* new file name */
	//$path = 'upload/'.$width.'x'.$height.'_'.$_FILES['image']['name'];
	$path = $_SESSION["tmp_img_path"].$width.'x'.$height.'_'.$_FILES['image']['name'];
	/* read binary data from image file */
	$imgString = file_get_contents($_FILES['image']['tmp_name']);
	/* create image from string */
	$image = imagecreatefromstring($imgString);
	$tmp = imagecreatetruecolor($width, $height);
	imagecopyresampled($tmp, $image,
  	0, 0,
  	$x, 0,
  	$width, $height,
  	$w, $h);
	/* Save image */
	switch ($_FILES['image']['type']) {
		case 'image/jpeg':
			imagejpeg($tmp, $path, 100);
			break;
		case 'image/png':
			imagepng($tmp, $path, 0);
			break;
		case 'image/gif':
			imagegif($tmp, $path);
			break;
		default:
			exit;
			break;
	}

if ($width==680){	
	// Load the stamp and the photo to apply the watermark to
$stamp = imagecreatefrompng('stamp.png');
$im = imagecreatefromjpeg($path);

// Set the margins for the stamp and get the height/width of the stamp image
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Copy the stamp image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the stamp. 
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

// Output and free memory

imagepng($im,$path);
imagedestroy($im);
}
	return $path;
	/* cleanup memory */
	imagedestroy($image);
	imagedestroy($tmp);
}
?>
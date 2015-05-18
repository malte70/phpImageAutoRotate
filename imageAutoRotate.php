<?php


function imageAutoRotate($originalFilename) {
	if (mime_content_type($originalFilename) != "image/jpeg")
		return False;
	$exif = exif_read_data($originalFilename);
	if(!$exif || !isset($exif['Orientation'])) {
		return false;
	} else {
		$orientation = $exif['Orientation'];
		$img = imagecreatefromjpeg($originalFilename);
		$mirror = false;
		$deg    = 0;

		switch ($orientation) {
			case 2:
				$mirror = true;
				break;
			case 3:
				$deg = 180;
				break;
			case 4:
				$deg = 180;
				$mirror = true;  
				break;
			case 5:
				$deg = 270;
				$mirror = true; 
				break;
			case 6:
				$deg = 270;
				break;
			case 7:
				$deg = 90;
				$mirror = true; 
				break;
			case 8:
				$deg = 90;
				break;
		}
		if ($deg)
			$img = imagerotate($img, $deg, 0); 
		if ($mirror)
			$img = imageflip($img, IMG_FLIP_BOTH);
		return imagejpeg($img);
	}
}

if (PHP_SAPI == 'cli' && __FILE__ == $argv[0]) {
	if (count($argv)!=2)
		die("Usage: php imageAutoRotate.php <image>\n");

	echo imageAutoRotate($argv[1]);
}
?>

<?php

//reference:http://webcheatsheet.com/php/create_thumbnail_images.php
function createThumbsFromPNG($src, $thumbHeight)
{	
	//load image and get image size
	$image = imagecreatefrompng($src);
	$width = imagesx($image);
	$height = imagesy($image);
	
	//calculate thumnail size
	$new_height = $thumbHeight;
	$new_width = floor( $width * ($thumbHeight/$height));
	
	//create a new temporary image
	$tmp_img = imagecreatetruecolor($new_width, $new_height);
		
	//copy and resize old image into new image
	imagecopyresized($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	ob_start();
	imagepng($tmp_img, null, 100);
	$image_data = ob_get_contents();
	ob_end_clean();
	
	return $image_data;
	}

function createThumbsFromJPG($src, $thumbHeight){
	//load image and get image size
	$image = imagecreatefromjpeg($src);
	$width = imagesx($image);
	$height = imagesy($image);
	
	//calculate thumnail size
	$new_height = $thumbHeight;
	$new_width = floor( $width * ($thumbHeight/$height));
	
	//create a new temporary image
	$tmp_img = imagecreatetruecolor($new_width, $new_height);
		
	//copy and resize old image into new image
	imagecopyresized($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
	
	ob_start();
	imagejpeg($tmp_img, null, 100);
	$image_data = ob_get_contents();
	ob_end_clean();
	
	return $image_data;
	}


?>
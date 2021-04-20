<?php

function imageresize($max_width,$max_height,$image)
{
	$dimensions=getimagesize(str_replace(' ','%20',trim($image)));
	

	if($dimensions[0]>0)
		$width_percentage=$max_width/$dimensions[0];
	else
		$width_percentage=$max_width;
	
		
	if($dimensions[1]>0)
		$height_percentage=$max_height/$dimensions[1];
	else
		$height_percentage=$max_height;
		
	
	if($width_percentage <= $height_percentage)
	{
		$new_width=$width_percentage*$dimensions[0];
		$new_height=$width_percentage*$dimensions[1];
	}
	else
	{
		$new_width=$height_percentage*$dimensions[0];
		$new_height=$height_percentage*$dimensions[1];
	}
	
	$new_image=array($new_width,$new_height);
	return $new_image;
}



?>
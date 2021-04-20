<?php
class createThubmbNail
{	
	function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth,$thumbHight,$fname)
	{	  
	//print "$pathToImages,<br> $pathToThumbs, <br>$thumbWidth,<br>$fname";
	//die;
		$dir = opendir( $pathToImages );
		$info = pathinfo($pathToImages . $fname);			
		//print $info['extension'];
		if ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' )
		{						  
			$img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
		}elseif ( strtolower($info['extension']) == 'png'){
		
			$img = imagecreatefrompng( "{$pathToImages}{$fname}" );
		}
		elseif ( strtolower($info['extension']) == 'gif'){
		
			$img = imagecreatefromgif( "{$pathToImages}{$fname}" );
		}

			$width = @imagesx($img);
			$height = @imagesy($img);			  
			$new_width = $thumbWidth;
			//$new_height = floor( $height * ( $thumbWidth / $width ) );	
			$new_height = $thumbHight;
			
			$tmp_img = @imagecreatetruecolor( $new_width, $new_height );	
			@imagecopyresampled( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );	
			$imgg=explode(".","{$fname}");
			//$img1=$imgg[0]."_".$_SESSION['MemberIno']['UserId'].".".$imgg[1];
			//$img1=$imgg[0].$_SESSION['MemberIno']['UserId'].".".$imgg[1];
			$img1=$fname;
			
		if ( strtolower($info['extension']) == 'png')
		{						
		  
			imagepng( $tmp_img, "{$pathToThumbs}{$img1}" );	  
		}elseif ( strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' ){
			imagejpeg( $tmp_img, "{$pathToThumbs}{$img1}" );	
		}
		elseif ( strtolower($info['extension']) == 'gif') {
			imagegif( $tmp_img, "{$pathToThumbs}{$img1}" );	
		}	  
	}
}
$thumb = new createThubmbNail();
//createThumbs("upload/","upload/thumbs/",100,$fname);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Esthetic Planet ::.</title>
<link href="includes/main.css" rel="stylesheet" type="text/css" />
<link href="includes/main2.css" rel="stylesheet" type="text/css" />
<link href="includes/main3.css" rel="stylesheet" type="text/css" />
<link href="includes/hoverbox.css" rel="stylesheet" type="text/css" />
<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox() 
    })	
</script>
<script type="text/javascript" src="js/animatedcollapse.js"></script>
<script type="text/javascript" src="js/jquery-1.3.1.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){									   
				//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
				//Full Caption Sliding (Hidden to Visible)
				$('.boxgrid.captionfull').hover(function(){
					document.getElementById("image_121").src = 'images/box_1l.jpg';
					$(".cover", this).stop().animate({top:'80px'},{queue:false,duration:160});
				}, 
				
				function() {
					document.getElementById("image_121").src = 'images/box_1.jpg';
					$(".cover", this).stop().animate({top:'180px'},{queue:false,duration:160});
				});
			
			});
		</script>
</head>
<body>
<!--Start Page Holder -->
<div id="page_holder">
	<!--Start page_panel -->
	<div id="page_panel">
		<div id="header" style="border-bottom:1px solid #ADADAD;"><img src="images/top-header.gif" /><!--<img src="images/header.jpg" />--></div>
		
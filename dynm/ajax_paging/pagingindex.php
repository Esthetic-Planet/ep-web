<?
/*
INDEX FILE
PLEASE DON'T CHANGE ANY FILENAMES, REFERENCES OTHER THAN WHAT IS INSTRUCTED THANK YOU
1. Please refer to config/config.php for initial configuration
2. set your preference (whether to use ajax or simple href link) in refresher.php file

-I am sharing this under a GPL distribution
-for any questions regarding usage, problems, questions and/or suggestions please email me at jan@bitpacket.com

*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Paging AJAX</title>
<link type="text/css" rel="stylesheet" href="main.css"  />
<script language="javascript" type="text/javascript" src="jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="pagingajax.js"></script>
</head>
<body>

	
<div id="wrapper">
   	<div id="preloader"><img src="preloader.gif" />
  <div>Loading Data...</div></div>
  <div id='container'><? require "refresher.php"; ?></div>
        
</div>


<h2>Paging queries using AJAX (jQUERY)</h2>
by jannerel roche<br />

comments and suggestions? please email me at <a href="mailto:jan@creatusadvertising.com">jan@creatusadvertising.com</a>



</body></html>

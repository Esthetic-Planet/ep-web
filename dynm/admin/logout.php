<?php
	require_once("../includes/global.inc.php");
	ob_start();
	session_destroy();
	$url = "index.php?msg=logout";
	header("Location: $url");
	exit;
?>
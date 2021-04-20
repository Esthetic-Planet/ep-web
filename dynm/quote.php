<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$qid = $_REQUEST["qid"];
$clid = $_REQUEST["clid"];

if($qid == "2")
{
	$page = "dental_form.php?qid=".$qid."&clid=".$clid;
}
else if($qid == "3")
{
	$page = "hair_form.php?qid=".$qid."&clid=".$clid;
}
else if($qid == "4")
{
	$page = "eye_form.php?qid=".$qid."&clid=".$clid;
	//$page = "servicelist.php";
}
else if($qid == "6")
{
	$page = "plastic_surgery_form.php?qid=".$qid."&clid=".$clid;
}

header("Location: $page");
?>
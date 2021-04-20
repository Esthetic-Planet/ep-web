<?php



include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

$AuthAdmin->ChkLogin();

$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")

{		

	$ReqArr = $_REQUEST;

	$ConArr = array();		

	foreach($ReqArr as $k=>$v)

	{

		if($k=="name" || $k=='dest_id' || $k=='title' || $k=="pageurl" || $k=="metaKeyword" || $k=="metaDesc" || $k=="pageLink" || $k=="short_desc" || $k=="long_desc"	    || $k=="status")

		$ConArr[$k]=addslashes($v);

	}

		

	$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

	$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

	$intResult = $sql->SqlInsert('mos_tblWebpage',$ConArr);

	if($intResult)

	{

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';

		echo '<input type="hidden" name="msg" id="msg" value="added">';

		echo '</form>';

		echo '<script type="text/javascript">document.frmSu.submit();</script>';

		echo '</body>';

	}

	else

	{

	 	$sqlError=mysql_error();

	}

}



else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['id']))

{		

	$ReqArr = $_REQUEST;

	$ConArr = array();		

	foreach($ReqArr as $k=>$v)

	{

		if($k=="name" || $k=='dest_id' || $k=='title' ||  $k=="pageurl" || $k=="metaKeyword" || $k=="metaDesc" || $k=="pageLink" || $k=="short_desc" || $k=="long_desc" || $k=="status")

		$ConArr[$k]=addslashes($v);

	}

	$CondArr = " WHERE id = ".$_REQUEST['id'];

	$sql->SqlUpdate('mos_tblWebpage',$ConArr,$CondArr);		

	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';

	echo '<input type="hidden" name="msg" id="msg" value="update">';

	echo '</form>';

	echo '<script type="text/javascript">document.frmSu.submit();</script>';

	echo '</body>';		

	exit;

}



if(isset($_REQUEST['id']) && ($_REQUEST['mode']=='edit') && !isset($_REQUEST['Submit']))

{

	$id = $_REQUEST['id'];

	$ConArr = " WHERE id= '$id' "; 						

	$arrArticle = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr);

	$count = $arrArticle['count'];

	$Data = $arrArticle['Data'];		 

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />

<title>:: <?=$sitename?> ::</title>

<link href="script/style.css" rel="stylesheet" type="text/css">

<link href="script/admin.css" rel="stylesheet" type="text/css">

<SCRIPT language=javascript src="../js/validation.js"></SCRIPT>

<script>

//STEP 9: prepare submit FORM function

function SubmitForm(formnm)

{

   if(!JSvalid_form(formnm))

   {

		return false;

	}

}		

</script>

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?>
<div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="write_page_url.php">Add/Edit Page Urls</a></div></td></tr>

  <tr>

   <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

     <tr>

       <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>

       <td width="14" valign="top">&nbsp;</td>

       <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" >

		<tr><td colspan="2" valign="top" class="top_bar">Update Page Urls</td></tr>

		<tr>

			<td class="top_bar2" valign="top"> <!--<a href="javascript: history.back()">Back</a> --> </td>

			<td width="200" valign="top" class="top_bar2"></td>

		</tr>

	  </table>	<br />

	<? include('mod_url_rewrite.php'); ?>

	  </td>

      </tr>

   </table></td>

  </tr>

  <tr><td valign="top"><?php include_once('include/footer.php');?></td> </tr>

</table>

</body>

</html>


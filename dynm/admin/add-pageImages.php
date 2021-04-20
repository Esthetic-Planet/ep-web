<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
include_once(_CLASS_PATH."/class.upload.php");
$AuthAdmin->ChkLogin();

$pageid="";
if(isset($_REQUEST['pageid']) && $_REQUEST['pageid'] != "")
{
	$pageid =$_REQUEST['pageid'];
}	
	
 if(isset($_POST['Submit']) && $_POST['Submit']=="Submit")
{		
	$pageid =$_POST['pageid'];

	$ConArr = array();		
	$uploaddir = _UPLOAD_FILE_PATH.'webpage_images/';

	if($_FILES['pageimage']['name']!="")
	{
		$file =  time()."_".basename($_FILES['pageimage']['name']);
	    $uploadfile = $uploaddir . $file;
		move_uploaded_file($_FILES['pageimage']['tmp_name'], $uploadfile);

		
		$ConArr['imageName'] = $file;
		$ConArr['pageId'] = $pageid;
		$ConArr['status'] = "active";
		$ConArr['addDate'] = time();

		$intResult = $sql->SqlInsert('mos_tblWebpageImages',$ConArr);		

		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-pageImages.php?pageid='.$pageid.'">';
		echo '<input type="hidden" name="msg" id="msg" value="update">';
		echo '<input type="hidden" name="page" value="'.$page.'">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;
	}	
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
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="top"><?php include_once('include/header.php');?></td> </tr>
 <tr>
  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
    <td width="14" valign="top">&nbsp;</td>
    <td valign="top">
	 <form name="frmAddBrands" action="" method="post"  enctype="multipart/form-data">
	 <input type="hidden" name="pageid" value="<?=$pageid; ?>">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
           <td><h1>Manage Page Images </h1></td>
          </tr>
         </table></td>
        </tr>
	   <tr>
        <td valign="top" align="center"><?php if($sqlError!="") { ?><span class="loginErrBox" style="margin:15px;"><?=$sqlError?></span><?php } ?></td>
       </tr>
	   <tr><td valign="top" align="center">&nbsp;</td></tr>
       <tr>
        <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
         <tr>
			<td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		  </tr>

		  <tr>
			<td align="right" valign="top" class="normal_text_blue">Upload Image:</td>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top" class="normal_text_blue"><input name="pageimage" type="file" class="textarea2" size="34">
			  <br>(For best view upload an image of 425 x 160  resolution)</td>
		  </tr>


		  <tr height="20"><td align="left" valign="top" colspan="3">&nbsp;</td></tr>

		  <tr height="20">
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top"><input type="submit" class="btn" name="Submit" value="Submit"></td>
		 </tr>
		</table></td>
	  </tr>
	  <tr>
		<td valign="top">&nbsp;</td>
	  </tr>
	</table>
	</form>
	</td>
  </tr>
</table></td>
</tr>
 <tr><td valign="top"><?php include_once('include/footer.php');?></td> </tr>
</table>
</body>
</html>
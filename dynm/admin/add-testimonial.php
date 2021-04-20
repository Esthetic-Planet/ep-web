<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
include_once(_CLASS_PATH."/class.upload.php");
$AuthAdmin->ChkLogin();
$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$sqlError="";
if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")
{		
		$ReqArr = $_REQUEST;
		$ConArr = array();		
		foreach($ReqArr as $k=>$v)
		{
			if($k=="tName" || $k=='tDesc' || $k=="status")
				$ConArr[$k]=addslashes($v);
		}
		
		$ConArr['tUser'] = $_REQUEST['tUser'] ;
		$ConArr['tCompany'] =  $_REQUEST['tCompany'] ;


		$ConArr['addedDate'] = date("Y-m-d h:i:s",time());
		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		
		$intResult = $sql->SqlInsert('mos_tbltestimonial',$ConArr);
		if($intResult)
		{
			$_SESSION["msg"] = "added";
			header("location:list-testimonial.php");
			die();
		}
		else
		{
		 	$sqlError=mysql_error();
		}
		
	}
	else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['tid']))
	{		
		$ReqArr = $_REQUEST;
		$ConArr = array();		
		foreach($ReqArr as $k=>$v)
		{
			if($k=="tName" || $k=='tDesc' || $k=="status")
				$ConArr[$k]=addslashes($v);
		}
		//print_r($ConArr);exit;
		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());	
		$CondArr = " WHERE tid = ".$_REQUEST['tid'];
		$intResult = $sql->SqlUpdate('mos_tbltestimonial',$ConArr,$CondArr);		
		
		$_SESSION["msg"] = "update";
		header("location:list-testimonial.php");
		die();
	}
	
	if(isset($_REQUEST['tid']) && ($_REQUEST['mode']=='edit'))
	{
		$id = $_REQUEST['tid'];
		$ConArr = " WHERE tid= '$id' "; 						
		$arrBrands = $sql->SqlSingleRecord('mos_tbltestimonial',$ConArr);
		$count = $arrBrands['count'];
		$Data = $arrBrands['Data'];		 
	}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />
<title>:: <?=$CMS_TITLE?> ::</title>
<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript src="../js/validation.js"></SCRIPT>
<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>
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
<!-- face box start -->
<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox() 
    })
</script>
<!-- face box end -->
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="add-testimonial.php">Add/Edit Testimonial</a></div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="frmAddDest" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
                <td><h1>Add/Edit Testimonial </h1></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>			</td>
          </tr>
		   <tr>
            <td valign="top" align="center"><?php if($sqlError!="") { ?><span class="loginErrBox" style="margin:15px;"><?=$sqlError?></span><?php } ?></td>
          </tr>
		   <tr>
            <td valign="top" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="141" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Testimonial Name:</td>
                <td width="9" align="left" valign="top">&nbsp;</td>
                <td width="450" align="left" valign="top">
				<input name="tName" id="tName" type="text" class="input_white" size="48" maxlength="100" value="<?=stripslashes($Data['tName'] )?>" alt="BC~DM~ Testimonial name~DM~" onBlur="isProper(this,'Testimonial Name');"></td>
              </tr>
			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="141" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Client Name:</td>
                <td width="9" align="left" valign="top">&nbsp;</td>
                <td width="450" align="left" valign="top">
				<input name="tUser" id="tUser" type="text" class="input_white" size="48" maxlength="100" value="<?=stripslashes($Data['tUser'] )?>" alt="BC~DM~ Client name~DM~"></td>
              </tr>
			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="141" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Client Company:</td>
                <td width="9" align="left" valign="top">&nbsp;</td>
                <td width="450" align="left" valign="top">
				<input name="tCompany" id="tCompany" type="text" class="input_white" size="48" maxlength="100" value="<?=stripslashes($Data['tCompany'] )?>" alt="BC~DM~ Client Company~DM~"></td>
              </tr>
			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>


			  
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Testimonial Description:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<textarea name="tDesc" cols="50" rows="6" class="input_white"><?=stripslashes($Data['tDesc'])?></textarea>				</td>
              </tr>
              
			
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="status" type="radio" value="active" <?php if($Data['status']=='active') echo " checked"?> <?php if($Data['status']=='') echo " checked"?>>
                  <span class="normal_text_blue">Active</span>
                  <input name="status" type="radio" value="inactive" <?php if($Data['status']=='inactive') echo " checked"?>>
                  <span class="normal_text_blue">Inactive</span></td>
              </tr>
              
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
				<?php
				if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')
				{
					$btnName = "Update";
				}
				else
				{
					$btnName = "Add";
				}
				?>
                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-testimonial.php?page=<?=$page?>'">				</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
		</form>		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><?php include_once('include/footer.php');?></td>
  </tr>
</table>
</body>
</html>

<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

//print_r($_SESSION);


/*if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
}  */

include_once(_CLASS_PATH."thumbnail.php");
require_once(_PATH."includes/resize_image.php");

$user_id=$_REQUEST['UserId'];


$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$sqlError="";
if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")
{	
	$chkUserExists=$sql->checkUserExists($_REQUEST['LoginEmail']);
	if($chkUserExists==FALSE)
	{
		$ReqArr = $_REQUEST;
		$ConArr = array();		
		foreach($ReqArr as $k=>$v)
		{
			if($k=="FirstName" || $k=='LastName' ||  $k=="Address1" || $k=="Address2" ||  $k=="Phone" || $k=="City" || $k=="State" || $k=="Zip"  || $k=="Country" || $k=="LoginEmail" || $k=="Password" || $k=="IsActive")
			{
				$ConArr[$k]=$v;
				$Data[$k]=$v;
			}
		}
		$ConArr['ClinicName'] = $_REQUEST['ClinicName'];
		$ConArr['ClinicDescription'] = $_REQUEST['ClinicDescription'];
		$ConArr['ClinicLongDescription'] = $_REQUEST['ClinicLongDescription'];
			
		$UserCategories='';
		if(is_array($_POST['UserCategories']))
		{
			$UserCategories=implode(',',$_POST['UserCategories']);
		}
			
		$ConArr["UserCategories"]=$UserCategories;
			
		$ConArr["user_meta_title"] = $_POST["user_meta_title"];
		$ConArr["user_meta_keywords"] = $_POST["user_meta_keywords"] ;
		$ConArr["user_meta_description"] = $_POST["user_meta_description"];
		$ConArr["user_page_url"] = strtolower(str_replace(" ","_",$_POST["user_page_url"] )).".html";
	
		$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
		$ConArr['modifiedDate'] = date("Y-m-d H:i:s",time());	
		
		$ConArr["display_order"] = $_POST["display_order"];
		
		
		$ConArr=add_slashes_arr($ConArr);	
		$intResult = $sql->SqlInsert('esthp_tblUsers',$ConArr);
			
		if($intResult)
		{
			if($_FILES['UserLargeImg']['name']!="")
			{
				$upload_dir= _UPLOAD_FILE_PATH."user_images/";
				$file_name =$intResult.'_'.$_FILES['UserLargeImg']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['UserLargeImg']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['UserLargeImg'] = $file_name ;
					$condition = " where UserId ='".$intResult."'";
					$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
				}
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
			}
			
			if($_FILES['UserSmallImg']['name']!="")
			{
				$upload_dir= _UPLOAD_FILE_PATH."user_images/small/";
				$file_name =$intResult.'_'.$_FILES['UserSmallImg']['name'];
				$upload_file=$upload_dir.$file_name ;
				if(move_uploaded_file($_FILES['UserSmallImg']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['UserSmallImg'] = $file_name ;
					$condition = " where UserId ='".$intResult."'";
					$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
				}	
			}
			  
			/// send email to clinic start///////////////////
			$to_email =$ReqArr['LoginEmail'];
			$email_subject="Your registration details: "._WEBSITE_NAME;
			$email_body .=
			'
			<table width="70%" cellpadding="0" border="0">
			<tr><td colspan="2" align="left">Hi '.$ReqArr['FirstName'].' '.$ReqArr['LastName'].',<br/><br/><b>Your clinic is successfully registered on '._WEBSITE_NAME.' !!</b><br/><br/></td></tr>
					<tr><td colspan="2" align="left">Your registration details are as follows: </td></tr>
					<tr>
						<td width="30%" align="left"><b>UserName :</b></td>
						<td align="left">'.$to_email.'</td>
					</tr>
					<tr>
						<td align="left"><b>Password :</b></td>
						<td align="left">'.$ReqArr['Password'].'</td>
					</tr>
					<tr>
						<td align="left"><b>Admin Access URL :</b></td>
						<td align="left">'._WWWROOT.'admin'.'</td>
					</tr>
					<tr>
						<td colspan="2" align="left">Thanks</td>	
					</tr>
					</table>
			';
				
			$super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
				
			$from="From: ".'Admin'." <".$admin_email.">";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .=$from;
			
			mail($to_email,$email_subject,$email_body,$header);
				/// send email to clinic end///////////////////
							
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-user.php">';
			echo '<input type="hidden" name="msg" id="msg" value="added">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';
		}
		else
		{
				$sqlError="<span class=\"loginErrBox\"><span class='alert_icon'></span>".mysql_error()."</sapn>";
		}
	}
	else
	{
		$sqlError="<span class=\"loginErrBox\"><span class='alert_icon'></span>User with the provided Email Id already exists. Please provide different Email Id.</sapn>";
		$Data=array();
		foreach($_REQUEST as $k=>$v)
		{
			$Data[$k]=$v;
		}
	}	
}
else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['UserId']))
{		
	$checkUserExistsonUpdate=$sql->checkUserExistsonUpdate($_REQUEST['LoginEmail'],$_REQUEST['UserId']);
		
	if($checkUserExistsonUpdate==FALSE)
	{
		$ReqArr = $_REQUEST;
		$ConArr = array();		
		foreach($ReqArr as $k=>$v)
		{
			if($k=="FirstName" || $k=='LastName' ||  $k=="Address1" || $k=="Address2" ||  $k=="Phone" || $k=="City" || $k=="State" || $k=="Zip"  || $k=="Country" || $k=="LoginEmail" || $k=="IsActive")
			{
				$ConArr[$k]=$v;
			}
		}
			
		$ConArr['ClinicName'] = $_REQUEST['ClinicName'];
		$ConArr['ClinicDescription'] = $_REQUEST['ClinicDescription'];
		$ConArr['ClinicLongDescription'] = $_REQUEST['ClinicLongDescription'];
		$UserCategories='';

		if(is_array($_POST['UserCategories']))
		{
			$UserCategories=implode(',',$_POST['UserCategories']);
		}
			
		$ConArr["UserCategories"]=$UserCategories;
			
		$ConArr["user_meta_title"] = $_POST["user_meta_title"];
		$ConArr["user_meta_keywords"] = $_POST["user_meta_keywords"] ;
		$ConArr["user_meta_description"] = $_POST["user_meta_description"];
		$ConArr["user_page_url"] = strtolower(str_replace(" ","_",$_POST["user_page_url"] )).".html";
			
		if(!empty($_REQUEST["Password"]))
			$ConArr["Password"]=$_REQUEST["Password"];
			$ConArr['modifiedDate'] = date("Y-m-d H:i:s",time());	
			
			
			$ConArr["display_order"] = $_POST["display_order"];

			$ConArr=add_slashes_arr($ConArr);	
			$CondArr = " WHERE UserId = ".$_REQUEST['UserId'];
			$intResult = $sql->SqlUpdate('esthp_tblUsers',$ConArr,$CondArr);

			if($_FILES['UserLargeImg']['name']!="")
			{
				$upload_dir= _UPLOAD_FILE_PATH."user_images/";
					
				@unlink($upload_dir.$_REQUEST['old_UserLargeImg']);
				@unlink($upload_dir.'thumbs/'.$_REQUEST['old_UserLargeImg']);
					
				$file_name =$user_id.'_'.$_FILES['UserLargeImg']['name'];
				$upload_file=$upload_dir.$file_name ;
				if(move_uploaded_file($_FILES['UserLargeImg']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['UserLargeImg'] = $file_name ;
					$condition = " where UserId ='".$user_id."'";
					$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
				}
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
			
		if($_FILES['UserSmallImg']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."user_images/small/";
				@unlink($upload_dir.$_REQUEST['old_UserSmallImg']);
				$file_name =$user_id.'_'.$_FILES['UserSmallImg']['name'];
				$upload_file=$upload_dir.$file_name ;
				if(move_uploaded_file($_FILES['UserSmallImg']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['UserSmallImg'] = $file_name ;
					$condition = " where UserId ='".$user_id."'";
					$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
				}
		}
			
		$user_cond = " WHERE UserId= '".$_REQUEST['UserId']."' "; 						
		$user_arr = $sql->SqlSingleRecord('esthp_tblUsers',$user_cond);
		$user_count = $user_arr['count'];
		$user_data = $user_arr['Data'];
			
		/// send email to clinic start///////////////////
			$to_email =$ReqArr['LoginEmail'];
			$email_subject="Your updated registration details: "._WEBSITE_NAME;
			$email_body .=
			'
			<table width="70%" cellpadding="0" border="0">
			<tr><td colspan="2">Hi '.$ReqArr['FirstName'].' '.$ReqArr['LastName'].',<br/><br/><b>Your clinic is successfully registered on '._WEBSITE_NAME.' !!</b><br/><br/></td></tr>
					<tr><td colspan="2" align="left">Your registration details are as follows: </td></tr>
					<tr>
						<td width="30%" align="left"><b>UserName :</b></td>
						<td width="70%" align="left">'.$to_email.'</td>
					</tr>
					<tr>
						<td align="left"><b>Password :</b></td>
						<td align="left">'.$ReqArr['Password'].'</td>
					</tr>
				<tr>
						<td align="left"><b>Admin Access URL :</b></td>
						<td align="left">'._WWWROOT.'admin'.'</td>
					</tr>
					<tr>
						<td colspan="2">Thanks</td>	
					</tr>
					</table>
			';
				
			$super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
				
			$from="From: ".'Admin'." <".$admin_email.">";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .=$from;
				
			mail($to_email,$email_subject,$email_body,$header);
			/// send email to clinic end///////////////////
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-user.php">';
			echo '<input type="hidden" name="msg" id="msg" value="updated">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';		
			exit;
			
			}
			else
			{
			$sqlError="<span class=\"loginErrBox\"><span class='alert_icon'></span>User with the provided Email Id already exists. Please provide different Email Id.</sapn>";
			}
		}
		
	if(!empty($_REQUEST['UserId']))
	{
		$id = $_REQUEST['UserId'];
		$ConArr = " WHERE UserId= '$id' "; 						
		$arrBrands = $sql->SqlSingleRecord('esthp_tblUsers',$ConArr);
		$count = $arrBrands['count'];
		$Data = $arrBrands['Data'];		 
	}
	
	
		
if(isset($_REQUEST['act']) && $_REQUEST['act']=='dellargeimg')
{

	$upload_dir= _UPLOAD_FILE_PATH."user_images/";
	

	@unlink($upload_dir.$Data['UserLargeImg']);
	@unlink($upload_dir.'thumbs/'.$Data['UserLargeImg']);
	
	$content_arr=array();
	$content_arr['UserLargeImg'] = '' ;
	$condition = " where UserId 	 ='".$user_id."'";
	$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
	

	
	header("location:add-user.php?UserId=".$user_id);
}


if(isset($_REQUEST['act']) && $_REQUEST['act']=='delsmallimg')
{

	$upload_dir= _UPLOAD_FILE_PATH."user_images/small/";
	

	@unlink($upload_dir.$Data['UserSmallImg']);
	
	$content_arr=array();
	$content_arr['UserSmallImg'] = '' ;
	$condition = " where UserId ='".$user_id."'";
	$sql->SqlUpdate('esthp_tblUsers',$content_arr,$condition);
	

	
	header("location:add-user.php?UserId=".$user_id);
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
<SCRIPT language=javascript src="../js/validation_new.js"></SCRIPT>


<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function($) {

      $('a[rel*=facebox]').facebox() 

    })	
</script>


<script language="javascript">
	
 
	function delete_UserLargeImg()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-user.php?act=dellargeimg&UserId=<?=$user_id?>"; 
		}
	}
	
	
		function delete_UserSmallImg()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-user.php?act=delsmallimg&UserId=<?=$user_id?>"; 
		}
	}
	
	

</script>

<script>



//STEP 9: prepare submit FORM function

function SubmitForm(formnm)

{
//alert("called");

		   if(!JSvalid_form(formnm))

			{

					return false;

			}

			if(formnm.Password.value=='' && formnm.old_Password.value=='')

			{

				alert("Please Enter Password ");
	
				formnm.Password.focus();
	
				return false;

			}

			if(formnm.Password.value!=formnm.rPassword.value)

			{

			alert("password  and re-password fileds mismatch ");

			formnm.Password.focus();

			return false;

			}

}		

</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?>
<div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-user.php">Manage Franchises</a></div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
                <td><h1>Register Clinic</h1></td>
              </tr>
            </table></td>
          </tr>
		   <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="4">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>
			</td>
          </tr>
		  
		  <?php
		  if($sqlError!='')
		  {
		  ?>
		 <tr>
            <td valign="middle" height="50" align="center" style="padding:5px;"><?=$sqlError?></td>
          </tr>
		  <?php
		  }
		  ?> 
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="1"></td>
          </tr>
          <tr>
            <td valign="top">
			
			<form name="frmAddUser" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data" style="margin:0px;">
			<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
			
			
			
			
			 <tr>
                <td colspan="3" align="left" valign="top">
				
				<fieldset ><legend class="blue12">Clinic Details</legend>
				<table width="100%" border="0">
				 
				 
				<?php
				if(!empty($_REQUEST['UserId']))
				{
				?>
				<tr>
				<td width="25%" align="left" valign="top" class="normal_text_blue">Clinic ID:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="73%" align="left" valign="top" class="normal_text_blue"><?=$Data['UserId']?></td>
              </tr>
				<?php
				}

				?>
				 
				 
				 <tr> 
                <td width="25%" align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Clinic Name:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="73%" align="left" valign="top">
				<input name="ClinicName" id="chk_ClinicName" type="text" class="input_white" size="48" value="<?=$Data['ClinicName']?>" title="Please enter Clinic Name."></td>
              </tr>
			  
			  
			  
			  				 <tr> 
                <td width="25%" align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Display Order:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="73%" align="left" valign="top">
				<input name="display_order" id="display_order" type="text" class="input_white" size="48" value="<?=$Data['display_order']?>" title="Please enter Display Order."></td>
              </tr>
			  
			  
          
              <tr>
                <td align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>short Description:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<textarea name="ClinicDescription"  id="chk_ClinicDescription" class="input_white" rows="4" cols="45"  title="Please enter Clinic Description."><?=$Data['ClinicDescription']?></textarea>
				</td>
              </tr>
			  
			  <tr>
                <td align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Long Description:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;
				</td>
              </tr>
			  <tr>
			  	<td colspan="3">
				<?php	
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('ClinicLongDescription') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['ClinicLongDescription'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="100%" ;
				$oFCKeditor1->Height="230" ;
				$oFCKeditor1->Create();	
				?>
				</td>
			  </tr>
			  
			  
			                <tr>
                <td align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Category:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<select name="UserCategories[]" class="input_white" style="width:250px;" multiple>
				<?php
				$user_categories=explode(',',trim($Data['UserCategories']));
				
				$user_cat_arr=$sql->SqlRecordMisc('esthp_tblUserCat',"where 1=1 order by cat_name");
				$user_cat_count=$user_cat_arr['count'];
				$user_cat_data=$user_cat_arr['Data'];
				
				foreach($user_cat_data as $user_cat_rec)
				{
				?>
				<option value="<?=$user_cat_rec['cat_id']?>" <?=(in_array($user_cat_rec['cat_id'],$user_categories)?'selected':'')?>><?=$user_cat_rec['cat_name']?></option>
				<?php
				}
				?>
				</select>
				</td>
              </tr>
			  
			  
			  
			  
			  	<tr>
                <td  align="left" valign="top" class="normal_text_blue">Small Image :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">	<input type="hidden" name="old_UserSmallImg" value="<?=$Data['UserSmallImg']?>"><input name="UserSmallImg" type="file" class="input_white" size="30">
				<?php
				$UserSmallImg=$Data['UserSmallImg'];
	
				if(is_file(_UPLOAD_FILE_PATH."user_images/small/".$UserSmallImg))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>user_images/small/<?=$UserSmallImg?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_UserSmallImg()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>

				
		</td>
              </tr>
			  
			  
			  
			
			  
			  <tr>
                <td align="left" valign="top" class="normal_text_blue">Large Image :</td>
                <td  align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">	<input type="hidden" name="old_UserLargeImg" value="<?=$Data['UserLargeImg']?>"><input name="UserLargeImg" type="file" class="input_white" size="30">
				<?php
				$UserLargeImg=$Data['UserLargeImg'];
				if(is_file(_UPLOAD_FILE_PATH."user_images/".$UserLargeImg))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>user_images/<?=$UserLargeImg?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_UserLargeImg()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>

				
		</td>
              </tr>
			  
			  

			  
			  
			  

              
				</table>
				</fieldset></td>
                </tr>
              
                <tr>
				
				<td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              

              
              <tr>
                <td height="20" colspan="3" align="right" valign="top">
				<fieldset ><legend class="blue12">Login Details</legend>
				<table width="100%" border="0">
				   <tr>
                <td width="25%" align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Login Email :</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="73%" align="left" valign="top">
				<input name="LoginEmail" id="chkemail_LoginEmail" type="text" class="input_white" size="48" value="<?=$Data['LoginEmail']?>" title="Please enter a valid Email ID" ></td>
              </tr>

              <tr>
                <td align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Password:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="hidden" name="old_Password" value="<?=$Data['Password']?>">
				<input name="Password" type="password" id="chk_password" class="input_white" size="48" value="<?=$Data['Password']?>" title="Please enter password.">				</td>
              </tr>

              <tr>
                <td align="left" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Retype Password:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="rPassword" type="password" id="chkpass_repassword" class="input_white" size="48" value="<?=$Data['Password']?>" title="Please retype password."></td>
              </tr>

          
			  <tr>
                <td align="left" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="IsActive" type="radio" value="t" <?php if($Data['IsActive']=='t') echo " checked"?> <?php if($Data['IsActive']=='') echo " checked"?>>
                  <span class="normal_text_blue">Active</span>
                  <input name="IsActive" type="radio" value="f" <?php if($Data['IsActive']=='f') echo " checked"?>>
                  <span class="normal_text_blue">Inactive</span></td>
              </tr>
			
			  
			  
			  
				</table>
				</fieldset>
				</td>
                </tr>
              <tr>
                <td height="20" align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  
			  
			  
              <tr>
                <td colspan="3" align="left" valign="top">
				
				<fieldset ><legend class="blue12">Contact Details</legend>
				<table width="100%" border="0">
				 
				 

				 
		
				 <tr> 
                <td width="25%" align="left" valign="top" class="normal_text_blue">First Name:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="73%" align="left" valign="top">
				<input name="FirstName" id="chk_FirstName" type="text" class="input_white" title="Please enter the First Name" size="48" value="<?=$Data['FirstName']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Last name:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="LastName" type="text" class="input_white"  size="48" value="<?=$Data['LastName']?>"></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Address:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="Address1" type="text" class="input_white" size="48" value="<?=$Data['Address1']?>" >
				</td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Address2:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="Address2" type="text" class="input_white" size="48" value="<?=$Data['Address2']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Phone:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="Phone" type="text" class="input_white" size="48" value="<?=$Data['Phone']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Zip Code:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="Zip" type="text" class="input_white" size="48" value="<?=$Data['Zip']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">City:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="City" type="text" class="input_white" size="48" value="<?=$Data['City']?>" ></td>
              </tr>
			  <tr>
                <td align="left" valign="top" class="normal_text_blue">State:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="State" type="text" class="input_white" size="48" value="<?=$Data['State']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Country:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
		
				
				
				
	
	<?php
	$country_condition="order by countries_name";
	$country_record_arr=$sql->SqlRecordMisc('esthp_tblCountries', $country_condition);
	$total_countries=$country_record_arr['count'];
	$country_records=$country_record_arr['Data'];
	?>
	<select name="Country" class="input_white" >
	<option value=''>Select Country</option>
	<?php
	foreach($country_records as $country)
	{
	?>
	<option value="<?=$country['countries_name']?>" <?=($country['countries_name']==$Data['Country']?'selected':'')?>><?=$country['countries_name']?></option>
	<?php
	}
	?>

	</select>
	
	
		
				</td>
              </tr>
				</table>
				</fieldset></td>
                </tr>
			  
			  <?
					$complete_url=explode(".html",$Data['user_page_url']);
					?>
			  
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue">Page Url</td>
					<td width="4" align="left" valign="top"></td>
					<td width="334" align="left" valign="top">	<input name="user_page_url" id="chk_user_page_url" title="Please enter clinic page URL." type="text"  size="48" value="<?=$complete_url[0]?>" ></td>
				  </tr>
				  

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="user_meta_title" type="text" class="input_white" size="48" value="<?=$Data['user_meta_title']?>"></td>
              </tr>


              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="user_meta_keywords" class="input_white" rows="4" cols="45"><?=$Data['user_meta_keywords']?></textarea></td>
              </tr>


			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="user_meta_description" class="input_white" rows="4" cols="45"><?=$Data['user_meta_description']?></textarea></td>
              </tr>		  


			 
			 
			 
		<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  
			  
			  
			  
			  
              <tr>
				<?php
				if(!empty($_REQUEST['UserId']))
				{
					$btnName = "Update";
				}
				else
				{
					$btnName = "Add";
				}
				?>
                <td align="center" valign="top" colspan="3">
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-user.php?page=<?=$page?>'">				</td>
              </tr>
            </table>
			</form>
			</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
          
        </table>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><?php include_once('include/footer.php');?></td>
  </tr>
</table>
</body>
</html>

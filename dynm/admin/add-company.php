<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();

if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
} 

include_once(_CLASS_PATH."thumbnail.php");
require_once(_PATH."includes/resize_image.php");


$comp_id=$_REQUEST['comp_id'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	$content_arr["comp_name"] = $_POST["comp_name"] ;
	$content_arr["comp_desc_short"] = $_POST["comp_desc_short"];
	$content_arr["comp_desc_long"] = $_POST["comp_desc_long"];
	$content_arr["comp_email"] = $_POST["comp_email"];
	$content_arr["comp_address"] = $_POST["comp_address"];
	$content_arr["comp_post_code"] = $_POST["comp_post_code"];
	$content_arr["comp_province"] = $_POST["comp_province"];
	$content_arr["comp_city"] = $_POST["comp_city"];
	$content_arr["comp_phone"] = $_POST["comp_phone"];
	
	
	
	$content_arr["comp_business_hrs"] = $_POST["comp_business_hrs"];
	$content_arr["comp_website"] = $_POST["comp_website"];
	//$content_arr["comp_logo"] = $_POST["comp_logo"];
	$content_arr["comp_press_release"] = $_POST["comp_press_release"];
	$content_arr["comp_page_url"] =strtolower(str_replace(" ","_",$_POST["comp_page_url"] )).".html";
	$content_arr["comp_meta_title"] = $_POST["comp_meta_title"];
	$content_arr["comp_meta_key"] = $_POST["comp_meta_key"];
	$content_arr["comp_meta_desc"] = $_POST["comp_meta_desc"];
	$content_arr["comp_date_add"] = date("Y-m-d H:i:s",time());
	//$content_arr["comp_date_mod"] = ;
	//$content_arr["comp_pri_feat"] = ;
	//$content_arr["comp_sec_feat"] = ;
	//$content_arr["comp_single_feat"] = ;
	$content_arr["comp_map_link"] = $_POST["comp_map_link"];
	$content_arr["comp_status"] = $_POST["comp_status"];
	$content_arr["comp_allow_comments"] = $_POST["comp_allow_comments"];
	$content_arr["comp_allow_moderation"] = $_POST["comp_allow_moderation"];


	$record_id = $sql->SqlInsert('esthp_tblCompanies',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
		if($_FILES['comp_logo']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."company_logos/";
				
				$file_name =$record_id.'_'.$_FILES['comp_logo']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['comp_logo']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['comp_logo'] = $file_name ;
					
					$condition = " where comp_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblCompanies',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
			  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-companies.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['comp_id']))
{	
	$content_arr = array();	
	$content_arr["comp_name"] = $_POST["comp_name"] ;
	$content_arr["comp_desc_short"] = $_POST["comp_desc_short"];
	$content_arr["comp_desc_long"] = $_POST["comp_desc_long"];
	$content_arr["comp_email"] = $_POST["comp_email"];
	$content_arr["comp_address"] = $_POST["comp_address"];
	
	$content_arr["comp_post_code"] = $_POST["comp_post_code"];
	$content_arr["comp_province"] = $_POST["comp_province"];
	$content_arr["comp_city"] = $_POST["comp_city"];
	$content_arr["comp_phone"] = $_POST["comp_phone"];
	$content_arr["comp_business_hrs"] = $_POST["comp_business_hrs"];
	$content_arr["comp_website"] = $_POST["comp_website"];
	//$content_arr["comp_logo"] = $_POST["comp_logo"];
	$content_arr["comp_press_release"] = $_POST["comp_press_release"];
	$content_arr["comp_page_url"] =strtolower(str_replace(" ","_",$_POST["comp_page_url"] )).".html";
	$content_arr["comp_meta_title"] = $_POST["comp_meta_title"];
	$content_arr["comp_meta_key"] = $_POST["comp_meta_key"];
	$content_arr["comp_meta_desc"] = $_POST["comp_meta_desc"];
	//$content_arr["comp_date_add"] = date("Y-m-d H:i:s",time());
	$content_arr["comp_date_mod"] = date("Y-m-d H:i:s",time());
	//$content_arr["comp_pri_feat"] = ;
	//$content_arr["comp_sec_feat"] = ;
	//$content_arr["comp_single_feat"] = ;
	$content_arr["comp_map_link"] = $_POST["comp_map_link"];
	$content_arr["comp_status"] = $_POST["comp_status"];
	
	$content_arr["comp_allow_comments"] = $_POST["comp_allow_comments"];
	$content_arr["comp_allow_moderation"] = $_POST["comp_allow_moderation"];

    $condition = " where comp_id='".$comp_id."'";
	$sql->SqlUpdate('esthp_tblCompanies',$content_arr,$condition);		
	
	//update_htaccess();
	
	 if($_FILES['comp_logo']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."company_logos/";
			
			@unlink($upload_dir.$_REQUEST['old_comp_logo']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_comp_logo']);
			
			$file_name =$comp_id.'_'.$_FILES['comp_logo']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['comp_logo']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['comp_logo'] = $file_name ;
				$condition = " where comp_id ='".$comp_id."'";
				$sql->SqlUpdate('esthp_tblCompanies',$content_arr,$condition);
			}
			$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-companies.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['comp_id']))
{
	$cond = " WHERE comp_id= '$comp_id' "; 						
	$comp_arr = $sql->SqlSingleRecord('esthp_tblCompanies',$cond);
	$count = $comp_arr['count'];
	$Data = $comp_arr['Data'];			
}



if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{
	$content_arr=array();
	$content_arr['comp_logo'] = '' ;
	$condition = " where comp_id ='".$comp_id."'";
	$sql->SqlUpdate('esthp_tblCompanies',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."company_logos/";
	
	@unlink($upload_dir.$Data['comp_logo']);
	@unlink($upload_dir.'thumbs/'.$Data['comp_logo']);
	
	header("location:add-company.php?comp_id=".$comp_id);
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

<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>	


<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function($) {

      $('a[rel*=facebox]').facebox() 

    })	
</script>


<script language="javascript">
	
 
	function delete_compImage()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-company.php?act=delimg&comp_id=<?=$comp_id?>"; 
		}
	}
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-companies.php">Manage Companies</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="add-company" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Company </h1></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  valign="top"><img src="images/spacer.gif" alt="" width="1" height="25" align="left">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>
         
		 <?php
		 if($sqlError!='')
		 {
		 ?>
		  </tr>
		  <tr><td valign="top"><?=$sqlError?></td>
		  </tr>
		  <?php
		  }
		  ?>
		  
		   <tr>
		  
            <td valign="top">
			
			<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">


              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Company Name :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="comp_name" id="chk_comp_name" title="Please enter company name." type="text" class="input_white" size="48" value="<?=$Data['comp_name']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  
			  
			  

              <tr>
                <td align="right" valign="top" class="normal_text_blue">Short Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('comp_desc_short') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['comp_desc_short'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="200" ;
				$oFCKeditor1->Create();	
				?>
				</td>
              </tr>
			  
			  
			  
			     <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td align="right" valign="top" class="normal_text_blue">Long Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	

				$oFCKeditor1 = new FCKeditor('comp_desc_long') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['comp_desc_long'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="200" ;
				$oFCKeditor1->Create();	
				?>
				</td>
              </tr>
			  
			  

			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  


              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Address: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="comp_address" title="Please enter company address." id="chk_comp_address" class="input_white" rows="4" cols="45"><?=$Data['comp_address']?></textarea></td>
              </tr>
			  
			  
			  
			  			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
	  
	  
	  
	  
	            <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> City: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_city" id="chk_comp_city" title="Please enter city." type="text" class="input_white" size="48" value="<?=$Data['comp_city']?>" ></td>
              </tr>
			  
			  
			  
			  			  
			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  	  
	            <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Province: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_province" id="chk_comp_province" title="Please enter province." type="text" class="input_white" size="48" value="<?=$Data['comp_province']?>" ></td>
              </tr>
			  
			  
			  
			  			  
			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
	  
	  

	  
	                <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Post Code: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_post_code" id="chk_comp_post_code" title="Please enter post code." type="text" class="input_white" size="48" value="<?=$Data['comp_post_code']?>" ></td>
              </tr>
			  
			  
			  
			  			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
	  
	  
	  
	  
	                <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Phone: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_phone" id="chk_comp_phone" title="Please enter phone number." type="text" class="input_white" size="48" value="<?=$Data['comp_phone']?>" ></td>
              </tr>
			  
			  
			  
			  			  
			     <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Company Email :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="comp_email" id="chkemail_comp_email" title="Please enter a valid email ID." type="text" class="input_white" size="48" value="<?=$Data['comp_email']?>" ></td>
              </tr>
			  
			  
			  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  	      <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Google Map Link: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_map_link" type="text" class="input_white" size="48" value="<?=$Data['comp_map_link']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
	  
	  
	  
	  
	            <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Business Hours: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_business_hrs" id="chk_comp_business_hrs" title="Please enter business hours." type="text" class="input_white" size="48" value="<?=$Data['comp_business_hrs']?>" ></td>
              </tr>
			  
			  
			  
			  				  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  	  
	            <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Website: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_website" id="chk_comp_website" title="Please enter website name." type="text" class="input_white" size="48" value="<?=$Data['comp_website']?>" ></td>
              </tr>
			  
			  
			  
			  				  

			  
			  
			  			  
			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			 

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Logo :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_comp_logo" value="<?=$Data['comp_logo']?>"><input name="comp_logo" type="file" class="input_white" size="30">
				<?php
				$comp_logo=$Data['comp_logo'];
	
				if(is_file(_UPLOAD_FILE_PATH."company_logos/".$comp_logo))
				{

				
				?>
				<a href="<?=_UPLOAD_FILE_URL?>company_logos/<?=$comp_logo?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_compImage()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>

				
		</td>
              </tr>
			  
			  
			  
			       <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td align="right" valign="top" class="normal_text_blue">Press Release :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php
				
				
				$oFCKeditor1 = new FCKeditor('comp_press_release') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['comp_press_release'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="200" ;
				$oFCKeditor1->Create();	
				?>
				</td>
              </tr>
			  
			  
			  
			  	<tr>
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				  
				  
			  		<?
					$complete_url=explode(".html",$Data['comp_page_url']);
					?>
					
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top" class="normal_text_blue">	<input name="comp_page_url" id="chk_comp_page_url" title="Please enter company page URL." type="text" class="input_white" size="48" value="<?=$complete_url[0]?>" >.html</td>
				  </tr>
				  
				  
				  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="comp_meta_title" type="text" class="input_white" size="48" value="<?=$Data['comp_meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="comp_meta_key" class="input_white" rows="4" cols="45"><?=$Data['comp_meta_key']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="comp_meta_desc" class="input_white" rows="4" cols="45"><?=$Data['comp_meta_desc']?></textarea></td>
              </tr>		  
			  
			  
			  
			     <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		





             <tr>
                <td align="right" valign="top" class="normal_text_blue">Allow Video Comments :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_allow_comments" type="radio" value="0" <?=($Data['comp_allow_comments']==0 || $Data['comp_allow_comments']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">No</span>      <input name="comp_allow_comments" type="radio" value="1" <?=($Data['comp_allow_comments']=='1' ? 'checked' : '')?>>  <span class="normal_text_blue">Yes</span></td>
              </tr>
			  
			  
			  
			  			  
			     <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		





             <tr>
                <td align="right" valign="top" class="normal_text_blue">Allow Comments Moderation:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_allow_moderation" type="radio" value="0" <?=($Data['comp_allow_moderation']==0 || $Data['comp_allow_moderation']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">No</span>      <input name="comp_allow_moderation" type="radio" value="1" <?=($Data['comp_allow_moderation']=='1' ? 'checked' : '')?>>  <span class="normal_text_blue">Yes</span></td>
              </tr>
			  
			  

			  
			  
			  
			    <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		





             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="comp_status" type="radio" value="active" <?=($Data['comp_status']=='active' || $Data['comp_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Active</span>      <input name="comp_status" type="radio" value="inactive" <?=($Data['comp_status']=='inactive' ? 'checked' : '')?>>  <span class="normal_text_blue">Inactive</span></td>
              </tr>
			  
			  
			  
			  


			  
			  
			  

			  
			
		

			 
			 
			 
		<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  






              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
			<?php
			
			if(isset($_REQUEST['comp_id']) && $_REQUEST['comp_id']!='')
			{
						$btnName = "Update";
			}
			else
			{
						$btnName = "Add";
			}
			?></td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-companies.php'">				
				
				</td>
              </tr>
            </table></td>
          </tr>
          <tr><td valign="top">&nbsp;</td></tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td></tr>
 </table>
</body>
</html>
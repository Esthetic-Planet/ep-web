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

//include_once(_CLASS_PATH."thumbnail.php");
//require_once(_PATH."includes/resize_image.php");


$ad_id=$_REQUEST['ad_id'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	$content_arr["ad_title"] = $_POST["ad_title"] ;
	$content_arr["ad_link"] = $_POST["ad_link"];
	
	$ad_categories='';

	if(is_array($_POST['ad_categories']))
	{
		$ad_categories=implode(',',$_POST['ad_categories']);
	}
	
	$content_arr["ad_categories"]=$ad_categories;
	
	
	$record_id = $sql->SqlInsert('esthp_tblLeadAds',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
		if($_FILES['ad_image']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."ads/leaderboard/";
				
				$file_name =$record_id.'_'.$_FILES['ad_image']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['ad_image']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['ad_image'] = $file_name ;
					
					$condition = " where ad_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblLeadAds',$content_arr,$condition);
					
				}	
				//$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
				//@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
			  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'leaderboard-ads.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['ad_id']))
{	
	$content_arr = array();	
	
	$content_arr["ad_title"] = $_POST["ad_title"] ;
	$content_arr["ad_link"] = $_POST["ad_link"];
	
	
	$ad_categories='';

	if(is_array($_POST['ad_categories']))
	{
		$ad_categories=implode(',',$_POST['ad_categories']);
	}
	
	$content_arr["ad_categories"]=$ad_categories;
	
    $condition = " where ad_id='".$ad_id."'";
	$sql->SqlUpdate('esthp_tblLeadAds',$content_arr,$condition);		
	
	//update_htaccess();
	
	 if($_FILES['ad_image']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."ads/leaderboard/";
			
			@unlink($upload_dir.$_REQUEST['old_ad_image']);
			//@unlink($upload_dir.'thumbs/'.$_REQUEST['old_cat_image']);
			
			$file_name =$ad_id.'_'.$_FILES['ad_image']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['ad_image']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['ad_image'] = $file_name ;
				$condition = " where ad_id ='".$ad_id."'";
				$sql->SqlUpdate('esthp_tblLeadAds',$content_arr,$condition);
			}
			//$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
			//@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'leaderboard-ads.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['ad_id']))
{
	$cond = " WHERE ad_id= '".$_REQUEST['ad_id']."' "; 						
	$ad_arr = $sql->SqlSingleRecord('esthp_tblLeadAds',$cond);
	$count = $ad_arr['count'];
	$Data = $ad_arr['Data'];	
	$ad_file_ext_arr=explode(".",$Data['ad_image']);
	$ad_file_ext=strtolower(end($ad_file_ext_arr));			
}



if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{
	$content_arr=array();
	$content_arr['ad_image'] = '' ;
	$condition = " where ad_id ='".$ad_id."'";
	$sql->SqlUpdate('esthp_tblLeadAds',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."ads/leaderboard/";
	
	@unlink($upload_dir.$Data['ad_image']);
	//@unlink($upload_dir.'thumbs/'.$Data['cat_image']);
	
	header("location:add-leaderboard.php?ad_id=".$ad_id);
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
	
 
	function delete_adImage()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-leaderboard.php?act=delimg&ad_id=<?=$ad_id?>"; 
		}
	}
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="leaderboard-ads.php">Leaderboard Ads</a> &raquo; Add Leaderboard Ad</a></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="add-category" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Leaderboard Ad</h1></td>
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
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Ad Title :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="ad_title" id="chk_ad_title" title="Please enter ad title." type="text" class="input_white" size="48" value="<?=$Data['ad_title']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  

            
              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Ad URL/LInk :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="ad_link" id="chk_ad_link" title="Please enter ad URL/Link." type="text" class="input_white" size="48" value="<?=$Data['ad_link']?>" ></td>
              </tr>
			  
			  
			  
			     <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
	  
			  
			 

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Ad Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_ad_image" value="<?=$Data['ad_image']?>"><input name="ad_image" type="file" class="input_white" size="30">
				<?php
				$ad_image=$Data['ad_image'];
	
				if(is_file(_UPLOAD_FILE_PATH."ads/leaderboard/".$ad_image))
				{

						if($ad_file_ext=='swf')
						{
						?>
						</td>
						</tr>
						<tr>
						<td colspan='3'><br/><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="730" height="92" title="test">
						  <param name="movie" value="<?=_UPLOAD_FILE_URL.'ads/leaderboard/'.$Data['ad_image']?>" />
						  <param name="quality" value="high" />
						  <embed src="<?=_UPLOAD_FILE_URL.'ads/leaderboard/'.$Data['ad_image']?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="730" height="92"></embed>
						</object><br/>&nbsp;<a href="javascript:void(0);" title="Click to Delete" onclick="javascript:delete_adImage()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
						</td>
						</tr>
						
						<tr>
						<td colspan="2"></td>
						<td>
						<?php
						}
						else
						{
						?><a href="<?=_UPLOAD_FILE_URL?>ads/leaderboard/<?=$ad_image?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>&nbsp;<a href="javascript:void(0);" title="Click to Delete" onclick="javascript:delete_adImage()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
						<?php
						}
				?>
				<?
				}
				?>
				</td>
				</tr>
				
				
				
				
				 <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			    <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Ad Category :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">
				<select name="ad_categories[]" class="input_white" style="width:250px;" id="ad_categories" multiple>
				<?php
				$ad_categories=explode(',',trim($Data['ad_categories']));
				
				
				$cat_array=getProdCategoriesAdmin();
				foreach($cat_array as $cat_data)
				{
				?>
				<option value="<?=$cat_data['cat_id']?>" <?=(in_array($cat_data['cat_id'],$ad_categories)?'selected':'')?>><?=$cat_data['cat_name']?></option>
				<?php
				}
				?>
				</select>
				</td>
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
			
			if(isset($_REQUEST['ad_id']) && $_REQUEST['ad_id']!='')
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='leaderboard-ads.php'">				
				
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
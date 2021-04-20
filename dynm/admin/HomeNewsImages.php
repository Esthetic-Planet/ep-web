<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
include_once(_CLASS_PATH."/class.upload.php");
include_once(_CLASS_PATH."/thumbnail.php");
$AuthAdmin->ChkLogin();
$sqlError="";

if(isset($_POST['Submit']) && $_POST['Submit']=="Update")
{		
	$ConArr["image_title"]  = addslashes($_POST["image_title"]);
	$ConArr["image_text"]  = addslashes($_POST["image_text"]);
	
	
	if($_FILES['image_name']['name']!="")
	{
		$handle = new Upload($_FILES['image_name']);
		if ($handle->uploaded) 
		{
			$handle->Process(_UPLOAD_FILE_PATH."/webpage_images/");

			if ($handle->processed) 
			{
				$image_name = $handle->file_dst_name;				
				@$thumb->createThumbs( _UPLOAD_FILE_PATH."/webpage_images/",  _UPLOAD_FILE_PATH."/webpage_images/", 90, 74, $image_name);
				$ConArr['image_name'] = $image_name;
   				$handle-> Clean(); 
				if( $_POST["pre_image"] != "")
				{
					if ( file_exists(_UPLOAD_FILE_PATH."/webpage_images/".$_POST["pre_image"]) )
					{
						unlink (_UPLOAD_FILE_PATH."/webpage_images/".$_POST["pre_image"]) ;
					}
				}
			}
			else 
			{ 
				$sqlError .='  Error: ' . $handle->error . ''; 
			}
		}
	 }
	$CondArr = " WHERE 1 ";
	if($intResult = $sql->SqlUpdate('mos_homeTopImages',$ConArr,$CondArr) )
	{
		header("location:HomeNewsImages.php?success=1");
		die();
	}	

	else
	{
	 	$sqlError=mysql_error();
	}
}

	if( isset($_GET["success"]) && $_GET["success"] == 1)
	{
		$sqlError =  "Image updated successfully.";;
	}

	$ConArr = " WHERE 1 "; 
	$arrBrands = $sql->SqlSingleRecord('mos_homeTopImages',$ConArr);
	$count = $arrBrands['count'];
	$Data = $arrBrands['Data'];		 
	
	
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
<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>	

<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
    jQuery(document).ready(function($) {

      $('a[rel*=facebox]').facebox() 

    })
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="HomeNewsImages.php">Add/Edit Home Page News Image</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="frmAddWebPage" action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id?>">
		<input type="hidden" name="pre_image" value="<?=$Data['image_name']?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Manage Home Page News Image</h1></td>
              </tr>
            </table></td>
          </tr>
 	      <tr><td valign="top">&nbsp;</td></tr>

          <tr>
            <td  valign="top"><img src="images/spacer.gif" alt="" width="1" height="25" align="left">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>
          </tr>
		  <tr><td valign="top">
		  <? if($sqlError != "") 
		  	   {
			   		echo '<tr><td valign="top">'.$sqlError.'</td></tr><tr><td valign="top">&nbsp;</td></tr>';
			   }?>
			   
          <tr>
           <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Upload Image :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">				
				<input name="image_name" type="file" class="textarea2" size="34">
		<?php  if($Data['image_name'])
					{
						echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/webpage_images/'.$Data['image_name'].'"  rel="facebox"><img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	
					}	?></td>
            </tr>
 	        <tr><td valign="top" colspan="3">&nbsp;</td></tr>
            <tr>
                <td align="right" valign="top" class="normal_text_blue">Image Title :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="image_title" type="text" class="input_white" size="47" value="<?php echo stripslashes($Data['image_title']); ?>" ></td>
            </tr>
 	        <tr><td valign="top" colspan="3">&nbsp;</td></tr>	
	
            <tr>
                <td align="right" valign="top" class="normal_text_blue">Image Text :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="image_text" type="text" class="input_white" size="47" maxlength="70" value="<?php echo stripslashes($Data['image_text']); ?>" ></td>
            </tr>
 	        <tr><td valign="top" colspan="3">&nbsp;</td></tr>	

	          
            <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="hidden" name="webId" value="<?=$webId?>" >
				<input type="submit" class="btn" name="Submit" value="Update">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='home.php'">	
				</td>
            </tr>
           </table>
			
			</td>
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
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


$page_id=$_REQUEST['page_id'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	$content_arr["page_name"] = $_POST["page_name"] ;
	$content_arr["page_content"] = $_POST["page_content"];
	$content_arr["page_url"] =strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	$content_arr["meta_title"] = $_POST["meta_title"];
	$content_arr["meta_keywords"] = $_POST["meta_keywords"];
	$content_arr["meta_description"] = $_POST["meta_description"];
	$content_arr["date_added"] = date("Y-m-d H:i:s",time());
	$content_arr["page_status"] = $_POST["page_status"];
	
	$record_id = $sql->SqlInsert('esthp_tblWebpage',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
		if($_FILES['page_image']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."webpage_images/";
				$file_name =$record_id.'_'.$_FILES['page_image']['name'];
				$upload_file=$upload_dir.$file_name ;
				if(move_uploaded_file($_FILES['page_image']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['page_image'] = $file_name ;
					$condition = " where id ='".$record_id."'";
					$sql->SqlUpdate('esthp_tblWebpage',$content_arr,$condition);
					
				}	
				//$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
				//@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
			  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-pages.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['page_id']))
{	

	$content_arr = array();	
	$content_arr["page_name"] = $_POST["page_name"] ;
	$content_arr["page_content"] = $_POST["page_content"];
	$content_arr["page_url"] =strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	$content_arr["meta_title"] = $_POST["meta_title"];
	$content_arr["meta_keywords"] = $_POST["meta_keywords"];
	$content_arr["meta_description"] = $_POST["meta_description"];
	$content_arr["date_modified"] = date("Y-m-d H:i:s",time());
	$content_arr["page_status"] = $_POST["page_status"];
	

    $condition = " where id='".$page_id."'";
	$sql->SqlUpdate('esthp_tblWebpage',$content_arr,$condition);		
	
	//update_htaccess();
	
	 if($_FILES['page_image']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."webpage_images/";
			
			@unlink($upload_dir.$_REQUEST['old_page_image']);
			//@unlink($upload_dir.'thumbs/'.$_REQUEST['old_comp_logo']);
			
			$file_name =$page_id.'_'.$_FILES['page_image']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['page_image']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['page_image'] = $file_name ;
				$condition = " where id ='".$page_id."'";
				$sql->SqlUpdate('esthp_tblWebpage',$content_arr,$condition);
			}
			//$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
			//@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-pages.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['page_id']))
{
	$cond = " WHERE id= '$page_id' "; 						
	$comp_arr = $sql->SqlSingleRecord('esthp_tblWebpage',$cond);
	$count = $comp_arr['count'];
	$Data = $comp_arr['Data'];			
}



if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{
	$content_arr=array();
	$content_arr['page_image'] = '' ;
	$condition = " where id ='".$page_id."'";
	$sql->SqlUpdate('esthp_tblWebpage',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."webpage_images/";
	
	@unlink($upload_dir.$Data['page_image']);
	//@unlink($upload_dir.'thumbs/'.$Data['comp_logo']);
	
	header("location:add-page.php?page_id=".$page_id);
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
			window.location.href="add-page.php?act=delimg&page_id=<?=$page_id?>"; 
		}
	}
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-pages.php">List Static Pages</a> &raquo; Add Static Page</div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="add-page" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Static Page </h1></td>
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
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page Name :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="page_name" id="chk_page_name" title="Please enter page name." type="text" class="input_white" size="48" value="<?=$Data['page_name']?>" ></td>
              </tr>
			  
			  

			  
			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			    <tr>
                <td align="right" valign="top" class="normal_text_blue">Page Content :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('page_content') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['page_content'];
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
                <td width="124" align="right" valign="top" class="normal_text_blue">Header Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_page_image" value="<?=$Data['page_image']?>"><input name="page_image" type="file" class="input_white" size="30">
				<?php
				$page_image=$Data['page_image'];
	
				if(is_file(_UPLOAD_FILE_PATH."webpage_images/".$page_image))
				{

				
				?>
				<a href="<?=_UPLOAD_FILE_URL?>webpage_images/<?=$page_image?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
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
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				  
				  
			  		<?
					$complete_url=explode(".html",$Data['page_url']);
					?>
					
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top" class="normal_text_blue">	<input name="page_url" id="chk_page_url" title="Please enter  page URL." type="text" class="input_white" size="48" value="<?=$complete_url[0]?>" >.html</td>
				  </tr>
				  
				  
				  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="meta_title" type="text" class="input_white" size="48" value="<?=$Data['meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Key Words: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_keywords" class="input_white" rows="4" cols="45"><?=$Data['meta_keywords']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_description" class="input_white" rows="4" cols="45"><?=$Data['meta_description']?></textarea></td>
              </tr>		  
			  
			  

			  			  
			  
			    <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		





             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="page_status" type="radio" value="active" <?=($Data['page_status']=='active' || $Data['page_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Active</span>      <input name="page_status" type="radio" value="inactive" <?=($Data['page_status']=='inactive' ? 'checked' : '')?>>  <span class="normal_text_blue">Inactive</span></td>
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
			
			if(isset($_REQUEST['page_id']) && $_REQUEST['page_id']!='')
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-pages.php'">				
				
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
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

$cat_id=$_REQUEST['cat_id'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	$content_arr["cat_name"] = $_POST["cat_name"] ;
	$content_arr["cat_description"] = $_POST["cat_description"];
	$content_arr["cat_meta_title"] = $_POST["cat_meta_title"];
	$content_arr["cat_meta_keywords"] = $_POST["cat_meta_keywords"] ;
	$content_arr["cat_meta_description"] = $_POST["cat_meta_description"];
	$content_arr["cat_page_url"] = strtolower(str_replace(" ","_",$_POST["cat_page_url"] )).".html";
	$content_arr['cat_modified_date'] = date("Y-m-d H:i:s",time());
	$content_arr["cat_status"] = $_POST["cat_status"];
	$record_id = $sql->SqlInsert('esthp_tblProdCat',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
		if($_FILES['cat_image']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."categories/";
				
				$file_name =$record_id.'_'.$_FILES['cat_image']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['cat_image']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['cat_image'] = $file_name ;
					
					$condition = " where cat_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
		
		
		if($_FILES['cat_small_image']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."categories/small/";
				
				$file_name =$record_id.'_'.$_FILES['cat_small_image']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['cat_small_image']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['cat_small_image'] = $file_name ;
					
					$condition = " where cat_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
					
				}	
		}
			  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-categories.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['cat_id']))
{	
	$content_arr = array();	
	
	$content_arr["cat_name"] = $_POST["cat_name"] ;
	$content_arr["cat_description"] = $_POST["cat_description"];
	$content_arr["cat_meta_title"] = $_POST["cat_meta_title"];
	$content_arr["cat_meta_keywords"] = $_POST["cat_meta_keywords"] ;
	$content_arr["cat_meta_description"] = $_POST["cat_meta_description"];
	$content_arr["cat_page_url"] = strtolower(str_replace(" ","_",$_POST["cat_page_url"] )).".html";
	$content_arr['cat_modified_date'] = date("Y-m-d H:i:s",time());
	$content_arr["cat_status"] = $_POST["cat_status"];
    $condition = " where cat_id='".$cat_id."'";
	$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);		
	
	//update_htaccess();
	
	 if($_FILES['cat_image']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."categories/";
			
			@unlink($upload_dir.$_REQUEST['old_cat_image']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_cat_image']);
			
			$file_name =$cat_id.'_'.$_FILES['cat_image']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['cat_image']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['cat_image'] = $file_name ;
				$condition = " where cat_id ='".$cat_id."'";
				$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
			}
			$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	
	if($_FILES['cat_small_image']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."categories/small/";
			
			@unlink($upload_dir.$_REQUEST['old_cat_small_image']);
			
			$file_name =$cat_id.'_'.$_FILES['cat_small_image']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['cat_small_image']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['cat_small_image'] = $file_name ;
				$condition = " where cat_id ='".$cat_id."'";
				$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
			}
	}
	

	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-categories.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['cat_id']))
{
	$cond = " WHERE cat_id= '$cat_id' "; 						
	$cat_arr = $sql->SqlSingleRecord('esthp_tblProdCat',$cond);
	$count = $cat_arr['count'];
	$Data = $cat_arr['Data'];			
}

//print_r($Data);

if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{

	$upload_dir= _UPLOAD_FILE_PATH."categories/";
	

	@unlink($upload_dir.$Data['cat_image']);
	@unlink($upload_dir.'thumbs/'.$Data['cat_image']);
	
	$content_arr=array();
	$content_arr['cat_image'] = '' ;
	$condition = " where cat_id ='".$cat_id."'";
	$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
	

	
	header("location:add-category.php?cat_id=".$cat_id);
}


if(isset($_REQUEST['act']) && $_REQUEST['act']=='delsmallimg')
{

	$upload_dir= _UPLOAD_FILE_PATH."categories/small/";
	

	@unlink($upload_dir.$Data['cat_small_image']);
	
	$content_arr=array();
	$content_arr['cat_small_image'] = '' ;
	$condition = " where cat_id ='".$cat_id."'";
	$sql->SqlUpdate('esthp_tblProdCat',$content_arr,$condition);
	

	
	header("location:add-category.php?cat_id=".$cat_id);
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
	
 
	function delete_catImage()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-category.php?act=delimg&cat_id=<?=$cat_id?>"; 
		}
	}
	
	
		function delete_catsmallImage()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-category.php?act=delsmallimg&cat_id=<?=$cat_id?>"; 
		}
	}
	
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-categories.php">Manage Categories</a></div></td></tr>
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
               <td><h1>Add Category </h1></td>
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
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Category Name :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="cat_name" id="chk_cat_name" title="Please enter category name." type="text" class="input_white" size="48" value="<?=$Data['cat_name']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  
			  
			  

              <tr>
                <td align="right" valign="top" class="normal_text_blue">Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('cat_description') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['cat_description'];
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
                <td width="124" align="right" valign="top" class="normal_text_blue">Banner Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_cat_image" value="<?=$Data['cat_image']?>"><input name="cat_image" type="file" class="input_white" size="30">
				<?php
				$cat_image=$Data['cat_image'];
				if(is_file(_UPLOAD_FILE_PATH."categories/".$cat_image))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>categories/<?=$cat_image?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_catImage()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
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
                <td width="124" align="right" valign="top" class="normal_text_blue">Small Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_cat_small_image" value="<?=$Data['cat_small_image']?>"><input name="cat_small_image" type="file" class="input_white" size="30">
				<?php
				$cat_small_image=$Data['cat_small_image'];
	
				if(is_file(_UPLOAD_FILE_PATH."categories/small/".$cat_small_image))
				{

				
				?>
				<a href="<?=_UPLOAD_FILE_URL?>categories/small/<?=$cat_small_image?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_catsmallImage()"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
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
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="cat_status" type="radio" value="active" <?=($Data['cat_status']=='active' || $Data['cat_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Active</span>      <input name="cat_status" type="radio" value="inactive" <?=($Data['cat_status']=='inactive' ? 'checked' : '')?>>  <span class="normal_text_blue">Inactive</span></td>
              </tr>
			  
			  
			  
			  


			  		<?
					$complete_url=explode(".html",$Data['cat_page_url']);
					?>
			  
			  
			  

			  
			
			<tr>
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top" class="normal_text_blue">	<input name="cat_page_url" id="chk_cat_page_url" title="Please enter category page URL." type="text" class="input_white" size="48" value="<?=$complete_url[0]?>" >.html</td>
				  </tr>
				  
				  
				  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="cat_meta_title" type="text" class="input_white" size="48" value="<?=$Data['cat_meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="cat_meta_keywords" class="input_white" rows="4" cols="45"><?=$Data['cat_meta_keywords']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="cat_meta_description" class="input_white" rows="4" cols="45"><?=$Data['cat_meta_description']?></textarea></td>
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
			
			if(isset($_REQUEST['cat_id']) && $_REQUEST['cat_id']!='')
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-categories.php'">				
				
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
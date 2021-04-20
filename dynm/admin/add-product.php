<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();


include_once(_CLASS_PATH."thumbnail.php");
require_once(_PATH."includes/resize_image.php");



$sqlError="";

$franchiseID=$_SESSION['AdminInfo']['id'];


$prodID=$_REQUEST['prodID'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	
	$content_arr["prod_name"] = $_POST["prod_name"] ;
	
	//$content_arr["page_url"] = strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	//$content_arr["meta_title"] = $_POST["meta_title"];
	//$content_arr["meta_keywords"] = $_POST["meta_keywords"] ;
	//$content_arr["meta_description"] = $_POST["meta_description"];
	
	$content_arr["prod_price"] = $_POST["prod_price"] ;
	
	$content_arr["prod_category"] = $_POST["prod_category"];
	
	$content_arr["prod_short_desc"] = $_POST["prod_short_desc"];
	
	$content_arr["prod_long_desc"] = $_POST["prod_long_desc"];
	
	$content_arr["prod_franchise"] = $franchiseID;
	
	$content_arr['prod_add_date'] = date("Y-m-d H:i:s",time());
	
	$content_arr['prod_modified_date'] = date("Y-m-d H:i:s",time());
	
	$content_arr["prod_status"] = $_POST["prod_status"];

	//$content_arr=add_slashes_arr($content_arr);

	$record_id = $sql->SqlInsert('esthp_tblProducts',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
	

		 if($_FILES['prod_small_img']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."products/";
				
				$file_name =$record_id.'_small_'.$_FILES['prod_small_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['prod_small_img']['tmp_name'], $upload_file))
				{
					$content_arr['prod_small_img'] = $file_name ;
					$condition = " where prod_id ='".$record_id."'";
					$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);
				}
				
				
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
					
				
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
				
				
				
				
		}	
		
		
		 if($_FILES['prod_large_img']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."products/";
				
				$file_name =$record_id.'_large_'.$_FILES['prod_large_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['prod_large_img']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['prod_large_img'] = $file_name ;
					$condition = " where prod_id ='".$record_id."'";
					$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);
				}	
				
				
				
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
					
				
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}	
				  
				  
				  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-products.php">';
		echo '<input type="hidden" name="msg" id="msg" value="added">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';
	}
	else
	{
	 	//$sqlError=mysql_error();
		
		$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>'.mysql_error().'</span>';
	}
}

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['prodID']))
{	
	$content_arr = array();	
	
	$content_arr["prod_name"] = $_POST["prod_name"] ;
	
	//$content_arr["page_url"] = strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	//$content_arr["meta_title"] = $_POST["meta_title"];
	//$content_arr["meta_keywords"] = $_POST["meta_keywords"] ;
	//$content_arr["meta_description"] = $_POST["meta_description"];
	
	$content_arr["prod_price"] = $_POST["prod_price"] ;
	
	$content_arr["prod_category"] = $_POST["prod_category"];
	
	$content_arr["prod_short_desc"] = $_POST["prod_short_desc"];
	
	$content_arr["prod_long_desc"] = $_POST["prod_long_desc"];
	
	$content_arr["prod_franchise"] = $franchiseID;
	
	//$content_arr['prod_add_date'] = date("Y-m-d H:i:s",time());
	
	$content_arr['prod_modified_date'] = date("Y-m-d H:i:s",time());
	
	$content_arr["prod_status"] = $_POST["prod_status"];

	//$content_arr=add_slashes_arr($content_arr);


    $condition = " where prod_id='".$prodID."' and prod_franchise='".$franchiseID."'";
	
	$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);		
	
	//update_htaccess();
	
	
	
		 if($_FILES['prod_small_img']['name']!="")
		{
	
				$upload_dir= _UPLOAD_FILE_PATH."products/";
				
				$file_name =$prodID.'_small_'.$_FILES['prod_small_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['prod_small_img']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['prod_small_img'] = $file_name ;
					$condition = " where prod_id ='".$prodID."'";
					$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);
				}	
				@unlink($upload_dir.$_REQUEST['old_prod_small_img']);
				
				@unlink($upload_dir.'thumbs/'.$_REQUEST['old_prod_small_img']);
				
				

				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
					
				
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}	
		
		
		 if($_FILES['prod_large_img']['name']!="")
		{
					
				
				$upload_dir= _UPLOAD_FILE_PATH."products/";
				
				@unlink($upload_dir.$_REQUEST['old_prod_large_img']);
				
				@unlink($upload_dir.'thumbs/'.$_REQUEST['old_prod_large_img']);
				
				$file_name =$prodID.'_large_'.$_FILES['prod_large_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['prod_large_img']['tmp_name'], $upload_file))
				{
					$content_arr['prod_large_img'] = $file_name ;
					$condition = " where prod_id ='".$prodID."'";
					$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);
				}	

				
				$dimensions=imageresize("150","150",$upload_file); // determine proportion size for creating thumb
				
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}	
	

	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-products.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}







if(!empty($_REQUEST['prodID']))
{
	$cond = " WHERE prod_id= '$prodID' "; 						
	$prod_arr = $sql->SqlSingleRecord('esthp_tblProducts',$cond);
	$count = $prod_arr['count'];
	$Data = $prod_arr['Data'];			
}




if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{
	$content_arr = array();	
	$type=$_REQUEST['type'];
	$content_arr[$type] = '' ;
	$condition = " where prod_id ='".$prodID."' and prod_franchise='".$franchiseID."'";
	$sql->SqlUpdate('esthp_tblProducts',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."products/";
	
	@unlink($upload_dir.$Data[$type]);
	@unlink($upload_dir.'thumbs/'.$Data[$type]);
	
	header("location:add-product.php?prodID=".$prodID);
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
	
	
	function delete_prodImage(type)
	{
	//alert("called");
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-product.php?act=delimg&prodID=<?=$prodID?>&type="+type; 
		}
	}
	
</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-products.php">Manage Products</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="add-product" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Product </h1></td>
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
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Product Name :</td>
                <td  align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="prod_name" id="chk_prod_name" title="Please enter product name." type="text" class="input_white" size="48" value="<?=$Data['prod_name']?>" ></td>
              </tr>
			  
			  		<?
					//$complete_url=explode(".html",$Data['page_url']);
					?>
			  
			  
			  

			<!--	  
			
			<tr>
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top" class="normal_text_blue">	<input name="page_url"  type="text" class="input_white" size="48" value="<? //=$complete_url[0]?>" alt="BC~DM~Page URL.~DM~">.html</td>
				  </tr>
				  
				  
				  
				     <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="meta_title" type="text" class="input_white" size="48" value="<? //=$Data['meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_keywords" class="input_white" rows="4" cols="45"><? //=$Data['meta_keywords']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_description" class="input_white" rows="4" cols="45"><? //=$Data['meta_description']?></textarea></td>
              </tr>		  

 -->
			 
			 
			 
			     <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Product Price :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	$ <input name="prod_price" id="chkintf_prod_price" title="Please enter product price." type="text" class="input_white" size="7" value="<?=$Data['prod_price']?>"></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Product Category :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">
				<select name="prod_category" class="input_white" id="chksbox_prod_category" title="Please select product category.">
				<option value="">Select Category</option>
				<?php
				$cat_array=getProdCategoriesAdmin();
				foreach($cat_array as $cat_data)
				{
				?>
				<option value="<?=$cat_data['cat_id']?>" <?=($Data['prod_category']==$cat_data['cat_id']?'selected':'')?>><?=$cat_data['cat_name']?></option>
				<?php
				}
				?>
				</select>
				</td>
              </tr>



   			<tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Product Short Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('prod_short_desc') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['prod_short_desc'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="200" ;
				$oFCKeditor1->Create() ;	
				?>
				</td>
              </tr>
			  
			  
			  
			     <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Product Long Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				
				$oFCKeditor2 = new FCKeditor('prod_long_desc') ;
				$oFCKeditor2->BasePath	= $sBasePath ;
				$oFCKeditor2->Value	=$Data['prod_long_desc'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor2->Width="90%" ;
				$oFCKeditor2->Height="200" ;
				$oFCKeditor2->Create() ;	
				?>
				</td>
              </tr>
			  
			  
			         <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Product Small Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_prod_small_img" value="<?=$Data['prod_small_img']?>"><input name="prod_small_img" type="file" class="input_white" size="30">
				<?php
				$prod_small_img=$Data['prod_small_img'];
				
				if(is_file(_UPLOAD_FILE_PATH."products/".$prod_small_img))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>products/<?=$prod_small_img?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_prodImage('prod_small_img')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
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
                <td width="124" align="right" valign="top" class="normal_text_blue">Product Large Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_prod_large_img" value="<?=$Data['prod_large_img']?>"><input name="prod_large_img" type="file" class="input_white" size="30">
				<?php
				$prod_large_img=$Data['prod_large_img'];
				
				if(is_file(_UPLOAD_FILE_PATH."products/".$prod_large_img))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>products/<?=$prod_large_img?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);"  onclick="javascript:delete_prodImage('prod_large_img')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
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
                <td align="right" valign="top" class="normal_text_blue">Product Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="prod_status" type="radio" value="active" <?=($Data['prod_status']=='active' || $Data['prod_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Active</span>      <input name="page_status" type="radio" value="inactive" <?=($Data['prod_status']=='inactive' ? 'checked' : '')?>>  <span class="normal_text_blue">Inactive</span></td>
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
			
			if(isset($_REQUEST['prodID']) && $_REQUEST['prodID']!='')
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-products.php'">				
				
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
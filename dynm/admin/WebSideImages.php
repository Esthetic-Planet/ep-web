<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
include_once(_CLASS_PATH."/class.upload.php");
$AuthAdmin->ChkLogin();
$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$sqlError="";
$webId=$_REQUEST['webId'];

// single Delete start
if($_REQUEST['delid']!="")
{
			
			$id_del = $_REQUEST['delid'];
			$ConArr_del = " WHERE id= '$id_del' "; 						
			$arrDest_del = $sql->SqlSingleRecord('mos_WebSideImages',$ConArr_del);
			$count_del = $arrDest_del['count'];
			$Data_del = $arrDest_del['Data'];	 
		if($count_del>0)
		{
			$delid=$_REQUEST['delid'];
			$cond = " id = ".$delid;
			$sql->SqlDelete('mos_WebSideImages',$cond);	
			unlink(_UPLOAD_FILE_PATH."/WebSideImages/".$Data_del['image_name']);
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'WebSideImages.php">';
		echo '<input type="hidden" name="msg" id="msg" value="deleted">';
		echo '<input type="hidden" name="webId" id="webId" value="'.$webId.'">';
		echo '<input type="hidden" name="page" value="'.$page.'">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;
		}
}
// single Delete end

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")
{		
		$ReqArr = $_REQUEST;
		$ConArr = array();		
		foreach($ReqArr as $k=>$v)
		{
			if($k=="image_title" || $k=='image_link' ||  $k=="display_order")
				$ConArr[$k]=addslashes($v);
		}
		
		$ConArr['web_id'] =$webId;
		$intResult = $sql->SqlInsert('mos_WebSideImages',$ConArr);
		if($intResult)
		{
			if($_FILES['image_name']['name']!="")
			{
				////////////////////////////////////////
				// ---------- SIMPLE UPLOAD ----------
				// we create an instance of the class, giving as argument the PHP object 
				// corresponding to the file field from the form
				// All the uploads are accessible from the PHP object $_FILES
				$handle = new Upload($_FILES['image_name']);
				
				
			
				// then we check if the file has been uploaded properly
				// in its *temporary* location in the server (often, it is /tmp)
					if ($handle->uploaded) {					
					
					//$handle->file_new_name_body   = 'image_resized';
					//$handle->image_resize         = true;
					//$handle->image_x              = 166;
					//$handle->image_ratio_y        = true;
						// yes, the file is on the server
						// now, we start the upload 'process'. That is, to copy the uploaded file
						// from its temporary location to the wanted location
						// It could be something like $handle->Process('/home/www/my_uploads/');
						$handle->Process(_UPLOAD_FILE_PATH."/WebSideImages/");
						
						// we check if everything went OK
						if ($handle->processed) {
							// everything was fine !
							$ConArr['image_name'] = $handle->file_dst_name;
							$CondArr = " WHERE id = ".$intResult;
							$intResult = $sql->SqlUpdate('mos_WebSideImages',$ConArr,$CondArr);
					 		//@unlink(_UPLOAD_FILE_PATH."/brands/".$_REQUEST['old_brand_img']);
						// we delete the temporary files
        				$handle-> Clean();
						}
						else { $sqlError .='  Error: ' . $handle->error . ''; }
					}
								 
		 }
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'WebSideImages.php">';
			echo '<input type="hidden" name="msg" id="msg" value="added">';
			echo '<input type="hidden" name="webId" id="webId" value="'.$webId.'">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
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
			if($k=="image_title" || $k=='image_link'  || $k=="display_order")
				$ConArr[$k]=addslashes($v);
		}
		//print_r($ConArr);exit;
		
		$CondArr = " WHERE id = ".$_REQUEST['id'];
		$intResult = $sql->SqlUpdate('mos_WebSideImages',$ConArr,$CondArr);		
		if($_FILES['image_name']['name']!="")
		{
				////////////////////////////////////////
				// ---------- SIMPLE UPLOAD ----------
				// we create an instance of the class, giving as argument the PHP object 
				// corresponding to the file field from the form
				// All the uploads are accessible from the PHP object $_FILES
				$handle = new Upload($_FILES['image_name']);
			
				// then we check if the file has been uploaded properly
				// in its *temporary* location in the server (often, it is /tmp)
					if ($handle->uploaded) {
					
					//$handle->file_new_name_body   = 'image_resized';
					//$handle->image_resize         = true;
					//$handle->image_x              = 166;
					//$handle->image_ratio_y        = true;
						// yes, the file is on the server
						// now, we start the upload 'process'. That is, to copy the uploaded file
						// from its temporary location to the wanted location
						// It could be something like $handle->Process('/home/www/my_uploads/');
						$handle->Process(_UPLOAD_FILE_PATH."/WebSideImages/");
						
						// we check if everything went OK
						if ($handle->processed) {
							// everything was fine !
							$ConArr['image_name'] = $handle->file_dst_name;
							$CondArr = " WHERE id = ".$_REQUEST['id'];
							$intResult = $sql->SqlUpdate('mos_WebSideImages',$ConArr,$CondArr);
					 		@unlink(_UPLOAD_FILE_PATH."/WebSideImages/".$_REQUEST['old_image_name']);
						// we delete the temporary files
        				$handle-> Clean();
						}
						else { $sqlError .='  Error: ' . $handle->error . ''; }
					}
								 
		 }
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'WebSideImages.php">';
		echo '<input type="hidden" name="msg" id="msg" value="update">';
		echo '<input type="hidden" name="webId" id="webId" value="'.$webId.'">';
		echo '<input type="hidden" name="page" value="'.$page.'">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;
		
		}
		
	
	
	if(isset($_REQUEST['did']) && ($_REQUEST['mode']=='edit'))
	{
		$id = $_REQUEST['did'];
		$ConArr = " WHERE id= '$id' "; 						
		$arrBrands = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr);
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
			if(formnm.image_name.value=='' && formnm.old_image_name.value=='')
			{
				alert("please select the Image file");
				return false;
			}
			if(formnm.display_order.value=="" || isNaN(formnm.display_order.value))
			{
				alert("please enter only numeric  value  for 'displayOrder'");
				formnm.display_order.focus();
				return false;
			}
}		

function SingleDelete(url)
{	
	if(confirm("Are you sure you want to delete the selected Record(s)?"))
	{
		document.location=url;
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
<?php
if(isset($_REQUEST['id']) && ($_REQUEST['mode']=='edit'))
	{
		$id = $_REQUEST['id'];
		$ConArr = " WHERE id= '$id' "; 						
		$arrBrands = $sql->SqlSingleRecord('mos_WebSideImages',$ConArr);
		$count = $arrBrands['count'];
		$Data = $arrBrands['Data'];		 
	}
	
	
	$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';
if($msg=='added')
	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";
else if($msg=='update')
	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";
else if($msg=='deleted')
	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";
?>
<form name="frmAddDest" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
                <td><h1>Manage Web  Images </h1></td>
              </tr>
            </table></td>
          </tr>
          <tr>
          <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5">		</td></tr>
		   <tr>
            <td valign="top" align="center">
			<?php if($sqlError!="") { ?><span class="loginErrBox" style="margin:15px;"><?=$sqlError?></span><?php } ?>
			<?=$message?>			</td>
          </tr>
		 <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>			</td>
          </tr>
		  <?php
		  if($_REQUEST['mode']=='add' || $_REQUEST['mode']=='edit') { ?>
          <tr>
            <td valign="top"><table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Upload Image :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">				
				<input type="hidden" name="old_image_name" value="<?=stripslashes($Data['image_name'])?>">
				<input name="image_name" type="file" class="textarea2" size="34">
				<?php  
					if($Data['image_name'])
					{
					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/WebSideImages/'.$Data['image_name'].'" 	rel="facebox">
					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	
					}
					
				?>				</td>
              </tr>
			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Image Title </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="image_title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['image_title'])?>"></td>
              </tr>
			  
			   <tr>
                <td width="141" align="right" valign="top" class="normal_text_blue">Image link:</td>
                <td width="9" align="left" valign="top">&nbsp;</td>
                <td width="450" align="left" valign="top">
				<input name="image_link" type="text" class="input_white" size="48" value="<?=stripslashes($Data['image_link'])?>" >				</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Display Order :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="display_order" type="text" class="input_white" size="6" value="<?=stripslashes($Data['display_order'])?>" >				</td>
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
				<input type="hidden" name="webId" value="<?=$webId?>" >
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='WebSideImages.php?webId=<?=$webId?>'">	
				</td>
              </tr>
            </table></td>
          </tr>
		  <?php } ?>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
          
          <tr>
            <td valign="top">
			</td>
          </tr>
		  <?php
		$records_per_page=100;			
		$offset = ($page-1) * $records_per_page;
		$cond="WHERE web_id='$webId' ";
		$orderby=" ORDER BY display_order,id";
		$webPage = $sql->SqlRecords("mos_WebSideImages",$cond,$orderby,$offset=0,$records_per_page);
		$count_total=$webPage['TotalCount'];
		$count = $webPage['count'];
		$Data = $webPage['Data'];		
		
		  if($_REQUEST['mode']!='add' && $_REQUEST['mode']!='edit') 
		  {		
		  ?>
          <tr>
            <td valign="top">
			<table width="98%" border="0" cellspacing="0" cellpadding="0" align="center">
			  <tr>
				<td>
				<input type="button" class="btn" name="Add" value="Add New" onClick="document.location='?mode=add&webId=<?=$webId?>' ">
				</td>
				<td align="right">
				<input type="button" class="btn" name="close" value="Close" onClick="javascript: window.close();">
				</td>
			  </tr>
			</table>

			<table width="98%" border="0" cellspacing="1" cellpadding="1" align="center" bgcolor="#66CCFF" bordercolor="#CCCCCC">
			  
			  <tr bgcolor="#00CCFF">
				<td width="62%" align="center" class="white_text">Image</td>
				<td width="22%" align="center" class="white_text">Action</td>
			  </tr>
			  <?php 
					if($count>0){
						for($i=0; $i<$count; $i++)
						{
							if($Data[$i]['image_name']!="" && file_exists(_UPLOAD_FILE_PATH."/WebSideImages/".$Data[$i]['image_name']))
							{
							$img='<img src="'._WWW_UPLOAD_IMAGE_PATH.'/WebSideImages/'.$Data[$i]['image_name'].'" border="0" width="100" height="100" />';
							}
							else
							{
							$img='<img src="'._WWW_UPLOAD_IMAGE_PATH.'/WebSideImages/no_image_icon.jpg" border="0" width="100" height="100" />';
							}
					?>
			  <tr bgcolor="#FFFFFF">
			    <td align="center"><?=$img?></td>
			    <td align="center">
				<a href="WebSideImages.php?mode=edit&id=<?=$Data[$i]['id']?>&webId=<?=$webId?>"><img src="images/b_edit.png" border="0"></a>&nbsp;
				<a href="javascript: void(0)" onclick="SingleDelete('WebSideImages.php?delid=<?=$Data[$i]['id']?>&webId=<?=$webId?>');">				
				<img src="images/b_drop.png" border="0"></a>				</td>
		      </tr>
			  <?php 
					 	} 
					 }
					 else
					{
						echo '<tr class="grey_bg"><td height="25" colspan="2" class="empty_record_txt">NO Record Found.</td></tr>';
					}
					 ?>
			</table>			</td>
          </tr>
		  <?php 
		  } ?>
        </table>
</form>
</body>
</html>

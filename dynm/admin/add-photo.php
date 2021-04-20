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

			if($k=="title" || $k=="description" || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		

		$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

		$intResult = $sql->SqlInsert('mos_tblPhoto',$ConArr);		

		if($intResult)

		{

			

				// upload  thumbnail image start 

					if($_FILES['thumb_img']['name']!="")

					{

						////////////////////////////////////////

						// ---------- SIMPLE UPLOAD ----------

						// we create an instance of the class, giving as argument the PHP object 

						// corresponding to the file field from the form

						// All the uploads are accessible from the PHP object $_FILES

						$handle = new Upload($_FILES['thumb_img']);

					

						// then we check if the file has been uploaded properly

						// in its *temporary* location in the server (often, it is /tmp)

							if ($handle->uploaded) {

							

								//$handle->file_new_name_body   = 'image_resized';

								$handle->image_resize         = true;

								$handle->image_x              = 130;

								$handle->image_ratio_y        = true;

								// yes, the file is on the server

								// now, we start the upload 'process'. That is, to copy the uploaded file

								// from its temporary location to the wanted location

								// It could be something like $handle->Process('/home/www/my_uploads/');

								$handle->Process(_UPLOAD_FILE_PATH."/photoGallery/thumb/");

								

								// we check if everything went OK

								if ($handle->processed) {

									// everything was fine !

									$ConArr['thumb_img'] = $handle->file_dst_name;

									$CondArr = " WHERE pid = ".$intResult;

									 $sql->SqlUpdate('mos_tblPhoto',$ConArr,$CondArr);

									//@unlink(_UPLOAD_FILE_PATH."/brands/".$_REQUEST['old_brand_img']);

								// we delete the temporary files

								$handle-> Clean();

								}

								else { $sqlError .='  Error: ' . $handle->error . ''; }

							}

						}

						// upload  thumbnail image end

						

						// upload  Full-Size image start 

					

					if($_FILES['fullsize_img']['name']!="")

					{

						////////////////////////////////////////

						// ---------- SIMPLE UPLOAD ----------

						// we create an instance of the class, giving as argument the PHP object 

						// corresponding to the file field from the form

						// All the uploads are accessible from the PHP object $_FILES

						$handle = new Upload($_FILES['fullsize_img']);

					

						// then we check if the file has been uploaded properly

						// in its *temporary* location in the server (often, it is /tmp)

							if ($handle->uploaded) {

								// yes, the file is on the server

								// now, we start the upload 'process'. That is, to copy the uploaded file

								// from its temporary location to the wanted location

								// It could be something like $handle->Process('/home/www/my_uploads/');

								$handle->Process(_UPLOAD_FILE_PATH."/photoGallery/");

								

								// we check if everything went OK

								if ($handle->processed) {

									// everything was fine !

									$ConArr['fullsize_img'] = $handle->file_dst_name;

									$CondArr = " WHERE pid = ".$intResult;

									$sql->SqlUpdate('mos_tblPhoto',$ConArr,$CondArr);

									

									//@unlink(_UPLOAD_FILE_PATH."/brands/".$_REQUEST['old_brand_img']);

								// we delete the temporary files

								$handle-> Clean();

								}

								else { $sqlError .='  Error: ' . $handle->error . ''; }

							}

						}

						

					// upload  Full-Size image end 

		

			echo "<body>";

			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-photo.php">';

			echo '<input type="hidden" name="msg" id="msg" value="added">';

			echo '<input type="hidden" name="page" value="'.$page.'">';

			echo '</form>';

			echo '<script type="text/javascript">document.frmSu.submit();</script>';

			echo '</body>';

		}

		else

		{

			$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);

			$db->connectDB();

		 	$sqlError=$db->showLastQuery();

		}

		

	

}

	else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['pid']))

	{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="title" || $k=='description' || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		//print_r($ConArr);exit;

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());	

		$CondArr = " WHERE pid = ".$_REQUEST['pid'];

		$intResult = $sql->SqlUpdate('mos_tblPhoto',$ConArr,$CondArr);		

		// upload  thumbnail image start 

					if($_FILES['thumb_img']['name']!="")

					{

						////////////////////////////////////////

						// ---------- SIMPLE UPLOAD ----------

						// we create an instance of the class, giving as argument the PHP object 

						// corresponding to the file field from the form

						// All the uploads are accessible from the PHP object $_FILES

						$handle = new Upload($_FILES['thumb_img']);

					

						// then we check if the file has been uploaded properly

						// in its *temporary* location in the server (often, it is /tmp)

							if ($handle->uploaded) {

							

								//$handle->file_new_name_body   = 'image_resized';

								$handle->image_resize         = true;

								$handle->image_x              = 130;

								$handle->image_ratio_y        = true;

								

								// yes, the file is on the server

								// now, we start the upload 'process'. That is, to copy the uploaded file

								// from its temporary location to the wanted location

								// It could be something like $handle->Process('/home/www/my_uploads/');

								$handle->Process(_UPLOAD_FILE_PATH."/photoGallery/thumb/");

								

								// we check if everything went OK

								if ($handle->processed) {

									// everything was fine !

									$ConArr['thumb_img'] = $handle->file_dst_name;

									$CondArr = " WHERE pid = ".$_REQUEST['pid'];

									$intResult = $sql->SqlUpdate('mos_tblPhoto',$ConArr,$CondArr);

									unlink(_UPLOAD_FILE_PATH."/photoGallery/thumb/".$_REQUEST['old_brand_img']);

								// we delete the temporary files

								$handle-> Clean();

								}

								else { $sqlError .='  Error: ' . $handle->error . ''; }

							}

					}		

						// upload  thumbnail image end

						

						// upload  Full-Size image start 

					

					if($_FILES['fullsize_img']['name']!="")

					{

						////////////////////////////////////////

						// ---------- SIMPLE UPLOAD ----------

						// we create an instance of the class, giving as argument the PHP object 

						// corresponding to the file field from the form

						// All the uploads are accessible from the PHP object $_FILES

						$handle = new Upload($_FILES['fullsize_img']);

					

						// then we check if the file has been uploaded properly

						// in its *temporary* location in the server (often, it is /tmp)

							if ($handle->uploaded) {

								// yes, the file is on the server

								// now, we start the upload 'process'. That is, to copy the uploaded file

								// from its temporary location to the wanted location

								// It could be something like $handle->Process('/home/www/my_uploads/');

								$handle->Process(_UPLOAD_FILE_PATH."/photoGallery/");

								

								// we check if everything went OK

								if ($handle->processed) {

									// everything was fine !

									$ConArr['fullsize_img'] = $handle->file_dst_name;

									$CondArr = " WHERE pid = ".$_REQUEST['pid'];

									$intResult = $sql->SqlUpdate('mos_tblPhoto',$ConArr,$CondArr);

									unlink(_UPLOAD_FILE_PATH."/photoGallery/".$_REQUEST['old_fullsize_img']);

								// we delete the temporary files

								$handle-> Clean();

								}

								else { $sqlError .='  Error: ' . $handle->error . ''; }

							}

					 }

					// upload  Full-Size  image end 

								 

		

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-photo.php">';

		echo '<input type="hidden" name="msg" id="msg" value="update">';

		echo '<input type="hidden" name="page" value="'.$page.'">';

		echo '</form>';

		echo '<script type="text/javascript">document.frmSu.submit();</script>';

		echo '</body>';		

		exit;

		

		

	}	

	

	

	if(isset($_REQUEST['pid']) && ($_REQUEST['mode']=='edit'))

	{

		$id = $_REQUEST['pid'];

		$ConArr = " WHERE pid= '$id' "; 						

		$arrBrands = $sql->SqlSingleRecord('mos_tblPhoto',$ConArr);

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

    <td valign="top"><?php include_once('include/header.php');?></td>

  </tr>

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>

        <td width="14" valign="top">&nbsp;</td>

        <td valign="top">

		<form name="frmAddBrands" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>Add Photo </h1></td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5">

			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>

			</td>

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

                <td width="141" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Title:</td>

                <td width="5" align="left" valign="top">&nbsp;</td>

                <td width="454" align="left" valign="top">

				<input name="title" type="text" class="input_white" size="45" value="<?=stripslashes($Data['title'])?>" alt="BC~DM~ photo title ~DM~">				</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

			  <tr>

                <td align="right" valign="top" class="normal_text_blue">Thumbnail Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_thumb_img" value="<?=stripslashes($Data['thumb_img'])?>">

				<input name="thumb_img" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['thumb_img'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/photoGallery/thumb/'.$Data['thumb_img'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

					

				?>				</td>

              </tr>

			  <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

			  <tr>

                <td align="right" valign="top" class="normal_text_blue">Full-Size Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_fullsize_img" value="<?=stripslashes($Data['fullsize_img'])?>">

				<input name="fullsize_img" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['fullsize_img'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/photoGallery/'.$Data['fullsize_img'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

					

				?>				</td>

              </tr>

			  <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue"> Description:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<textarea name="description" cols="45" rows="3" class="input_white"><?=$Data['description']?></textarea>

				<?php

				/*

					$fullDes = stripslashes($Data['description']);				

					include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;

					//$oFCKeditor->BasePath = _WWWROOT. '/htmleditor/' ;	// '/FCKeditor/' is the default value.

					$sBasePath = _HTML_EDITOR_PATH."/";

					$oFCKeditor = new FCKeditor('description') ;

					$oFCKeditor->BasePath	= $sBasePath ;

					$oFCKeditor->Value	= $fullDes;

					$oFCKeditor->ToolbarSet ="Basic";

					$oFCKeditor->Width="300" ;

					$oFCKeditor->Height="150" ;

					$oFCKeditor->Create() ;	

				*/

				?>	 

				</td>

              </tr>

              <tr >



                <td align="left" valign="top" colspan="3">&nbsp;

					

				</td>

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

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-photo.php?page=<?=$page?>'">				</td>

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

  <tr>

    <td valign="top"><?php include_once('include/footer.php');?></td>

  </tr>

</table>

</body>

</html>


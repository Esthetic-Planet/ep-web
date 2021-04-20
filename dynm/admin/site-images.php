<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";



	 if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update")

	{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		/*

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

		

		*/

					if($_FILES['headerimage']['name']!="")

					{



					    $uploadfile = $uploaddir . basename($_FILES['headerimage']['name']);
						

						move_uploaded_file($_FILES['headerimage']['tmp_name'], $uploadfile);

						$ConArr['headerimage'] = $_FILES['headerimage']['name'];

							$delheader = $_REQUEST['old_headerimage'];
						

							if($delheader!='')

							{

								$delheaderimg = _UPLOAD_FILE_PATH.'/main_imges/'.$delheader;

								unlink($delheaderimg);

							}


					}

						if($_FILES['leftimge']['name']!="")

					{

						$uploaddir = _UPLOAD_FILE_PATH.'/main_imges/';

					    $uploadfile = $uploaddir . basename($_FILES['leftimge']['name']);

						move_uploaded_file($_FILES['leftimge']['tmp_name'], $uploadfile);

						$ConArr['leftimge'] = $_FILES['leftimge']['name'];

						$delheader = $_REQUEST['old_leftimge'];

							if($delheader!='')

							{

								@$delheaderimg = _UPLOAD_FILE_PATH.'/main_imges/'.$delheader;

								unlink($delheaderimg);

							}

						

						

					}	

							if($_FILES['righttop']['name']!="")

					{

						$uploaddir = _UPLOAD_FILE_PATH.'/main_imges/';

					    $uploadfile = $uploaddir . basename($_FILES['righttop']['name']);

						move_uploaded_file($_FILES['righttop']['tmp_name'], $uploadfile);

						$ConArr['righttop'] = $_FILES['righttop']['name'];

						$delheader = $_REQUEST['old_righttop'];

							if($delheader!='')

							{

								$delheaderimg = _UPLOAD_FILE_PATH.'/main_imges/'.$delheader;

								unlink($delheaderimg);

							}

						

					}	

							

							if($_FILES['rightbottom']['name']!="")

					{

						$uploaddir = _UPLOAD_FILE_PATH.'/main_imges/';

					    $uploadfile = $uploaddir . basename($_FILES['rightbottom']['name']);

						move_uploaded_file($_FILES['rightbottom']['tmp_name'], $uploadfile);

						$ConArr['rightbottom'] = $_FILES['rightbottom']['name'];

						$delheader = $_REQUEST['old_rightbottom'];

							if($delheader!='')

							{

								$delheaderimg = _UPLOAD_FILE_PATH.'/main_imges/'.$delheader;

								unlink($delheaderimg);

							}

					}	

					

						if($_FILES['insideImage']['name']!="")

					{

						$uploaddir = _UPLOAD_FILE_PATH.'/main_imges/';

					    $uploadfile = $uploaddir . basename($_FILES['insideImage']['name']);

						move_uploaded_file($_FILES['insideImage']['tmp_name'], $uploadfile);

						$ConArr['inside_banner'] = $_FILES['insideImage']['name'];

						$delheader = $_REQUEST['old_insideImage'];

							if($delheader!='')

							{

								$delheaderimg = _UPLOAD_FILE_PATH.'/main_imges/'.$delheader;

								unlink($delheaderimg);

							}

					}	

							

								 

			

			//$CondArr = " WHERE id = 1";

			$sql->SqlUpdate('mos_siteImages',$ConArr,"where id=1");	

		

		

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'site-images.php">';

		echo '<input type="hidden" name="msg" id="msg" value="update">';

		echo '<input type="hidden" name="page" value="'.$page.'">';

		echo '</form>';

		echo '<script type="text/javascript">document.frmSu.submit();</script>';

		echo '</body>';		

		exit;

			

	}	

	

	

	

		//$id = $_REQUEST['pid'];

		$ConArr = " WHERE id= 1 "; 						

		$arrBrands = $sql->SqlSingleRecord('mos_siteImages',$ConArr);

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

                <td><h1>Manage Site Images </h1></td>

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

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

			  <tr>

                <td align="right" valign="top" class="normal_text_blue">Header Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_headerimage" value="<?=stripslashes($Data['headerimage'])?>">

				<input name="headerimage" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['headerimage'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/main_imges/'.$Data['headerimage'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

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

                <td align="right" valign="top" class="normal_text_blue">Left Panel  Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_leftimge" value="<?=stripslashes($Data['leftimge'])?>">

				<input name="leftimge" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['leftimge'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/main_imges/'.$Data['leftimge'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

				?>

				</td>

              </tr>

			

			  <!--<tr>

                <td align="right" valign="top" class="normal_text_blue">Right Top    Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_righttop" value="<?=stripslashes($Data['righttop'])?>">

				<input name="righttop" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['leftimge'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/main_imges/'.$Data['leftimge'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

					

				?>				</td>

              </tr>-->

			   <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

<!--			  <tr>

                <td align="right" valign="top" class="normal_text_blue">Left Panel  Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_rightbottom" value="<?=stripslashes($Data['rightbottom'])?>">

				<input name="rightbottom" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['rightbottom'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/main_imges/'.$Data['rightbottom'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

				?>	

				</td>

              </tr>-->

			  

			  

			  	  <tr>

                <td align="right" valign="top" class="normal_text_blue">Inside Image:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input type="hidden" name="old_insideImage" value="<?=stripslashes($Data['inside_banner'])?>">

				<input name="insideImage" type="file" class="textarea2" size="34">

				 <?php  

					if($Data['inside_banner'])

					{

					echo '<a href="'._WWW_UPLOAD_IMAGE_PATH.'/main_imges/'.$Data['inside_banner'].'" 	rel="facebox">

					<img src="'._ADMIN_IMAGE_PATH.'/image_icon.gif" border="0" title="Click here to see Image"></a>' ;	

					}

				?>	

				</td>

              </tr>

			  

			  

			  

			  <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

             

              <tr >



                <td align="left" valign="top" colspan="3">&nbsp;

					

				</td>

              </tr>

			

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

			

                <td align="left" valign="top">

				<input type="submit" class="btn" name="Submit" value="Update">

					</td>

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


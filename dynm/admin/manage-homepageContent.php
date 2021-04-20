<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

$AuthAdmin->ChkLogin();

$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")

{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="name" || $k=='title' || $k=="metaKeyword" || $k=="metaDesc" || $k=="pageLink"  || $k=="long_desc"

			|| $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		

		$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

		$intResult = $sql->SqlInsert('mos_tblHomepageContent',$ConArr);

		if($intResult)

		{

			echo "<body>";

			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'home.php">';

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

	else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['id']))

	{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="name" || $k=='title' || $k=="metaKeyword" || $k=="metaDesc" || $k=="pageLink"  || $k=="long_desc" || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		$CondArr = " WHERE id = ".$_REQUEST['id'];

		$sql->SqlUpdate('mos_tblHomepageContent',$ConArr,$CondArr);		

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'home.php">';

		echo '<input type="hidden" name="msg" id="msg" value="update">';

		echo '<script>';

		echo 'alert("Record Updated Successfully");';

		echo '</script>';

		echo '</form>';

		echo '<script type="text/javascript">document.frmSu.submit();</script>';

		echo '</body>';		

		exit;

	}



	if(isset($_REQUEST['id']) && ($_REQUEST['mode']=='edit') && !isset($_REQUEST['Submit']))

	{

		$id = $_REQUEST['id'];

		$ConArr = " WHERE id= '$id' "; 						

		$arrArticle = $sql->SqlSingleRecord('mos_tblHomepageContent',$ConArr);

		$count = $arrArticle['count'];

		$Data = $arrArticle['Data'];		 

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

<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>

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

		<form name="frmAddHomePage" action="" method="post" onsubmit="return SubmitForm(this);">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>Manage Homepage Contents</h1></td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td  valign="top"><img src="images/spacer.gif" alt="" width="1" height="25" align="left">

			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>

          </tr>

		  <tr>

            <td valign="top" align="center"><?=$sqlError?></td>

          </tr>

          <tr>

            <td valign="top"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">

              

              <tr>

                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Home Page Name :</td>

                <td  align="left" valign="top">&nbsp;</td>

                <td width="334" align="left" valign="top">

				<input name="name" type="name" class="input_white" size="48" value="<?=stripslashes($Data['name'])?>" alt="BC~DM~ home page name~DM~"></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td width="124" align="right" valign="top" class="normal_text_blue">Title :</td>

                <td width="4" align="left" valign="top">&nbsp;</td>

                <td width="334" align="left" valign="top">

				<input name="title" id="title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['title'])?>"></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><input name="metaKeyword" id="metaKeyword" type="text" class="input_white" size="48" value="<?=stripslashes($Data['metaKeyword'])?>"></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Desc.: </td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><input name="metaDesc" id="metaDesc" type="text" class="input_white" size="48" value="<?=stripslashes($Data['metaDesc'])?>"></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

				<tr>

                <td align="right" valign="top" class="normal_text_blue">page link :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="pageLink" id="pageLink"  class="input_white" size="48" value="<?=stripslashes($Data['pageLink'])?>"></td>

              </tr>

              <!--<tr>

                <td align="right" valign="top" class="normal_text_blue">Meta Keywords :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><textarea name="textarea4" cols="50" rows="3" class="input_white"></textarea></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">                                  Meta Descriptions :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><textarea name="textarea6" cols="50" rows="3" class="input_white"></textarea></td>

              </tr> -->

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td>

					

				<a href="#" class="link_blue_bold" onClick="popupWindow('homeTopImages.php?destId=<?=$_REQUEST['did']?>',650,420);"><img src="images/upload_file_big.png" border="0" align="Manage Top Image" title="Manage Top Images">

				Manage Top Image </a>					</td>

					<td>

					<a href="#" class="link_blue_bold" 	onClick="popupWindow('homeSideImages.php?destId=<?=$_REQUEST['did']?>',650,420);">

					<img src="images/upload_file_big.png" border="0" align="Manage Side Image" title="Manage Side Images">

					Manage Side Image					</a>					</td>

				  </tr>

				</table>



				

				</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Home Page Content :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              

              <tr>

                <td  colspan="3" align="left" valign="top">

				<!--<textarea name="long_desc" cols="50" rows="6" class="input_white"><?=stripslashes($Data['long_desc'])?></textarea> -->

				<?php

					$fullDes = stripslashes($Data['long_desc']);				

					include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;					

					$sBasePath = _HTML_EDITOR_PATH."/";

					$oFCKeditor = new FCKeditor('long_desc') ;

					$oFCKeditor->BasePath	= $sBasePath ;

					$oFCKeditor->Value	= $fullDes;

					//$oFCKeditor->ToolbarSet ="Basic";

					$oFCKeditor->Width="100%" ;

					$oFCKeditor->Height="300" ;

					$oFCKeditor->Create() ;	

				?>	

				</td>

                </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

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

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<?php

						if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')

						{

							$btnName = "Update";

						}

						else

						{

							$btnName = "Add";

						}

					?>				</td>

                <td align="left" valign="top">

				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='home.php'">				</td>

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


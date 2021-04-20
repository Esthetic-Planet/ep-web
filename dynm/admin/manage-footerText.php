<?php



include_once("../includes/global.inc.php");



require_once(_PATH."/modules/mod_admin_login.php");



$AuthAdmin->ChkLogin();



$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;



$sqlError="";







	if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update")



	{		



		$ReqArr = $_REQUEST;



		$ConArr = array();		



		foreach($ReqArr as $k=>$v)



		{



			if($k=="footerText")



				$ConArr[$k]=addslashes($v);



		}



		$CondArr = " WHERE 1";



		$sql->SqlUpdate('mos_tblFooter',$ConArr,$CondArr);		



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







	if(($_REQUEST['mode']=='edit') && !isset($_REQUEST['Submit']))



	{



		



		$ConArr = " WHERE 1"; 						



		$arrArticle = $sql->SqlSingleRecord('mos_tblFooter',$ConArr);



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



    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="manage-footerText.php">Add/Edit Footer Text</a></div></td>



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



                <td><h1>Manage Footer Text </h1></td>



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



                <td align="left" valign="top" class="normal_text_blue" colspan="2">Footer  Text :</td>



               



                <td width="335" align="left" valign="top">&nbsp;</td>



              </tr>



              



              <tr>



                <td  colspan="3" align="left" valign="top">



				 



				<!--<textarea name="long_desc" cols="50" rows="6" class="input_white"><?=stripslashes($Data['long_desc'])?></textarea> -->



				<?php



					$fullDes = stripslashes($Data['footerText']);				



					include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;					



					$sBasePath = _HTML_EDITOR_PATH."/";



					$oFCKeditor = new FCKeditor('footerText') ;



					$oFCKeditor->BasePath	= $sBasePath ;



					$oFCKeditor->Value	= $fullDes;



					//$oFCKeditor->ToolbarSet ="Basic";



					$oFCKeditor->Width="100%" ;



					$oFCKeditor->Height="350" ;



					$oFCKeditor->Create() ;	



				?>				</td>



                </tr>



              



              <tr>



                <td width="23" height="20" align="right" valign="top">&nbsp;</td>



                <td width="151" align="left" valign="top">&nbsp;</td>



                <td align="left" valign="top">&nbsp;</td>



              </tr>



              <tr>



                <td align="left" valign="top">&nbsp;</td>



                <td align="left" valign="top">



				<?php



						



							$btnName = "Update";



						



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




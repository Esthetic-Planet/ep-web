<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

$AuthAdmin->ChkLogin();



$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";



$linkSection = 0;



if(isset($_POST['Submit']) && $_POST['Submit']=="Add")

{		

	$ConArr = array();		

	$ConArr["mName"]=addslashes($_POST["mName"]);

	$ConArr["linkSection"]=addslashes($_POST["linkSection"]);

	$ConArr["displayOrder"]=addslashes($_POST["displayOrder"]);

	$ConArr["status"]=addslashes($_POST["status"]);

	

	if($_POST["linkSection"] == 1)

		$ConArr["url"]=addslashes($_POST["url"]);	

	else

		$ConArr["url"]=addslashes($_POST["web_url"]);			

		

		

	$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

	$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

	$intResult = $sql->SqlInsert('mos_tblFooterMenu',$ConArr);

	if($intResult)

	{

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-footer-menues.php">';

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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && isset($_POST['mid']))

{		

	$ConArr = array();		



	$ConArr["mName"]=addslashes($_POST["mName"]);

	$ConArr["linkSection"]=addslashes($_POST["linkSection"]);

	$ConArr["displayOrder"]=addslashes($_POST["displayOrder"]);

	$ConArr["status"]=addslashes($_POST["status"]);



	if($_POST["linkSection"] == 1)

		$ConArr["url"]=addslashes($_POST["url"]);	

	else

		$ConArr["url"]=addslashes($_POST["web_url"]);	





	$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());	

	$CondArr = " WHERE mid = ".$_POST['mid'];

	$intResult = $sql->SqlUpdate('mos_tblFooterMenu',$ConArr,$CondArr);



	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-footer-menues.php">';

	echo '<input type="hidden" name="msg" id="msg" value="update">';

	echo '</form>';

	echo '<script type="text/javascript">document.frmSu.submit();</script>';

	echo '</body>';		

	exit;

}



	if(isset($_REQUEST['mid']) && ($_REQUEST['mode']=='edit'))

	{

		$id = $_REQUEST['mid'];

		$ConArr = " WHERE mid= '$id' "; 						

		$arrBrands = $sql->SqlSingleRecord('mos_tblFooterMenu',$ConArr);

		$count = $arrBrands['count'];

		$Data = $arrBrands['Data'];		 

		$linkSection = $Data["linkSection"];

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

<SCRIPT language=javascript src="../js/ajax.js"></SCRIPT>

</head>

<body>

<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="add-footer-menu.php">Add/Edit Footer Menu</a></div></td></tr>

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>

        <td width="14" valign="top">&nbsp;</td>

        <td valign="top">

		<form name="frmAddMenues" id="frmAddMenues" action="" method="post" onsubmit="return SubmitForm(this);">

		<input type="hidden" name="mid" value="<?=$id?>">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>Add Footer Menu </h1></td>

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

		  <tr><td valign="top" align="center">&nbsp;</td></tr>

          <tr>

            <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="107" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Menu Name:</td>

                <td width="10" align="left" valign="top">&nbsp;</td>

                <td width="382" align="left" valign="top">

				<input name="mName" type="text" class="input_white" size="45" value="<?=stripslashes($Data['mName'])?>" alt="BC~DM~ menu name~DM~">				</td>

              </tr>

			  





              <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

            <?php

			$records_per_page=1000;			

			$offset = ($page-1) * $records_per_page;

			$cond="WHERE status='active' ";

			$orderby=" ORDER BY id ASC";

			$dest = $sql->SqlRecords("mos_tblWebpage",$cond,$orderby,$offset=0,$records_per_page);

			$count_total_dest=$dest['TotalCount'];

			$count_dest= $dest['count'];

			$DataDest = $dest['Data'];		

			  ?>



			  <tr>

                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>link to:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top" class="normal_text_blue">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td width="30%"><input type="radio" name="linkSection" value="0"  <?=($linkSection==0)?"checked":"";?> onClick="showLinks(this.value)">Webpage.</td>

					<td width="70%"><input type="radio" name="linkSection" value="1"   <?=($linkSection==1)?"checked":"";?> onClick="showLinks(this.value)"> External Link.</td>

				  </tr>

				  <tr height="40" valign="bottom" id="external_tr"><td colspan="2"><span id="urlBlock"><input type="text" name="url" value="<?=$Data['url']?>" class="input_white" size="38"><br />e.g. http://www.mysite.com/index.html	</span></td></tr>



				  <tr height="40" valign="bottom" id="webpage_tr" style="display:none"><td colspan="2"><select name="web_url" class="input_white" size="1" style="width:350px;">

	    	              <option value="index.html" selected="selected">Home</option>

	               <?	for($i=0; $i<$count_dest; $i++)

						{ ?>

            		      <option value="<?=$DataDest[$i]['pageUrl']?>"<?php	if($Data['url']==$DataDest[$i]['pageUrl'])	echo " selected";	?>><? echo show_breadcrumbs($DataDest[$i]['id']); ?> </option>

                  <?	} ?>

			 			</select></td></tr>



				</table></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Display Order: </td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><input type="text" name="displayOrder" class="input_white" size="6" maxlength="10" value="<?=$Data['displayOrder']?>"></td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Status :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"><input name="status" type="radio" value="active" <?php if($Data['status']=='active') echo " checked"?> <?php if($Data['status']=='') echo " checked"?>> <span class="normal_text_blue">Active</span>   <input name="status" type="radio" value="inactive" <?php if($Data['status']=='inactive') echo " checked"?>>            <span class="normal_text_blue">Inactive</span></td>

              </tr>



              <tr>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>



              <tr>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

		<?	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')

				{

					$btnName = "Update";

				}

				else

				{

					$btnName = "Add";

				}	?>

                <td align="left" valign="top"><input type="submit" class="btn" name="Submit" value="<?=$btnName?>">

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-main-menues.php'">				</td>

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

<script>

//STEP 9: prepare submit FORM function

function SubmitForm(formnm)

{

   if(!JSvalid_form(formnm))

	{

		return false;

	}

	if(formnm.displayOrder.value=="" || isNaN(formnm.displayOrder.value))

	{

		alert("please enter numeric value only for 'displayOrder'");

		return false;

	}

}		



function showLinks(value)

{

	if(value == 1)

	{

		document.getElementById("external_tr").style.display = '';

		document.getElementById("webpage_tr").style.display = 'none';

	}

	else

	{

		document.getElementById("external_tr").style.display='none'

		document.getElementById("webpage_tr").style.display=''

	}





}

showLinks("<?=$linkSection;?>");



</script>

</body>

</html>
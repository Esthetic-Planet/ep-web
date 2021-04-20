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

			if($k=="mName" || $k=='url' || $k=='linkSection' || $k=='pageUrl'  || $k=='displayOrder' || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		

		$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

		$intResult = $sql->SqlInsert('mos_tblArticle',$ConArr);

		if($intResult)

		{

			echo "<body>";

			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-article.php">';

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

	else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['mid']))

	{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="mName" || $k=='url'  || $k=='linkSection' || $k=='pageUrl' || $k=='assignOnTop' || $k=='displayOrder' || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());	

		$CondArr = " WHERE mid = ".$_REQUEST['mid'];

		$intResult = $sql->SqlUpdate('mos_tblArticle',$ConArr,$CondArr);


		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-article.php">';

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

		$arrBrands = $sql->SqlSingleRecord('mos_tblArticle',$ConArr);

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

<SCRIPT language=javascript src="../js/ajax.js"></SCRIPT>





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

		<form name="frmAddMenues" id="frmAddMenues" action="" method="post" onsubmit="return SubmitForm(this);">

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>Add Article </h1></td>

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

            <td valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td width="107" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Article Name:</td>

                <td width="10" align="left" valign="top">&nbsp;</td>

                <td width="382" align="left" valign="top">

				<input name="mName" type="text" class="input_white" size="45" value="<?=stripslashes($Data['mName'])?>" alt="BC~DM~ menu name~DM~">				</td>

              </tr>
			     <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>
			  
			  <tr>

                <td width="107" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page url:</td>

                <td width="10" align="left" valign="top">&nbsp;</td>

                <td width="382" align="left" valign="top">

				<input name="pageUrl" type="text" class="input_white" size="45" value="<?=stripslashes($Data['pageUrl'])?>" alt="BC~DM~ Paage Url~DM~">				</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

			  <tr>

                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>link to:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top" class="normal_text_blue">

				<table width="100%" border="0" cellspacing="0" cellpadding="0">

				  <tr>

					<td width="34%">					

				<input type="radio" name="linkSection" value="0" onClick="showLinks(this.value)">Webpage.<br />				

				<input type="radio" name="linkSection" value="1" checked="checked" onClick="showLinks(this.value)"> External Link.<br />					</td>

					<td width="66%" valign="top">

					<span id="urlBlock">

					<input type="text" name="url" value="" class="input_white" size="38">

					<br />e.g. http://www.mysite.com/index.html	</span>					</td>

				  </tr>

				  <tr>

				    <td colspan="2"><span class="pink_text"><?=$Data['url']?></span></td>

				    </tr>

				</table>				</td>

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

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-article.php'">				</td>

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

<script>



//STEP 9: prepare submit FORM function

function SubmitForm(formnm)

{

		   if(!JSvalid_form(formnm))

			{

					return false;

			}

}		



function showLinks(value)

{

	//alert(id);

	//alert(document.frmAddMenues);

	for(i=0;i<document.frmAddMenues.linkSection.length;i++)

	{

		if(i==value && value!='')

		{

			document.frmAddMenues.linkSection[i].checked=true

		}

	}

	

	switch(value)

	{

	case '0' :

		url = '<?=_ADMIN_WWWROOT?>/box_webpage.php?id=';		

		break;    

	case '1' :

		url = '<?=_ADMIN_WWWROOT?>/box_external.php'

		break;

	default:

		url = '<?=_ADMIN_WWWROOT?>/box_external.php'

		

	}

	getRequest(url,'urlBlock','');	

}



showLinks("<?=$Data['linkSection']?>");

//alert("<?=$Data['linkSection']?>");

</script>

</body>

</html>


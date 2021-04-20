<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

//include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

$page=isset($_REQUEST['page'])? $_REQUEST['page'] : 1;

$sqlError="";

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Add")

{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="title" || $k=='short_desc' ||  $k=="long_desc" || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		

		$ConArr['addedDate'] = date("Y-m-d h:i:s",time());

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		

		$intResult = $sql->SqlInsert('tblArticles',$ConArr);

		if($intResult)

		{

			echo "<body>";

			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-article.php">';

			echo '<input type="hidden" name="msg" id="msg" value="added">';

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

	else if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update" && isset($_REQUEST['aid']))

	{		

		$ReqArr = $_REQUEST;

		$ConArr = array();		

		foreach($ReqArr as $k=>$v)

		{

			if($k=="title" || $k=='short_desc' ||  $k=="long_desc" || $k=="status")

				$ConArr[$k]=addslashes($v);

		}

		$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());	

		$CondArr = " WHERE aid = ".$_REQUEST['aid'];

		$intResult = $sql->SqlUpdate('tblArticles',$ConArr,$CondArr);

		

		

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-article.php">';

		echo '<input type="hidden" name="msg" id="msg" value="update">';

		echo '<input type="hidden" name="page" value="'.$page.'">';

		echo '</form>';

		echo '<script type="text/javascript">document.frmSu.submit();</script>';

		echo '</body>';		

		exit;

		

		}

		

	

	

	if(isset($_REQUEST['aid']) && ($_REQUEST['mode']=='edit'))

	{

		$id = $_REQUEST['aid'];

		$ConArr = " WHERE aid= '$id' "; 						

		$arrBrands = $sql->SqlSingleRecord('tblArticles',$ConArr);

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

		

		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>User Account Settings </h1></td>

              </tr>

            </table></td>

          </tr>

          <tr>

            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="35"></td>

          </tr>

          <tr>

            <td valign="top">

			

			<form name="frmAddArticle" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">

			<table width="475" border="0" align="center" cellpadding="0" cellspacing="0">

              

              <tr>

                <td width="100" height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

                <td width="5" align="left" valign="top">&nbsp;</td>

                <td width="370" align="left" valign="top">&nbsp;</td>

              </tr>

             

          

              

              <tr>

                <td height="20" colspan="3" align="right" valign="top">

				<fieldset ><legend class="blue12">Login Details</legend>

				<table width="100%" border="0">

				   <tr>

                <td width="21%" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Username:</td>

                <td width="2%" align="left" valign="top">&nbsp;</td>

                <td width="77%" align="left" valign="top">

				<input name="LoginEmail" type="text" class="input_white" size="48" value="<?=$Data['LoginEmail']?>" alt="BC~DM~user name~DM~">				 				</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Password:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="Password" type="password" class="input_white" size="48" value="">				</td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Re-password:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="rPassword" type="password" class="input_white" size="48" value=""></td>

              </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">User Type </td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="UserType" type="radio" value="Admin" <?php if($Data['UserType']=='Admin') echo " checked"?> >

                  <span class="normal_text_blue">Admin </span>

                  <input name="UserType" type="radio" value="User" <?php if($Data['UserType']=='User') echo " checked"?> <?php if($Data['UserType']=='') echo " checked"?>>

                  <span class="normal_text_blue">User</span>

				</td>

              </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Status :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="IsActive" type="radio" value="active" <?php if($Data['IsActive']=='t') echo " checked"?> <?php if($Data['status']=='') echo " checked"?>>

                  <span class="normal_text_blue">Active</span>

                  <input name="IsActive" type="radio" value="inactive" <?php if($Data['IsActive']=='f') echo " checked"?>>

                  <span class="normal_text_blue">Inactive</span></td>

              </tr>

				</table>

				</fieldset>

				</td>

                </tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td colspan="3" align="left" valign="top">

				

				<fieldset ><legend class="blue12">Personal Details</legend>

				<table width="100%" border="0">

				 <tr>

                <td width="21%" align="left" valign="top" class="normal_text_blue">First Name:</td>

                <td width="2%" align="left" valign="top">&nbsp;</td>

                <td width="77%" align="left" valign="top">

				<input name="FirstName" type="text" class="input_white" size="48" value="<?=$Data['FirstName']?>" ></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Last name:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="LastName" type="text" class="input_white" size="48" value="<?=$Data['LastName']?>"></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Address:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="Address1" type="text" class="input_white" size="48" value="<?=$Data['Address1']?>" >

				</td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Address2:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="Address2" type="text" class="input_white" size="48" value="<?=$Data['Address2']?>" ></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Phone:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="Phone" type="text" class="input_white" size="48" value="<?=$Data['Phone']?>" ></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Zip Code:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="Zip" type="text" class="input_white" size="48" value="<?=$Data['Zip']?>" ></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">City:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="City" type="text" class="input_white" size="48" value="<?=$Data['City']?>" ></td>

              </tr>

              <tr>

                <td align="left" valign="top" class="normal_text_blue">Country:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<select name="Country" class="input_white">

				<option value="">select</option>

				<?php

				$arrCountry=countryArray();	

				foreach($arrCountry as $key=>$val) {

					print "<option value='$val' ";

					if($val==$Data['Country'])

						print " selected";

					print ">$val</option>";								

				

				}

						?>	

				</select>

				

				</td>

              </tr>

				</table>

				</fieldset></td>

                </tr>

              

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

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-article.php?page=<?=$page?>'">				</td>

              </tr>

            </table>

			</form>

			</td>

          </tr>

          <tr>

            <td valign="top">&nbsp;</td>

          </tr>

          

        </table>

		

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


<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

//print_r($_SESSION);


$adminID=$_SESSION['AdminInfo']['id'];

$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";

if(isset($_REQUEST['Submit']) && $_REQUEST['Submit']=="Update")
{		
		
		$checkUserExistsonUpdate=$sql->checkUserExistsonUpdate($_REQUEST['LoginEmail'],$adminID);
		
		if($checkUserExistsonUpdate==FALSE)
		{
			$ReqArr = $_REQUEST;
			$ConArr = array();		
			foreach($ReqArr as $k=>$v)
			{
				if($k=="FirstName" || $k=='LastName' ||  $k=="Address1" || $k=="Address2" ||  $k=="Phone" || $k=="City" || $k=="State" || $k=="Zip" 
				|| $k=="Country" || $k=="LoginEmail" || $k=="IsActive")
				{
					//$ConArr[$k]=addslashes($v);
					$ConArr[$k]=$v;
				}
			}
			if(!empty($_REQUEST["Password"]))
				$ConArr["Password"]=$_REQUEST["Password"];

			$ConArr['modifiedDate'] = date("Y-m-d H:i:s",time());	
			
			
			$ConArr=add_slashes_arr($ConArr);	
			
			
			$CondArr = " WHERE UserId = ".$adminID;
			
			
			$intResult = $sql->SqlUpdate('esthp_tblUsers',$ConArr,$CondArr);
			
			$user_cond = " WHERE UserId= '".$adminID."' "; 						
			$user_arr = $sql->SqlSingleRecord('esthp_tblUsers',$user_cond);
			$user_count = $user_arr['count'];
			$user_data = $user_arr['Data'];
			

		
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'home.php">';
			echo '<input type="hidden" name="msg" id="msg" value="profile_updated">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';
			exit;
	
	
			
			}
			else
			{
				$sqlError="<span class=\"loginErrBox\"><span class='alert_icon'></span>User with the provided Email Id already exists. Please provide different Email Id.</sapn>";
			}
		}
		
	

		$ConArr = " WHERE UserId= '".$adminID."'"; 						
		$arrBrands = $sql->SqlSingleRecord('esthp_tblUsers',$ConArr);
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
//alert("called");

		   if(!JSvalid_form(formnm))

			{

					return false;

			}

			if(formnm.Password.value=='' && formnm.old_Password.value=='')

			{

				alert("Please Enter Password ");
	
				formnm.Password.focus();
	
				return false;

			}

			if(formnm.Password.value!=formnm.rPassword.value)

			{

			alert("password  and re-password fileds mismatch ");

			formnm.Password.focus();

			return false;

			}

}		

</script>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?>
<div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="update-profile.php">My Account</a></div></td>
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
                <td><h1>My Account</h1></td>
              </tr>
            </table></td>
          </tr>
		   <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="4">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>
			</td>
          </tr>
		  <?php
		  if($sqlError!='')
		  {
		  ?>
		 <tr>
            <td valign="middle" height="50" align="center" style="padding:5px;"><?=$sqlError?></td>
          </tr> 
		  <br>
		<?php
		}
		?>
		<?php
		  if($success_message!='')
		  {
		  ?>
		 <tr>
            <td valign="middle" height="50" align="center" style="padding:5px;"><?=$success_message?></td>
          </tr> 
		  <br>
		<?php
		}
		?>
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="1"></td>
          </tr>
          <tr>
            <td valign="top">
			
			<form name="frmAddUser" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data" style="margin:0px;">
			<table width="475" border="0" align="center" cellpadding="0" cellspacing="0">
              
        <!--      <tr>
                <td width="100" height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td width="5" align="left" valign="top">&nbsp;</td>
                <td width="370" align="left" valign="top">&nbsp;</td>
              </tr>
             
           -->
              
              <tr>
                <td height="20" colspan="3" align="right" valign="top">
				<fieldset ><legend class="blue12">Login Details</legend>
				<table width="100%" border="0">
				   <tr>
                <td width="21%" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Login Email :</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="77%" align="left" valign="top">
				<input name="LoginEmail" id="LoginEmail" type="text" class="input_white" size="48" value="<?=$Data['LoginEmail']?>" alt="EMC~DM~ Login Email ~DM~" ></td>
              </tr>
              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Password:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="hidden" name="old_Password" value="<?=$Data['Password']?>">
				<input name="Password" type="password" class="input_white" size="48" value="<?=$Data['Password']?>">				</td>
              </tr>
              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Re-password:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="rPassword" type="password" class="input_white" size="48" value="<?=$Data['Password']?>"></td>
              </tr>
              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
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
				 
				 
				<?php
				if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')
				{
				?>
				<tr>
				<td width="21%" align="left" valign="top" class="normal_text_blue">Franchise ID:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="77%" align="left" valign="top"><?=$Data['franchise_url']?></td>
              </tr>
				<?php
				}

				?>
				 
				 
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
                <td align="left" valign="top" class="normal_text_blue">State:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="State" type="text" class="input_white" size="48" value="<?=$Data['State']?>" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Country:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				
				
				
					<?php
	$country_condition="order by countries_name";
	$country_record_arr=$sql->SqlRecordMisc('esthp_tblCountries', $country_condition);
	$total_countries=$country_record_arr['count'];
	$country_records=$country_record_arr['Data'];
	?>
	<select name="Country" class="input_white" >
	<option value=''>Select Country</option>
	<?php
	foreach($country_records as $country)
	{
	?>
	<option value="<?=$country['countries_name']?>" <?=($country['countries_name']==$Data['Country']?'selected':'')?>><?=$country['countries_name']?></option>
	<?php
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

                <td align="center" valign="top">
				<input type="submit" class="btn" name="Submit" value="Update">
					</td>
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

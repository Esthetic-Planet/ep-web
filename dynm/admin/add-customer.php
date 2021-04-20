<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

//print_r($_SESSION);

/* 
if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
} 

*/

$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$sqlError="";

if(isset($_POST['submit']) && $_POST['submit']=='Register' && empty($_REQUEST['cust_id']))
{
		////////////////////// code to insert the details
		$cust_arr=array();
		$cust_arr['cust_fname']=trim($_POST['cust_fname']);
		$cust_arr['cust_lname']=trim($_POST['cust_lname']);
		$cust_arr['cust_email']=trim($_POST['cust_email']);
		$cust_arr['cust_address']=trim($_POST['cust_address']);
		$cust_arr['cust_state']=trim($_POST['cust_state']);
		$cust_arr['cust_city']=trim($_POST['cust_city']);
		$cust_arr['cust_zip']=trim($_POST['cust_zip']);
		$cust_arr['cust_country']=trim($_POST['cust_country']);
		$cust_arr['cust_phone']=trim($_POST['cust_phone']);
		$cust_arr['cust_date_added']=date('Y-m-d H:i:s', time());
		$cust_arr['cust_date_modified']=$cust_arr['cust_date_added'];
		
		
		$cust_arr['cust_password']=trim($_POST['cust_password']);
		$cust_arr['cust_status']=trim($_POST['cust_status']);
	
		
	if( ! $sql->checkCustExistsInsert(trim($_POST['cust_email'])) )
	{

		$record_id=$sql->SqlInsert('esthp_tblCustomers',$cust_arr);
		
		
		if($record_id)
		{

			/// send email to super admin ///////////////////
			$super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
			$to_email =$admin_email;
			$from_email=trim($_POST['cust_email']);
				$email_subject="New user registered on "._WEBSITE_NAME;
				$email_body .=
				'
				<table width="70%" cellpadding="0" border="0" >
				<tr><td colspan="2" align="left">Hi,<br/><br/><b>New user is registered on '._WEBSITE_NAME.' !! </b><br/><br/></td></tr>
						<tr><td colspan="2" align="left">The details are given below: </td></tr>
						<tr>
							<td width="30%" align="left"><b>First Name :</b></td>
							<td align="left">'.trim($_POST['cust_fname']).'</td>
						</tr>
						<tr>
							<td align="left"><b>Last Name :</b></td>
							<td align="left">'.trim($_POST['cust_lname']).'</td>
						</tr>
						<tr>
							<td align="left"><b>Email ID :</b></td>
							<td align="left">'.trim($_POST['cust_email']).'</td>
						</tr>
						
						<tr>
							<td align="left"><b>Password :</b></td>
							<td align="left">'.trim($_POST['cust_password']).'</td>
						</tr>
						
						
						<tr>
							<td colspan="2" align="left">Thanks</td>	
						</tr>
						</table>
				';
				$from="From: ".trim($_POST['cust_fname']).' '.trim($_POST['cust_lname'])." <".$from_email.">";
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$header .=$from;
				mail($to_email,$email_subject,$email_body,$header);
				/// send email to super admin///////////////////


			if(!empty($_REQUEST['alert_customer']))
			{
					/// send email to customer admin ///////////////////
					$super_admin_arr = $sql->SqlSuperAdmin();	
					$Count = $super_admin_arr['count'];
					$admin_arr = $super_admin_arr['Data'][0];	
					$admin_email =$admin_arr['LoginEmail'];
					$from_email =$admin_email;
					$to_email=trim($_POST['cust_email']);
						$email_subject="Your registration details: "._WEBSITE_NAME;
						$email_body .=
						'
						<table width="70%" cellpadding="0" border="0" >
						<tr><td colspan="2" align="left">Hi '.trim($_POST['cust_fname']).' '.trim($_POST['cust_lname']).',<br/><br/><b>You are a successful registered user on '._WEBSITE_NAME.' !! </b><br/><br/></td></tr>
								<tr><td colspan="2" align="left">You canlogin into our website by using the following details: </td></tr>
								<tr>
									<td align="left"><b>User Name :</b></td>
									<td align="left">'.trim($_POST['cust_email']).'</td>
								</tr>
								<tr>
									<td align="left"><b>Password :</b></td>
									<td align="left">'.trim($_POST['cust_password']).'</td>
								</tr>
								<tr>
									<td colspan="2" align="left">Thanks</td>	
								</tr>
								</table>
						';
						$from="From: Admin <".$from_email.">";
						$header  = 'MIME-Version: 1.0' . "\r\n";
						$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$header .=$from;
						mail($to_email,$email_subject,$email_body,$header);
						/// send email to super admin///////////////////
			}
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-customers.php">';
			echo '<input type="hidden" name="msg" id="msg" value="added">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';
			exit;
		}
		else
		{
			$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>'.mysql_error().'</span>';
		}
	
	}
	else
	{
		$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>A user with same Email ID already exists. Please provide a different Email ID.</span>';

	}

	/////////////////////////
		
}
else if(isset($_POST['submit']) && $_POST['submit']=='Update' && !empty($_REQUEST['cust_id']))
{		

		//////////////////////////////////////////
		
		$cust_arr=array();
		$cust_arr['cust_fname']=trim($_POST['cust_fname']);
		$cust_arr['cust_lname']=trim($_POST['cust_lname']);
		$cust_arr['cust_email']=trim($_POST['cust_email']);
		$cust_arr['cust_address']=trim($_POST['cust_address']);
		$cust_arr['cust_state']=trim($_POST['cust_state']);
		$cust_arr['cust_city']=trim($_POST['cust_city']);
		$cust_arr['cust_zip']=trim($_POST['cust_zip']);
		$cust_arr['cust_country']=trim($_POST['cust_country']);
		$cust_arr['cust_phone']=trim($_POST['cust_phone']);
		$cust_arr['cust_date_modified']=date('Y-m-d H:i:s', time());
		
		$cust_arr['cust_password']=trim($_POST['cust_password']);
		$cust_arr['cust_status']=trim($_POST['cust_status']);
		
	if( ! $sql->checkCustExistsUpdate(trim($_POST['cust_email']),$_REQUEST['cust_id']) )
	{
		// code to insert the details

		
		$update_condition="where cust_id='".$_REQUEST['cust_id']."'";
		
		$affected_rows=$sql->SqlUpdate('esthp_tblCustomers',$cust_arr,$update_condition);
		
		//echo $affected_rows;
		//die;
		
		if($affected_rows)
		{
		
		
			if(!empty($_REQUEST['alert_customer']))
			{
					/// send email to customer admin ///////////////////
					$super_admin_arr = $sql->SqlSuperAdmin();	
					$Count = $super_admin_arr['count'];
					$admin_arr = $super_admin_arr['Data'][0];	
					$admin_email =$admin_arr['LoginEmail'];
					$from_email =$admin_email;
					$to_email=trim($_POST['cust_email']);
					
						$email_subject="Yor registration details: "._WEBSITE_NAME;
						$email_body .=
						'
						<table width="70%" cellpadding="0" border="0">
						<tr><td colspan="2" align="left">Hi '.trim($_POST['cust_fname']).' '.trim($_POST['cust_lname']).',<br/><br/><b>You are a successful registered user on '._WEBSITE_NAME.' !! </b><br/><br/></td></tr>
								<tr><td colspan="2" align="left">You can login into our website by using the following details: </td></tr>
								<tr>
									<td align="left"><b>User Name :</b></td>
									<td align="left">'.trim($_POST['cust_email']).'</td>
								</tr>
								<tr>
									<td align="left"><b>Password :</b></td>
									<td align="left">'.trim($_POST['cust_password']).'</td>
								</tr>
								<tr>
									<td colspan="2" align="left">Thanks</td>	
								</tr>
								</table>
						';
						$from="From: Admin <".$from_email.">";
						$header  = 'MIME-Version: 1.0' . "\r\n";
						$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
						$header .=$from;
						mail($to_email,$email_subject,$email_body,$header);
						
						//echo $email_body;
						
						//die;
						/// send email to super admin///////////////////
			}
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-customers.php">';
			echo '<input type="hidden" name="msg" id="msg" value="updated">';
			echo '<input type="hidden" name="page" value="'.$page.'">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';
			exit;
		}

	
	}
	else
	{
		$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>A user with same Email ID already exists. Please provide a different Email ID.</span>';
	}
	

		
/////////////////////////////////////////////
		
}
		
		
if(!empty($_REQUEST['cust_id']))
{
	$select_condition="where cust_id='".$_REQUEST['cust_id']."'";
	$cust_record_arr=$sql->SqlRecordMisc('esthp_tblCustomers', $select_condition);
	$total_customers=$cust_record_arr['count'];
	$cust_records=$cust_record_arr['Data'];
	$cust_arr=array();
	$cust_arr=$cust_records[0];
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

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?>
<div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-customers.php">Manage Users</a></div></td>
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
                <td><h1>Register User</h1></td>
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
		  <?php
		  }
		  ?> 
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="1"></td>
          </tr>
          <tr>
            <td valign="top">
			

			
			
				  <form name="register_frm" action="" method="post" onsubmit="return ValidateForm(this)" enctype="multipart/form-data" style="margin:0px;">
			<table width="475" border="0" align="center" cellpadding="0" cellspacing="0">

              

              <tr>
                <td colspan="3" align="left" valign="top">
				
				<fieldset ><legend class="blue12">Details</legend>
				<table width="100%" border="0">
				 
				 

				 
				 <tr>
				 
				 
				 
				 
                <td width="21%" align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>First Name:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="77%" align="left" valign="top">
				<input name="cust_fname" id="chk_fname" type="text" class="input_white" size="48" title="Please enter first name." value="<?=$cust_arr['cust_fname']?>" ></td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Last name:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_lname" id="chk_lname" type="text" class="input_white" size="48" title="Please enter last name." value="<?=$cust_arr['cust_lname']?>"></td>
              </tr>
			  
			  
			                <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Email ID:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_email" id="chkemail_email" type="text" class="input_white" size="48" title="Please enter a valid email address."  value="<?=$cust_arr['cust_email']?>"></td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Address:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_address"  type="text" class="input_white" size="48" title="Please enter address." value="<?=$cust_arr['cust_address']?>" >
				</td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>State:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_state"  type="text" class="input_white" size="48" title="Please enter state." value="<?=$cust_arr['cust_state']?>" ></td>
              </tr>
			  
			     <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>City:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_city"  type="text" class="input_white" size="48" title="Please enter city." value="<?=$cust_arr['cust_city']?>" ></td>
              </tr>
			  
			  
			  			  
			     <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Zip:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_zip"  type="text" class="input_white" size="48" title="Please enter zip/post code." value="<?=$cust_arr['cust_zip']?>" ></td>
              </tr>
			  
			  
			  
	<tr>
	<td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Country:</td>
	<td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">
	
	<?php
	$country_condition="order by countries_name";
	$country_record_arr=$sql->SqlRecordMisc('esthp_tblCountries', $country_condition);
	$total_countries=$country_record_arr['count'];
	$country_records=$country_record_arr['Data'];
	?>
	<select name="cust_country" class="input_white" id="chksbox_country" title="Please select a country.">
	<option value=''>Select Country</option>
	<?php
	foreach($country_records as $country)
	{
	?>
	<option value="<?=$country['countries_name']?>" <?=($country['countries_name']==$cust_arr['cust_country']?'selected':'')?>><?=$country['countries_name']?></option>
	<?php
	}
	?>

	</select>
     </td>
    </tr>
	
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Phone:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_phone"  type="text" class="input_white" size="48"  title="Please enter phone number." value="<?=$cust_arr['cust_phone']?>" ></td>
              </tr>
			  
			  
		
			  

			  <tr>
                <td align="left" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				 <input name="cust_status" type="radio" value="inactive" <?php if($cust_arr['cust_status']=='inactive') echo " checked"?> <?php if($cust_arr['cust_status']=='') echo " checked"?>>
                  <span class="normal_text_blue">Inactive</span>
				  <input name="cust_status" type="radio" value="active" <?php if($cust_arr['cust_status']=='active') echo " checked"?> >
                  <span class="normal_text_blue">Active</span>
				  </td>
              </tr>
			  
			  
			  
			  	<tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Password:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_password"  id="chk_password" title="Please enter a password." type="password" class="input_white" size="48"  value="<?=$cust_arr['cust_password']?>" ></td>
              </tr>
			  
			  
			  
			  			  	<tr>
                <td align="left" valign="top" class="normal_text_blue"><span class="empty_record_txt">* </span>Retype Pass.:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input name="cust_cpassword" id="chkpass_repassword" title="Please confirm password."  type="password" class="input_white" size="48"  value="<?=$cust_arr['cust_password']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td align="left" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue">
				<input name="alert_customer" id="alert_customer" type="checkbox" value='1' > Alert user via Email</td>
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
if(!empty($_REQUEST['cust_id']))
{
	$btn_value='Update';
	
}
else
{
	$btn_value='Register';
}
?>
                <td align="center" valign="top">

				
			<input name="submit" type="submit" class="btn" id="button" value="<?=$btn_value?>" /> 
      &nbsp;
      <input name="clear" type="reset" class="btn" id="button2" value="Clear" />
				
				
				
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

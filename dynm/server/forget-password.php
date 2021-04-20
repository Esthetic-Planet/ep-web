<?php 
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
$AuthUser->RedirctUser();

if(($_REQUEST['email'])!='')
{
	$user_email = $_REQUEST['email'];
	
	$user_record_arr = $sql->SqlGetUserPasswd($user_email);	
	$Count = $user_record_arr['count'];
		
	if($Count>0)
	{
		$user_arr = $user_record_arr['Data'][0];	
		$to_email =$user_arr['cust_email'];
		$email_subject="Password Recovery Email: "._WEBSITE_NAME;
		$email_body .=
			'
				<table width="70%" cellpadding="0" border="0" align="center">
					<tr>
						<td colspan="2"><b>Your login details on '._WEBSITE_NAME.' are as follows: </b></td>
					</tr>
					<tr>
						<td width="30%"><b>UserName :</b></td>
						<td>'.$user_arr['cust_email'].'</td>
					</tr>
					<tr>
						<td><b>Password :</b></td>
						<td>'.$user_arr['cust_password'].'</td>
					</tr>
					<tr>
						<td colspan="2"></td>	
					</tr>
				</table>
			';
			
			$super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
				
			$from="From: ".'Admin'." <".$admin_email.">";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .=$from;
				
			
			if(mail($to_email,$email_subject,$email_body,$header))
			{
				$msg="emailSendMsg";
				header("Location: index.php?msg=$msg");
			}
			else
			{
				$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Email was not sent.</span>";
			}
		}
		else
		{
			$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>The provided email id is invalid. Please check your email id and try again.</span>";
		}		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Esthetic Planet ::.</title>
<link href="includes/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function SubmitForm()
{
	if(document.getElementById('email').value=='')
	{
		alert("Please enter user email id.");
		document.getElementById('email').focus();
		return false;
	}
	else
	{
		if(!is_email(document.getElementById('email').value))
		{
			alert("Please enter valid email address.");
			document.getElementById('email').focus();
			return false;
		}
	}
	function is_email(email)
	{
		if(!email.match(/^[A-Za-z0-9\._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/))
			return false;
		return true;
	}
	return true;
}
</script>
</head>
<body>
<!--Start Page Holder -->
<div id="page_holder">
	<!--Start page_panel -->
	<div id="page_panel">
		<div id="header"><img src="images/header.jpg" /></div>
		
	<!--Start middle_area -->
	<div id="middle_area">
		<div id="left_part"><img src="images/left_part.jpg" /></div>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Mot de passe oublié ?</div>
				<div class="clear"></div>
				<div><?=$message?></div>
				<!--Start form -->
				<form name="frmForgetPass" id="frmForgetPass" action="forget-password-old.php" method="post" onSubmit="return SubmitForm();">
				<div id="form">
		  	<ul>
				<li class="field_name">Email Id :</li>
				<li class="field"><input type="text" class="textbox" name="email" id="email" />
				</li>
			</ul>
			<div class="clear"></div>
		  	<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><input name="submit" type="submit" class="submit"  value="Submit"/> &nbsp; 
											<input name="Reset" type="reset" class="submit"  value="Effacer"/>
				</li>
		  	</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><a href="index.php">User Login</a></li>
		  	</ul>
			<div class="clear"></div>
			
		  </div>
		  </form>
		  <!--End Form -->	
		  
			</div>
			<div class="clear"></div>
		</div>
		<!--End Right_part -->	
		<div class="clear"></div>
		</div>	
		<!--End Middle_Area -->	
	</div>
	<!--End Page panel -->
</div>
<!--End Page Holder -->
</body>
</html>

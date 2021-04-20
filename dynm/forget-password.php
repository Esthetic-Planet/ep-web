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
		$email_subject="Email Password Recovery: "._WEBSITE_NAME;
		$email_body .=
			'
				<table width="70%" cellpadding="0" border="0" align="center">
					<tr>
						<td colspan="2"><b>Votre identifiant de détails sur '._WEBSITE_NAME.' sont les suivants: </b></td>
					</tr>
					<tr>
						<td width="30%"><b>UserName :</b></td>
						<td>'.$user_arr['cust_email'].'</td>
					</tr>
					<tr>
						<td><b>Mot de passe :</b></td>
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
				$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Courrier électronique n'a pas été envoyé.</span>";
			}
		}
		else
		{
			$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>L'id e-mail fournie n'est pas valide. S'il vous plaît vérifier votre e-mail ID et essayez à nouveau.</span>";
		}		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Esthetic Planet : récupération de votre mot de passe</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta name="description" content="Esthetic Planet : récupération rapide du mot de passe pour votre compte sur Esthetic Planet" >
<meta name="keywords" content="Esthetic Planet" >
<meta name="ABSTRACT" content="">
<meta name="AUTHOR" content="www.esthetic-planet.com">
<meta name="robots" content="ALL">
<meta name="robots" content="INDEX">
<meta name="robots" content="FOLLOW">
<meta name="rating" content="general">
<meta name="expires" content="never">
<meta name="ROBOTS" content="index,follow,all">
<meta name="REVISIT-AFTER" content="7 days">
<meta name="Copyright" content="Medcom SARL">
<meta name="google-site-verification" content="xXtXqIffWToHnDHvSNV8QWLaiPRzF_SUz45fzUI2ddA" >
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" /> 
<meta name="idxchk" content="IDX94934CHECKb2647dd70c46206bca8fecc20d6886c3" />
<link href="includes/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
function SubmitForm()
{
	if(document.getElementById('email').value=='')
	{
		alert("S'il vous plaît entrer ID utilisateur.");
		document.getElementById('email').focus();
		return false;
	}
	else
	{
		if(!is_email(document.getElementById('email').value))
		{
			alert("S'il vous plaît entrez votre adresse e-mail valide.");
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
				<form name="frmForgetPass" id="frmForgetPass" action="forget-password.php" method="post" onSubmit="return SubmitForm();">
				<div id="form">
		  	<ul>
				<li class="field_name">Email :</li>
				<li class="field"><input type="text" class="textbox" name="email" id="email" />
				</li>
			</ul>
			<div class="clear"></div>
		  	<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><input name="submit" type="submit" class="submit"  value="Envoyer"/> &nbsp; 
											<input name="Reset" type="reset" class="submit"  value="Effacer"/>
				</li>
		  	</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><a href="index.php">Connexion utilisateur</a></li>
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

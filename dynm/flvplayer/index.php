<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
$AuthUser->RedirctUser();

if(isset($_POST['submit']))
{		
	$user = isset($_REQUEST['txtUserName']) ? $_REQUEST['txtUserName'] : '';
	$pass = isset($_REQUEST['txtpass']) ? $_REQUEST['txtpass'] : '';
	$AuthUser = $sql->SqlCheckUserLogin($user,$pass);
	$Count = $AuthUser['count'];
	
	if($Count>0)
	{
		$Data = $AuthUser['Data'][0];			
		$_SESSION['UserInfo']['id'] = $Data['cust_id'];
		$_SESSION['UserInfo']['fname'] = $Data['cust_fname'];			
		$_SESSION['UserInfo']['lname'] = $Data['cust_lname'];			
		header("Location: service.php");
		exit;
	}
	else
	{
		$msg = "incorectLogin";
		header("Location: index.php?msg=$msg");
	}		
}

$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : "";
$message="";

if($msg=='logout')
	$message = "<span class=\"logoutMsgBox\"><span class='green_check_icon'></span>Vous avez réussi à vous connecter à partir <strong>$sitename</strong></span>";
else if($msg=="incorectLogin")
	$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Niveau nom d'utilisateur incorrect, mot de passe, ou Access. S'il vous plaît essayez de nouveau.</sapn>";
else if($msg=='noSess')
	$message="<span class=\"loginErrBox\">Votre session a expiré, S'il vous plaît vous connecter à nouveau pour obtenir l'accès.<span>";
else if($msg=="emailSendMsg")
	$message="<span class=\"logoutMsgBox\">Vos informations de connexion ont été envoyé à votre adresse e-mail. S'il vous plaît vérifier votre boîte de réception.</span>";
else if($msg=="Inscrit")
	$message="<span class=\"logoutMsgBox\">Vous êtes enregistré avec succès Maintenant vous pouvez vous connecter</span>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Esthetic Planet ::.</title>
<link href="includes/main.css" rel="stylesheet" type="text/css" />
<SCRIPT language=javascript src="js/validation_new.js"></SCRIPT>
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
				<div class="login_hea">Connexion utilisateur</div>
				<div class="clear"></div>
				
				<form name="frmLogin" id="frmLogin" action="index.php" method="post" onsubmit="return ValidateForm(this)">
				<!--Start form -->
				<?php if(!empty($message))
				{ ?>
				<div align="center"> <?php echo $message; ?></div>
				<br />
				<?php } ?>
				<div id="form">
		  	<ul>
				<li class="field_name">Utilisateur :</li>
				<li class="field"><input type="text" class="textbox" name="txtUserName" id="chkemail_txtUserName" title="S'il vous plaît entrez email valide" />
				</li>
			</ul>
			<div class="clear"></div>
		  	
		  	<ul>
				<li class="field_name">Mot de passe :</li>
				<li class="field"><input type="password" class="textbox" name="txtpass" id="chk_password" title="Pleaes entrer le mot de passe" />
				</li>
			</ul>
			<div class="clear"></div>
		  	
		  	<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><input name="submit" type="submit" class="submit"  value="Se connecter"/> &nbsp;
											 <input name="reset" type="reset" class="submit" value="Effacer"  /></li>
		  	</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><a href="forget-password.php">Mot de passe oublié ?</a> &nbsp; <a href="registration.php">S’inscrire maintenant</a></li>
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

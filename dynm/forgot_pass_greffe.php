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
				
				header("Location: http://www.greffe-cheveux.fr/dynm/index.php?message=password");
				exit;
			}
			else
			{
				$message = "Courrier électronique n'a pas été envoyé.";
				header("Location:http://www.greffe-cheveux.fr/dynm/forget-password.php?message=$message");
				exit;
				
			}
		}
		else
		{
		
				$message = "L'id e-mail fournie n'est pas valide. S'il vous plaît vérifier votre e-mail ID et essayez à nouveau.";
				
				header("Location:http://www.greffe-cheveux.fr/dynm/forget-password.php?message=$message");
				exit;
				
				
			
		}		
	}
	
	?>
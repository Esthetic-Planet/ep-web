<?php
include_once("includes/global.inc.php");
//require_once(_PATH."modules/mod_user_login.php");
//$AuthUser->ChkLogin();

/* $uid = $_SESSION['UserInfo']['id'];
$cond_list="where 1=1 and cust_id='$uid'";
$orderby_list="order by cust_id desc";
$cat_arr_list = $sql->SqlRecords("esthp_tblCustomers",$cond_list,$orderby_list);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'][0];
*/

if(isset($_POST['submit']) && $_POST['submit']=='Inscrivez-vous maintenant')
{
	////////////////////// code to insert the details
	$cust_arr=array();
	$cust_arr['cust_fname']=trim($_POST['cust_fname']);
	$cust_arr['cust_lname']=trim($_POST['cust_lname']);
	$cust_arr['cust_email']=trim($_POST['cust_email']);
	$cust_arr['cust_address']=trim($_POST['cust_address']);
	//$cust_arr['cust_state']=trim($_POST['cust_state']);
	$cust_arr['cust_city']=trim($_POST['cust_city']);
	$cust_arr['cust_zip']=trim($_POST['cust_zip']);
	$cust_arr['cust_country']=trim($_POST['cust_country']);
	$cust_arr['cust_phone']=trim($_POST['cust_phone']);
	$cust_arr['cust_date_added']=date('Y-m-d H:i:s', time());
	$cust_arr['cust_date_modified']=$cust_arr['cust_date_added'];
	
	$cust_arr['cust_password']=trim($_POST['cust_password']);
	$cust_arr['cust_status']='active';
	
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
			$email_subject="Nouvel utilisateur enregistré le "._WEBSITE_NAME;
			$email_body .=
				'
				<table width="70%" cellpadding="0" border="0" >
				<tr>
					<td colspan="2" align="left">Salut,<br/><br/><b>Nouvel utilisateur est enregistré sur '._WEBSITE_NAME.' !! </b><br/><br/></td>
				</tr>
				<tr>
					<td colspan="2" align="left">Les détails sont donnés ci-dessous: </td>
				</tr>
				<tr>
					<td width="30%" align="left"><b>Prénom :</b></td>
					<td align="left">'.trim($_POST['cust_fname']).'</td>
				</tr>
				<tr>
					<td align="left"><b>Nom :</b></td>
					<td align="left">'.trim($_POST['cust_lname']).'</td>
				</tr>
				<tr>
					<td align="left"><b>Email ID :</b></td>
					<td align="left">'.trim($_POST['cust_email']).'</td>
				</tr>
				<tr>
					<td align="left"><b>Mot de passe :</b></td>
					<td align="left">'.trim($_POST['cust_password']).'</td>
				</tr>
				<tr>
					<td colspan="2" align="left">Merci</td>	
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
			$email_subject="Votre inscription détails: "._WEBSITE_NAME;
			$email_body="";
			$email_body .=
				'
					<table width="70%" cellpadding="0" border="0" >
						<tr>
							<td colspan="2" align="left">Bonjour,
							<br/><br/></td>
						</tr>
						<tr><td colspan="2" align="left">Vous venez de créer votre compte dans l’espace patient d’Esthetic
Planet. Nous sommes heureux de vous compter parmi nous. </td>
						</tr>
						<tr><td colspan="2" align="left">Vous trouverez ci-dessous le récapitulatif de votre identifiant et
mot de passe.
 </td>
						</tr>
						<tr><td colspan="2" align="left">Merci de votre confiance et à bientôt.
 </td>
						</tr>
						<tr><td colspan="2" align="left">L’équipe d’Esthetic Planet
 </td>
						</tr>
						<tr>
							<td align="left"><b>Identifiant :</b></td>
							<td align="left">'.trim($_POST['cust_email']).'</td>
						</tr>
						<tr>
							<td align="left"><b>Mot de passe :</b></td>
							<td align="left">'.trim($_POST['cust_password']).'</td>
						</tr>
						
					</table>
				';
				$from="From: Admin <".$from_email.">";
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$header .=$from;
				mail($to_email,$email_subject,$email_body,$header);
				/// send email to customer ///////////////////
			}

			// Start - Insert the new Lead into SugarCRM (#2982)
			require_once("soap_login.php");		
			$soap_obj = new soap_login();
			$login = $soap_obj->login();

			if($soap_obj->error == "no" && !empty($soap_obj->session_id))
			{
				$user_id = $soapClient->get_user_id($soap_obj->session_id);
				$soapClient->set_entry($soap_obj->session_id,
						'Leads',
						array(
						array("name" => "last_name","value" => $_POST["cust_lname"] ),
						array("name" => "first_name" , "value" => $_POST["cust_fname"]),
						array("name" => "email1","value" => $_POST["cust_email"]),
						array("name" => "primary_address_street","value" => $_POST["cust_address"]),
						array("name" => "primary_address_city","value" => $_POST["cust_city"]),
						array("name" => "primary_address_postalcode","value" => $_POST["cust_zip"]),
						array("name" => "primary_address_country","value" => $_POST["cust_country"]),
						array("name" => "phone_work","value" => $_POST["cust_phone"]),
						array("name" => "assigned_user_id","value" => $user_id ),));
			}
			// End - Insert the new Lead into SugarCRM (#2982)

			header("location:http://www.greffe-cheveux.fr/dynm/index.php?message=Inscrit");
			exit;
			
			
		}
		else
		{
			$error='Unable to update database';
			header("location:http://www.greffe-cheveux.fr/dynm/register.php?error=$error");
			exit;
		}
	}
	else
	{
		
			$error='Un utilisateur avec le même Email ID existe déjà. S\'il vous plaît donner un autre Email ID.';
			header("location:http://www.greffe-cheveux.fr/dynm/register.php?error=$error");
			exit;
	}
	/////////////////////////
}
?>

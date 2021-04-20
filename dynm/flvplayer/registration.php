<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
//$AuthUser->ChkLogin();

$uid = $_SESSION['UserInfo']['id'];
$cond_list="where 1=1 and cust_id='$uid'";
$orderby_list="order by cust_id desc";
$cat_arr_list = $sql->SqlRecords("esthp_tblCustomers",$cond_list,$orderby_list);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'][0];

if(isset($_POST['submit']) && $_POST['submit']=='Mettre à jour maintenant')
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
	$cust_arr['cust_date_modified']=$cust_arr['cust_date_added'];
	
	$cust_arr['cust_password']=trim($_POST['cust_password']);
	$cust_arr['cust_status']='active';
	
	$condition = " where cust_id='".$uid."'";
	$record_id = $sql->SqlUpdate('esthp_tblCustomers',$cust_arr,$condition);

	if(!empty($_REQUEST['alert_customer']))
	{
			/// send email to customer admin ///////////////////
			$super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
			$from_email =$admin_email;
			$to_email=trim($_POST['cust_email']);
			$email_subject="les modalités d'inscription à jour: "._WEBSITE_NAME;
			$email_body .=
				'
					<table width="70%" cellpadding="0" border="0" >
						<tr>
							<td colspan="2" align="left">Salut '.trim($_POST['cust_fname']).' '.trim($_POST['cust_lname']).',<br/><br/><b>Vous êtes un utilisateur mis à jour le succès) '._WEBSITE_NAME.' !! </b><br/><br/></td>
						</tr>
						<tr>
							<td colspan="2" align="left">Vous pouvez vous connecter sur notre site Internet en utilisant les informations suivantes: </td>
						</tr>
						<tr>
							<td align="left"><b>Nom d\'utilisateur :</b></td>
							<td align="left">'.trim($_POST['cust_email']).'</td>
						</tr>
						<tr>
							<td align="left"><b>Mot de passe :</b></td>
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
				/////////////////////////// send email to super admin //////////////////////////
			}
		
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._WWWROOT.'index.php">';
		echo '<input type="hidden" name="msg" id="msg" value="Mise à jour">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';
		exit;
	/*	}
	else
		{
			$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>'.mysql_error().'</span>';
		}
	
	else
	{
		$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>A user with same Email ID already exists. Please provide a different Email ID.</span>';
	} */
	/////////////////////////
		
}
else if(isset($_POST['submit']) && $_POST['submit']=='Inscrivez-vous maintenant' && empty($_REQUEST['cust_id']))
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
					<td align="left"><b>Nom de famille :</b></td>
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
			$email_body .=
				'
					<table width="70%" cellpadding="0" border="0" >
						<tr>
							<td colspan="2" align="left">Salut '.trim($_POST['cust_fname']).' '.trim($_POST['cust_lname']).',<br/><br/><b>Vous êtes un utilisateur enregistré le succès! '._WEBSITE_NAME.' !! </b><br/><br/></td>
						</tr>
						<tr>
							<td colspan="2" align="left">Vous canlogin dans notre site Web en utilisant les coordonnées suivantes: </td>
						</tr>
						<tr>
							<td align="left"><b>Nom d\'utilisateur :</b></td>
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
				$from="From: Admin <".$from_email.">";
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$header .=$from;
				mail($to_email,$email_subject,$email_body,$header);
				/// send email to super admin///////////////////
			}
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._WWWROOT.'index.php">';
			echo '<input type="hidden" name="msg" id="msg" value="Inscrit">';
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
		$sqlError='<span class="loginErrBox"><span class="alert_icon"></span>Un utilisateur avec le même Email ID existe déjà. S\'il vous plaît donner un autre Email ID.</span>';
	}
	/////////////////////////
		
}
?>
<?php if(!empty($_SESSION["UserInfo"]["id"]))
{
	include("header.php");
} else {
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
<?php } ?>

	<!--Start middle_area -->
	<div id="middle_area">
		<div id="left_part">
			<?php if(!empty($_SESSION["UserInfo"]["id"]))
			{
				include("left.php");
			} else {
			?>
				<img src="images/left_part.jpg" />
			<?php } ?>
		</div>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				
				<!--Start form -->
				<form name="register_frm" action="" method="post" onsubmit="return ValidateForm(this)" >
				<div id="form">
		
			<div class="clear"></div>
			<div class="clear"></div>
			<?php
			if($sqlError!='')
			{
			?>
					<br /><div align="center"><?=$sqlError?></div>
			<?php
			}
			?> 
			<div class="login_hea">Enregistrement de l'utilisateur</div>
			<ul>
				<li class="field_name">Prénom :</li>
				<li class="field"><input type="text" class="textbox" name="cust_fname" value="<?=$Data_list["cust_fname"]?>" id="chk_fname" title="S'il vous plaît entrer le prénom"/>
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Nom de famille :</li>
				<li class="field"><input type="text" class="textbox" value="<?=$Data_list["cust_lname"]?>" name="cust_lname" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Email ID :</li>
				<li class="field"><input type="text" class="textbox" name="cust_email" value="<?=$Data_list["cust_email"]?>" id="chkemail_email" title="S'il vous plaît entrer une adresse e-mail valide" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Adresse :</li>
				<li class="field"><input type="text" class="textbox" name="cust_address" value="<?=$Data_list["cust_address"]?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">État :</li>
				<li class="field"><input type="text" class="textbox" name="cust_state" value="<?=$Data_list["cust_state"]?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Ville :</li>
				<li class="field"><input type="text" class="textbox" name="cust_city" value="<?=$Data_list["cust_city"]?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Code Postal :</li>
				<li class="field"><input type="text" class="textbox" name="cust_zip" value="<?=$Data_list["cust_zip"]?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Pays :</li>
				<li class="field">
					<?php
					$country_condition="order by countries_name";
					$country_record_arr=$sql->SqlRecordMisc('esthp_tblCountries', $country_condition);
					$total_countries=$country_record_arr['count'];
					$country_records=$country_record_arr['Data'];
					
					?>
					<select name="cust_country" class="input_white" >
					<option value=''>selectionner pays</option>
					<?php
					//foreach($country_records as $country)
					for($i=0; $i<$total_countries; $i++)
					{	?>
						<option value="<?php echo $country_records[$i]["countries_name"]; ?>" <?php echo ($country_records[$i]["countries_name"] == $Data_list["cust_country"]) ?"selected":""; ?> ><?php echo $country_records[$i]["countries_name"]; ?> </option>
  	<?php  }	?>
					</select>
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Téléphone :</li>
				<li class="field"><input type="text" class="textbox" name="cust_phone" value="<?=$Data_list["cust_phone"]?>" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Mot de passe :</li>
				<li class="field"><input type="password" class="textbox" name="cust_password" value="<?=$Data_list["cust_password"]?>" id="chk_password" title="Pleaes entrer le mot de passe" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Retapez Pass :</li>
				<li class="field"><input type="password" class="textbox"  value="<?=$Data_list["cust_password"]?>" name="cust_cpassword" id="chkpass_repassword" title="Pleaes entrer le mot de passe Confirmez" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><input name="alert_customer" type="checkbox" id="alert_customer" value="1" checked="checked">
				alertez moi par email de mes messages et devis</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">&nbsp;</li>
				<?php
				if(!empty($_SESSION['UserInfo']['id']))
				{
					$btnName = "mettre à jour";
				}
				else
				{
					$btnName = "Inscrivez-vous maintenant";
				}
				?>
				<li class="field">
					<input type="submit" value="<?php echo $btnName; ?>" class="submit" name="submit">
					<!--<input name="submit" type="submit" class="submit"  value="Register Now!"/>--> &nbsp; 
					<input name="" type="reset" class="submit"  value="Effacer"/> </li>
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
<?php include("footer.php"); ?>
<!--End Page Holder -->
</body>
</html>

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

if(isset($_POST['submit']) && $_POST['submit']=='mettre à jour')
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
else if(isset($_POST['submit']) && $_POST['submit_send']=='Inscrivez-vous maintenant' && empty($_REQUEST['cust_id']))
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
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="post" action="'._WWWROOT.'index.php">';
			echo '<input type="hidden" name="msg" id="msg" value="Inscrit">';
			echo '<input type="hidden" name="cufname" id="" value="'.trim($_POST['cust_fname']).'">';
			echo '<input type="hidden" name="culname" id="" value="'.trim($_POST['cust_lname']).'">';
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
<link href="style2.css" rel="stylesheet" type="text/css" />
<link href="layout2.css" rel="stylesheet" type="text/css" />
<SCRIPT language=javascript src="js/validation_new.js"></SCRIPT>
</head>
<body>
<!--Start Page Holder -->
<div id="page_holder" style="background:none;">
	<!--Start page_panel -->
	<div id="page_panel" >
	
    <div id="header">
          <div id="socialmedia" align="right">
          <a href="http://www.esthetic-planet.com/contact-societe-esthetic-planet.php" title="Contact us"><img src="../img/contact.jpg" alt="esthetic planet" border="0" /></a>
          
          <a href="http://www.facebook.com/group.php?gid=216202259799#!/group.php?gid=216202259799&v=wall" title=""><img src="../img/facebook.jpg" alt="esthetic planet" border="0" /></a>
          <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a href="skype:esthetic_planet?call"><img src="../img/skype.jpg" alt="esthetic planet" border="0" /></a>
          <a href="http://twitter.com/account/confirm_email/estheticplanet/9BA62-G89AA-129916
" title="twitter"><img src="../img/twitter.jpg" alt="esthetic planet" border="0" /></a><br/>
          <a href="http://www.esthetic-planet.com/dynm/registration.php" title=""><img src="../img/s-inscriere.jpg" border="0" alt="" /></a><img src="../img/separator.jpg" border="0"/><a href="http://www.esthetic-planet.com/dynm/" title=""><img src="../img/se-connecter.jpg" border="0"  alt="" /></a>

          </div>
 				<div id="logo"><a href="http://www.esthetic-planet.com" title="Esthetic planet"><img src="../../img/logo-esthetic-planet.jpg" alt="esthetic planet" border="0" /></a></div>
                    
                   <div id="menu">
                   			<ul>
                            <li><a href="http://www.esthetic-planet.com/cliniques.html" title="CLINIQUES">CLINIQUES</a></li>
                            
                            <li><a href="http://www.esthetic-planet.com/interventions.html" title="INTERVENTIONS">INTERVENTIONS</a></li>
                            <li><a href="http://www.esthetic-planet.com/services.html" title="SERVICES">SERVICES</a></li>
                            <li><a href="http://www.esthetic-planet.com/chirurgie-du-visage.html" title="TARIFS">TARIFS</a></li>
                            <li><a href="http://www.esthetic-planet.com/galerie-photo-visage.html" title="GALERIE">GALERIE</a></li>
                            <li><a href="http://www.esthetic-planet.com/qui-sommes-nous.html" title="QUI SOMMES NOUS ?">QUI SOMMES NOUS ?</a></li>
                            <li style="border-right:none;"><a href="http://www.esthetic-planet.com/vos-questions.html" title="FAQ">FAQ</a></li>
                            
                            </ul>
                   </div> 
           
		</div>
    
    
    
    
    
    
<?php } ?>
<?php header('Content-Type: text/html; charset=utf-8'); ?>
	<!--Start middle_area -->
	<div id="middle_area" style="margin:32px auto auto;">
		<div id="left_part">
			<?php if(!empty($_SESSION["UserInfo"]["id"]))
			{
				include("left.php");
			} else {
			?>
				 
			<?php } ?>
            
            
            
            
            <!--videos box-->
      	      <div class="videos-box"><a href="http://www.esthetic-planet.com/temoignages.html" title="T&eacute;moignages"><img src="../img/temoignages.jpg" alt="Temoignages" border="0"/></a></div>
              <div class="videos-box"><a href="http://www.esthetic-planet.com/videos.html" title="Vid&eacute;os"><img src="../img/videos2.jpg" alt="Videos" border="0" /></a></div>
              <!--videos box end-->
		</div>
		
		<!--Start right_part -->
		<div id="right_part" style="float:right;">
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
			<div class="login_hea" style="color:#399DFB; border:none;">Enregistrement de l'utilisateur</div>
			<ul>
				<li class="field_name">Prénom :</li>
				<li class="field"><input type="text" class="textbox" name="cust_fname" value="<?=$Data_list["cust_fname"]?>" id="chk_fname" title="S'il vous plaît entrer le prénom"/>
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Nom :</li>
				<li class="field"><input type="text" class="textbox" value="<?=$Data_list["cust_lname"]?>" name="cust_lname" />
				</li>
			</ul>
			<div class="clear"></div>
			<ul>
				<li class="field_name">Email :</li>
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
				<li class="field_name">Réécrire mot de passe :</li>
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
                <input type="hidden" name="submit_send" value="<?php echo $btnName; ?>"/>
                <input type="submit" name="submit" value="<?php //echo $btnName; ?>" class="effacer"></input>
            
      		    <input type="submit" name="reset" value="" class="envoyer"></input>
                
            </li>
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
<!--footer -->
		<div id="footer">
			<div class="left-bg">
            	<div class="right-bg">
            	  <div class="text" style="width:100%; height: 200px;">
                      <div id="footer-content">
                          <p>Cliniques</p>
                <ul style="text-align:left; margin-right:40px; width: 118px;">

                <li><a href="http://www.esthetic-planet.com/chirurgie-esthetique-cliniques-chirurgie-esthtetique-miami.html"  title="MIAMI - NEW YORK">Miami</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-esthetique-cliniques-chirurgie-esthetique-praga.html" title="Prague">Prague</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-esthetique-tunisie.html" title="Tunis">Tunis</a></li>
                <li><a href="http://www.esthetic-planet.com/tourisme-dentaire-soins-dentaire-hongrie.html" title="Budapest">Budapest</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-esthetique-turquie-greffe-de-cheveux.html" title="Istanbul">Istanbul</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-esthetique-belgique-greffe-de-cheveux.html" title="Bruxelles">Bruxelles</a></li>
<li><a href="http://www.esthetic-planet.com/paris.html" title="PARIS">Paris</a></li>
<li><a href="http://www.esthetic-planet.com/inde.html" title="INDE">Inde</a></li>
               
                </ul>
                  </div>
               <div  id="footer-content">
                   <p style="margin-left: 0px;">Interventions</p>
                    <ul style="width: 135px; border: none; margin-left: 0px; margin-right: 13px;">
               
                <li><a href="http://www.esthetic-planet.com/greffe-de-cheveux-implants-capillaires.html" title="Greffe de cheveuxi">Greffe de cheveux</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-botox-injection-collagene-acide-hyaluronique.html" title="Botox">Botox</a></li>
                <li><a href="http://www.esthetic-planet.com/lifting-cervico-facial.html" title="Lifting">Lifting</a></li>
                <li><a href="http://www.esthetic-planet.com/vision.html" title="Vision">Vision</a></li>
                <li><a href="http://www.esthetic-planet.com/blepharoplastie.html" title="Blépharoplastiel">Blépharoplastie</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-du-nez-rhinoplastie.html" title="Rhinoplastie">Rhinoplastie</a></li>
                 <li><a href="http://www.esthetic-planet.com/soins-dentaire.html" title="Soins dentaires">Soins dentaires</a></li>
                  <li><a href="http://www.esthetic-planet.com/chirurgie-des-oreilles-decollees-otoplastie.html" title="Bruxelles">Otoplastie</a></li>
                   <li><a href="http://www.esthetic-planet.com/genioplastie.html" title="Génioplastie">Génioplastie</a></li>
                   </ul>
                  </div>
                      <div id="footer-content">
                   <ul style="margin-left:0px; width: 154px; margin-top: 25px; padding-right:25px;">
     
                <li><a href="http://www.esthetic-planet.com/chirurgie-mammaire-augmentation-mammaire.html" title="Augmentation Mammaire">Augmentation Mammaire</a></li>
                <li><a href="http://www.esthetic-planet.com/lifting-des-seins.html" title="Lifting des seins">Lifting des seins</a></li>
                <li><a href="http://www.esthetic-planet.com/gynecomastie.html" title="Gynécomastie">Gynécomastie</a></li>
                <li><a href="http://www.esthetic-planet.com/lifting-des-bras-brachioplastie.html" title="Lifting des bras">Lifting des bras</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-corps-lifting-des-cuisses.html" title="Lifting des cuissesl">Lifting des cuisses</a></li>
                <li><a href="http://www.esthetic-planet.com/liposuccion-liposculpture.html" title="Liposuccion Liposculpture">Liposuccion Liposculpture</a></li>
                 <li><a href="http://www.esthetic-planet.com/chirurgie-intime-nymphoplastie-hymenoplastie-labioplastie.html" title="Chirurggie Intime">Chirurggie Intime</a></li>
                  <li><a href="http://www.esthetic-planet.com/abdominoplastie.html" title="Abdominopmastie">Abdominopmastie</a></li>
               </ul></div>
                  <div id="footer-content">
                      <p style="margin-left: 16px;">Services</p>
                     <ul style="padding-left:6px; padding-right:20px;">
                <li><a href="http://www.esthetic-planet.com/expertise-a-votre-service.html" title="Expertise à votre service">Expertise à votre service</a></li>
                <li><a href="http://www.esthetic-planet.com/guide-par-etapes.html" title="Guide par étapes">Guide par étapes</a></li>
                <li><a href="http://www.esthetic-planet.com/charte-qualite.html" title="Charte de qualité">Charte de qualité</a></li>
                <li><a href="http://www.esthetic-planet.com/garanties.html" title="Garantie">Garantie</a></li>
                <li><a href="http://www.esthetic-planet.com/financement.html" title="Financement">Financement</a></li>
                <li><a href="http://www.esthetic-planet.com/vos-questions.html" title="Vos questions">Vos questions</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-mammaire-reduction-mammaire-hypertrophie.html" title="Remboursements">Remboursements</a></li>
                <li><a href="http://www.esthetic-planet.com/qui-sommes-nous.html" title="Qui sommes nous ?">Qui sommes nous ?</a></li>
                <li><a href="http://www.esthetic-planet.com/pourquoi-nous-choisir.html" title="Pourquoi nous choisir ?">Pourquoi nous choisir ?</a></li>
                
               </ul></div>
                  <div id="footer-content" >  
                       <p>Tarifs</p>
                      <ul style="border:none;">
                <li><a href="http://www.esthetic-planet.com/chirurgie-du-visage.html" title="Chirurgie visage">Chirurgie visage</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-des-seins.html" title="Chirurgie des seins">Chirurgie des seins</a></li>
                <li><a href="http://www.esthetic-planet.com/chirurgie-du-corps.html" title="Chirurgie du Corps">Chirurgie du Corps</a></li>
                <li><a href="http://www.esthetic-planet.com/soins-dentaires.html" title="Soins dentaires">Soins dentaires</a></li>
                <li><a href="http://www.esthetic-planet.com/greffe-des-cheveux.html" title="Greffe des cheveux">Greffe des cheveux</a></li>
                <li><a href="http://www.esthetic-planet.com/#" title="Bruxelles">Les forfaits</a></li>
                <li><a href="http://www.esthetic-planet.com/destinations.html" title="Destinations">Votre séjour</a></li>
 <li><br/></li>
<li><a href="http://www.esthetic-planet.com/mentions-legales.html" title="Mentions Légales"><strong>Mentions Légales</strong></a></li>
                </ul></div>     
                  </div>
                 <div id="footer-bottom">&nbsp;</div>
             </div>                 
          </div>           
		</div>
		<!--footer end-->
<!--End Page Holder -->
</body>
</html>

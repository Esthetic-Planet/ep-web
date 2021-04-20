<?php
// On ve...
$desactive = ini_get('disable_functions');
if (preg_match("/ini_set/i", "$desactive") == 0) {
// Si elle n'est pas Â  n'afficher que les erreurs...
ini_set("error_reporting" , "E_ALL & ~E_NOTICE");
}

// V...
if (isset($_POST['envoi'])) {
	// Definir l'indicateur d'erreur sur zero...
	$flag_erreur = 0;

	//On commence une session pour enregistrer les variables du formulaire...

	session_start();


	$_SESSION['champ1'] = $_POST['champ1'];
	//Controle du spam...
	if (eregi("http",$_POST['champ1'])) {
		$erreur_champ1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
		$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['champ1'])) {
		$erreur_champ1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
		$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['champ1'])) {
		$erreur_champ1 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
		$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['champ1'])) {
		$erreur_champ1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
		$flag_erreur = 1;
	}

	$_SESSION['champ2'] = $_POST['champ2'];
	//Controle du spam...
	if (eregi("http",$_POST['champ2'])) {
		$erreur_champ2 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
		$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['champ2'])) {
		$erreur_champ2 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
		$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['champ2'])) {
		$erreur_champ2 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
		$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['champ2'])) {
		$erreur_champ2 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
		$flag_erreur = 1;
	}
	$_SESSION['zone_email1'] = $_POST['zone_email1'];

	//Controle du spam...
	if (eregi("http",$_POST['zone_email1'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
		$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['zone_email1'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
		$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['zone_email1'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
		$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['zone_email1'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
		$flag_erreur = 1;
	}

	//Enregistrement des parametres de la case 1...
	$_SESSION['case1'][0] = "";
	if (isset($_POST['case1'][0])) {
		$_SESSION['case1'][0] = $_POST['case1'][0];
	} // Fin du if...

	$_SESSION['case1'][1] = "";
	if (isset($_POST['case1'][1])) {
	$_SESSION['case1'][1] = $_POST['case1'][1];
	} // Fin du if...

	$_SESSION['case1'][2] = "";
	if (isset($_POST['case1'][2])) {
		$_SESSION['case1'][2] = $_POST['case1'][2];
	} // Fin du if...

	//Enregistrement des zones de texte...
	$_SESSION['zone_texte1'] = $_POST['zone_texte1'];

	//Controle du spam...
	if (eregi("http",$_POST['zone_texte1'])) {
		$erreur_texte1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
		$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['zone_texte1'])) {
		$erreur_texte1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
		$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['zone_texte1'])) {
		$erreur_texte1 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
		$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['zone_texte1'])) {
		$erreur_texte1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
		$flag_erreur = 1;
	}

	// Definir l\'icone apparaissant en cas d\'erreur...


	// Definir sur 0 pour afficher un petit x de couleur rouge.
	// Definir sur 1 pour afficher l\'image d\'une croix rouge telle que celle utilisee dans l\'assistant
	// Si vous utilisez l\'option 1, l\'image de la croix rouge \'icone.gif\' doit se trouver dans le repertoire \'images\',
	// ce dernier devant se trouver au meme niveau que votre formulaire...
	$flag_icone = 0;

	// On verifie si $flag_icone est defini sur 0 ou 1...
	if ($flag_icone == 0) {
		$icone = "<b><font size=\"3\" face=\"Arial, Verdana, Helvetica, sans-serif\" color=\"#CC0000\">x</font></b>";
	} else {
		$icone = "<img src=\"images/icone.gif\"";
	}


	//Validation PHP des elements du formulaire...
	if ($_POST['champ1'] == "") {
		$erreur_champ1 = "Merci d\'inscrire votre nom";
		$flag_erreur = 1;
	} // Fin du if...



	if ($_POST['zone_email1'] == "") {
		$erreur_email1 = "Merci d\'inscrire votre email";
		$flag_erreur = 1;
	} else {
		if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['zone_email1'])){
			$erreur_email1 = "Votre adresse e-mail 1 n'est pas complete ou contient des caracteres invalides.";
			$flag_erreur = 1;
		} // Fin du if...
	} // Fin du else...
	// N'envoyer le formulaire que s'il n'y a pas d'erreurs...
	if ($flag_erreur == 0) {

		// Start - Insert the new Lead into SugarCRM (#2978)
		include_once("dynm/soap_login.php");
		$soap_obj = new soap_login();
		$soap_connection = $soap_obj->login();

		if($soap_obj->error == "no" && !empty($soap_obj->session_id))
		{
			$last_name = $_POST['champ1'];
			$first_name = $_POST['champ3'];
			$telephone = $_POST['champ2'];
			$email = $_POST['zone_email1'];
			$decsription = $_POST['zone_texte1'];
			$meeting_type = "";
			if(isset($_REQUEST['case1']) && count($_REQUEST['case1']) > 0 )
			{
				foreach($_REQUEST['case1'] as $key => $value)
				{
					if($value == "une consultation webcam")
						$meeting_type .= "^une consultation webcam^";
					if($value == "un rendez-vous a paris")
						$meeting_type .= !empty($meeting_type)?(",^un rendezvous a paris^"):"^un rendezvous a paris^";
					if($value == "rendez-vous telephonique")
						$meeting_type .= !empty($meeting_type)?(",^rendezvous telephonique^"):"^rendezvous telephonique^";
				}
			}

			$assigned_user_id = $soapClient->get_user_id($soap_obj->session_id);
			$soapClient->set_entry(
				$soap_obj->session_id,
				'Leads',
				array(
					array('name' => 'last_name', 'value' => $last_name),
					array('name' => 'first_name', 'value' => $first_name),
					array('name' => 'description', 'value' => $decsription),
					array('name' => 'email1', 'value' => $email),
					array('name' => 'phone_work', 'value' => $telephone),
					array('name' => 'type_meeting_c', 'value' => $meeting_type),
					array('name' => 'assigned_user_id', 'value' => $assigned_user_id),
					)
				);
		}
		// End - Insert the new Lead into SugarCRM (#2978)
/*
	// Addresse de reception du formulaire
	$email_dest = "info@esthetic-planet.com";
	$sujet = "Requete page de contact";
	$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: Esthetic Planet<info@esthetic-planet.com>\n";
	$entetes .="Return-Path: Esthetic Planet<info@esthetic-planet.com>\n";
	$entetes .="Reply-To: Esthetic Planet<info@esthetic-planet.com>\n";
	$entetes .="Content-Type: text/html; charset=utf-8 \n";
	$partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n";


	//Partie HTML de l'e-mail...
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Nom Prenom = " . $_SESSION['champ1'] . "</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Telephone = " . $_SESSION['champ2'] . "</font><br>\n";
	$partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Email = " . $_SESSION['zone_email1'] . "</font><br>\n";
	$partie_cases .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Vous souhaiteriez = ". $_SESSION['case1'][0] . " ". $_SESSION['case1'][1] . " ". $_SESSION['case1'][2] . " "."</font><br>\n";
	$partie_zone_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Votre message = " . $_SESSION['zone_texte1'] . "</font><br>\n";


	// Fin du message HTML
	$fin = "</body></html>\n\n";

	$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_zone_texte . $fin;


	// Send the e-mail
	if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
		echo("Envoi du formulaire impossible");
		exit();
	} else {
		// Rediriger vers la page de remerciement
		header("Location:http://www.esthetic-planet.com/merci.html");
		exit();
		} // Fin else*/
		echo "pouet";
		exit();
	} // Fin du if ($flag_erreur == 0) {
}// Fin de if POST
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Chirurgie esthétique à l'étranger, Esthetic Planet</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta name="description" content="Esthetic Planet : informations de contact Esthetic Planet. Sollicitez une consultation webcam ou un rendez-vous avec un représentant Esthetic Planet" >
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
<script type="text/javascript">

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-5658450-3']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>
</head>


<body id="page1">
<div id="main">
<div id="right-tail">
<!--header -->
<div id="header">
<div id="socialmedia" align="right">
<a href="contact-societe-esthetic-planet.php" title="Contact us"><img src="img/contact.jpg" alt="esthetic planet" border="0" /></a>

<a href="http://www.facebook.com/group.php?gid=216202259799#!/group.php?gid=216202259799&v=wall" title=""><img src="img/facebook.jpg" alt="esthetic planet" border="0" /></a>
<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a href="skype:esthetic_planet?call"><img src="img/skype.jpg" alt="esthetic planet" border="0" /></a>
<a href="http://twitter.com/estheticplanet" title="twitter"><img src="img/twitter.jpg" alt="esthetic planet" border="0" /></a><br/>
<a href="http://www.esthetic-planet.com/dynm/registration.php" title=""><img src="img/s-inscriere.jpg" border="0" alt="" /></a><img src="img/separator.jpg" border="0"/><a href="http://www.esthetic-planet.com/dynm/" title=""><img src="img/se-connecter.jpg" border="0"  alt="" /></a>

</div>
<div id="logo"><a href="http://www.esthetic-planet.com" title="Esthetic planet"><img src="img/logo-esthetic-planet.jpg" alt="esthetic planet" border="0" /></a></div>

<div id="menu">
<ul>
<li><a href="cliniques.html" title="CLINIQUES">CLINIQUES</a></li>

<li><a href="interventions.html" title="INTERVENTIONS">INTERVENTIONS</a></li>
<li><a href="services.html" title="SERVICES">SERVICES</a></li>
<li><a href="chirurgie-du-visage.html" title="TARIFS">TARIFS</a></li>
<li><a href="galerie-photo-visage.html" title="GALERIE">GALERIE</a></li>
<li><a href="qui-sommes-nous.html" title="QUI SOMMES NOUS ?">QUI SOMMES NOUS ?</a></li>
<li style="border-right:none;"><a href="vos-questions.html" title="FAQ">FAQ</a></li>

</ul>
</div>

</div>
<!--header end-->
<!--content begin-->
<div id="content-new">
<div class="container">
<div id="page-name"><a href="/" title="Accueil page">Accueil</a> > Contactez-nous</div>
<div id="top-banner" style="margin-bottom:0px;">
<div class="header-bg">
<ul>

<li><a href="interventions.html" title="interventions">Chirurgie esth&eacute;tique</a></li>
<li><a href="soins-dentaire.html" title="Soins dentaires">Soins dentaires</a></li>
<li><a href="vision.html" title="Chirurgie des yeux">Chirurgie des yeux</a></li>
<li><a href="greffe-de-cheveux-implants-capillaires.html" title="Greffe capillaire">Greffe capillaire</a></li>
</ul>
<!--demandes de vis and rappel bottons-->
<div class="demande-de-devis"><a href="consultation_en_ligne.php" title="Demande de devis"><img src="img/demande-de-devis.jpg" alt="" width="247" border="0"/></a></div>
<div class="rappel-immediat"><a href="rappel.php" title="Rappel imm?ƒÂ©diat" style="color:#FFF;"><img src="img/rappel-immediat.jpg"  width="247"  alt="Rappel imm&eacute;diat" /></a></div>
</div>
<!--demandes de vis and rappel bottons end-->
<div style="float:right"> <img src="img/img_28_03.jpg" border="0" width="492" height="146" alt=""/></div>
</div>

<div style="width:937px;">
<!--left column begin-->
<div id="left-column" style="width:200px;" >
<div  >





<div class="left-menu-top-bg" style="margin-top:10px;"></div>

<div class="left-menu-cliniques">
<p class="left-box-content-text">Nos Sites Spécialisés<br/>
<br/>
<a href="http://www.greffe-cheveux.fr">Hairmed greffe de cheveux</a><br/>
<br/>

<a href="http://www.europe-dentaire.com">Europe Dentaire soins dentaires à l'étranger</a> <br/></p>
<p class="left-box-content-text">
Nous Rencontrer à Paris<br/>
Adresse : <br/>
23, Rue d'Enghien - Paris 10<br/>
Métro : Bonne Nouvelle <br/>
(ligne 8)<br/>
Bus : lignes 20, 39, 48<br/>
Voir le plan</p>
<p style="font-size:14px; font-weight:bold; text-align:center;">
Sociétés Savantes<br/>
<br/>
SOFCPRE<br/>
<a href="http://www.plasticiens.org" title="www.plasticiens.org" target="_blank">www.plasticiens.org</a><br/>
<br/>
ISAPS<br/>
<a href="http://www.isaps.org" title="www.isaps.org" target="_blank">www.isaps.org</a><br/><br/>

IPRAS<br/>
<a href="http://www.ipras.org" title="www.ipras.org" target="_blank">www.ipras.org</a><br/>
<br/>
IAHRS<br/>
<a href="http://www.ipras.org" title="www.ipras.org" target="_blank">www.iahrs.org</a><br/>

</p>     </div>


<div class="left-bottom-menu-bg"></div>
<!--menu gallery end-->

</div>

<!--videos box-->
<div class="videos-box"><a href="temoignages.html" title="T&eacute;moignages"><img src="img/temoignages.jpg" alt="Temoignages" /></a></div>
<div class="videos-box"><a href="videos.html" title="Vid&eacute;os"><img src="img/videos2.jpg" alt="Videos" /></a></div>
<!--videos box end-->


</div>
<!--left column end-->

<!--contact form end-->


</div>




<div id="right-column" style="width:700px; margin-bottom:27px; margin-left:20px; " >

<div class="indent" style="padding-top:0px;">

<div style="width:700px; height: 140px;">
<h2>Contactez-nous</h2>

<!--grey box-->

<div style="height: 177px; width: 16px; float: left; background-image: url(&quot;img/contactez-nous-bg-left.jpg&quot;);"></div>

<div style="background-color:#F1F1F1;
background-image:url('img/contactez-nous-bg-bottom.jpg');
background-position:center bottom;
background-repeat:repeat-x;
float:left;
font-size:14px;
height:177px;
text-align:left;
width:667px;">
<div style="float: left;"><br /><img src="img/estheticplanet.jpg" width="399" height="138" /></div>
<div style="float: right; width: 40%; margin-top:30px;">

<div style="float:right;"><a target="_new" href="http://www.facebook.com/group.php?gid=216202259799#!/group.php?gid=216202259799&v=wall"><img border="0" alt="esthetic planet" src="images/facebook.jpg"></a>
<script src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js" type="text/javascript"></script>
<a href="skype:esthetic_planet?call"><img border="0" alt="esthetic planet" src="images/img_07.jpg"></a>
<a href="http://twitter.com/estheticplanet" target="_new" title="twitter"><img border="0" alt="esthetic planet" src="images/twitter.jpg"></a><br/></div>
<span style="color: rgb(57, 157, 251);">Esthetic Planet</span>
<p>    23, Rue d'Enghien - 75010 PARIS<br>
Tél : +33 (0)1 42 74 07 18<br>
Fax : +33 (0)1 56 03 65 65<br>
E-mail : info@esthetic-planet.com</p>
</div>
</div>

<div style="background-image: url(&quot;img/contactez-nous-bg-right.jpg&quot;); height: 177px; width: 17px; float: right;"></div>

</div>
<!--grey box end-->
</div>
<div class="box3">
<div class="right-top">
<div class="left-bot">
<div class="right-bot">
<div class="indent">
<br/><br/><br/>
<p>Vous souhaitez une information ou un rendez-vous, merci de remplir le formulaire ci-dessous : </p>
<form name="mail_form" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>">
<div align="center"></div><table align="center" width="566" border="0" cellspacing="0" cellpadding="0">
<tr>
<td height="16"><div align="center">
<font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma"><strong><?php
if ($erreur_champ1) {
echo(stripslashes($erreur_champ1));
} else {
if ($erreur_champ2) {
echo(stripslashes($erreur_champ2));
} else {
if ($erreur_email1) {
echo(stripslashes($erreur_email1));
} else {
if ($erreur_case1) {
echo(stripslashes($erreur_case1));
} else {
if ($erreur_texte1) {
echo(stripslashes($erreur_texte1));
} else {
} // Fin du else...
} // Fin du else...
} // Fin du else...
} // Fin du else...
} // Fin du else...
?>
</strong></font>
</div></td>
</tr>
</table>
<p align="center"></p><table width="566" border="0" align="center"><tr>
<td width="140"><div align="right"><font face="Verdana" size="2" >Nom</font></div></td>
<td align="center" valign="middle" width="30">
<?php
if ($erreur_champ1) {
echo($icone);
}
?>
</td>
<td><input name="champ1" type="text" value="<?php echo(stripslashes($_SESSION['champ1'])); ?>"></input></td>
</tr></table>

<table width="566" border="0" align="center"><tr>
<td width="140"><div align="right"><font face="Verdana" size="2" >Prénom</font></div></td>
<td align="center" valign="middle" width="30">
<?php
if ($erreur_champ3) {
echo($icone);
}
?>
</td>
<td><input name="champ3" type="text" value="<?php echo(stripslashes($_SESSION['champ3'])); ?>">
</input></td>




</tr></table>

<table width="566" border="0" align="center"><tr>
<td width="140"><div align="right"><font face="Verdana" size="2" >Téléphone</font></div></td>
<td align="center" valign="middle" width="30">
<?php
if ($erreur_champ2) {
echo($icone);
}
?>
</td>
<td><input name="champ2" type="text" value="<?php echo(stripslashes($_SESSION['champ2'])); ?>"></input></td>
</tr></table><table width="566" border="0" align="center"><tr>
<td width="140"><div align="right"><font face="Verdana" size="2" >Email</font></div></td>
<td width="30" align="center" valign="middle">
<?php
if ($erreur_email1) {
echo($icone);
}
?>
</td>
<td><input name="zone_email1" type="text" value="<?php echo(stripslashes($_SESSION['zone_email1'])); ?>"></input></td>
</tr></table><table width="566" border="0" align="center"><tr>
<td width="140"><div align="right"><font face="Verdana" size="2" >Vous souhaitez</font></div></td>
<td width="30" align="center" valign="middle">
<?php
if ($erreur_case1) {
echo($icone);
}
?>
</td>
<td><input type="checkbox" name="case1[]" value="une consultation webcam"<?php
if ($_SESSION['case1_'][0] == "une consultation webcam") {
echo(" checked");
}
?>></input><font face="Verdana" size="2" > une consultation webcam</font><br /><input type="checkbox" name="case1[]" value="un rendez-vous a paris"<?php
if ($_SESSION['case1_'][1] == "un rendez-vous a paris") {
echo(" checked");
}
?>>
</input><font face="Verdana" size="2" >un rendez-vous à Paris</font><br />
<input type="checkbox" name="case1[]" value="rendez-vous telephonique"<?php
if ($_SESSION['case1_'][2] == "rendez-vous telephonique") {
echo(" checked");
}
?>>
</input><font face="Verdana" size="2" >un rendez-vous téléphonique</font></td>
</tr></table><table width="566" border="0" align="center"><tr>
<td width="140" valign="top"><div align="right"><font face="Verdana" size="2" >Votre message</font></div></td>
<td width="30" align="center" valign="top">
<?php
if ($erreur_texte1) {
echo($icone);
}
?>
</td>
<td><textarea name="zone_texte1" cols="45" rows="10" class="text-box-contact"><?=stripslashes($_SESSION['zone_texte1']);?></textarea></td>
</tr></table>
<table width="566" border="0" align="center" style="margin-top:20px;"><tr>
<td valign="top"><div align="center">
<input type="reset" name="Reset" value="" class="effacer"></input>

<input type="submit" name="envoi" value="" class="envoyer"></input>
</div></td></tr></table><div align="center"><input name="nbre_fichiers" type="hidden" id="nbre_fichiers" value="0"></input></div></form></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!--content end-->
</div>
<!--footer -->
<div id="footer">
<div class="left-bg">
<div class="right-bg">
<div class="text" style="width:100%; height: 200px;">
<div id="footer-content">
<p>Cliniques</p>
<ul style="text-align:left; margin-right:40px; width: 118px;">

<li><a href="chirurgie-esthetique-cliniques-chirurgie-esthtetique-miami.html"  title="MIAMI - NEW YORK">Miami</a></li>
<li><a href="chirurgie-esthetique-cliniques-chirurgie-esthetique-praga.html" title="Prague">Prague</a></li>
<li><a href="chirurgie-esthetique-tunisie.html" title="Tunis">Tunis</a></li>
<li><a href="tourisme-dentaire-soins-dentaire-hongrie.html" title="Budapest">Budapest</a></li>
<li><a href="chirurgie-esthetique-turquie-greffe-de-cheveux.html" title="Istanbul">Istanbul</a></li>
<li><a href="chirurgie-esthetique-belgique-greffe-de-cheveux.html" title="Bruxelles">Bruxelles</a></li>
<li><a href="paris.html" title="PARIS">Paris</a></li>
<li><a href="inde.html" title="INDE">Inde</a></li>

</ul>
</div>
<div  id="footer-content">
<p style="margin-left: 0px;">Interventions</p>
<ul style="width: 135px; border: none; margin-left: 0px; margin-right: 13px;">

<li><a href="greffe-de-cheveux-implants-capillaires.html" title="Greffe de cheveuxi">Greffe de cheveux</a></li>
<li><a href="chirurgie-botox-injection-collagene-acide-hyaluronique.html" title="Botox">Botox</a></li>
<li><a href="lifting-cervico-facial.html" title="Lifting">Lifting</a></li>
<li><a href="vision.html" title="Vision">Vision</a></li>
<li><a href="blepharoplastie.html" title="Blépharoplastiel">Blépharoplastie</a></li>
<li><a href="chirurgie-du-nez-rhinoplastie.html" title="Rhinoplastie">Rhinoplastie</a></li>
<li><a href="soins-dentaire.html" title="Soins dentaires">Soins dentaires</a></li>
<li><a href="chirurgie-des-oreilles-decollees-otoplastie.html" title="Bruxelles">Otoplastie</a></li>
<li><a href="genioplastie.html" title="Génioplastie">Génioplastie</a></li>
</ul>
</div>
<div id="footer-content">
<ul style="margin-left:0px; width: 154px; margin-top: 25px; padding-right:25px;">

<li><a href="chirurgie-mammaire-augmentation-mammaire.html" title="Augmentation Mammaire">Augmentation Mammaire</a></li>
<li><a href="lifting-des-seins.html" title="Lifting des seins">Lifting des seins</a></li>
<li><a href="gynecomastie.html" title="Gynécomastie">Gynécomastie</a></li>
<li><a href="lifting-des-bras-brachioplastie.html" title="Lifting des bras">Lifting des bras</a></li>
<li><a href="chirurgie-corps-lifting-des-cuisses.html" title="Lifting des cuissesl">Lifting des cuisses</a></li>
<li><a href="liposuccion-liposculpture.html" title="Liposuccion Liposculpture">Liposuccion Liposculpture</a></li>
<li><a href="chirurgie-intime-nymphoplastie-hymenoplastie-labioplastie.html" title="Chirurggie Intime">Chirurggie Intime</a></li>
<li><a href="abdominoplastie.html" title="Abdominopmastie">Abdominopmastie</a></li>
</ul></div>
<div id="footer-content">
<p style="margin-left: 16px;">Services</p>
<ul style="padding-left:6px; padding-right:20px;">
<li><a href="expertise-a-votre-service.html" title="Expertise à votre service">Expertise à votre service</a></li>
<li><a href="guide-par-etapes.html" title="Guide par étapes">Guide par étapes</a></li>
<li><a href="charte-qualite.html" title="Charte de qualité">Charte de qualité</a></li>
<li><a href="garanties.html" title="Garantie">Garantie</a></li>
<li><a href="financement.html" title="Financement">Financement</a></li>
<li><a href="vos-questions.html" title="Vos questions">Vos questions</a></li>
<li><a href="chirurgie-mammaire-reduction-mammaire-hypertrophie.html" title="Remboursements">Remboursements</a></li>
<li><a href="qui-sommes-nous.html" title="Qui sommes nous ?">Qui sommes nous ?</a></li>
<li><a href="pourquoi-nous-choisir.html" title="Pourquoi nous choisir ?">Pourquoi nous choisir ?</a></li>

</ul></div>
<div id="footer-content" >
<p>Tarifs</p>
<ul style="border:none;">
<li><a href="chirurgie-du-visage.html" title="Chirurgie visage">Chirurgie visage</a></li>
<li><a href="chirurgie-des-seins.html" title="Chirurgie des seins">Chirurgie des seins</a></li>
<li><a href="chirurgie-du-corps.html" title="Chirurgie du Corps">Chirurgie du Corps</a></li>
<li><a href="soins-dentaires.html" title="Soins dentaires">Soins dentaires</a></li>
<li><a href="greffe-des-cheveux.html" title="Greffe des cheveux">Greffe des cheveux</a></li>
<li><a href="chirurgie-du-visage.html" title="Bruxelles">Les forfaits</a></li>
<li><a href="destinations.html" title="Destinations">Votre séjour</a></li>
<li><br/></li>
<li><a href="mentions-legales.html" title="Mentions Légales"><strong>Mentions Légales</strong></a></li>
</ul></div>
</div>
<div id="footer-bottom">&nbsp;</div>
</div>
</div>
</div>
<!--footer end-->
</div>

</div>
</div>



</body>

</html>
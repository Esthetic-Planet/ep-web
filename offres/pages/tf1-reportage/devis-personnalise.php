<?php

$desactive = ini_get('disable_functions');
if (preg_match("/ini_set/i", "$desactive") == 0) {
// Si elle n'est pas Â  n'afficher que les erreurs...
ini_set("error_reporting" , "E_ALL & ~E_NOTICE");
}
if (isset($_POST['envoi'])) {
	if(empty($_POST['comment'])) {
	
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
	
	$_SESSION['champ3'] = $_POST['champ3'];
	//Controle du spam...
	if (eregi("http",$_POST['champ3'])) {
	$erreur_champ3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
	$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['champ3'])) {
	$erreur_champ3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
	$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['champ3'])) {
	$erreur_champ3 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
	$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['champ3'])) {
	$erreur_champ3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
	$flag_erreur = 1;
	}
	
	$_SESSION['zone_texte4'] = $_POST['zone_texte4'];
	//Controle du spam...
	if (eregi("http",$_POST['zone_texte4'])) {
	$erreur_texte3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
	$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['zone_texte4'])) {
	$erreur_texte3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
	$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['zone_texte4'])) {
	$erreur_texte3 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
	$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['zone_texte4'])) {
	$erreur_texte3 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
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
	
	$_SESSION['allergie'] = $_POST['allergie'];
	//Controle du spam...
	if (eregi("http",$_POST['allergie'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>http</b>";
		$flag_erreur = 1;
	}
	if (eregi("\[url",$_POST['allergie'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <B>[url</b>";
		$flag_erreur = 1;
	}
	if (eregi("<a",$_POST['allergie'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter des liens hypertexte.";
		$flag_erreur = 1;
	}
	if (eregi("\[link",$_POST['allergie'])) {
		$erreur_email1 = "Pour raisons de securite, ce champ ne peut comporter les caracteres <b>[link</b>";
		$flag_erreur = 1;
	}

	$_SESSION['liste5'] = $_POST['liste5'];

	// Definir l\'icone apparaissant en cas d\'erreur...


	// Definir sur 0 pour afficher un petit x de couleur rouge.
	// Definir sur 1 pour afficher l\'image d\'une croix rouge telle que celle utilisee dans l\'assistant
	// Si vous utilisez l\'option 1, l\'image de la croix rouge \'icone.gif\' doit se trouver dans le repertoire \'images\',
	// ce dernier devant se trouver au meme niveau que votre formulaire...
	$flag_icone = 0;

	// On verifie si $flag_icone est defini sur 0 ou 1...
	if ($flag_icone == 0) {
		$icone = "<b><font size=\"40px\" face=\"Arial, Verdana, Helvetica, sans-serif\" color=\"#CC0000\" style=\"float:left;padding-right:20px;\">x</font></b>";
	} else {
		$icone = "<img src=\"../../../images/icone.gif\"";
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
			$erreur_email1 = "Votre adresse e-mail n'est pas complete ou contient des caracteres invalides.";
			$flag_erreur = 1;
		} // Fin du if...
	} // Fin du else...
	// N'envoyer le formulaire que s'il n'y a pas d'erreurs...
	if ($flag_erreur == 0) {

		// Start - Insert the new Lead into SugarCRM (#2978)
		include_once("../../../dynm/soap_login.php");
		$soap_obj = new soap_login();
		$soap_connection = $soap_obj->login();

		if($soap_obj->error == "no" && !empty($soap_obj->session_id))
		{
			$last_name = $_POST['champ1'];
			$telephone = $_POST['champ2'];
			$age = $_POST["champ3"];
			$smoke = $_POST["champ9"];
			$email = $_POST['zone_email1'];
			$description = $_POST['zone_texte4'];
			$allergie = $_POST['allergie'];
			$leadorigine = "ReportageTf1";
			$assigned_user_id = $soapClient->get_user_id($soap_obj->session_id);
			$soapClient->set_entry(
				$soap_obj->session_id,
				'Leads',
				array(
					array('name' => 'last_name', 'value' => $last_name),
					array('name' => 'age_c','value' => $age),
					array('name' => 'description', 'value' => $description),
					array('name' => 'email1', 'value' => $email),
					array('name' => 'phone_work', 'value' => $telephone),
					array("name" => "smoking_c","value" => $smoke),
					array('name' => 'type_meeting_c', 'value' => $meeting_type),
					array('name' => 'assigned_user_id', 'value' => $assigned_user_id),
					array('name' => 'alergy_current_tret_c', 'value' => $allergie),
					array('name' => 'speciality_list', 'value' => hairtransplant),
					array("name" => 'lead_source', 'value' => $leadorigine),
					array("name" => "action_de_contact_c","value" => Formulaire_devis ),
					)
				);
		}
		// End - Insert the new Lead into SugarCRM (#2978)

	// Addresse de reception du formulaire
	$email_dest = "estheticplanet.paris@gmail.com";
	$sujet = "Requete page de contact";
	$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Return-Path: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Reply-To: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Content-Type: text/html; charset=utf-8 \n";
	$partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n";


	//Partie HTML de l'e-mail...
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"3\" color=\"#003366\">Landing-page : TF1 greffe cheveux en Turquie</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Nom Prenom = " . $_SESSION['champ1'] . "</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Âge = " . $_SESSION['champ3'] . "</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Telephone = " . $_SESSION['champ2'] . "</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Allergies ou traitements médicaux = " . $_SESSION['allergie'] . "</font><br>\n";
	$partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Email = " . $_SESSION['zone_email1'] . "</font><br>\n";
	$partie_zone_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Les objectifs souhaitées = " . $_SESSION['zone_texte4'] . "</font><br>\n";



	// Fin du message HTML
	$fin = "</body></html>\n\n";

	$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_zone_texte . $fin;


	// Send the e-mail
	if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
		echo("Envoi du formulaire impossible");
		exit();
	} else {
		// Rediriger vers la page de remerciement
		header("Location:../merci.html");
		exit();
		} // Fin else
	} // Fin du if ($flag_erreur == 0) {
	}else{header("Location:https://www.esthetic-planet.com/merci-robot.html");  }
}// Fin de if POST


?>




<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Page Title -->
    <title>Votre devis personnalisée reportage TF1</title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="description" content="Page de devis personnalisé. Réalisez vos soins à l'étranger avec Esthetic Planet la première agence de tourisme médical en France !">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="Esthetic-Planet">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Theme Styles -->
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../../css/animations.css" rel="stylesheet" type="text/css">
    
    <!-- Main Style -->
    <link href="../../css/style.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Style -->
    <link href="../../css/custom.css" rel="stylesheet" type="text/css">
    
    <!-- Updates Style -->
    <link href="../../css/updates.css" rel="stylesheet" type="text/css">
    
    <!-- Loader Style -->
    <link href="../../css/loader.css" rel="stylesheet" type="text/css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->  
    
</head>
<body>

<style>

	.btn{
		color: #fff;
    font-size: 24px;
    background: #dc3522;
    text-align: center;
    text-transform: uppercase;
    font-family: Lato,sans-serif;
    font-weight: 700;
    line-height: 48px;
    height: 60px;
	}
	
	.banner-form span
	{display:inline;
	}
	
	
	td {
		width:100%
	}
	
	input {
		    margin-bottom: 20px;
    background-color: #fff;
    border-top: 1px solid #edf0f1;
    height: 60px;
    padding: 15px 20px 0;
		width: 100%;
    line-height: 20px;
    font-size: 15px;
    color: #9f9f9f;
    font-weight: 400;
    z-index: 1;
    position: relative;
	}
	
	textarea {
		    margin-bottom: 20px;
    background-color: #fff;
    border-top: 1px solid #edf0f1;
    padding: 15px 20px 0;
		width:100%
	}
	
	@media (max-width: 767px) and (min-width: 0){
		h1, .h2-titre {
    		font-size: 20px !important;
    		line-height: 30px !important;
    		margin-top: -33px !important;
		}
		
		.logo-ep{
			margin: 0 auto;
    		margin: 0px auto !important;
		}
		#lien-logo{width: 100%;}
		.header-top-outer .call{float: inherit;margin: 0 auto;text-align: center;right:inherit;}
		.image-gallerie-tf1 img{
       		width: 120px;
    		height: 83px;
       }

	}
</style>	

<!-- LOADER -->
<div id="preloader">
    <div id="status"></div>
</div>		
<!-- END OF LOADER -->
<!-- HEADER -->
<header class="header1">
    <div class="header-wrapper">
        <div class="banner-outer">
            <img src="images/banner-min.jpg" alt="" class="banner-img">
            <div class="header-content">
                <div class="container">
                    <div class="header-top-outer clearfix">
                       	<div class="logo">
                        	<a href="https://www.esthetic-planet.com">
                            	<img src="../../images/logo-ep.png" alt="" class="img-responsive logo-ep">
                            </a>
                        </div>
                        <a href="tel:0142740718">
                        <div class="call">
                        	01 42 74 07 18
                        </div>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-xs-12">
                          <div class="banner-text">
                            <h1 id="heading1" style="visibility: visible !important;" class="animated fadeInDown">Devis personnalisé</h1>
                              <p style="visibility: visible !important;" class="animated fadeInDown">Souhaitez-vous nous contacter ? Remplissez le formulaire ci-dessous afin d’être contacté par notre Service Patientèle. Nous respectons la confidentialité de vos données personnelles qui ne seront communiquées qu'aux chirurgiens. Nous sommes également joignable au (+33) 01 42 74 07 18</p>
                            </div>
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</header> 
<!-- END OF HEADER -->        


<!-- DEVIS PERSO -->
<section id="procedure-section" style="padding: 70px 0 0px;background-image: url(https://www.esthetic-planet.com/images/couleur-yeux/vision-min.jpeg);
    background-repeat: no-repeat;
    background-size: cover;">
      <div class="container">
 <!-- HEADER FORM -->
<div class="banner-form" style="position: relative;
    bottom: 100px;
    visibility: inherit;
    height: auto;
    padding: 60px 20px 30px;
    border-radius: 10px;
    background: rgba(220, 237, 241, 0.9);
    margin-bottom: -70px;" id="rdv">
    
   
   
   
   <p style="border: 3px solid white;
    width:100%;text-align:center;
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    color: white;
    text-transform: uppercase;
    margin-top:5px;">Ma demande de devis</p>
                               <!-- DEBUT LEAD CATCHER -->
<script type="text/javascript" src="https://medcom.sugaropencloud.eu/cache/include/javascript/sugar_grp1.js?v=pwbHIS0LGQylZxf0QjwJJQ"></script>
<script type="text/javascript" src="https://medcom.sugaropencloud.eu/cache/include/javascript/calendar.js?v=3hJ2rwYfp2dZuKaVqEddTQ"></script>

<form id="WebToLeadForm" action="https://medcom.sugaropencloud.eu/index.php?entryPoint=WebToLeadCapture" method="POST" name="WebToLeadForm">


    <table style="font-size:12px;width: 100%;padding:20px;">
        <tbody>

        <tr>
            <td>
                <span><input id="last_name" type="text" name="last_name" placeholder="Entrez votre nom..." /></span>
            </td>
        </tr>
        
        <tr>
            <td>
                <span><input id="first_name" type="text" name="first_name" placeholder="Entrez votre prénom..." /></span>
            </td>
        </tr>

        <tr>
            <td>
                <span><input id="email1" type="text" name="email1" onChange="validateEmailAdd();" placeholder="Votre adresse e-mail ici..." /></span>
            </td>
        </tr>

        <tr>
            <td>
                <span><input id="phone_work" type="text" name="phone_work" placeholder="Votre numéro de téléphone..."  /></span>
            </td>
        </tr>
        
         <tr>
               <td>
               <span><input id="age_c" type="text" name="age_c" placeholder="Votre âge..." /></span>
               </td>

        </tr>
    
             <tr>
           <td style=" margin-bottom: 20px;
    background-color: #fff;
    border-top: 1px solid #edf0f1;
    height: 60px;
    padding: 15px 20px 0;"><span style="margin-right:20px;font-size:15px;">Tabac : </span>

<input name="smoking_c"  type="radio" value="oui" style="width:1%;height:10px;margin-right:10px;margin-left:20px;font-size:15px;">Oui
<input name="smoking_c" type="radio" value="non" style="width:1%;height:10px;margin-right:10px;margin-left:20px;font-size:15px;">Non
<input name="smoking_c"  type="radio" value="occasionnellement" style="width:1%;height:10px;margin-right:10px;margin-left:20px;">Occasionnellement
</select></span></td>
        </tr>
    
        <tr>
            <td>
                <span id="ta_replace">
                    <textarea id="description" type="text" name="description" style="margin-bottom:20px;margin-top:10px;" class="textarea-form" placeholder="Expliquez en quelques mots vos souhaits..." cols="50" rows="10" /></textarea>
                </span>
            </td>
        </tr>

        <tr align="center">
            <td colspan="10"><input class="btn" onClick="submit_form();" type="button" name="Submit" value="Envoyer" /></td>
        </tr>

        <!-- Début des Variables fixes à remplir CRM  dans value=""-->
            <tr>
                <td style="display:none;">
                    <select id="lead_source" name="lead_source" tabindex="1"> 
                        <option selected="selected" value="Estheticplanet"></option> 
                    </select>
                </td>
            </tr>

            <tr>
                <td style="display:none;">
                    <select id="action_de_contact_c" name="action_de_contact_c" tabindex="1"> 
                        <option selected="selected" value="Formulaire_Landing_Page"></option> 
                    </select>
                </td>
            </tr>

            <tr>
                <td style="display:none;">
                    <select id="how_find_us_c" name="how_find_us_c" tabindex="1"> 
                        <option selected="selected" value="website"></option> 
                    </select>
                </td>
            </tr>


            <tr>
                <td style="display: none;"><input id="campaign_id" type="hidden" name="campaign_id" value="d48dc390-3278-11e8-b3bf-064b5550e047" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="redirect_url" type="hidden" name="redirect_url" value="https://www.esthetic-planet.com/offres/pages/merci.html" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="assigned_user_id" type="hidden" name="assigned_user_id" value="1" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="team_id" type="hidden" name="team_id" value="1" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="team_set_id" type="hidden" name="team_set_id" value="Global" /></td>
            </tr>

            <tr>
                <td style="display: none;"><input id="req_id" type="hidden" name="req_id" value="last_name;" /></td>
            </tr>
         <!-- FIN Variable fixe à remplir CRM -->


        </tbody>
    </table>
</form>

<script type="text/javascript">// <![CDATA[
 function submit_form(){
    if(typeof(validateCaptchaAndSubmit)!='undefined'){
        validateCaptchaAndSubmit();
    }else{
        check_webtolead_fields();
    }
 }
 function check_webtolead_fields(){
     if(document.getElementById('bool_id') != null){
        var reqs=document.getElementById('bool_id').value;
        bools = reqs.substring(0,reqs.lastIndexOf(';'));
        var bool_fields = new Array();
        var bool_fields = bools.split(';');
        nbr_fields = bool_fields.length;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(bool_fields[i]).value == 'on'){
             document.getElementById(bool_fields[i]).value = 1;
          }
          else{
             document.getElementById(bool_fields[i]).value = 0;
          }
        }
      }
    if(document.getElementById('req_id') != null){
        var reqs=document.getElementById('req_id').value;
        reqs = reqs.substring(0,reqs.lastIndexOf(';'));
        var req_fields = new Array();
        var req_fields = reqs.split(';');
        nbr_fields = req_fields.length;
        var req = true;
        for(var i=0;i<nbr_fields;i++){
          if(document.getElementById(req_fields[i]).value.length <=0 || document.getElementById(req_fields[i]).value==0){
           req = false;
           break;
          }
        }
        if(req){
            document.WebToLeadForm.submit();
            return true;
        }
        else{
          alert('Merci de renseigner tous les champs requis');
          return false;
         }
        return false
   }
   else{
    document.WebToLeadForm.submit();
   }
}
function validateEmailAdd(){
    if(document.getElementById('email1') && document.getElementById('email1').value.length >0) {
        if(document.getElementById('email1').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
          alert('Adresse email invalide');
        }
    }
    if(document.getElementById('email2') && document.getElementById('email2').value.length >0) {
        if(document.getElementById('email2').value.match(/^\w+(['\.\-\+]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,})+$/) == null){
          alert('Adresse email invalide');
        }
    }
}
// ]]>
    
</script>
<!-- FIN LEAD CATCHER -->
                            </div>
                            <!-- END OF HEADER FORM-->
  	  </div>
</section>
<!--END OF DEVIS PERSO -->




<!-- PROCEDURE -->
<section id="team-section">
    <div class="container">
      <h2 class="text-center">Autres interventions...</h2>
      <div class="row text-center procedure">
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
                <span class="procedure-boxin1">
                <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html" target="_blank">
                	<img src="../../images/chirugie-esthetique-rhinoplastie.jpg" alt="" class="img-responsive img-circle" >
                </a>
                </span>
          <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html" target="_blank">
          <h3>Chirurgie esthétique</h3>
                <p>Rhinoplastie bosse et pointe à 1900€</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        	<a href="https://www.esthetic-planet.com/greffe-de-cheveux-implants-capillaires.html" target="_blank">
                <span class="procedure-boxin2">
                	<img src="../../images/coiffure-homme-min.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
            <h3>Greffe de cheveux</h3>
                <p>4000 greffes en FUE à 2450€</p></a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/vision.html" target="_blank">
                <span class="procedure-boxin3">
                	<img src="../../images/ilasik.jpg" alt="" class="img-responsive img-circle" >
                </span>
        <h3>Vision</h3>
                <p>Opération au iLasik™ 100% laser à 1300€</p>
                </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/pma-fecondation-in-vitro.html" target="_blank">
                <span class="procedure-boxin3">
                	<img src="../../images/pma-fiv-enfant.jpg" alt="" class="img-responsive img-circle" >
                </span>
        <h3>Fécondation in vitro</h3>
                <p>La FIV ICSI à 4000€</p>
              </a>
        </div>
      </div>
  </div>
</section>
<!-- END OF PROCEDURE -->
<div class="separator-section  separator-style1"></div>
<!-- opening HOUR -->
<section class="opening-hour-style2" id="opening-hour-section">
    <div class="container">
        <label>
            Nos bureaux à Paris
        </label>
        <h2 class="text-center">Lundi au Vendredi - 9h à 18h <br>
          <span style="font-size:20px;"><em>10 bis Place de Clichy, 75009 Paris</em></span></h2>
        <div class="row opening-hour-animation">
          
            <div class="col-sm-12 col-xs-12 calling-number text-center">	
                <p>Ou appelez-nous au <a href="tel:0142740718"> <span> 01 42 74 07 18 </span></a></p>
            </div>
        </div>
    </div>
</section>
<!-- END OF opening HOUR -->
<!-- END OF CONTENT -->
<!-- FOOTER -->
<div class="separator-section separator-style2"></div>
<footer class="footer-style2">
    <div class="container text-center">
        <div class="row">
            <div class="col-xs-12">
                <a href="https://www.esthetic-planet.com" class="footer-logo">
                    <img src="../../images/footerlogo.png" alt="" class="img-responsive">
                </a>
                <div class="socials">
                    <a href="https://www.facebook.com/esthetic.planet/" target="_blank"></a>
                    <a href="https://twitter.com/estheticplanet" target="_blank"></a>
                    <a href="https://www.youtube.com/user/EstheticPlanet" target="_blank"></a>
                    <a href="https://plus.google.com/100918231325414807980" target="_blank"></a>
                </div>
                <p>© Copyright 2016. All Rights Reserved by <a target="_blank" href="https://www.esthetic-planet.com"> Esthetic-Planet</a>.</p>
            </div>
        </div>
     </div> 
</footer>
<!-- END OF FOOTER -->

<!-- JQUERY LIBRARY -->
<script type="text/javascript" src="../../js/jquery-2.1.1.min.js"></script>
<!-- LESS.JS -->
<script type="text/javascript" src="../../less/less.js"></script>        
<!-- Modernizr.js -->
<script type="text/javascript" src="../../js/modernizr.js"></script>
<!-- Mootstrap.min.js -->
<script type="text/javascript" src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- Moving-gradient.js -->
<script type="text/javascript" src="../../js/moving-gradient.js"></script> 
<!-- Jquery.waypoints.js -->
<script type="text/javascript" src="../../js/jquery.waypoints.js"></script> 

<!-- Custom.js -->
<script type="text/javascript" src="../../js/custom.js"></script>		

</body>
</html>
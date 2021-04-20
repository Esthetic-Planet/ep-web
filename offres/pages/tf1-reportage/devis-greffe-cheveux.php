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

	//Traitement greffe de cheveux (graft_procedure_c )
	$liste5 =''; 
	if($_POST["liste5"]=='FUE_scarless')
		$liste5='FUE_scarless';
	elseif($_POST["liste5"]=='FUT')
		$liste5='FUT';
	elseif($_POST["liste5"]=='BHT')
		$liste5='BHT_Body_Hair';
	elseif($_POST["liste5"]=='Combo BHT FUE FUT')
		$liste5='Combo_FUE_FUT_BHT';
		
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
			$leadorigine = "CampagneGreffeCheveuxTurquieLandingPageEstheticPlanet";
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
					array("name" => 'graft_procedure_c','value' => $liste5),
					array("name" => "smoking_c","value" => $smoke),
					array('name' => 'type_meeting_c', 'value' => $meeting_type),
					array('name' => 'assigned_user_id', 'value' => $assigned_user_id),
					array('name' => 'alergy_current_tret_c', 'value' => $allergie),
					array('name' => 'speciality_list', 'value' => hairtransplant),
					array("name" => 'lead_source', 'value' => $leadorigine),
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
	$partie_listes .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Traitement greffe de cheveux = " . $_SESSION['liste5'] . "</font><br>\n";
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




<!doctype html>
<html>
<head>
	<!-- Page Title -->
    <title>Devis personnalisé pour votre Greffe de Cheveux</title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="devis personnalisé" />
    <meta name="description" content="page de devis">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="Esthetic-Planet">
    <meta name="robots" content="noindex,nofollow">

    
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
                            <h1 id="heading1">Devis personnalisé<br>
                              Greffe de cheveux</h1>
                              <p>Les devis en greffe de cheveux sont principalement basés sur un diagnostic par rapport à vos photos. Nous pouvons vous recevoir dans nos bureaux à Paris et vous proposer un rendez-vous pour réaliser ce diagnostic. Se rencontrer nous permettra de vous apporter des éléments complémentaires suite aux plans de traitements proposés, de mieux comprendre vos attentes et de calculer le nombre de greffons approprié avant l'opération.</p>
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
<section id="procedure-section" style="padding: 70px 0 0px;background:white;">
      <div class="container">
 <!-- HEADER FORM -->
                            <div class="banner-form" style="position:relative;bottom:100px;visibility:inherit;height:950px;padding:60px 20px 0px;border-radius:4px;background:#DCEDF1;margin-bottom:-70px;" id="rdv">
                                <form name="mail_form" id="theform" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" >
                                    
                                    <font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma" style="font-size:16px;text-align:center;;display:block;margin-top:-15px;margin-bottom:20px;" ><strong><?php
										if ($erreur_champ1) {
											echo(stripslashes($erreur_champ1));
										} 
										else {
											if ($erreur_email1) {
												echo(stripslashes($erreur_email1));
											} 
											else {
												if ($erreur_champ2) {
													echo(stripslashes($erreur_champ2));
												} 
												else {
													if ($erreur_champ3) {
	  													echo(stripslashes($erreur_champ3));
	  												} 
													else {
														if ($erreur_liste5) {
	  														echo(stripslashes($erreur_liste5));
	 													 } 
														 else {}	
													}
												}
											}
										}
										?>
										</strong></font>
                                    <?php if ($erreur_champ1) { echo($icone); } ?>
                                    <fieldset>
                                        <input name="champ1" type="text" value="<?php echo(stripslashes($_SESSION['champ1'])); ?>" placeholder="Entrez votre nom. . ." required>
                                    </fieldset>
                                    <?php if ($erreur_email1) { echo($icone); } ?>
                                    <fieldset>
                                        <input name="zone_email1" type="text" value="<?php echo(stripslashes($_SESSION['zone_email1'])); ?>" placeholder="Votre adresse e-mail ici  . . ." required>
                                    </fieldset>
                                    <?php if ($erreur_champs2) { echo($icone); } ?>
                                    <fieldset>
                                        <input name="champ2" type="text" value="<?php echo(stripslashes($_SESSION['champ2'])); ?>" placeholder="Votre numéro de téléphone . . ." required>
                                    </fieldset>
                                    <?php if ($erreur_champ3) { echo($icone); } ?>
                                    <fieldset>
                                        <input name="champ3" type="text" value="<?php echo(stripslashes($_SESSION['champ3'])); ?>" placeholder="Votre age . . ." required>
                                    </fieldset>	
                                    
                                    <?php if ($erreur_liste5) { echo($icone); } ?>
                                    <fieldset>
                                        <select name="liste5" style="width:100%;color:inherit;height:34px;right: 8px;">
                                            <option value="">Sélectionner le traitement désiré...</option>
                                            
                                            <option value="FUE_scarless"
                                            <?php
                                                if 		($_SESSION['liste5'] == "FUE_scarless") {
                                                echo(" selected");
                                                }
                                            ?>
                                            >FUE sans cicatrice</option>
                                            
                                            <option value="FUT"
                                            <?php
                                                if ($_SESSION['liste5'] == "FUT") {
                                                echo(" selected");
                                                }
                                            ?>
                                            >FUT</option>
                                            
                                            <option value="BHT"
                                            <?php
                                                if ($_SESSION['liste5'] == "BHT") {
                                                echo(" selected");
                                                }
                                            ?>
                                            >BHT</option>
                                            
                                            <option value="Combo BHT FUE FUT"
                                            <?php
                                                if ($_SESSION['liste5'] == "Combo BHT FUE FUT") {
                                                echo(" selected");
                                                }
                                            ?>
                                            >Combo BHT FUE FUT</option>
                                            
                                        </select>
                                   </fieldset>
                                     
                                    <span style="text-align:left;color:rgba(0, 0, 0, 0.51);letter-spacing:1.1px;margin-left:1px;">Tabac</span>	
                                    <fieldset style="text-align:left;font-size:15px;">
                                        <input name="champ9" type="radio" <?php echo $_SESSION['champ9'] == "oui" ? 'checked': ''; ?> value="oui" /> Oui
                                        <input style="margin-left:7px;" name="champ9" type="radio" <?php echo $_SESSION['champ9'] == "non" ? 'checked': ''; ?> value="non" /> Non                       
                                        <input style="margin-left:7px;" name="champ9" type="radio" <?php echo $_SESSION['champ9'] == "occasionnellement" ? 'checked': ''; ?> value="occasionnellement" /> Occasionnellement 
                                    </fieldset>	
                                    <fieldset>	
                                                <input name="allergie" type="text" value="<?php echo(stripslashes($_SESSION['allergie'])); ?>" placeholder="Allergies ou traitements médicaux (Optionnel). . ." required>
                                    </fieldset>	
                                    
                                        <textarea name="zone_texte4" style="background:white;width:100%;padding:17px;font-size: 15px;" rows=7 value="<?php echo(stripslashes($_SESSION['zone_texte4'])); ?>" placeholder="Votre message (type de soins, votre ville de départ, date souhaitée ) . . ." required></textarea>
                                 												
                                    <div class="hp">
    							   		<label>Si vous êtes un humain, laissez ce champ vide</label> 
    							   		<input type="text" name="comment">
								    </div>
                                       
                                    <input type="submit" name="envoi" value="ENVOYER" class="btn"> 
                                </form>
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
                <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html">
                	<img src="../../images/chirugie-esthetique-rhinoplastie.jpg" alt="" class="img-responsive img-circle" >
                </a>
                </span>
          <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html">
          <h3>Chirurgie esthétique</h3>
                <p>Rhinoplastie bosse et pointe à 1900€</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        	<a href="https://www.esthetic-planet.com/greffe-de-cheveux-implants-capillaires.html">
                <span class="procedure-boxin2">
                	<img src="../../images/coiffure-homme-min.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
            <h3>Greffe de cheveux</h3>
                <p>4000 greffes en FUE à 2450€</p></a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/vision.html">
                <span class="procedure-boxin3">
                	<img src="../../images/ilasik.jpg" alt="" class="img-responsive img-circle" >
                </span>
        <h3>Vision</h3>
                <p>Opération au iLasik™ 100% laser à 1300€</p>
                </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/pma-fecondation-in-vitro.html">
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
                    <a href="https://www.facebook.com/esthetic.planet/"></a>
                    <a href="https://twitter.com/estheticplanet"></a>
                    <a href="https://www.youtube.com/user/EstheticPlanet"></a>
                    <a href="https://plus.google.com/100918231325414807980"></a>
                </div>
                <p>© Copyright 2018. All Rights Reserved by <a target="_blank" href="https://www.esthetic-planet.com"> Esthetic-Planet</a>.</p>
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
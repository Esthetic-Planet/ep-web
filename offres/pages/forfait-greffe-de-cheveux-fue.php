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

		// Nbre de zones de selection de fichiers -1 car on commence le tableau a  zero...
	$nbre_zones_fichiers = 4 - 1;

	// Repertoire de telechargement du fichier...
	$repertoire = "/homez.428/estheticg/www/upload";

	// Taille maximale autorisee en octets...
	$taille_max_fichier = 2048000;

	// Extensions de fichiers autorisees...
	$extensions_autorisees = array("gif","jpg","jpeg","zip","png","raw","pdf","psd");

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
		include_once("../../dynm/soap_login.php");
		$soap_obj = new soap_login();
		$soap_connection = $soap_obj->login();

		if($soap_obj->error == "no" && !empty($soap_obj->session_id))
		{
			$last_name = $_POST['champ1'];
			$telephone = $_POST['champ2'];
			$email = $_POST['zone_email1'];
			$description = $_POST['zone_texte1'];
			$leadorigine = "promogreffebarbe";
			$assigned_user_id = $soapClient->get_user_id($soap_obj->session_id);
			$soapClient->set_entry(
				$soap_obj->session_id,
				'Leads',
				array(
					array('name' => 'last_name', 'value' => $last_name),
					array('name' => 'description', 'value' => $description),
					array('name' => 'email1', 'value' => $email),
					array('name' => 'phone_work', 'value' => $telephone),
					array('name' => 'type_meeting_c', 'value' => $meeting_type),
					array('name' => 'assigned_user_id', 'value' => $assigned_user_id),
					array("name" => 'lead_source', 'value' => $leadorigine),
					array('name' => 'speciality_list', 'value' => beardtransplant),
					array("name" => "action_de_contact_c","value" => Formulaire_devis ),

					)
				);
		}
		// End - Insert the new Lead into SugarCRM (#2978)

	//Addresse de reception du formulaire
	$email_dest = "estheticplanet.paris@gmail.com";
	$sujet = "Requete page promo greffe de barbe";
	$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Return-Path: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Reply-To: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
	$entetes .="Content-Type: text/html; charset=utf-8 \n";
	$partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n";


	//Partie HTML de l'e-mail...
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"3\" color=\"#003366\">Landing-page : TF1 Greffe de cheveux en Turquie</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Nom Prenom = " . $_SESSION['champ1'] . "</font><br>\n";
	$partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Telephone = " . $_SESSION['champ2'] . "</font><br>\n";
	$partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Email = " . $_SESSION['zone_email1'] . "</font><br>\n";


	// Fin du message HTML
	$fin = "</body></html>\n\n";

	$sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_zone_texte . $fin;


	// Send the e-mail
	if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
		echo("Envoi du formulaire impossible");
		exit();
	} else {
		// Rediriger vers la page de remerciement
		header("Location:https://www.esthetic-planet.com/offres/pages/merci.html");
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
    <title>Greffe de cheveux en Turquie : Promotion all-inclusive</title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="Landing page dentaire" />
    <meta name="description" content="Barbe irrégulière ou pas suffisamment développée, optez pour une transplantation de barbe à Istanbul pour 2300€, séjour inclus !">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="Esthetic-Planet">
    <meta name="robots" content="index">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Theme Styles -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/animations.css" rel="stylesheet" type="text/css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Main Style -->
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Style -->
    <link href="../css/custom.css" rel="stylesheet" type="text/css">
    
    <!-- Updates Style -->
    <link href="../css/updates.css" rel="stylesheet" type="text/css">
    
    <!-- JQUERY LIBRARY -->
	<script type="text/javascript" src="../js/jquery-2.1.1.min.js"></script>
    
    <!-- Loader Style -->
    <link href="../css/loader.css" rel="stylesheet" type="text/css">
    
    <link href="../../css/lightbox.css" rel="stylesheet" />
    
    <!-- Custom.js -->
	<script src="../../js/lightbox.min.js"></script>	
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->  
    
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-5658450-3', 'auto');
  ga('send', 'pageview');

</script>

       
</head>
<body>
<style>
	@media (max-width: 767px) and (min-width: 0){
		.promo-text{font-size: 20px !important;}
		#g-photos img{
       		width: 120px;
    		height: 83px;
       }
		.button-see-more{
			display:block !important;
			background: #0267b9;
			color: white;
			text-align: center;
			margin: 0px auto;
			position: relative;
			top: 20px;
			font-size: 14px;
		}
		.service-smartphone{text-align: left;font-size: 16px !important;font-weight: 300;margin-left: 10px;}
		.photo-no-mobile{display: none !important}
		.header-top-outer .logo {
    		width: 60% !important;
    		float: none !important;
    		margin: 0 auto !important;
		}
		.header-top-outer .logo a {
    		width: auto !important;
    		height: auto !important;
    		display: auto !important;
		}
		.logo-ep {
    		min-width:inherit !important;
		}
		#image-clinique-mobile{
			height: 100% !important;
    		width: 100% !important;
    		padding: inherit !important;
		}
		.chevron{display:none !important}
		.hidden-mobile{display:none;}
		.soins-garantis-mobile li{font-size:17px;}
		.garantis-mobile{margin-top:10px !important;}
		
		.bouton-plan-traitement{font-size:14px !important;}
		.opening-hour-style2{height:380px !important;}
		#image-trust{width: 100% !important;}
		.banner-outer{background-image: url(https://www.esthetic-planet.com/img/barbe-turquie/beard-smartphone-min.jpg) !important;
    background-position: 18% 36%;
    background-size: 100%;
    background-repeat: no-repeat;
    height: 265px !important;}
		#texte-offre-mobile{display:inherit !important;}
		.devis-smartphone{margin-top: 160px !important;float: right !important;}
		.header-top-outer .call {
			float: inherit;
			margin: 0 auto;
			position: relative;
			top: 10px;
			right: inherit;
			font-size: 22px;
    		width: 180px;
		}

	}
	
	body{font-weight: 300 !important;}
	.button-see-more{display:none;}
	#texte-offre-mobile{display:none;}
	.chevron::before {
	border-style: solid;
    border-width: 0.25em 0.25em 0 0;
    content: '';
    display: inline-block;
    height: 70px;
    left: 50%;
    position: relative;
    vertical-align: top;
    width: 70px;
    font-size: 7px;
    color: rgba(255, 255, 255, 0.7);
}

.chevron.right:before {
	left: 0;
	transform: rotate(45deg);
}

.chevron.bottom:before {
	top: 170px;
	transform: rotate(135deg);
}

.chevron.left:before {
	left: 0.25em;
	transform: rotate(-135deg);
}
.call{
    text-shadow: rgba(0, 0, 0, 0.09) 1px 1px, rgba(0, 0, 0, 0) -1px 1px, rgba(0, 0, 0, 0.02) -1px -1px, rgba(0, 0, 0, 0) 1px -1px;
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
        <div class="banner-outer" style="height: 750px;">
            <img src="../../img/barbe-turquie/beard-min.jpg" alt="greffe de barbe turquie" class="banner-img">
            <div class="header-content">
                <div class="container">
                    <div class="header-top-outer clearfix">
                       	<div class="logo">
                        	<a href="https://www.esthetic-planet.com">
                            	<img src="../images/logo-ep.png" alt="logo esthetic planet" class="img-responsive logo-ep">
                            </a>
                        </div>
                        <a href="tel:0142740718">
                        <div class="call">
                        	01 42 74 07 18
                        </div>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                           
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <!-- HEADER FORM -->
                         <div class="banner-text">
                                <h1 id="heading1">Greffe de cheveux<br>
                              en Turquie à <span style="">2450€</span></h1>
                                <p>Barbe irrégulière ou pas suffisamment développée, optez pour une transplantation de barbe en Turquie avec des équipes médicales expérimentées en greffe capillaire sans cicatrice !
                                </p>
                                <p>Offre valable pour toute réservation effectuée avant le 31/12/2017</p>
                                
                                 <div id="texte-offre-mobile">
                       		 <p style="font-size:18px;margin-top: 100px;">
                       		 	<span style="letter-spacing: 1px;
    margin-left: 164px;
    color: white;
    font-size: 40px;
    font-family: 'Satisfy', cursive;
    background: rgba(62, 120, 142, 0.7);
    border-radius: 70px;
    padding-top: 18px;
    padding-left: 2px;
    padding-right: 5px;
    padding-bottom: 5px;
    right: 12px;">2450€</span> <br><span style="position: relative;
    top: 34px;
    color: white;
    width: 168px;
    background: rgba(0, 0, 0, 0.1);
    float: right;"> Votre greffe de cheveux en Turquie</span>
                      		 </p>
                       </div>
                              <a href="#barbe" class="btn btn-round cta2 devis-smartphone" style="font-size: 15px;
    height: 42px;
    line-height: 29px;
    margin-top: 20px;
    border-radius: 1px;">Devis personnalisé en 48H<br></a>
                            </div>
                            <!-- END OF HEADER FORM-->
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
    </div>
</header> 
<!-- END OF HEADER -->        
<!-- CONTENT -->
<!-- PROCEDURE -->
<section id="procedure-section">
    <div class="container">
        <h2 class="text-center" style="font-size: 42px;padding-bottom:10px;">Forfait de 2450€ pour 4000 Greffes de cheveux</h2>
        <h3 class="text-center" style="font-size: 25px;padding-bottom:60px;color:#0267b9;">Équivalent de 8000 cheveux</h3>

        <div class="row text-center">
    
  <div class="row text-center">

        <div class="col-md-5 col-sm-5 col-xs-12 autre-procedure-box">
                <span class="procedure-boxin2" style="width:200px;height:200px;" >
                	<img src="tf1-reportage/images/bht.jpg" alt="image bht" class="img-responsive img-circle" >
                </span>
               
          <h3>4500 Greffes FUE</h3>
          
                <div style="margin-top:10px;">
                    <b style="font-family:impact,trebuchet ms,arial,sans-serif;color:white;font-size:30px;background: #E23B13;border-right: 2px white solid;letter-spacing: 2px;padding: 3px 10px;">2450€</b>
                    <del style="color:#E23B13;font-size:23px;padding:2px;font-weight:bold">2900€</del><br>
                    <div style="color:red;font-style: italic;font-size: 15px;font-weight: 400;margin-top: 5px;">Offre disponible jusqu'au 31/12/2017</div>
                    
                </div>
                
        		<p style="margin-bottom: 10px;margin-top: 30px;color: #0267b9;border: 1px rgba(2, 103, 185, 0.7) solid;padding-top: 5px;padding-bottom: 5px;width: auto;font-weight: 300;">SERVICES OFFERTS</p>

                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-bed" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; 2 nuits d'hôtel 4* + Petit-déjeuner
                    </p>
  
      
                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-user-md" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Suivi postopératoire en France pendant 12 mois
                    </p>
       
                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-taxi" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Transferts sur place
                    </p>
       

                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-stethoscope" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Consultations préopératoire et postopératoire
                  </p>
   
                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-globe" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Traductrice francophone
                    </p>

                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-check" style="opacity:0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Bilan sanguin
                    </p>

                    <p class="service-smartphone" style="text-align:left;font-size:17px;font-weight:400;">
                        <i class="fa fa-medkit" style="opacity: 0.7;width: 20px;"></i>
                        &nbsp;&nbsp; Médicaments et fournitures post-opératoires
                    </p>
    </div>
    
     	<div class="col-md-6 col-sm-6 col-xs-12 text-left" style="margin-left:10px;"> 
 

    <div class="banner-form animated fadeInUp" style="height:550px;visibility: visible !important;" >
                                <h2 style="font-size:35px;">Diagnostic en ligne</h2>
                                <form name="mail_form" id="theform" method="post" action="<?php echo($_SERVER['PHP_SELF']); ?>" >
                                    
                                    <font color="#CC0000" size="2" face="Verdana, Arial, Helvetica, sans-serif, Tahoma" style="line-height:15px;display:block;margin-top:-6px;" ><strong><?php
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
												else {}
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
                                      <fieldset style="height: 90px;">
                                        <textarea style="resize:none;color:#9f9f9f;font-size:15px;width:100%;height:100%;font-weight: 400;" placeholder="Expliquez en quelques mots vos souhaits" name="zone_texte1" cols="45" rows="5" required><?=stripslashes($_SESSION['zone_texte1']);?></textarea>
                                    </fieldset>	
                            
                   
                                    											
                                    <div class="hp">
    							   		<label>Si vous êtes un humain, laissez ce champ vide</label> 
    							   		<input type="text" name="comment">
								    </div>
                                       
                                    <input type="submit" name="envoi" value="ENVOYER" class="btn"> 
                                </form>
                            </div>
    
 </div>

 </div>

        
       
        
       

    </div>
</section>
<!-- END OF PROCEDURE -->

<!-- WATCH VIDEO -->
<section id="watch-video-section" class="watch-video-style2">
    <div class="container">
      <h2 class="text-center">Découvrez la clinique !</h2>
      <div class="row">
            <div class="col-sm-5 col-xs-12 watch-video-animations">
                <div class="watch-video-text">
                  <p style="text-align: justify;">Créée en 2000, la clinique offre des interventions d'implantation capillaire dans des conditions optimales en profitant des améliorations scientifiques internationales avec des méthodes de traitement appropriées, des médecins experts et des équipements technologiques modernes à des prix avantageux. Les opérations sont supervisées par le Dr Ergin Er.</p>
                 </div>
                 <div class="soial-container">
                 <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fwww.facebook.com%2Festhetic.planet%2F&layout=button_count&size=small&mobile_iframe=true&appId=415007058689910&width=95&height=20" width="95" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                 	<a href="https://twitter.com/estheticplanet" class="twitter-follow-button" data-show-count="false" data-lang="fr">Suivre @estheticplanet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                 	
                 </div>
            </div>
            <div class="col-sm-7 col-md-6 col-xs-12 pull-right">
                <div>
                	<a href="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/clinique-ergin3.jpg" data-lightbox="photos"><img src="https://www.esthetic-planet.com/img/barbe-turquie/clinique-ergin3-thumb.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                	<a href="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/clinique-ergin7.JPG" data-lightbox="photos"><img src="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/photo-ergin-thumb/clinique-ergin7-thumb.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                	<a href="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/4.jpg" data-lightbox="photos"><img src="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/4.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                	<a href="https://www.esthetic-planet.com/images/photo-clinique-chirurgie-esthetique-turquie/anatomica2.jpg" data-lightbox="photos"><img src="https://www.esthetic-planet.com/images/photo-clinique-chirurgie-esthetique-turquie/anatomica2.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                	<a href="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/7.jpg" data-lightbox="photos"><img src="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/7.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                	<a href="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/6.jpg" data-lightbox="photos"><img src="https://www.esthetic-planet.com/images/clinique-greffe-cheveux-turquie/clinique-dr-ergin/Aesthetic%20center/6.jpg" width="149" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                </div>
                
                
                <a target="_blank" href="https://www.esthetic-planet.com/clinique-greffe-cheveux-hacer-yuce.html">
                	<div class="boutton-blanc text-center" style="width:100%;">
                Plus d'informations sur la clinique
                	</div>
                </a>
                
     
    		<div class="row" style="margin-top:20px;">

			</div>
   	
    	
           </div> 
        </div>
        
       
        	


        
    </div> 
    
    
     <div class="gradient-outer" id="gradient">
        <div class="gradient-outer" id="output"></div>
    </div>
</section>
<!-- END OF WATCH VIDEO -->	





<!-- TEAM -->
<section id="team-section">
    <div class="container">
      <h2 class="text-center">Notre équipe en Turquie</h2>
      <div class="row team-row1-animations">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../../img/barbe-turquie/clinique-ergin.jpg" alt="dr Ergin" class="img-responsive" style="display:initial;">
                            <div class="team-img-overlay"></div>
                    </div>
                    
                    <div class="team-text">
                        <h4>Dr. Ergin Er</h4>
                        <span>Pratique la greffe de barbe depuis 1993<br>
                            <span style ="font-size:13px;color:#9F9F9F;">                     
                                International Society of Hair Restoration Surgery (ISHRS)<br>
                                Europeen Society of Hair Restoration Surgery (ESHRS)<br>
                                American Academy of Cosmetic Surgery (AACS)<br>
                            </span>
                        </span>
                    </div>
                    

                    
                </div>
            </div>
            
          
            
            <div class="col-md-8 col-sm-8 col-xs-12">
            
            <p style="padding-bottom:20px;">L’intervention en greffe de barbe est réalisée par des équipes médicales exclusivement spécialisées en greffe capillaire sans cicatrice. Avec plus de 12 ans d'expérience et une hyper spécialisation de la technique FUE, nous garantissons une équipe titulaire et fixe, ce qui permet de maintenir un niveau de qualité égale pour toutes les interventions.</p>
            
            
            	<h3> Résultats avant-après</h3>
            	
            	                          <div class="row text-center" style="margin-top:10px;margin-bottom:20px;">
        	<div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;margin-right:70px;">
            	<a href="https://www.esthetic-planet.com/galerie-photo-greffe-barbe-2000-bht.html" target="_blank">2000 Greffes en BHT</a><br>
                <a href="https://www.esthetic-planet.com/galerie-photo-greffe-barbe-2000-bht.html" target="_blank">
                	<img alt="Greffe de cheveux" src="../../img/barbe-turquie/result1.jpg"><br>
                </a>
            </div>
            
        	<div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;">
           	  <a href="https://www.esthetic-planet.com/greffe-de-barbe-avant-apres.html" target="_blank">3000 Greffes en BHT</a><br>
                <a href="https://www.esthetic-planet.com/greffe-de-barbe-avant-apres.html" target="_blank">
                	<img alt="Greffe de cheveux" src="../../img/barbe-turquie/result2.jpg"><br>
              </a>
            </div>

       
      </div>
            </div>
   
            
        </div>
	</div>
</section>
<!-- END OF TEAM -->
<!-- TESTIMONIAL -->
<section class="testimoial-style2" id="testimoial-section">
    <div class="container">
		<h2 class="text-center">Témoignages de nos patients sur <img src="../../img/barbe-turquie/trustpilot-logo.png" style="width:322px;position:relative;bottom:5px;left:7px;"></img></h2>
        <div class="row">
            <div class="col-xs-12 patient-text-animation text-center">

           			  
            			  <div style="background:#007f4e;display:inline-block;line-height: 1em;padding: 3px;border-radius: 3px;margin: 0 3px 0 0;"><img src="https://images-static.trustpilot.com/community/shared/sprite_star.png" style="width: 20px;height: auto;"></div>
                         
                          <div style="background:#007f4e;display:inline-block;line-height: 1em;padding: 3px;border-radius: 3px;margin: 0 3px 0 0;"><img src="https://images-static.trustpilot.com/community/shared/sprite_star.png" style="width: 20px;height: auto;"></div>

                          <div style="background:#007f4e;display:inline-block;line-height: 1em;padding: 3px;border-radius: 3px;margin: 0 3px 0 0;"><img src="https://images-static.trustpilot.com/community/shared/sprite_star.png" style="width: 20px;height: auto;"></div>

                          <div style="background:#007f4e;display:inline-block;line-height: 1em;padding: 3px;border-radius: 3px;margin: 0 3px 0 0;"><img src="https://images-static.trustpilot.com/community/shared/sprite_star.png" style="width: 20px;height: auto;"></div>

                          <div style="background:#007f4e;display:inline-block;line-height: 1em;padding: 3px;border-radius: 3px;margin: 0 3px 0 0;"><img src="https://images-static.trustpilot.com/community/shared/sprite_star.png" style="width: 20px;height: auto;"></div>

              <h3 style="margin-top:10px;">Je suis allé en Turquie</h3><p style="margin-top:40px;">Je suis allé en Turquie, début Aout 2017 pour une greffe capillaire, j'ai été enchanté, et incroyablement supris par le sérieux et la qualité du travail sur place.
Esthétic Planet à répond totalement à toutes mes attentes, le patient est pris en charges dans toute sles étapes et fait l'objet d'un suivi très sérieux. L'équipe sur place est incroyablement efficace et l'hygiène y est rigoureuse. La gentillesse et le professionnalisme des personnes y est complet! Si je devais recommencer, se serait immédiatement... <a href="https://fr.trustpilot.com/reviews/59886f25f4f2690bbc9777fd" target="blank">Lire la suite</a><br>
             
             <div class="patient-text"><span>- Pat.</span></div><br>
             
             <a href="https://fr.trustpilot.com/review/esthetic-planet.com" target="_blank" style="text-align:left;">Voir tous les avis Truspilot à propos d'Esthetic-Planet</a>
              
            </div>
        </div>
        
       <div class="row">
		
       </divW
        


    ></div>
</section>
<!-- END OF TESTIMONIAL -->	
<!-- PROCEDURE -->
<section id="team-section">
    <div class="container">
      <h2 class="text-center">Autres interventions...</h2>
      <div class="row text-center procedure">
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
                <span class="procedure-boxin1">
                <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html">
                	<img src="../images/chirugie-esthetique-rhinoplastie.jpg" alt="" class="img-responsive img-circle" >
                </a>
                </span>
          <a href="https://www.esthetic-planet.com/chirurgie-esthetique.html">
          <h3>Chirurgie esthétique</h3>
                <p>Rhinoplastie bosse et pointe à 1900€</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        	<a href="https://www.esthetic-planet.com/clinique-dentaire-istanbul.html">
                <span class="procedure-boxin2">
                	<img src="../images/soins-couronne.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
            <h3>Soins dentaires</h3>
                <p>La couronne à 130€</p></a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/vision.html">
                <span class="procedure-boxin3">
                	<img src="../images/ilasik.jpg" alt="" class="img-responsive img-circle" >
                </span>
        <h3>Vision</h3>
                <p>Opération au iLasik™ 100% laser à 1300€</p>
                </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="https://www.esthetic-planet.com/pma-fecondation-in-vitro.html">
                <span class="procedure-boxin3">
                	<img src="../images/pma-fiv-enfant.jpg" alt="" class="img-responsive img-circle" >
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
            Nos bureaux à Paris :
        </label>
        <h2 class="text-center">Lundi au Vendredi - 9h à 18h<br>
        <span style="font-size:20px;"><em>10 bis Place de Clichy, 75009 Paris</em></span>
        </h2>
        <div class="row opening-hour-animation">
            <div class="col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-sm-8 col-xs-12 pull-right">
                        <a href="tf1-reportage/devis-greffe-cheveux.php" class="btn btn-round cta2">Rdv à Paris !</a>	
                    </div>
                </div>
            </div>
            <div class="col-sm-5 col-xs-12 calling-number">	
                <p>Ou appelez-nous <a href="tel:0142740718"><span> 01 42 74 07 18</span></a></p>
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
                    <img src="../images/footerlogo.png" alt="" class="img-responsive">
                </a>
                <div class="socials">
                    <a target="_blank" href="https://www.facebook.com/esthetic.planet/"></a>
                    <a target="_blank" href="https://twitter.com/estheticplanet"></a>
                    <a target="_blank" href="https://www.youtube.com/user/EstheticPlanet"></a>
                    <a target="_blank" href="https://plus.google.com/100918231325414807980"></a>
                </div>
                <p>© Copyright 2017. All Rights Reserved by <a target="_blank" href="https://www.esthetic-planet.com"> Esthetic-Planet</a>.</p>
            </div>
        </div>
     </div> 
</footer>
<!-- END OF FOOTER -->


<!-- LESS.JS -->
<script type="text/javascript" src="../less/less.js"></script>        
<!-- Modernizr.js -->
<script type="text/javascript" src="../js/modernizr.js"></script>
<!-- Mootstrap.min.js -->
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
<!-- Moving-gradient.js -->
<script type="text/javascript" src="../js/moving-gradient.js"></script> 
<!-- Jquery.waypoints.js -->
<script type="text/javascript" src="../js/jquery.waypoints.js"></script> 

<!-- Custom.js -->
<script type="text/javascript" src="../js/custom.js"></script>
	

</body>
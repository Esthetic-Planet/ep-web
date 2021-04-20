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
		include_once("../../../dynm/soap_login.php");
		$soap_obj = new soap_login();
		$soap_connection = $soap_obj->login();

		if($soap_obj->error == "no" && !empty($soap_obj->session_id))
		{
			$last_name = $_POST['champ1'];
			$telephone = $_POST['champ2'];
			$email = $_POST['zone_email1'];
			$description = "Demande de rendez-vous à partir de https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$leadorigine = "CampagneGreffeCheveuxTurquieLandingPageEstheticPlanet";
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
					array('name' => 'speciality_list', 'value' => hairtransplant),

					)
				);
		}
		// End - Insert the new Lead into SugarCRM (#2978)

	//Addresse de reception du formulaire
	$email_dest = "info@esthetic-planet.com";
	$sujet = "Requete page de contact";
	$entetes ="MIME-Version: 1.0 \n";
	$entetes .="From: Esthetic Planet<info@esthetic-planet.com>\n";
	$entetes .="Return-Path: Esthetic Planet<info@esthetic-planet.com>\n";
	$entetes .="Reply-To: Esthetic Planet<info@esthetic-planet.com>\n";
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
    <title>Reportage TF1 sur la Greffe de Cheveux en Turquie</title>
    
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="keywords" content="Landing page dentaire" />
    <meta name="description" content="Découvrez nos offres de soins dentaires à Izmir en Turquie et économisez jusqu'à 70%">
    <meta name="format-detection" content="telephone=no">
    <meta name="author" content="Esthetic-Planet">
    <meta name="robots" content="noindex,nofollow">

    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Theme Styles -->
    <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../../css/animations.css" rel="stylesheet" type="text/css">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Main Style -->
    <link href="../../css/style.css" rel="stylesheet" type="text/css">
    
    <!-- Custom Style -->
    <link href="../../css/custom.css" rel="stylesheet" type="text/css">
    
    <!-- Updates Style -->
    <link href="../../css/updates.css" rel="stylesheet" type="text/css">
    
    <!-- JQUERY LIBRARY -->
	<script type="text/javascript" src="../../js/jquery-2.1.1.min.js"></script>
    
    <!-- Loader Style -->
    <link href="../../css/loader.css" rel="stylesheet" type="text/css">
    
    <link href="../../../css/lightbox.css" rel="stylesheet" />
    
    <!-- Custom.js -->
	<script src="../../../js/lightbox.min.js"></script>	
    
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
<!-- LOADER -->
<div id="preloader">
    <div id="status"></div>
</div>		
<!-- END OF LOADER -->
<!-- HEADER -->
<header class="header1">
    <div class="header-wrapper">
        <div class="banner-outer">
            <img src="images/banner.jpg" alt="" class="banner-img">
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
                        <div class="col-sm-7 col-xs-12">
                            <div class="banner-text">
                                <h1 id="heading1">Nouvelles Offres <br>
                              Esthetic-Planet !</h1>
                                <p>Soins dentaires, iLasik ou Greffe de cheveux
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <!-- HEADER FORM -->
                            <div class="banner-form" id="rdv">
                                <h2>Rdv à Paris</h2>
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
                                    <div class="hp">
    							   		<label>Si vous êtes un humain, laissez ce champ vide</label> 
    							   		<input type="text" name="comment">
								    </div>
                                       
                                    <input type="submit" name="envoi" value="ENVOYER" class="btn"> 
                                </form>
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
        <h2 class="text-center">Découvrez nos nouvelles offres</h2>
        <div class="row text-center procedure">
            <div class="col-md-4 col-sm-4 col-xs-12 procedure-box">
            	<img src="images/ilasik01.jpg" alt="" class="img-responsive img-circle" >            	
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12 procedure-box ">
               Le tourisme médical a offert beaucoup plus qu’un nouveau sourire à Arthur. En souriant de nouveau, il a brisé sa carapace. <br><br> <i>« Des gens qui ne m’adressaient pas la parole, se sont soudainement, mis à me saluer ou me dire bonjour… je me suis rendu compte que c’était parce que je leur souriais !»</i>.<br><br>
Sans la Turquie, ses paysages majestueux et ses prix attractifs, Arthur n’aurait jamais pu s’offrir ce nouveau départ dans la vie. Un bonheur de 20 facettes dentaires qui lui aurait coûté 14 000 € en France. Devant le montant, il choisit la Turquie, et les plages de Izmir pour 4300€ en Turquie (tout inclus).
            </div>
        </div>
        
        <div class="row text-right" style="margin-top:10px;">
        	<div class="col-md-12 col-sm-12 col-xs-12">
                <a href="../tf1-reportage/images/tournage-tf1-08.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-08-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-01.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-01-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-07.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-07-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-04.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-04-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
            </div>
		</div>
        
        <div class="row text-right" style="margin-top:10px;margin-bottom:10px;">
        	<div class="col-md-12 col-sm-12 col-xs-12">
                <a href="../tf1-reportage/images/tournage-tf1-02.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-02-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-05.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-05-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-06.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-06-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>
                <a href="../tf1-reportage/images/tournage-tf1-03.jpg" data-lightbox="photos"><img src="../tf1-reportage/images/tournage-tf1-03-thumb.jpg" width="150" height="100" onmouseover="change(this,true);" onmouseout="change(this,false);" /></a>

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
                  <p style="text-align: justify;">Créée en 2000, la clinique offre des interventions d'implantation capillaire dans des conditions optimales en profitant des améliorations scientifiques internationales avec des méthodes de traitement appropriées, des médecins experts et des équipements technologiques modernes à des prix abordables.
La clinique propose des interventions capillaires en FUE sans cicatrice avec un prix extrêmement avantageux (3500-4000 greffes pour 2450 €). Ce prix comprend l'hôtel et les transferts durant votre séjour. Les opérations sont supervisées par le Dr Ergin Er.</p>
                     <a href="../tf1-reportage/devis-greffe-cheveux.php" class="btn btn-round cta2">Devis personnalisé !<br></a>
                 </div>
                 <div class="soial-container">
                 <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fwww.facebook.com%2Festhetic.planet%2F&layout=button_count&size=small&mobile_iframe=true&appId=415007058689910&width=95&height=20" width="95" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                 	<a href="https://twitter.com/estheticplanet" class="twitter-follow-button" data-show-count="false" data-lang="fr">Suivre @estheticplanet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                 	
                 </div>
            </div>
            <div class="col-sm-7 col-md-6 col-xs-12 pull-right">
                <div class="video-container">
                	<img src="../tf1-reportage/images/clinique-greffe-cheveux-turquie.jpg" alt="" >
                </div>
                <a target="_blank" href="https://www.esthetic-planet.com/clinique-greffe-cheveux-hacer-yuce.html">
                <div class="boutton-blanc">
                Plus d'informations sur la clinique
                </div>
                </a>
            </div> 
        </div>
    </div> 
     <div class="gradient-outer" id="gradient">
        <div class="gradient-outer" id="output"></div>
    </div>
</section>
<!-- END OF WATCH VIDEO -->	

<section class="testimoial-style2" id="testimoial-section">
    <div class="container">
    <h2 class="text-center">Tarifs</h2>
    
    
  <div class="row text-center">
        <div class="col-md-4 col-sm-4 col-xs-12 autre-procedure-box" style="height: 320px;">
                <span class="procedure-boxin1">
                	<img src="../tf1-reportage/images/fue.jpg" alt="" class="img-responsive img-circle" >
                </span>
          <h3>4000 Greffes FUE</h3>
          <div style="margin-top:10px;"><strong style="font-family:impact,trebuchet ms,arial,sans-serif;color:white;font-size:25px;background: #E23B13;border-right: 2px white solid;letter-spacing: 1px;padding: 3px 10px;">2450€</strong> <del style="color:#E23B13;font-size:15px;padding:2px;font-weight:bold">2900€</del></div>
                
    </div>
        <div class="col-md-4 col-sm-4 col-xs-12 autre-procedure-box" style="height: 320px;">
                <span class="procedure-boxin2">
                	<img src="../tf1-reportage/images/bht.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
          <h3>3000 Greffes BHT</h3>
          
                    		<div style="margin-top:10px;">
                    <b style="font-family:impact,trebuchet ms,arial,sans-serif;color:white;font-size:25px;background: #E23B13;border-right: 2px white solid;letter-spacing: 1px;padding: 3px 10px;">2500€</b>
                    <del style="color:#E23B13;font-size:15px;padding:2px;font-weight:bold">1.200€</del>
                </div>
    </div>
       
        <div class="col-md-4 col-sm-4 col-xs-12 autre-procedure-box" style="height: 320px;">
                <span class="procedure-boxin3">
                	<img src="../tf1-reportage/images/kit-prp.jpg" alt="" class="img-responsive img-circle" >
                </span>
        <h3>Kit PRP</h3>          
                    		<div style="margin-top:10px;margin-bottom:10px;">
                    <b style="font-family:impact,trebuchet ms,arial,sans-serif;color:white;font-size:25px;background: #E23B13;border-right: 2px white solid;letter-spacing: 1px;padding: 3px 10px;">150€</b><del style="color:#E23B13;font-size:15px;padding:2px;font-weight:bold">10.800€</del>
                </div>
    </div>
</div>


 <div class="row text-left" style="margin-bottom:10px;margin-top:10px;">
 	 	<div class="col-md-12 col-sm-12 col-xs-12"> 
        		SERVICES OFFERTS
		</div>
</div>

 <div class="row text-left">
 		<div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-bed fa-2x" style="opacity: 0.7;"></i>
                        &nbsp;&nbsp; 2 nuits d'hôtel 4*
                    </p>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-coffee fa-2x" style="opacity:0.7;"></i>
                        &nbsp;&nbsp; Petit-déjeuner
                    </p>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-taxi fa-2x" style="opacity: 0.7;"></i>
                        &nbsp;&nbsp; Transferts sur place
                    </p>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-stethoscope fa-2x"></i>
                        &nbsp;&nbsp; Bilan préopératoire
                    </p>
        </div>
 </div>
 
 
 
  <div class="row text-left">
 		<div class="col-md-2 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-globe fa-2x" style="opacity: 0.7;"></i>
                        &nbsp;&nbsp; Traduction
                    </p>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-check fa-2x" style="opacity:0.7;"></i>
                        &nbsp;&nbsp; Bilan sanguin
                    </p>
        </div>
        <div class="col-md-4 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-medkit fa-2x" style="opacity: 0.7;"></i>
                        &nbsp;&nbsp; Médicaments et fournitures post-opératoires
                    </p>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12"> 
                    <p>
                        <i class="fa fa-user-md fa-2x"></i>
                        &nbsp;&nbsp; Suivi pendant 1 an
                    </p>
        </div>
 </div>
 
    
    
<!-- Le JS... -->
<script type="text/javascript">
function toggle_div(bouton, id) { // On déclare la fonction toggle_div qui prend en param le bouton et un id
  var div = document.getElementById(id); // On récupère le div ciblé grâce à l'id
  if(div.style.display=="none") { // Si le div est masqué...
    div.style.display = "block"; // ... on l'affiche...
    bouton.innerHTML = "Cacher le tableau de prix"; // ... et on change le contenu du bouton.
  } else { // S'il est visible...
    div.style.display = "none"; // ... on le masque...
    bouton.innerHTML = "Plus de prix ..."; // ... et on change le contenu du bouton.
  }
}
</script>
    
         <div class="row text-left" style="margin-top:30px;margin-bottom:5px;">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" onclick="toggle_div(this,'id_du_div');">Plus de prix ...</button>
                    
                    <!-- Un div caché avec un attribut id -->
					<div id="id_du_div" style="display:none;">

						
                    
                    <h3 style="margin-top:10px;margin-bottom:10px;">Comparatif des prix en Turquie et en France</h3>
                    
                
                
                <div class="row text-center">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <table id="tarifclinique" style="width:100%">
                            <tbody>
                                <tr>
                                    <th>NOMBRE DE GREFFONS</th>
                                    <th>Prix en Turquie <img src="../dentaires-promo-turquie/images/turquie-flag-thumb.jpg" style="width: 19px;position: relative;top: 0px;left: 3px;"></th>
                                    <th>Prix en France <img src="../dentaires-promo-turquie/images/france-flag-thumb.jpg" style="width: 19px;position: relative;top: 0px;left: 3px;"></th>
                                    <th class="hidden-mobile">Économie réalisée</th>
                                    <th>Économie en %</th>
                                </tr>
                                
                                <tr><th colspan="5" class="titreintervention">GREFFE DE CHEVEUX EN FUE</th></tr>
                                
                                <tr>
                                    <td class="nomintervention">Jusqu'à 1000</td>
                                    <td class="interventionprixturquie">1990€</td>
                                    <td class="interventionprixfrance">5600.00€</td>
                                    <td class="hidden-mobile">470.00€</td>
                                    <td class="interventionprix">78%</td>
                                </tr>
                                
                                <tr>
                                    <td class="nomintervention">De 1000 à 4000</td>
                                    <td class="interventionprixturquie">2450€</td>
                                    <td class="interventionprixfrance">11900.00€</td>
                                    <td class="hidden-mobile">705.00€</td>
                                    <td class="interventionprix">78%</td>
                                </tr>
                              
                                  
                                   <tr><th colspan="5" class="titreintervention">GREFFE DE BARBE EN BHT</th></tr>
                                  
                                  <tr>
                                      <td class="nomintervention">Jusqu'à 1000</td>
                                      <td class="interventionprixturquie">2300€</td>
                                      <td class="interventionprixfrance">8950.00€</td>
                                      <td class="hidden-mobile">525.00€</td>
                                      <td class="interventionprix">46%</td>
                                  </tr>
                                
                                  <tr>
                                      <td class="nomintervention">De 1000 à 3000</td>
                                      <td class="interventionprixturquie">2500 €</td>
                                      <td class="interventionprixfrance">10000.00€</td>
                                      <td class="hidden-mobile">525.00€</td>
                                      <td class="interventionprix">44%</td>
                                  </tr>
                                 
                                 <tr><th colspan="5" class="titreintervention">PRP</th></tr>
                                 
                                  <tr>
                                      <td class="nomintervention">PRP simple</td>
                                      <td class="interventionprixturquie">Inclus</td>
                                      <td class="interventionprixfrance">10800.00€</td>
                                      <td class="hidden-mobile">6575.00€</td>
                                      <td class="interventionprix">61%</td>
                                  </tr>
                                  
                                   <tr>
                                      <td class="nomintervention">Kit PRP</td>
                                      <td class="interventionprixturquie">150€</td>
                                      <td class="interventionprixfrance">12600.00€</td>
                                      <td class="hidden-mobile">6720.00€</td>
                                      <td class="interventionprix">53%</td>
                                  </tr>
                            </tbody>
                    </table>
            </div>
            </div>
            
            
            
          
            </div>
            
            



 
</div>
</section>
<!-- TEAM -->


<!-- TEAM -->
<section id="team-section">
    <div class="container">
      <h2 class="text-center">Notre équipe en Turquie</h2>
      <div class="row team-row1-animations">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../tf1-reportage/images/dr-ergin-er.jpg" alt="" class="img-responsive">
                            <div class="team-img-overlay"></div>
                    </div>
                    
                    <div class="team-text">
                        <h4>Dr. Ergin Er</h4>
                        <span>Pratique la greffe de cheveux depuis 1993<br>
                            <span style ="font-size:13px;color:#9F9F9F;">                     
                                International Society of Hair Restoration Surgery (ISHRS)<br>
                                Europeen Society of Hair Restoration Surgery (ESHRS)<br>
                                American Academy of Cosmetic Surgery (AACS)<br>
                            </span>
                        </span>
                    </div>
                    
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../tf1-reportage/images/hacer-yuce.jpg" alt="" class="img-responsive">
                            <div class="team-img-overlay"></div>								
                    </div>
                    <div class="team-text">
                      <h4>Hacer Yüce</h4>
                      <span>Pratique la greffe de cheveux depuis 2004</span></div>
                </div>
            </div>
            
        </div>
	</div>
</section>
<!-- END OF TEAM -->
<!-- TESTIMONIAL -->
<section class="testimoial-style2" id="testimoial-section">
    <div class="container">
        <h2 class="text-center">Ce qu'en disent nos patients</h2>
        <div class="row">
            <div class="col-xs-12">
                <div class="patient-img"> 
                    <span>
                        <img src="../tf1-reportage/images/temoignage.jpg" alt="" class="img-responsive img-circle"> 
                    </span>	
                </div>
            </div>
            <div class="col-xs-12 patient-text-animation text-center">
              <p>Je recommande vivement cette clinique. Tout est conforme. L'équipe est au top, du chauffeur à l'interprète et l'équipe médicale. Même la clinique est au top du top. Merci pour cette 2ème fois pour ma part.</p>
              <div class="patient-text"><span>Enzo P.</span>Vendeur (95200)</div>
            </div>
        </div>
        
      <div class="row text-center" style="margin-top:20px;margin-bottom:20px;">
        	<div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;">
            	<a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-2500-fue-istanbul.html">2500 Greffes en FUE</a><br>
                <a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-2500-fue-istanbul.html">
                	<img alt="Greffe de cheveux" src="../tf1-reportage/images/resultat-1-thumb.jpg"><br>
                </a>
            </div>
            
        	<div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;">
           	  <a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-fue-3000-greffes-ergin-Istanbul-5-mois.html">3000 Greffes en FUE</a><br>
                <a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-fue-3000-greffes-ergin-Istanbul-5-mois.html">
                	<img alt="Greffe de cheveux" src="../tf1-reportage/images/resultat-patient-2-thumb.jpg"><br>
              </a>
            </div>
            
            <div class="col-md-4 col-sm-4 col-xs-12" style="margin-bottom:10px;">
            	<a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-fue-2100-greffes-ergin-Istanbul.html">2100 Greffes en FUE</a><br>
                <a href="https://www.esthetic-planet.com/galerie-photo-greffe-cheveux-fue-2100-greffes-ergin-Istanbul.html">
                	<img alt="Greffe de cheveux" src="../tf1-reportage/images/resultat-patient-3-thumb.jpg"><br>
              </a>
        </div>   
       
      </div>

    </div>
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
                	<img src="../../images/chirugie-esthetique-rhinoplastie.jpg" alt="" class="img-responsive img-circle" >
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
                	<img src="../../images/soins-couronne.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
            <h3>Soins dentaires</h3>
                <p>La couronne à 130€</p></a>
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
            Nos bureaux à Paris :
        </label>
        <h2 class="text-center">Lundi au Vendredi - 9h à 18h<br>
        <span style="font-size:20px;"><em>10 bis Place de Clichy, 75009 Paris</em></span>
        </h2>
        <div class="row opening-hour-animation">
            <div class="col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-sm-8 col-xs-12 pull-right">
                        <a href="../tf1-reportage/devis-greffe-cheveux.php" class="btn btn-round cta2">Rdv à Paris !</a>	
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
                    <img src="../../images/footerlogo.png" alt="" class="img-responsive">
                </a>
                <div class="socials">
                    <a target="_blank" href="https://www.facebook.com/esthetic.planet/"></a>
                    <a target="_blank" href="https://twitter.com/estheticplanet"></a>
                    <a target="_blank" href="https://www.youtube.com/user/EstheticPlanet"></a>
                    <a target="_blank" href="https://plus.google.com/100918231325414807980"></a>
                </div>
                <p>© Copyright 2016. All Rights Reserved by <a target="_blank" href="https://www.esthetic-planet.com"> Esthetic-Planet</a>.</p>
            </div>
        </div>
     </div> 
</footer>
<!-- END OF FOOTER -->


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
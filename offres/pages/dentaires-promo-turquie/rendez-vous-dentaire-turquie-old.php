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
			$description = "Demande de rendez-vous à partir de http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$leadorigine = "EstheticplanetLandingpage";
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
					)
				);
		}
		// End - Insert the new Lead into SugarCRM (#2978)

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
	}else{header("Location:http://www.esthetic-planet.com/merci-robot.html");  }
}// Fin de if POST


?>


<!doctype html>
<html>
<head>
	<!-- Page Title -->
    <title>Réalisez vos soins dentaires en Turquie</title>
    
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
                        	<a href="http//www.esthetic-planet.com/">
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
                                <h1 id="heading1">Vos soins dentaires<br>
                                en Turquie</h1>
                                <p>Réalisez vos soins dentaires en Turquie avec Esthetic-Planet et économisez jusqu’à 70% 
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-5 col-xs-12">
                            <!-- HEADER FORM -->
                            <div class="banner-form" id="rdv">
                                <span>Patients 100% satisfaits</span>
                                <h2>Rendez-vous</h2><span style="color:red;margin-bottom:10px;position:relative;margin-top:-20px;font-size:15px">+ panoramique dentaire</span>
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
        <h2 class="text-center">Nouveau sourire !<br><span style="font-size:18px;font-size: 30px;line-height:0px;">Avec 20 facettes dentaires à Izmir, Turquie</span></h2>
        <div class="row text-center procedure">
            <div class="col-md-4 col-sm-4 col-xs-12 procedure-box">
            	<img src="images/avant-apres.jpg" alt="" class="img-responsive img-circle" >
           	  <h3>Arthur H.</h3>
           	  <p>50 ans, Cadre supérieur</p>
            </div>
            <div class="col-md-8 col-sm-8 col-xs-12 procedure-box ">
               Le tourisme médical a offert beaucoup plus qu’un nouveau sourire à Arthur. En souriant de nouveau, il a brisé sa carapace. <br><br> <i>« Des gens qui ne m’adressaient pas la parole, se sont soudainement, mis à me saluer ou me dire bonjour… je me suis rendu compte que c’était parce que je leur souriais !»</i>.<br><br>
Sans la Turquie, ses paysages majestueux et ses prix attractifs, Arthur n’aurait jamais pu s’offrir ce nouveau départ dans la vie. Un bonheur de 20 facettes dentaires qui lui aurait coûté 14 000 € en France. Devant le montant, il choisit la Turquie, et les plages de Izmir pour 4300€ en Turquie (tout inclus).
            </div>
        </div>
        
        <div class="row text-left" style="margin-top:30px;margin-bottom:5px;">
        	<div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Comparatif des prix en Turquie et en France</h3>
            </div>
		</div>
        
        <div class="row text-center">
        	<div class="col-md-12 col-sm-12 col-xs-12">
       			<table id="tarifclinique" style="width:100%">
					<tbody>
                    	<tr>
                            <th>Soins dentaires</th>
                            <th>Prix en Turquie <img src="images/turquie-flag-thumb.jpg" style="width: 19px;position: relative;top: 0px;left: 3px;"></th>
                            <th>Prix en France <img src="images/france-flag-thumb.jpg" style="width: 19px;position: relative;top: 0px;left: 3px;"></th>
                            <th class="hidden-mobile">Économie réalisée</th>
                            <th>Économie en %</th>
                        </tr>
                        
                        <tr><th colspan="5" class="titreintervention">Soins esthétiques</th></tr>
                        
                        <tr>
                            <td class="nomintervention">Couronne céramo-métallique</td>
                            <td class="interventionprixturquie">130.00€</td>
                            <td class="interventionprixfrance">600.00€</td>
                            <td class="hidden-mobile">470.00€</td>
                            <td class="interventionprix">78%</td>
                        </tr>
                        
                        <tr>
                            <td class="nomintervention">Couronne zircone</td>
                            <td class="interventionprixturquie">195.00€</td>
                            <td class="interventionprixfrance">900.00€</td>
                            <td class="hidden-mobile">705.00€</td>
                            <td class="interventionprix">78%</td>
                        </tr>
                        
                           <tr>
                               <td class="nomintervention">Facette céramique</td>
                               <td class="interventionprixturquie">200.00€</td>
                               <td class="interventionprixfrance">700.00€</td>
                               <td class="hidden-mobile">600.00€</td>
                               <td class="interventionprix">86%</td>
                          </tr>
                        
                         <tr>
                              <td class="nomintervention">Blanchiment professionnel (Nite White, Esthetics, Zoom2)</td>
                              <td class="interventionprixturquie">150.00€</td>
                              <td class="interventionprixfrance">800.00€</td>
                              <td class="hidden-mobile">650.00€</td>
                              <td class="interventionprix">81%</td>
                          </tr>
                          
                           <tr><th colspan="5" class="titreintervention">Implantologie</th></tr>
                          
                          <tr>
                              <td class="nomintervention">Implant + pilier AB</td>
                              <td class="interventionprixturquie">625.00€</td>
                              <td class="interventionprixfrance">1150.00€</td>
                              <td class="hidden-mobile">525.00€</td>
                              <td class="interventionprix">46%</td>
                          </tr>
                        
                          <tr>
                              <td class="nomintervention">Implant + pilier LEGACY </td>
                              <td class="interventionprixturquie">675.00€</td>
                              <td class="interventionprixfrance">1200.00€</td>
                              <td class="hidden-mobile">525.00€</td>
                              <td class="interventionprix">44%</td>
                          </tr>
                        
                          <tr>
                              <td class="nomintervention">Implant + pilier STRAUMANN</td>
                              <td class="interventionprixturquie">965.00€</td>
                              <td class="interventionprixfrance">1400.00€</td>
                              <td class="hidden-mobile">435.00€</td>
                              <td class="interventionprix">31%</td>
                          </tr>
                        
                          <tr>
                              <td class="nomintervention">Implant + pilier NOBEL</td>
                              <td class="interventionprixturquie">965.00€</td>
                              <td class="interventionprixfrance">1800.00€</td>
                              <td class="hidden-mobile">835.00€</td>
                              <td class="interventionprix">46%</td>
                          </tr>
                         
                         <tr><th colspan="5" class="titreintervention">Réhabilitation totale / mâchoire (Istanbul)</th></tr>
                         
                          <tr>
                              <td class="nomintervention">All-in-4<br><span style="font-size:11px;">4 implants Bego + 12 couronnes + appareil provisoire</span></td>
                              <td class="interventionprixturquie">4225.00€</td>
                              <td class="interventionprixfrance">10800.00€</td>
                              <td class="hidden-mobile">6575.00€</td>
                              <td class="interventionprix">61%</td>
                          </tr>
                          
                           <tr>
                              <td class="nomintervention">All-in-6<br><span style="font-size:11px;">6 implants Bego + 12 couronnes + appareil provisoire</span></td>
                              <td class="interventionprixturquie">5880.00€</td>
                              <td class="interventionprixfrance">12600.00€</td>
                              <td class="hidden-mobile">6720.00€</td>
                              <td class="interventionprix">53%</td>
                          </tr>
					</tbody>
			</table>
	</div>
    </div>



 <div class="row text-left" style="margin-top:60px;">
 	<div class="col-md-2 col-sm-2 col-xs-12">
    	<img src="images/securite.jpg" style="height:100px;" alt="securité">
	</div>
     	<div class="col-md-10 col-sm-10 col-xs-12">
<h3>Les soins dentaires en Turquie sont garantis !</h3>
          <ul>
                <li>Couronne, bridge, facette : <span style="color: rgb(96, 112, 134);font-weight:600;">3 ans ✓ </span></li>
                <li>Implant AB/LEGACY : <span style="color: rgb(96, 112, 134);font-weight:600;">10 ans ✓ </span></li>
                <li>Implant NOBEL/STRAUMANN : <span style="color: rgb(96, 112, 134);font-weight:600;">à vie ✓ </span></li>
			</ul>
    </div>
 </div>

    </div>
</section>
<!-- END OF PROCEDURE -->

<!-- WATCH VIDEO -->
<section id="watch-video-section" class="watch-video-style2">
    <div class="container">
      <h2 class="text-center">VISITEZ LA CLINIQUE !</h2>
      <div class="row">
            <div class="col-sm-5 col-xs-12 watch-video-animations">
                <div class="watch-video-text">
                  <p style="text-align: justify;">Fondée en 1982, la clinique dispose d’une équipe médicale expérimentée. Les experts se spécialisent dans tous les domaines de soins dentaires modernes : implantologie, soins esthétiques (couronnes, facettes…), réhabilitation de dentition,  Invisalign (appareil orthodontique invisible)…  </p>
                     <a href="#rdv" class="btn btn-round cta2">Prenez rendez-vous!<br><span style="font-size: 11px;position: relative;bottom: 33px;">+ Panoramique dentaire</span></a>
                 </div>
                 <div class="soial-container">
                 <iframe src="https://www.facebook.com/plugins/share_button.php?href=https%3A%2F%2Fwww.facebook.com%2Festhetic.planet%2F&layout=button_count&size=small&mobile_iframe=true&appId=415007058689910&width=95&height=20" width="95" height="20" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
                 	<a href="https://twitter.com/estheticplanet" class="twitter-follow-button" data-show-count="false" data-lang="fr">Suivre @estheticplanet</a> <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                 	
                 </div>
            </div>
            <div class="col-sm-7 col-md-6 col-xs-12 pull-right">
                <div class="video-container">
                	<iframe width="466" height="300" src="https://www.youtube.com/embed/qhipWQEH_WE?controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
                <a target="_blank" href="http://www.esthetic-planet.com/clinique-dentaire-istanbul.html">
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
<!-- TEAM -->
<section id="team-section">
    <div class="container">
      <h2 class="text-center">Nos DENTISTES EN TURQUIE</h2>
      <div class="row team-row1-animations">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../../images/team-dr-mehmet.jpg" alt="" class="img-responsive">
                            <div class="team-img-overlay"></div>
                    </div>
                    <div class="team-text">
                      <h4>Dr. Mehmet Sonmez<br>
                      </h4>
                    <span>Dentiste depuis 1978<br>
						  <span style ="font-size:13px;color:#9F9F9F;">Implantologie – Prothésiste<br>
						  Réhabilitation implantaire et prothétique<br></span>
					</span></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../../images/team-dr-gulay-vural.jpg" alt="" class="img-responsive">
                            <div class="team-img-overlay"></div>								
                    </div>
                    <div class="team-text">
                      <h4>Dr. Gulay </h4>
                      <h4> Vural</h4>
                      <span>Orthodontiste depuis 1973</span></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="team-box">
                    <div class="team-img">
                            <img src="../../images/team-levent-kardesler.jpg" alt="" class="img-responsive">
                            <div class="team-img-overlay"></div>
                    </div>
                    <div class="team-text">
                      <h4>Dr. Levent Kardesler</h4>
                      <span>Chirurgien dentiste depuis 2002<br>
							<span style ="font-size:13px;color:#9F9F9F;">Traitements parodontaux – Implantologie<br>
							Greffe osseuse – Soins esthétiques<br></span>
					</span></div>
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
                        <img src="../../images/patientimg.jpg" alt="" class="img-responsive img-circle"> 
                    </span>	
                </div>
            </div>
            <div class="col-xs-12 patient-text-animation text-center">
              <p>Excellente prise en charge par toute l'équipe depuis l’établissement de plan de traitement jusqu’au suivi à mon retour en France. J'ai fait poser les implants et les couronnes en zircone dans cette clinique. Le résultat est magnifique ! </p>
              <div class="patient-text"><span>Isabelle M.</span>Professeur(94170)</div>
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
                <a href="http://www.esthetic-planet.com/chirurgie-esthetique.html">
                	<img src="images/rhinoplastie-min.jpg" alt="" class="img-responsive img-circle" >
                </a>
                </span>
          <a href="http://www.esthetic-planet.com/chirurgie-esthetique.html">
          <h3>Chirurgie esthétique</h3>
                <p>Rhinoplastie bosse et pointe à 1900€</p>
          </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        	<a href="http://www.esthetic-planet.com/greffe-de-cheveux-implants-capillaires.html">
                <span class="procedure-boxin2">
                	<img src="images/coiffure-homme-min.jpg" alt="" class="img-responsive img-circle" >
                </span>
               
                <h3>Greffe de cheveux</h3>
                <p>4000 greffes en FUE à 2450€</p></a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="http://www.esthetic-planet.com/vision.html">
                <span class="procedure-boxin3">
                	<img src="images/ilasik-femme-min.jpg" alt="" class="img-responsive img-circle" >
                </span>
                <h3>Vision</h3>
                <p>Opération au iLasik™ 100% laser à 1300€</p>
                </a>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 autre-procedure-box">
        <a href="http://www.esthetic-planet.com/pma-fecondation-in-vitro.html">
                <span class="procedure-boxin3">
                	<img src="images/babyparent-min.jpg" alt="" class="img-responsive img-circle" >
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
            Heures d'ouverture :
        </label>
        <h2 class="text-center">Lundi au Vendredi - 9h à 18h<br>
        <span style="font-size:20px;"><em>10 bis Place de Clichy, 75009 Paris</em></span>
        </h2>
        <div class="row opening-hour-animation">
            <div class="col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-sm-8 col-xs-12 pull-right">
                        <a href="#rdv" class="btn btn-round cta2">Prenez rendez-vous!<br><span style="font-size: 11px;position: relative;bottom: 33px;">+ Panoramique dentaire</span></a>	
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
                <a href="http://esthetic-planet.com" class="footer-logo">
                    <img src="../../images/footerlogo.png" alt="" class="img-responsive">
                </a>
                <div class="socials">
                    <a href="https://www.facebook.com/esthetic.planet/"></a>
                    <a href="https://twitter.com/estheticplanet"></a>
                    <a href="https://www.youtube.com/user/EstheticPlanet"></a>
                    <a href="https://plus.google.com/100918231325414807980"></a>
                </div>
                <p>© Copyright 2016. All Rights Reserved by <a target="_blank" href="http://esthetic-planet.com"> Esthetic-Planet</a>.</p>
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
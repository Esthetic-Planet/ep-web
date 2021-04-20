<?php
// On ve...
$desactive = ini_get('disable_functions');
if (preg_match("/ini_set/i", "$desactive") == 0) {
// Si elle n'est pas n'afficher que les erreurs...
ini_set("error_reporting" , "E_ALL & ~E_NOTICE");
}

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
	}

	$_SESSION['case1'][1] = "";
	if (isset($_POST['case1'][1])) {
	$_SESSION['case1'][1] = $_POST['case1'][1];
	} 

	$_SESSION['case1'][2] = "";
	if (isset($_POST['case1'][2])) {
		$_SESSION['case1'][2] = $_POST['case1'][2];
	} 

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
    
    $_SESSION['liste8'] = $_POST['liste8'];
    
    // Nbre de zones de selection de fichiers -1 car on commence le tableau a  zero...
	$nbre_zones_fichiers = 2 - 1;

	// Repertoire de telechargement du fichier...
	$repertoire = "/homez.428/estheticg/www/mobile/upload";

	// Taille maximale autorisee en octets...
	$taille_max_fichier = 4048000;

	// Extensions de fichiers autorisees...
	$extensions_autorisees = array("gif","jpg","jpeg","zip","png","","pdf","");

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
		  echo "Erreur";
	}

    // Rajouter par alex :
    
    //Envoi avec fichier...
if (($_FILES['fichier']['name']['0'] !="") && is_array($_FILES)) {
	if (!is_dir($repertoire)) {
		$erreur_fichier[0] = "Le repertoire de telechargement specifie n'existe pas!";
		$flag_erreur = 1;
        echo"Le repertoire de telechargement specifie n'existe pas!";
	} else {
		// Verifier si le repertoire a les droits en ecriture...
		if (!is_writeable($repertoire)) {
			$erreur_fichier[0] = "Le repertoire specifie n'a pas les droits d'acces en ecriture.";
			$flag_erreur = 1;
            echo "Le repertoire specifie n'a pas les droits d'acces en ecriture.";
		} else {
			// On boucle x nbre de fois, sauf si aucun fichier n'a eteselectionne...
			for ($u = 0; $u <= $nbre_zones_fichiers, $_FILES['fichier']['name'][$u] != ""; $u++) {

				// Verifier les eventuelles erreurs de telechargement du fichier...
				if ($_FILES['fichier']['error'][$u] != 0) {

					switch ($_FILES['fichier']['error'][$u]) {
   						//case UPLOAD_ERR_OK:
						case 0;
       							break;
   						//case UPLOAD_ERR_INI_SIZE:
						case 1;
       							$erreur_fichier[$u] = "Le fichier telecharge depasse la taille maximale autorisee par le serveur.";
							$flag_erreur = 1;
                            echo "Le fichier telecharge depasse la taille maximale autorisee par le serveur.";
		       					break;
   						//case UPLOAD_ERR_FORM_SIZE:
						case 2;
      							$erreur_fichier[$u] = "Le fichier telecharge depasse la taille maximale autorisee par le formulaire.";
							$flag_erreur = 1;
                            echo "Le fichier telecharge depasse la taille maximale autorisee par le formulaire.";
							break;
   						//case UPLOAD_ERR_PARTIAL:
						case 3;
      	 						$erreur_fichier[$u] = "Le fichier n'a ete telecharge que partiellement.";
							$flag_erreur = 1;
                            echo "Le fichier n'a ete telecharge que partiellement.";
		       					break;
   						//case UPLOAD_ERR_NO_FILE:
						case 4;
      							$erreur_fichier[$u] = "Aucun fichier n'a etetelecharge.";
							$flag_erreur = 1;
                        echo "Aucun fichier n'a etetelecharge.";
	       						break;
   						// case UPLOAD_ERR_NO_TMP_DIR:
						case 6:
       							$erreur_fichier[$u] = "Repertoire temporaire manquant.";
							$flag_erreur = 1;
                            echo "Repertoire temporaire manquant.";
       							break;
  						// case UPLOAD_ERR_CANT_WRITE:
						case 7:
		       					$erreur_fichier[$u] = "Echec d'ecriture du fichier";
							$flag_erreur = 1;
                            echo "Echec d'ecriture du fichier";
      							break;
   						default:
    	   						$erreur_fichier[$u] = "Erreur de fichier inconnue";
							$flag_erreur = 1;
                            echo "Erreur de fichier inconnue";
					} // fin du switch

				} else {

        	    			// On verifie si la taille du fichier ne depasse pas le maximum autorise
	        	    		if ($_FILES['fichier']['size'][$u] > $taille_max_fichier) {
            					$erreur_fichier[$u] = "Le fichier telechargedepasse la taille maximum autorisee.";
						$flag_erreur = 1;
                                echo "Le fichier telechargedepasse la taille maximum autorisee.";
        		    		} else {

			                	// On met le nom du fichier en minuscules...
			                	$nom_fichier = strToLower($_FILES['fichier']['name'][$u]);

			            		// On recherche la position du point dans le nom de fichier...
						$dernPos = strRChr($nom_fichier, ".");

			            		// On extrait l'extension du fichier...
            					$extension = strToLower(subStr($dernPos, 1));

			            		// Si l'extension n'existe pas ou qu'elle ne fait pas partie des extensions autorisees...
            					if (($dernPos == "") OR (in_array($extension, $extensions_autorisees) == false)) {
				            		$erreur_fichier[$u] = "L'extension de fichier specifiee n'est pas autorisee.";
							$flag_erreur = 1;
                                    echo "L'extension de fichier specifiee n'est pas autorisee.";
			            		} else {

                   					//On extrait seulement le nom du fichier sans l'extension, $dernPos donnant l'extension avec le point.
				                   	$posExtension = strpos($nom_fichier, $dernPos);
				                   	$nom_sans_extension = substr($nom_fichier,0,$posExtension);

				                   	// On ajoute au nom du fichier un numero unique puis l'extension du fichier...
				                   	$nom_unique[$u] = $nom_sans_extension. "_ID_" . uniqid(rand()).$dernPos;

						} // Fin du else
                  			} // Fin du else
		              	} // Fin du else
            		} // Fin de la boucle for... ()

			// On boucle une seconde fois, et on ne copie les fichiers que si aucun d'eux n'a retourned'erreurs...
			$u = 0;
			while ((($u<= $nbre_zones_fichiers) && ($_FILES['fichier']['name'][$u] != "") && ($flag_erreur !=1))) {

				// On deplace le fichier telechargedu repertoire temporaire sur le repertoire specifie
                		if (!move_uploaded_file($_FILES['fichier']['tmp_name'][$u], $repertoire."/".$nom_unique[$u])) {
			                $erreur_move_uploaded[$u] = "Impossible de deplacer le fichier dans le repertoire de destination...";
					$flag_erreur = 1;
                            echo "Impossible de deplacer le fichier dans le repertoire de destination...";
		                } // Fin du if
				$u++;
			} // Fin de la boucle while
		} // Fin du else
	} // Fin du else
} // Fin du if (($_FILES['fichier']['name']['0'] !="") && is_array($_FILES)) {

    $liste8='';
	if($_POST["liste8"]=='Greffe Cheveux')
		$liste8='hairtransplant';
	elseif($_POST["liste8"]=='Chirurgie Esthetique')
		$liste8='cosmeticsurgery';
	elseif($_POST["liste8"]=='Dentaire')
		$liste8='dentalcare';
	elseif($_POST["liste8"]=='Vision')
		$liste8='vision';
	elseif($_POST["liste8"]=='Anneau gastrique')
		$liste8='Anneau_gastrique';
	elseif($_POST["liste8"]=='PMA')
		$liste8='PMA';
    
//Validation PHP des elements du formulaire...
	if ($_POST['champ1'] == "") {
		$erreur_champ1 = "Merci d\'inscrire votre nom";
		$flag_erreur = 1;
	} 


    if ($_POST['zone_email1'] == "") 
        {
		  $erreur_email1 = "Merci d\'inscrire votre email";
		  $flag_erreur = 1;
	   } 
    else 
        {
		  if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['zone_email1']))
            {
			 $erreur_email1 = "Votre adresse e-mail 1 n'est pas complete ou contient des caracteres invalides.";
			$flag_erreur = 1;
		  } 
	   } 
	
	if ($flag_erreur == 0) 
        {
            // Start - Insert the new Lead into SugarCRM (#2978)
		      include_once("../../../mobile/dynm/soap_login.php");
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
                                                                array("name" => "speciality_c","value" => $liste8),
                                                                array('name' => 'assigned_user_id', 'value' => $assigned_user_id),
                                                                array("name" => "lead_source","value" => Estheticplanet ),
							 									array("name" => "action_de_contact_c","value" => Formulaire_mobile ),
                                                            
                                                            )
				                                );
		      }
		// Fin - Insert the new Lead into SugarCRM (#2978)

	
        // Addresse de reception du formulaire
	        $email_dest = "estheticplanet.paris@gmail.com";
            $sujet = "Requete depuis la version mobile";
            
        if (($_FILES['fichier']['name']['0'] !="") && is_array($_FILES)) {
            // En-tetes specifiques de l'e-mail AVEC piece jointe:
            // Generation d'une chne de delimitation
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
            $entetes ="MIME-Version: 1.0 \n";
		$entetes .="From: Esthetic-Planet<estheticplanet.paris@gmail.com>\n";
		$entetes .="Content-Type: multipart/mixed;\n";
		$entetes .=" boundary=\"{$mime_boundary}\"";

		$partie_entete = "Message au format MIME.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type: text/html; charset=\"UTF-8\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		"<html>\n<head>\n<meta http-equiv=Content-Type content=text/html; charset=UTF-8>\n</head>\n<body bgcolor=#FFFFFF>\n";
	} else {
        
            $entetes ="MIME-Version: 1.0 \n";
            $entetes .="From: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
            $entetes .="Return-Path: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
            $entetes .="Reply-To: Esthetic Planet<estheticplanet.paris@gmail.com>\n";
            $entetes .="Content-Type: text/html; charset=utf-8 \n";
            $partie_entete = "<html>\n<head>\n<title>Formulaire</title>\n";
        }

	   //Partie HTML de l'e-mail...
            $partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Nom Prenom = " . $_SESSION['champ1'] . "</font><br>\n";
            $partie_champs_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Telephone = " . $_SESSION['champ2'] . "</font><br>\n";
            $partie_zone_email .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Email = " . $_SESSION['zone_email1'] . "</font><br>\n";
            $partie_cases .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Vous souhaiteriez = ". $_SESSION['case1'][0] . " ". $_SESSION['case1'][1] . " ". $_SESSION['case1'][2] . " "."</font><br>\n";
            $partie_listes .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Traitement greffe de cheveux = " . $_SESSION['liste8'] . "</font><br>\n";
            $partie_zone_texte .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Votre message = " . $_SESSION['zone_texte1'] . "</font><br>\n";


        
        // Ajouter Par alex
        // Enfin, on indique le nom et l'emplacement de la piece jointe sur le serveur.
	if (($_FILES['fichier']['name']['0'] !="") && is_array($_FILES)) {

		// On boucle x nbre de fois, sauf si aucun fichier n'a eteselectionne...
		for ($u = 0; $u <= $nbre_zones_fichiers, $_FILES['fichier']['name'][$u] != ""; $u++) {
			$a = $u + 1;
			$partie_fichier .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Piece jointe $a : " . $nom_unique[$u] . "</font><br>";
		} // Fin de la boucle for...

		$partie_fichier .= "<font face=\"Verdana\" size=\"2\" color=\"#003366\">Pieces jointes conservees dans le repertoire : /home/estheticg/www/mobile/upload</font><br>";
	} // Fin du if...
        
        
        
        
        
	   // Fin du message HTML
	       $fin = "</body></html>\n\n";
        
        
        
        
        //Ajouter par alex
        
        // Si envoi de fichier...
	if (($_FILES['fichier']['name']['0'] !="") && is_array($_FILES)) {

		// Construction de la piece jointe...
        	for ($u = 0; $u <= $nbre_zones_fichiers, $_FILES['fichier']['name'][$u] != ""; $u++) {
	        	$type = $_FILES['fichier']['type'][$u];

			// Lecture du fichier ('rb' = lecture en binaire)
			$fichier = fopen($repertoire . "/" . $nom_unique[$u],'rb');
			$donnees = fread($fichier,filesize($repertoire . "/" . $nom_unique[$u]));
			fclose($fichier);

			// Encodage Base64 des donnees
			$donnees = chunk_split(base64_encode($donnees));

			// Partie piece jointe de l'e-mail
			$piece_jointe .= "--{$mime_boundary}\n" .
	              	"Content-Type: {$type};\n" .
        	      	" name=\"{$nom_unique[$u]}\"\n" .
	              	"Content-Disposition: attachment;\n" .
	              	" filename=\"{$nom_unique[$u]}\"\n" .
	              	"Content-Transfer-Encoding: base64\n\n" .
              		$donnees . "\n\n";
        	} // Fin de la boucle for...

		// Fin de la piece jointe...
		$piece_jointe .= "--{$mime_boundary}--\n";
    

	       $sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_liste . $partie_zone_texte . $partie_fichier . $fin . $piece_jointe;
    }else {
        $sortie = $partie_entete . $partie_champs_texte . $partie_zone_email . $partie_listes . $partie_boutons . $partie_cases . $partie_liste . $partie_zone_texte . $fin;
    }


	// Send the e-mail
	if (@!mail($email_dest,$sujet,$sortie,$entetes)) {
		echo("Envoi du formulaire impossible");
		exit();
	} else {
	        echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="https://www.esthetic-planet.com/mobile/merci.php"</SCRIPT>';// Rediriger vers la page de remerciement
	} 	       
// Fin else
} 
}
?>
   

   
  
<!----------------------------------- Mise en place du Formulaire ----------------------------------------->
   <section class="bloc-formulaire">
        <article class="contact">
            Vous souhaitez une information ou un rendez-vous, merci de remplir le formulaire ci-dessous : 
        </article>
   
   
 <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post" id="mail_form"  enctype="multipart/form-data">
   
    <?php if ($erreur_champ1) 
            { 
                echo(stripslashes($erreur_champ1)); 
            } 
        else 
            { 
                if ($erreur_champ2) 
                    { 
                        echo(stripslashes($erreur_champ2)); 
                    } 
                else 
                    { 
                        if ($erreur_email1) 
                            { 
                                echo(stripslashes($erreur_email1)); 
                            } 
                        else 
                            { 
                                if ($erreur_case1) 
                                    { 
                                        echo(stripslashes($erreur_case1)); 
                                    } 
                                else 
                                    { 
                                        if ($erreur_texte1) 
                                            { 
                                                echo(stripslashes($erreur_texte1)); 
                                            } 
                                        else { 

                                            } 
                                    }         
                            }  
                    }  
            }  
    ?>
    
     <?php if ($erreur_champ1) { echo($icone); } ?>
        
        <input name="champ1" type="text" value="<?php echo(stripslashes($_SESSION['champ1'])); ?>" placeholder="Nom"></input><br>
            
    <?php if ($erreur_champ3) { echo($icone); } ?>
            
        <input name="champ3" type="text" value="<?php echo(stripslashes($_SESSION['champ3'])); ?>" placeholder="Prénom"></input><br>
           

     <?php if ($erreur_champ2) { echo($icone); } ?>
            
            <input name="champ2" type="tel" value="<?php echo(stripslashes($_SESSION['champ2'])); ?>" placeholder="Téléphone"></input><br>
    
     <?php if ($erreur_email1) { echo($icone); } ?>
            
            <input name="zone_email1" type="email" value="<?php echo(stripslashes($_SESSION['zone_email1'])); ?>" placeholder="E-mail"></input><br>
            
    <article class="rdv">Vous souhaitez : <?php if ($erreur_case1) { echo($icone); } ?><br>
            
            <input type="checkbox" name="case1[]" value="une consultation webcam"<?php if ($_SESSION[ 'case1_'][0]=="une consultation webcam" ) { echo( " checked"); } ?>>
            </input> une consultation en ligne
                
                <br>
                
            <input type="checkbox" name="case1[]" value="un rendez-vous a paris" <?php if ($_SESSION[ 'case1_'][1]=="un rendez-vous a paris" ) 
    { echo( " checked"); } ?>>
            </input>un rendez-vous à Paris
                
                <br>
                
                <input type="checkbox" name="case1[]" value="rendez-vous telephonique" <?php if ($_SESSION[ 'case1_'][2]=="rendez-vous telephonique" ) { echo( " checked"); } ?>>
                un rendez-vous téléphonique
                </input>
        </article>
            
        
           
           
        <article class="rdv">Spécialités : <?php if ($erreur_liste8) { echo($icone); } ?>
            
                                               <?php
                                                  if ($erreur_liste8) {
                                                        echo($icone);
                                                    } 
                                                ?>
                                                <select name="liste8">
                                                    <option value="">Sélectionner...</option>
                                                        <option value="Greffe Cheveux"
                                                                <?php
                                                                    if ($_SESSION['liste8'] == "Greffe Cheveux") {
                                                                        echo(" selected");
                                                                    }
                                                                ?>
                                                            >Greffe de cheveux
                                                    </option>
                                                    <option value="Dentaire"
                                                                <?php
                                                                    if ($_SESSION['liste8'] == "Dentaire") {
                                                                        echo(" selected");
                                                                    }
                                                                ?>
                                                            >Soins dentaires
                                                    </option>
                                                    <option value="Chirurgie Esthetique"
                                                                <?php
                                                                    if ($_SESSION['liste8'] == "Chirurgie Esthetique") {
                                                                        echo(" selected");
                                                                    }
                                                                ?>
                                                            >Chirurgie esthétique
                                                    </option>
                                                    <option value="Vision"
                                                                 <?php
                                                                    if ($_SESSION['liste8'] == "Vision") {
                                                                        echo(" selected");
                                                                    }
                                                                ?>
                                                        >Vision
                                                    </option>
                                                    <option value="Anneau gastrique"
                                                                <?php
                                                                    if ($_SESSION['liste8'] == "Anneau gastrique") {
                                                                        echo(" selected");
                                                                    }
                                                                ?>
                                                            >Anneau gastrique
                                                    </option>
                                                    <option value="PMA"
                                                            <?php
                                                                if ($_SESSION['liste8'] == "PMA") {
                                                                    echo(" selected");
                                                                }
                                                            ?>
                                                    >PMA
                                            </option>
                                        </select>
                                    </article>
        
<?php if ($erreur_texte1) { echo($icone); } ?>
            
                <textarea name="zone_texte1" cols="45" rows="10" class="text-box-contact" placeholder="Votre message"><?=stripslashes($_SESSION[ 'zone_texte1']);?></textarea>
            
                    <p>Vous pouvez joindre des photos pour que notre équipe puisse prendre connaissance des soins que vous souhaitez réaliser<br/>	
                    
                   Photo 1 :<input type="file" name="fichier[]" id="fichier1"/>
                    <?php
	  if ($erreur_fichier[1]) {
	  echo($icone);
	  }
	  ?>

                   Photo 2 :<input type="file" name="fichier[]" id="fichier2"/>
                    <?php
	  if ($erreur_fichier[1]) {
	  echo($icone);
	  }
	  ?>
                    <input type="reset" name="Reset" value="Rénitialiser les champs" class="effacer"></input>

                    <input type="submit" name="envoi" value="Envoyer la demande" class="envoyer"></input>
                
                    <input name="nbre_fichiers" type="hidden" id="nbre_fichiers" value="0"></input></p>
    
</form>   
</section>





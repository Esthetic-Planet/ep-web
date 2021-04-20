<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
$AuthUser->RedirctUser();

if(isset($_POST['submit']))
{		
	$user = isset($_REQUEST['txtUserName']) ? $_REQUEST['txtUserName'] : '';
	$pass = isset($_REQUEST['txtpass']) ? $_REQUEST['txtpass'] : '';
	$AuthUser = $sql->SqlCheckUserLogin($user,$pass);
	$Count = $AuthUser['count'];
	
	if($Count>0)
	{
		$Data = $AuthUser['Data'][0];			
		$_SESSION['UserInfo']['id'] = $Data['cust_id'];
		$_SESSION['UserInfo']['fname'] = $Data['cust_fname'];			
		$_SESSION['UserInfo']['lname'] = $Data['cust_lname'];	
		$_SESSION['welmsg']=1;		
		header("Location: service.php");
		exit;
	}
	else
	{
		if(isset($_POST['came_from']) && $_POST['came_from']=='europe-dentaire')
		{
			header("Location: http://www.europe-dentaire.com/dynm/index.php?message=error");
			exit;
		}
		
		if(isset($_POST['came_from']) && $_POST['came_from']=='greffe-cheveux')
		{
			header("Location: http://www.greffe-cheveux.fr/dynm/index.php?message=error");
			exit;
		}
		
		$msg = "incorectLogin";
		header("Location: index.php?msg=$msg");
	}		
}

$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : "";
$message="";

if($msg=='logout')
	$message = "<span class=\"logoutMsgBox\"><span class='green_check_icon'></span>Vous avez réussi à vous connecter à partir <strong>$sitename</strong></span>";
else if($msg=="incorectLogin")
	$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Niveau nom d'utilisateur incorrect, mot de passe, ou Access. S'il vous plaît essayez de nouveau.</sapn>";
else if($msg=='noSess')
	$message="<span class=\"loginErrBox\">Votre session a expiré, S'il vous plaît vous connecter à nouveau pour obtenir l'accès.<span>";
else if($msg=="emailSendMsg")
	$message="<span class=\"logoutMsgBox\">Vos informations de connexion ont été envoyées à votre adresse e-mail. S'il vous plaît vérifiez votre boîte de réception.</span>";
else if($msg=="Inscrit")
	$message="<span class=\"logoutMsgBox\"> Vous êtes enregistré avec succès ! Vous pouvez maintenant vous connecter. </span>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
 
<title>Esthetic Planet : formulaire de connexion sur notre site</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<meta name="description" content="Esthetic Planet : formulaire de connexion pour les utilisateurs du site Esthetic Planet" >
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
<script language=javascript src="js/validation_new.js"></script>
</head>


<body id="page1">
	<div id="main">
<div id="right-tail">
		<!--header -->
		<div id="header">
          <div id="socialmedia" align="right">
          <a href="../contact-societe-esthetic-planet.php" title="Contact us"><img src="../img/contact.jpg" alt="esthetic planet" border="0" /></a>
          
          <a href="http://www.facebook.com/group.php?gid=216202259799#!/group.php?gid=216202259799&v=wall" title=""><img src="../img/facebook.jpg" alt="esthetic planet" border="0" /></a>
          <script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
<a href="skype:esthetic_planet?call"><img src="../img/skype.jpg" alt="esthetic planet" border="0" /></a>
          <a href="/" title=""><img src="../img/twitter.jpg" alt="esthetic planet" border="0" /></a><br/>
          <a href="http://www.esthetic-planet.com/dynm/registration.php" title=""><img src="../img/s-inscriere.jpg" border="0" alt="" /></a><img src="../img/separator.jpg" border="0"/><a href="http://www.esthetic-planet.com/dynm/" title=""><img src="../img/se-connecter.jpg" border="0"  alt="" /></a>

          </div>
 				<div id="logo"><a href="http://www.esthetic-planet.com" title="Esthetic planet"><img src="../img/logo-esthetic-planet.jpg" alt="esthetic planet" border="0" /></a></div>
                    
                   <div id="menu">
                   			<ul>
                            <li><a href="../cliniques.html" title="CLINIQUES" style="color:#399DFB;">CLINIQUES</a></li>
                            
                            <li><a href="../interventions.html" title="INTERVENTIONS">INTERVENTIONS</a></li>
                            <li><a href="../services.html" title="SERVICES">SERVICES</a></li>
                            <li><a href="../chirurgie-du-visage.html" title="TARIFS">TARIFS</a></li>
                            <li><a href="../galerie-photo-visage.html" title="GALERIE">GALERIE</a></li>
                            <li><a href="../qui-sommes-nous.html" title="QUI SOMMES NOUS ?">QUI SOMMES NOUS ?</a></li>
                            <li style="border-right:none;"><a href="../vos-questions.html" title="FAQ">FAQ</a></li>
                            
                            </ul>
                   </div> 
           
		</div>
    <!--header end-->
<!--content begin-->
	  <div id="content-new">
	    <div class="container">
	      <div id="page-name"><strong><a href="http://www.esthetic-planet.com" title="Esthetic planet">Accueil</a> > <span style="color:#379DFB;">Cliniques</span></strong></div>
	      <div id="top-banner">
	       <div class="header-bg" style="background-image:url('../img/imgs_03.jpg');">
				<ul>
	            <li><a href="../interventions.html" title="Chirurgie esthétique">Chirurgie esthétique</a></li>
	            <li><a href="../soins-entaires.html" title="Soins dentaires">Soins dentaires</a></li>
	            <li><a href="../vision.html" title="Chirurgie des yeux">Chirurgie des yeux</a></li>
	            <li><a href="../greffe-de-cheveux-implants-capillaires.html" title="Greffe capillaire">Greffe capillaire</a></li>
              </ul>
	          <!--demandes de vis and rappel bottons-->
	          <div class="demande-de-devis"><a href="../consultation_en_ligne.php" title="Demande de devis"><img src="../img/demande-de-devis.jpg" alt="" width="247" border="0"/></a></div>
	          <div class="rappel-immediat"><a href="../rappel.php" title="Rappel immédiat" style="color:#FFF;"><img src="../img/rappel-immediat.jpg"  width="247"  alt="Rappel imm&eacute;diat" /></a>		               </div>
            </div>
              <!--demandes de vis and rappel bottons end-->
	        <div style="float:right"> <img src="../img/cliniques-topimg.jpg" alt="" border="0"/></div>
          </div>
	       
	      <!-- ** center-box **  -->
	      
	      <!-- ** center-box end **  -->
	      <div style="width:937px;">
		<!--left menu begin-->
	        <div id="left-column-cliniques"> 

           <div class="left-menu-top-bg" style="background-image:url('../img/menu-left-top.jpg');"></div>
           <div class="left-menu-cliniques" style="background-image:url('../img/menu-left-right-bg.jpg'); height:231px;">
  				<ul style="line-height: 28px;">
        	    	<li><a title="Tunis" href="../chirurgie-esthetique-tunisie.html">Tunis</a></li>
                    <li><a title="Prague" href="../chirurgie-esthetique-cliniques-chirurgie-esthetique-praga.html">Prague</a></li>
                    <li><a title="Budapest" href="../tourisme-dentaire-soins-dentaire-hongrie.html">Budapest</a></li>
                    <li><a title="Istanbul" href="../chirurgie-esthetique-turquie-greffe-de-cheveux.html">Istanbul</a></li>
                    <li><a title="Inde" href="../inde.html">New Delhi</a></li>
                     <li><a title="Bruxelles" href="../chirurgie-esthetique-belgique-greffe-de-cheveux.html">Bruxelles</a></li>
                     <li><a title="Paris" href="../paris.html">Paris</a></li>                    
        			<li><a title="Miami - New York" href="../chirurgie-esthetique-cliniques-chirurgie-esthtetique-miami.html">Miami - New York</a></li>
       			</ul>
       </div>
      
            <div class="left-bottom-menu-bg" style="background-image:url('../img/menu-left-bottom.jpg');" ></div>
             <!--left menu end-->
             
             
                        <!--second-->
             <div class="left-menu-top-bg" style="background-image:url('../img/menu-left-top.jpg');"></div>
            
       <div class="left-menu-cliniques" style="padding-bottom:5px; background-image:url('../img/menu-left-right-bg.jpg');height:199px;" >
       
	 <a title="Galerie photo Visage" href="../galerie-photo-visage.html"><img border="0" src="../img/galerie-visage.jpg" alt="&lt;galerie photo esthetic-planet&gt;"></a><br>
	 <br>
	<a title="galerie photo dentaire" href="../galerie-photo-dentaire.html"><img border="0" src="../img/galerie-dentaire.jpg" alt="&lt;galerie photo esthetic-planet&gt;"></a><br>
	<br>
          <a title="Galerie photo corps" href="../galerie-photo-corps.html"><img border="0" src="../img/galerie-corps.jpg" alt="&lt;galerie photo esthetic-planet&gt;"></a>       </div>
      
			<div class="left-bottom-menu-bg" style="background-image:url('../img/menu-left-bottom.jpg');"></div>            
            <!--second end-->
	      
          </div>
          
          
          <div id="right-column-cliniques">
            <h2>Connexion utilisateur</h2>
 
 
 			  <!-- Form Begin -->	
				<form name="frmLogin" id="frmLogin" action="index.php" method="post" onsubmit="return ValidateForm(this)" style="padding-left:20px;">
				<!--Start form -->
				<?php if(!empty($message))
				{ ?>
				<div align="center"> <?php echo $message; ?></div>
				<br />
				<?php } ?>
				<div id="form">
		  	<ul style="width:600px;"> 
				<li class="field_name" style="width:450px; margin-bottom:10px; height:20px;">
                    <div style="float:left; width:65px; height:15px;">Email :</div>
                     <input type="text" class="textbox" name="txtUserName" id="chkemail_txtUserName" style="float:right; width:330px;" title="S'il vous plaît entrez email valide" />
                 </li>	 
				<li class="field_name" style="width:450px;">
                    <div style="float:left; width:100px; height:15px;">Mot de passe :</div>
                    <input type="password" class="textbox" name="txtpass" id="chk_password" title="Pleaes entrer le mot de passe" style="float:right;width:330px"/>
                </li>
			</ul>
			<div class="clear"></div>
		  	
		  	<ul style="width:450px;">
				<li class="field_name">&nbsp;</li>
				<li class="field" style="float:right;width:323px;"><input name="submit" type="submit" class="submit"  value=" "  style="background-image:url('images/connecter.jpg'); border:none;
height:38px;
width:129px; margin-right:40px;" /> &nbsp;
				    <input name="reset" type="reset" class="submit" value=" " style="background-image:url('images/effacer.jpg'); border:none;
height:38px;
width:129px;" /></li>
		  
		   
				
		  	</ul>
        <ul style="width:450px;">
            <li class="field" style="float:right;width:323px;"><a href="forget-password.php" style="margin-right:30px;">Mot de passe oublié ?</a> &nbsp; <a href="registration.php">S’inscrire maintenant</a></li>
            </ul>
			<div class="clear"></div>
			
		  </div>
		  </form>
		  <!--End Form -->	
          
          
          
          
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
		 </div>
 
		</div>
        </div>
 
 
	 
</body>

</html>
<?php
  require 'phpmailer/PHPMailerAutoload.php';
 

	
    $name		=	$_POST['name'];
	$email		=	$_POST['email'];
	$phone		=	$_POST['phone'];
	$select_type=	$_POST['type'];
	
	$to = $email; 
	$message = '<b>Lire les informations attentivement.</b>'; 
	$message .= '<table><tr><td>Nom: </td><td>'.$name.'<td></td></tr>';
	$message .= '<tr><td>Email: </td><td>'.$email.'</td></tr>';
	$message .= '<tr><td>Téléphone: </td><td>'.$phone.'</td></tr>';
	$message .= '<tr><td>Type de soins: </td><td>'.$select_type.'</td></tr>';
	
   		$mail1 = new PHPMailer(); // defaults to using php "mail()"
		$body = $message;
		$mail1->SetFrom($email, "Guest");
		$mail1->AddAddress('estheticplanet.paris@gmail.com','mark@simplemedia.co'); // admin email address
		$mail1->Subject = "Demande de rendez-vous.";
		$mail1->AltBody = "Pour voir le message, utilisez un gestionnaire d'email qui lit le HTML!"; // optional
		$mail1->MsgHTML('<h1>Détail de la demande de prise de rendez-vous.</h1>'.$message);  
		if(!$mail1->Send()) 
		{
			echo "Erreur de mail: " . $mail1->ErrorInfo;
		} 
		else 
		{
			echo 1;
		}
		
		
		
		
		
		
	
	
	
	?>	
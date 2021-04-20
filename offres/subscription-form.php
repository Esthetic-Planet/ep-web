<?php
  require 'phpmailer/PHPMailerAutoload.php';
	 
	$newsletter		=	$_POST['newsletter']; 
	
	$to = $newsletter;
	$message = '<b>Hi!</b></br>';
	$message .= '<h1>New subscriber has subscribed successfully.</h1></br>
	</br>'; 
	$message .= '<p>'.'Subscriber: '.$newsletter.'</p>'; 
	
   
	$mail = new PHPMailer(); // defaults to using php "mail()"
	$body = $message;
	$mail->SetFrom($newsletter,'Guest'); // admin email address
	$mail->AddAddress('mark@simplemedia.co','mark@simplemedia.co'); 
	$mail->Subject = "Newsletter Subscriber";
	$mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; // optional
	$mail->MsgHTML($body); 
	
	if(!$mail->Send()) 
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
		echo 1;
	}



?>	
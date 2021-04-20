<% 

ini_set("include_path", "."); 
$mail->PluginDir = "/home/solus/www"; 
require("class.phpmailer.php"); 

$sleeptmp = 0; 

// While Loop to send emails 

$mybody = "<b>This is <i> Test  Mail </i> </b><br>"; 
$subject = "test"; 
$content = " "; 

//$tmpemail = "altmededu@altmededu.com"; 
$tmpemail = "hariom@solus.co.in";

$mail = new phpmailer(); 
$mail->IsSMTP(); 
$mail->Mailer = "smtp"; 
$mail->Host = "127.0.0.1"; 
$mail->WordWrap = 50; 
$mail->IsHTML(true); 
$mail->Subject = $subject; 
$mail->Body = $mybody; 
$mail->AltBody = $content; 

//$mail->From = "support@indialinks.com"; 
$mail->From = "support@indialinks.com"; 
$mail->FromName = "test sender"; 
$mail->AddAddress("$tmpemail"); 

if(!$mail->Send()) 
{ 
echo "Message was not sent <p>"; 
echo "Mailer Error: " . $mail->ErrorInfo; 
exit; 
} 
flush(); 
%> 


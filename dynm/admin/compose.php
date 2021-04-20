<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
include_once(_CLASS_PATH."pager.cls.php");
include_once(_CLASS_PATH."class.phpmailer.php");


$AuthAdmin->ChkLogin();
//echo "<pre>";
//print_r($_SESSION);
$parent_Id = 0;
$mail_userID = 0;
$subject = "";
$mailBody = "";


if( isset($_REQUEST["parent"] ) && $_REQUEST["parent"] != ""  && $_REQUEST["parent"]  != 0 )
{
		$parent_Id = $_REQUEST["parent"];
	
		$mail_parent_arr = $sql->SqlSingleRecord('esthp_mails',"where mail_Id='".$parent_Id."'");
		$mail_parent_count = $mail_parent_arr['count'];
		$mail_parent_data= $mail_parent_arr['Data'];	
		$mail_sender=$mail_parent_data['mail_sender'];	
		$mail_receiver=$mail_parent_data['mail_reciever'];	
			
		
		
		if($mail_parent_data['mail_type']=='customer_to_clinic')
		{
						$customer_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_sender."'");
						$customer_count = $customer_arr['count'];
						$customer_data= $customer_arr['Data'];	
						
						$customer_fname=$customer_data['cust_fname'];
						$customer_lname=$customer_data['cust_lname'];
						
						$clinic_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_receiver."'");
						$clinic_count = $clinic_arr['count'];
						$clinic_data= $clinic_arr['Data'];	
						
						$clinic_name=$clinic_data['ClinicName'];
						
						$clinic_fname=$clinic_data['FirstName'];
						$clinic_lname=$clinic_data['LastName'];
						
						
					$mailBody = "<br><br><hr>On ".date("j M h:i A",$mail_parent_data["mail_date"]).", ".$customer_fname .' '. $customer_lname. " wrote<br><br>". stripslashes($mail_parent_data["mail_body"]);
					
			}
			else if($mail_parent_data['mail_type']=='clinic_to_customer')
			{
						$clinic_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_sender."'");
						$clinic_count = $clinic_arr['count'];
						$clinic_data= $clinic_arr['Data'];	
						
						$clinic_name=$clinic_data['ClinicName'];
						
						$clinic_fname=$clinic_data['FirstName'];
						$clinic_lname=$clinic_data['LastName'];
						
						$customer_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_receiver."'");
						$customer_count = $customer_arr['count'];
						$customer_data= $customer_arr['Data'];	
						
						$customer_fname=$customer_data['cust_fname'];
						$customer_lname=$customer_data['cust_lname'];	
						
						
				$mailBody = "<br><br><hr>On ".date("j M h:i A",$mail_parent_data["mail_date"]).", ".$clinic_name.' ['.$clinic_fname.' '.$clinic_lname .'] '. " wrote<br><br>". stripslashes($mail_parent_data["mail_body"]);
				
				
									
			}
	
	

	
	$subject = "Re: ". stripslashes($mail_parent_data["mail_subject"]);
	
	
		if($_SESSION['AdminInfo']['is_superadmin']==1 && $mail_parent_data['mail_type']=='clinic_to_customer')
		{
			$mail_userID = $mail_parent_data["mail_reciever"]; //must be customer id
			

		}
		else
		{
			$mail_userID = $mail_parent_data["mail_sender"]; // always is customer id
			
		}
	









/*
	$parent_Id = $_REQUEST["parent"];
	$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblCustomers U on U.cust_id = A.mail_sender WHERE mail_Id= '".$parent_Id."'";
	$arrBrands = $sql->SqlExecuteQuery($query);
	$count = $arrBrands['count'];
	$Data = $arrBrands['Data'][0];
	$subject = "Re: ". stripslashes($Data["mail_subject"]);
	$mailBody = "<br><br><hr>On ".date("j M h:i A",$Data["mail_date"]).", ".$Data["cust_fname"]. " ".$Data["cust_lname"]. " wrote<br><br>". stripslashes($Data["mail_body"]);
	$mail_userID = $Data["mail_sender"];
	
	
	*/
}


if(isset($_POST['Submit']) && $_POST['Submit']=="Send")
{		
	$ConArr = array();	
	
	$ConArr['mail_date'] = time();
	$ConArr["mail_sender"] =  $_SESSION["AdminInfo"]["id"];
	$ConArr["mail_reciever"] = $_POST["mail_userID"];
	$ConArr["mail_type"] = 'clinic_to_customer';
	$ConArr["mail_subject"] = addslashes($_POST["subject"]) ;
	$ConArr["mail_body"] = addslashes($_POST["message_body"]) ;	
	
	if($_FILES['mail_attachment']['name']!="")
	{
			$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
			$file_name =time().'_'.$_FILES['mail_attachment']['name'];
			$upload_file=$upload_dir.$file_name ;
							
			if(move_uploaded_file($_FILES['mail_attachment']['tmp_name'], $upload_file))
			{			
				if($attachmants != "")
				  $attachmants .= "|";
				$attachmants .= $file_name ;
			}
		}
		$ConArr["mail_attachment"] = addslashes($attachmants) ;
		$ConArr["mail_ParentId"] = $parent_Id;
		
//	$ConArr["mail_priority"] = 1 ;

	$receiver = $_POST["mail_userID"];
	$arrClinic = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblCustomers WHERE cust_status = 'active' and cust_id ='$receiver'");
	 $Clinic_count = $arrClinic['count'];
	$Clinic_Data = $arrClinic['Data'][0];
	$cfname = $Clinic_Data["cust_fname"];
	$clname = $Clinic_Data["cust_lname"];
	
	 $sender = $_SESSION["AdminInfo"]["id"];
	$arrSender = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblUsers WHERE IsActive = 't' and UserId='$sender'");
	 $Sender_count = $arrSender['count'];
	$Sender_Data = $arrSender['Data'][0];
	$clinicname= $Sender_Data["ClinicName"];
	  $to  = $Clinic_Data["cust_email"];
	$sub = addslashes($_POST["subject"]) ;
	$subject = "New Request for ".$sub;
	$fname = $Sender_Data["FirstName"];
	$lname = $Sender_Data["LastName"];
	$message = $cfname. " ".$clname." un message de ".$clinicname." est arrivé sur votre espace client Esthetic-Planet. Cliquez ici pour y acceder "._WWWROOT."";
	 //$message = "Dear ". $cfname. " ".$clname."<br><br>a new message from ". $sub.". is waiting<br><br>Thanks<br>Esthetic Planet";
	 $super_admin_arr = $sql->SqlSuperAdmin();	
			$Count = $super_admin_arr['count'];
			$admin_arr = $super_admin_arr['Data'][0];	
			$admin_email =$admin_arr['LoginEmail'];
			
	$mail= new PHPMailer;
$mail->IsHTML(true);
$mail->IsMail();
  $frommail=$admin_email;
$mail->IsFrom($frommail);
$mail->IsFromName($admin_arr['FirstName'].' '.$admin_arr['LastName'] );


$mail->AddAddress($to);
$mail->Subject=$subject;


$mail->Body=$message;
//$mail->AddAttachment($upload_file, $name = "");

if($mail->Send()){
echo "Mail Sent.";

}
else{
echo "Message was not sent <p>"; 
//echo "Mailer Error: " . $mail->ErrorInfo; 
 
}
	/*$mail = new PHPMailer; 
	
$mail->IsMail(); 
$mail->Mailer = "mail"; 

$mail->IsHTML(true); 
$mail->Subject = $subject; 
$mail->Body = $message; 


//$mail->From = "support@indialinks.com"; 
$mail->From = $Sender_Data["LoginEmail"];; 
$mail->FromName = $fname.' '.$lname; 
$mail->AddAddress($to); 

if(!$mail->Send()) 
{ 
echo "Message was not sent <p>"; 
//echo "Mailer Error: " . $mail->ErrorInfo; 
exit; 
} */
	//$headers  = 'MIME-Version: 1.0' . "\r\n";
	//$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	//$headers .= 'From: '.$fname.' '.$lname.' <'.$_SESSION["UserInfo"]["id"].'>' . "\r\n";

	// Mail it
	//mail($to, $subject, $message, $headers);
	
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr);
	
	if($intResult > 0)
	{
		header("location:inbox.php?msg=success");
		die();
	}
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />
<title>:: <?=$sitename?> ::</title>
<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">
<script language="javascript" src="<?=_WWWROOT?>js/formvalidate.js"></script>
<script language="javascript" src="<?=_WWWROOT?>js/validateUnique.js"></script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?></td>  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		  <form name="emailForm" id="emailForm" method="post" action="" onsubmit="return validateForm(this);" enctype="multipart/form-data">
		  <input type="hidden" name="parent" value="<?php echo $parent_Id;?>">
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">          
           <tr>
             <td height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>                
                <td><h1>Compose Message </h1></td>
              </tr>
             </table></td>
           </tr>
           <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5"><div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>
           </tr>
  <?php if($sqlError!="") 
  		{ ?>
		  <tr><td valign="top" align="center"><span class="loginErrBox" style="margin:15px;"><?=$sqlError?></span></td></tr>
  <?php } ?>
		  <tr>          <td valign="top" align="center">&nbsp;</td>          </tr>
          <tr>
           <td valign="top"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
             <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">Reciever :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left">

<select name="mail_userID" id="mail_userID"  class="input_white" style="width:352px;" lang="MUST" title="Reciever">

<option value="">Select Reciever</option>
	  <?php
	  
	   		$arrUsers = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblCustomers WHERE cust_status = 'active' order by cust_fname, cust_lname");
			
			$Users_count = $arrUsers['count'];
			
			$Users_Data = $arrUsers['Data'];
			
			if($Users_count > 0)
			{
				 for($i=0; $i<$Users_count; $i++)
				 {
				 
						$sel = "";
						
						if($Users_Data[$i]['cust_id']==$mail_userID)
						{
							$sel = "selected";
						}
						?>
						
<option value="<?=$Users_Data[$i]['cust_id']?>" <?=$sel?>><?=$Users_Data[$i]['cust_fname'].' '.$Users_Data[$i]['cust_lname']?></option>		
						<?php
				 }
			}
			
	?>	 
			  </select></td>
             </tr>
			 <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>



             <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">Subject :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left"><input name="subject" id="subject" type="text" class="input_white" size="48" value="<?php echo $subject;?>"></td>
             </tr>
			 <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>
	         <tr valign="top">
			   <td align="left" class="normal_text_blue">Body :</td>
               <td>&nbsp;</td>
               <td align="left">&nbsp;	</td>
			  </tr>
			  <tr>
			  	<td colspan="3">
					<?php	
			   							include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
			   							$sBasePath = _HTML_EDITOR_PATH."/";
										$oFCKeditor = new FCKeditor('message_body') ;
										$oFCKeditor->BasePath	= $sBasePath ;
										//$oFCKeditor->ToolbarSet ="Basic";
										$oFCKeditor->Value= $mailBody;
										$oFCKeditor->Width = "100%" ;
										$oFCKeditor->Height = "350" ;
										$oFCKeditor->Create() ;	?>					</td>
			  </tr>
              
              <tr>
                <td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td>
              </tr>
              <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">Attach File :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left"><input type="file" name="mail_attachment" id="mail_attachment" /></td>
             </tr>
              <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Send">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='inbox.php';"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
		</form>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td>  </tr>
</table>
</body>
</html>
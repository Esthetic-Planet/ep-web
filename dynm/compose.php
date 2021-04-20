<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
include_once(_CLASS_PATH."class.phpmailer.php");
$AuthUser->ChkLogin();

//echo "<pre>";
//print_r($_SESSION);
$parent_Id = 0;
$mail_userID = 0;
$subject = "";
$mailBody = "";
$clnic_Id = $_REQUEST["clnic"];

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
	
	$mail_userID = $mail_parent_data["mail_sender"];
}


if(isset($_POST['Submit']) && $_POST['Submit']=="Envoyer")
{		
	$ConArr = array();	
	
	$ConArr['mail_date'] = time();
	$ConArr["mail_sender"] =  $_SESSION["UserInfo"]["id"];
	$ConArr["mail_reciever"] = $_POST["mail_userID"];
	$ConArr["mail_type"] = 'customer_to_clinic';
	$ConArr["mail_subject"] = addslashes($_POST["subject"]) ;
	$ConArr["mail_body"] = addslashes($_POST["message_body"]) ;	
	$ConArr["mail_ParentId"] = $parent_Id;
//	$ConArr["mail_priority"] = 1 ;

	$receiver = $_POST["mail_userID"];
	$arrClinic = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblUsers WHERE IsActive = 't' and UserId='$receiver'");
	$Clinic_count = $arrClinic['count'];
	$Clinic_Data = $arrClinic['Data'][0];
	$cfname = $Clinic_Data["FirstName"];
	$clname = $Clinic_Data["LastName"];
	$clinicname= $Clinic_Data["ClinicName"];
	$sender = $_SESSION["UserInfo"]["id"];
	$arrSender = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblCustomers WHERE cust_status = 'active' and cust_id ='$sender'");
	$Sender_count = $arrSender['count'];
	$Sender_Data = $arrSender['Data'][0];
	
	$to  = $Clinic_Data["LoginEmail"];
	$sub = addslashes($_POST["subject"]) ;
	$subject = "New Request for ".$sub;
	$fname = $Sender_Data["cust_fname"];
	$lname = $Sender_Data["cust_lname"];
$message = $fname. " ".$lname." un message de ".$clinicname." est arrivé sur votre espace client Esthetic-Planet. Cliquez ici pour y acceder "._ADMIN_WWWROOT."";
	//$message = "Dear ". $cfname. " ".$clname."<br><br>a new message from ". $sub.". is waiting<br><br>Thanks<br>Esthetic Planet";
	/*$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$fname.' '.$lname.' <'.$_SESSION["UserInfo"]["id"].'>' . "\r\n";
*/
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
	// Mail it
	//mail($to, $subject, $message, $headers);
	
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
	
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr);
	
	
	if($intResult > 0)
	{
		header("location:inbox.php?msg=success");
		die();
	}
}	
?>
<script>
function ValidateForm()
{
	var a=document.search.mail_userID.value;
	
	if(a=="")
	{
		alert("S'il vous plait selectionner le receveur");
		document.search.mail_userID.focus();
		return false;
	}
}
</script>

<?php include("header.php"); ?>
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Nouveau message</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					<div id="sea_mid">
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="field1_form2">
								<div id="clinicdiv">
									<input type="hidden" name="parent" value="<?php echo $parent_Id;?>">
								  <table width="100%" border="0" cellspacing="0" cellpadding="0">          
          
           <tr>
            <td valign="top">&nbsp;</td>
           </tr>
		  <tr>          <td valign="top" align="center">&nbsp;</td>          </tr>
          <tr>
           <td valign="top"><table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
             <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">Destinataire  :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left">
			   <?php
			   
			   
			   if(!empty($clnic_Id))
			  { 
			  	//$get_id = $_SESSION["UserInfo"]["id"];
			  	$Userinfo1 = $sql->SqlExecuteQuery("SELECT * FROM  esthp_tblUsers where UserId='$clnic_Id'");
				$Uinfo_count1 = $Userinfo1['count'];
				$Uinfo_Data1 = $Userinfo1['Data'][0];
				//echo "<pre>";
				//print_r($Userinfo); Ecrire un message
			  ?>
			  <input type="text" name="mail_userID_name" id="mail_userID_name" title="Receiver" class="textbox2" value="<?=$Uinfo_Data1["ClinicName"]?> [<?=$Uinfo_Data1["FirstName"]; ?> <?=$Uinfo_Data1["LastName"]; ?>]" />
			   <input type="hidden" name="mail_userID" id="mail_userID" title="Receiver" class="textbox2" value="<?php echo $Uinfo_Data1["UserId"]; ?>" />
			 <?php  
			 } 
			 else if(!empty($parent_Id))
			 { 
			 
			 		//$parent_Id = $_REQUEST["parent"];
	
			
					$mail_parent_arr = $sql->SqlSingleRecord('esthp_mails',"where mail_Id='".$parent_Id."'");
					$mail_parent_count = $mail_parent_arr['count'];
					$mail_parent_data= $mail_parent_arr['Data'];	
					$mail_sender=$mail_parent_data['mail_sender'];	
					$mail_receiver=$mail_parent_data['mail_reciever'];	
			
		
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
						
			  ?>
			  <input type="text" name="mail_userID_name" id="mail_userID_name" title="Receiver" class="textbox2" value="<?=$clinic_name?> [<?=$clinic_fname?>  <?=$clinic_lname?>]" />
			  <input type="hidden" name="mail_userID" id="mail_userID" title="Receiver" class="textbox2" value="<?=$clinic_data["UserId"]?>" />
			 <?php  }
			 else { ?>
			 <select name="mail_userID" id="select"  class="input_white" style="width:352px;" lang="MUST" title="Reciever">
			  <option value="">Select Reciever</option>
               <?php $arrUsers = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblUsers WHERE IsActive = 't' and UserId!='1'");
			$Users_count = $arrUsers['count'];
			$Users_Data = $arrUsers['Data'];
			if($Users_count > 0)
			{
				 for($i=0; $i<$Users_count; $i++)
				 {
				 	if( $Users_Data[$i]['cust_id'] == $mail_userID)	 $sel = "selected";
					else $sel = "";
					$name = $Users_Data[$i]['FirstName'];
					if(!empty($Users_Data[$i]['LastName']))
					{
						$name = $name. " " .$Users_Data[$i]['LastName'];
					}
				    echo '<option value="'.$Users_Data[$i]['UserId'].'" '.$sel.'>'.$Users_Data[$i]['ClinicName'].' ['.$name .'] </option>';		  
				 }
			}
			}?>
             </select>			 </td>
             </tr>
			 <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>



             <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">Objet :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left"><input name="subject" id="subject" type="text" class="textbox2" size="48" value="<?php echo $subject;?>"></td>
             </tr>
			 <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>
	         <tr valign="top">
			   <td align="left" class="normal_text_blue"></td>
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
										$oFCKeditor->Width = "98%" ;
										$oFCKeditor->Height = "350" ;
										$oFCKeditor->Create() ;	?>					</td>
			  </tr>
			  
			  <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>
	         <tr valign="top">
			   <td align="left" class="normal_text_blue">Joindre un fichier :</td>
               <td>&nbsp;</td>
               <td align="left"><input type="file" name="mail_attachment" id="mail_attachment" /></td>
			  </tr>
              
              <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Envoyer">
				<input type="button" name="cancel"  value="Effacer" class="btn" onClick="location.href='inbox.php';"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
							</div>
							</li>
						</ul>
						<div class="clear"></div>
						</div>
						
						</div>
					<div id="sea_right"></div>
					<div class="clear"></div>
					<!--End listing_page -->
				</div>
				</form>
				<!--End clinic_page -->
			
			<div class="clear"></div>
		  <!--End Form -->	
		  
			</div>
			<div class="clear"></div>
		</div>
		<!--End Right_part -->	
		<div class="clear"></div>
	  </div>	
		<!--End Middle_Area -->	
	</div>
	<!--End Page panel -->
</div>
<!--End Page Holder -->
<?php include("footer.php"); ?>
</body>
</html>
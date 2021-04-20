<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");
$AuthAdmin->ChkLogin();


if(isset($_REQUEST['MId']) && $_REQUEST['MId'] != ""  && $_REQUEST['MId'] != 0 )
{
	/*$id = $_REQUEST['MId'];
	$ConArr['mail_read'] = 1;
	$CondArr = " WHERE mail_Id = '$id' ";
	$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);*/
	
	
	/*$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblUsers U on U.UserId = A.mail_sender WHERE mail_Id= '$id'" ;
	$arrBrands = $sql->SqlExecuteQuery($query);
	$count_total=$arrBrands['TotalCount'];
	$count = $arrBrands['count'];
	$Data = $arrBrands['Data'][0];		 
	*/
	
	
			$id = $_REQUEST['MId'];
	
				$ConArr['mail_read'] = 1;
				$CondArr = " WHERE mail_Id = '$id' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);


			$query = "SELECT * from esthp_mails WHERE mail_Id= '$id'" ;
			$arrBrands = $sql->SqlExecuteQuery($query);
			$count_total=$arrBrands['TotalCount'];
			$count = $arrBrands['count'];
			$Data = $arrBrands['Data'][0];
			
			$mail_sender=$Data['mail_sender'];	
			$mail_receiver=$Data['mail_reciever'];	
			
			if($Data['mail_type']=='customer_to_clinic')
			{
						
						$customer_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_sender."'");
						$customer_count = $customer_arr['count'];
						$customer_data= $customer_arr['Data'];	
						
						$customer_fname=$customer_data['cust_fname'];
						$customer_lname=$customer_data['cust_lname'];
						
						$customer_name=$customer_fname.' '.$customer_lname;	
						
						$clinic_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_receiver."'");
						$clinic_count = $clinic_arr['count'];
						$clinic_data= $clinic_arr['Data'];	
						
						$clinic_name=$clinic_data['ClinicName'];
						
						$clinic_fname=$clinic_data['FirstName'];
						$clinic_lname=$clinic_data['LastName'];
						
						$clinicName=$clinic_name.' ['.$clinic_fname.' '.$clinic_lname.']';
			}
			else if($Data['mail_type']=='clinic_to_customer')
			{
			
						$clinic_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_sender."'");
						$clinic_count = $clinic_arr['count'];
						$clinic_data= $clinic_arr['Data'];	
						
						$clinic_name=$clinic_data['ClinicName'];
						
						$clinic_fname=$clinic_data['FirstName'];
						
						$clinic_lname=$clinic_data['LastName'];
						
						
						$clinicName=$clinic_name.' ['.$clinic_fname.' '.$clinic_lname.']';
						
						
						$customer_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_receiver."'");
						$customer_count = $customer_arr['count'];
						$customer_data= $customer_arr['Data'];	
						
						$customer_fname=$customer_data['cust_fname'];
						
						$customer_lname=$customer_data['cust_lname'];
						
						$customer_name=$customer_fname.' '.$customer_lname;										
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
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="25" valign="top" class="green_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td><h1>View Message</h1></td>
              </tr>
            </table></td>
          </tr>
		  <tr><td valign="top"><img src="images/spacer.gif" alt="" width="1" height="12"></td>          </tr>
		  <tr><td valign="top" align="left" class="msg_head">Subject: <?php echo stripslashes($Data["mail_subject"]); ?></td></tr> 
          <tr>
            <td valign="top" align="left">
		
			
			<table width="99%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="20" colspan="3" align="right" valign="top">			
				
				
					
				<table width="100%" border="0" cellpadding="1" cellspacing="2" id="view_msg" align="center">
				
			<?php
			if($Data['mail_type']=='customer_to_clinic')
			{
			?>
			<tr valign="top"><td align="left" class="msg_user">From: <?php echo $customer_name. " on ".date("j M h:i A",$Data["mail_date"]); ?></td></tr>


<tr valign="top"><td align="left" class="msg_user">To: <?php echo $clinicName; ?></td></tr>	
			<?php
				
			}
			else if($Data['mail_type']=='clinic_to_customer')
			{
			?>
			<tr valign="top"><td align="left" class="msg_user">From: <?php echo $clinicName. " on ".date("j M h:i A",$Data["mail_date"]); ?></td></tr>


<tr valign="top"><td align="left" class="msg_user">To: <?php echo $customer_name; ?></td></tr>	
			<?php
			
			}
				
			?>
			
				
				


				  
				  <tr valign="top"><td align="left" class="msg_content"><?php echo stripslashes($Data["mail_body"]); ?></td></tr>                                  	
				</table>
				
				
				
								
				</td>
              </tr>
               <tr><td valign="top" align="center"><img src="images/msg_btm_cr.gif" width="715" height="21"></td></tr> 
            </table></td>
          </tr> 
		  <?php 	 if( trim( $Data["mail_attachment"] ) != "")				 
				{
					echo '<tr><td valign="top" align="left" class="msg_reply" style="padding-left:6px;"><strong>Attachments</strong></td></tr>';	
					echo '<tr><td valign="top" align="left" class="msg_reply">';
					$attachments_arr  =  explode("|",$Data["mail_attachment"]);
					foreach ( $attachments_arr as $val)
					{
						$loc = strpos( $val,"_");
						$filename = substr($val, ($loc+1));
						if($filename)
						{
						echo '<div style="padding:6px;">'.$filename.'&nbsp;&nbsp;<a href="'._UPLOAD_FILE_URL.'mail_attachment/'.$val.'">'.view.'</a> &nbsp;&nbsp;<a href="download.php?f='.$val.'&fc='.$filename.'">'.download.'</a></div>';
						}
					}
				echo '</td></tr>';		
				}?>         
  		  <tr><td valign="top" align="left" class="msg_reply">
		<?php
			$a = $_SERVER['HTTP_REFERER'];
			
		?>
		  <?php if (preg_match("/inbox/i", $a)) 
				{ ?>
					<a href="compose.php?parent=<?php echo $Data["mail_Id"];?>">Reply</a> 
		  <?php	} ?>
		 &nbsp;&nbsp; <A HREF="javascript:history.go(-1)">Back</A>
		  </td></tr> 

         </table>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td>  </tr>
</table>
</body>
</html>
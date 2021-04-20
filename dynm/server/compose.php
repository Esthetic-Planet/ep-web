<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

//echo "<pre>";
//print_r($_SESSION);
$parent_Id = 0;
$mail_userID = 0;
$subject = "";
$mailBody = "";
if( isset($_REQUEST["parent"] ) && $_REQUEST["parent"] != ""  && $_REQUEST["parent"]  != 0 )
{
	$parent_Id = $_REQUEST["parent"];
	$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblUsers U on U.UserId = A.mail_sender WHERE mail_Id= '".$parent_Id."'";
	$arrBrands = $sql->SqlExecuteQuery($query);
	$count = $arrBrands['count'];
	$Data = $arrBrands['Data'][0];
	$subject = "Re: ". stripslashes($Data["mail_subject"]);
	$mailBody = "<br><br><hr>On ".date("j M h:i A",$Data["mail_date"]).", ".$Data["cust_fname"]. " ".$Data["cust_lname"]. " wrote<br><br>". stripslashes($Data["mail_body"]);
	$mail_userID = $Data["mail_sender"];
}


if(isset($_POST['Submit']) && $_POST['Submit']=="Send")
{		
	$ConArr = array();	
	
	$ConArr['mail_date'] = time();
	$ConArr["mail_sender"] =  $_SESSION["UserInfo"]["id"];
	$ConArr["mail_reciever"] = $_POST["mail_userID"];
	$ConArr["mail_subject"] = addslashes($_POST["subject"]) ;
	$ConArr["mail_body"] = addslashes($_POST["message_body"]) ;	
	$ConArr["mail_ParentId"] = $parent_Id;
//	$ConArr["mail_priority"] = 1 ;
	
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr);
	if($intResult > 0)
	{
		header("location:inbox.php?msg=success");
		die();
	}
}	
?>
<?php include("header.php"); ?>
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Compose Message</div>
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
	          <td width="103" align="left" class="normal_text_blue">Reciever :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left">
			  <?php if(!empty($parent_Id))
			  { 
			  	$get_id = $_SESSION["UserInfo"]["id"];
			  	$Userinfo = $sql->SqlExecuteQuery("SELECT m.*, u.* FROM esthp_mails as m, esthp_tblUsers as u where m.mail_reciever='$get_id' and m.mail_sender=u.UserId");
				$Uinfo_count = $Userinfo['count'];
				$Uinfo_Data = $Userinfo['Data'][0];
				//echo "<pre>";
				//print_r($Userinfo);
			  ?>
			  <input type="text" name="mail_userID_name" id="mail_userID_name" title="Receiver" class="textbox2" value="<?php echo $Uinfo_Data["FirstName"]; ?> <?php echo $Uinfo_Data["LastName"]; ?>" />
			  <input type="hidden" name="mail_userID" id="mail_userID" title="Receiver" class="textbox2" value="<?php echo $Uinfo_Data["UserId"]; ?>" />
			 <?php  }
			 else { ?>
			 <select name="select" id="select"  class="input_white" style="width:352px;" lang="MUST" title="Reciever">
			   <option value="">Select Reciever</option>
               <?php $arrUsers = $sql->SqlExecuteQuery("SELECT * FROM esthp_tblCustomers WHERE cust_status = 'active'");
			$Users_count = $arrUsers['count'];
			$Users_Data = $arrUsers['Data'];
			if($Users_count > 0)
			{
				 for($i=0; $i<$Users_count; $i++)
				 {
				 	if( $Users_Data[$i]['cust_id'] == $mail_userID)	 $sel = "selected";
					else $sel = "";
				    echo '<option value="'.$Users_Data[$i]['cust_id'].'" '.$sel.'>'.$Users_Data[$i]['cust_fname'].' '.$Users_Data[$i]['cust_lname'].'</option>';		  
				 }
			}
			}?>
             </select>			 </td>
             </tr>
			 <tr><td height="20" align="right" valign="top" colspan="3" class="normal_text_blue">&nbsp;</td></tr>



             <tr valign="top">
	          <td width="103" align="left" class="normal_text_blue">sujet :</td>
              <td width="6">&nbsp;</td>
              <td width="591" align="left"><input name="subject" id="subject" type="text" class="textbox2" size="48" value="<?php echo $subject;?>"></td>
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
										$oFCKeditor->Width = "98%" ;
										$oFCKeditor->Height = "350" ;
										$oFCKeditor->Create() ;	?>					</td>
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
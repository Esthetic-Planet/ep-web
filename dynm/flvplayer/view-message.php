<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();


if(isset($_REQUEST['MId']) && $_REQUEST['MId'] != ""  && $_REQUEST['MId'] != 0 )
{
	$id = $_REQUEST['MId'];

	$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblUsers U on U.UserId = A.mail_sender WHERE mail_Id= '$id'" ;
	$arrBrands = $sql->SqlExecuteQuery($query);
	$count_total=$arrBrands['TotalCount'];
	$count = $arrBrands['count'];
	$Data = $arrBrands['Data'][0];		 
}
?>
<?php include("header.php"); ?>
		
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Visualiser le message entier</div>
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
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
        
		  <tr><td valign="top"><img src="images/spacer.gif" alt="" width="1" height="12"></td>          </tr>
		  <tr><td valign="top" align="left" class="msg_head"><?php echo stripslashes($Data["mail_subject"]); ?></td></tr> 
          <tr>
            <td valign="top" align="left"><table width="99%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="20" colspan="3" align="right" valign="top">				
				<table width="100%" border="0" cellpadding="1" cellspacing="2" id="view_msg" align="center">
				  <tr valign="top"><td align="left" class="msg_user"><?php echo stripslashes($Data["UserName"]). " on ".date("j M h:i A",$Data["mail_date"]); ?></td></tr>	
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
						echo '<div style="padding:6px;">'.$filename.'&nbsp;&nbsp;<a href="'._UPLOAD_FILE_URL.'mail_attachment/'.$val.'">'.view.'</a> &nbsp;&nbsp;<a href="download.php?f='.$val.'&fc='.$filename.'">'.download.'</a></div>';
					}
				echo '</td></tr>';		
				}
		?>
  		  <tr><td valign="top" align="left" class="msg_reply">
		<?php
			$a = $_SERVER['HTTP_REFERER'];
			
		?>
		  <?php if (preg_match("/inbox/i", $a)) 
				{ ?>
					<a href="compose.php?parent=<?php echo $Data["mail_Id"];?>"><img src="images/reply_btn.jpg" border="0" /></a> 
		  <?php	} ?>
		   &nbsp;&nbsp;<div> <A HREF="javascript:history.go(-1)"><b>Back</b></A></div>
		  </td></tr> 
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
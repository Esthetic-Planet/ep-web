<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");
$AuthAdmin->ChkLogin();


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
                
                <td><h1>View User Profile</h1></td>
              </tr>
            </table></td>
          </tr>
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
  		  <tr><td valign="top" align="left" class="msg_reply">

		  <?php //if($Data["mail_reciever"] != $_SESSION["AdminInfo"]["id"])
				//{ ?>
					<!--<a href="compose.php?parent=<?php echo $Data["mail_Id"];?>">Reply</a> -->
		  <?php	//} ?>
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
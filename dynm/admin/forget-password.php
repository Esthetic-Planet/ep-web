<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
$AuthAdmin->RedirctAdm();
	if(($_REQUEST['email'])!='')
	{		
	
		$user_email = $_REQUEST['email'];
		
		$user_record_arr = $sql->SqlGetAdminPasswd($user_email);	
			
		$Count = $user_record_arr['count'];
		
		if($Count>0)
		{
				$user_arr = $user_record_arr['Data'][0];	
				$to_email =$user_arr['LoginEmail'];
				$email_subject="Password Recovery Email: "._WEBSITE_NAME;
				$email_body .=
				'
				<table width="70%" cellpadding="0" border="0" align="center">
						<tr><td colspan="2"><b>Your login details on '._WEBSITE_NAME.' are as follows: </b></td></tr>
						<tr>
							<td width="30%"><b>UserName :</b></td>
							<td>'.$user_arr['LoginEmail'].'</td>
						</tr>
						<tr>
							<td><b>Password :</b></td>
							<td>'.$user_arr['Password'].'</td>
						</tr>
						<tr>
							<td colspan="2"></td>	
						</tr>
						</table>
				';
				
				$super_admin_arr = $sql->SqlSuperAdmin();	
				$Count = $super_admin_arr['count'];
				$admin_arr = $super_admin_arr['Data'][0];	
				$admin_email =$admin_arr['LoginEmail'];
				
				
				
				$from="From: ".'Admin'." <".$admin_email.">";
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$header .=$from;
				
				//echo $email_body;
				
				if(mail($to_email,$email_subject,$email_body,$header))
				{
				
					$msg="emailSendMsg";
					header("Location: index.php?msg=$msg");
				}
				else
				{
					$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Email was not sent.</span>";
				}
		}
		else
		{
			$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>The provided email id is invalid. Please check your email id and try again.</span>";
		}		
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />
<title>:: Welcome To
<?=$sitename?>
Cpanel ::</title>
<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	function SubmitForm()
	{
		if(document.getElementById('email').value=='')
		{
			alert("Please enter user email id.");
			document.getElementById('email').focus();
			return false;
		}
		else
		{
			if(!is_email(document.getElementById('email').value))
			{
				alert("Please enter valid email address.");
				document.getElementById('email').focus();
				return false;
			}
		}
		function is_email(email)
	{
		if(!email.match(/^[A-Za-z0-9\._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/))
			return false;
		return true;
	}
				
		return true;
	}
</script>
</head>
<body onLoad="javascript: document.frmLogin.txtUserName.focus();">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?></td>
  </tr>
  <tr>
    <td valign="middle" style="height:310px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <!--<td width="232" valign="top" class="border_left">&nbsp;</td> -->
          <td width="14" valign="top">&nbsp;</td>
          <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" align="center" style="padding:5px;"><?=$message?></td>
              </tr>
              <tr>
                <td valign="top"><table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td valign="top"><table width="534" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" valign="top" ></td>
                          </tr>
                          <tr>
                            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
                          </tr>
                          <tr>
                            <td valign="top"><table width="534" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td valign="top"><img src="images/admin_topimg.gif" alt="" width="534" height="14"></td>
                                </tr>
                                <tr>
                                  <td valign="top" class="admin_bg"><table width="534" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td valign="top" width="18">&nbsp;</td>
                                        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                              <td width="145" align="center" valign="middle" class="grey_text"><img src="images/admin_image.gif" alt="" width="97" height="99"><br>
                                              Enter Valid Email ID to retrive your Password.</td>
                                              <td width="245" valign="top"><form name="frmForgetPass" id="frmForgetPass" action="forget-password.php" method="post" onSubmit="return SubmitForm();">
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="26"></td>
                                                    </tr>
                                                    <tr>
                                                      <td valign="top"><img src="images/admin_panel.gif" alt="" width="134" height="23"></td>
                                                    </tr>
                                                    <tr>
                                                      <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="15"></td>
                                                    </tr>
                                                    <tr>
                                                      <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td width="33%" valign="top" class="red_text">Email Id</td>
                                                            <td width="67%" valign="top"><input name="email" id="email" type="text" class="search_box"></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top" class="red_text"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" valign="top" class="red_text"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top"><input type="hidden" name="submit" value="Login"></td>
                                                            <td align="left" valign="top">
															<input type="image" name="loginBtn" src="images/submit.gif" alt="" width="62" height="21" border="0" />
                                                              &nbsp; <img src="images/clear.gif" alt="" width="62" height="21" onClick="javascript: document.frmForgetPass.reset();" style="cursor:pointer;"></td>
                                                          </tr>
                                                          <tr>
                                                            <td valign="top">&nbsp;</td>
                                                            <td height="20" align="left" valign="bottom">
															<a href="index.php" class="grey_text">Login</a></td>
                                                          </tr>
                                                      </table></td>
                                                    </tr>
                                                    <tr>
                                                      <td valign="top">&nbsp;</td>
                                                    </tr>
                                                  </table>
                                              </form></td>
                                              <td width="108" valign="top">&nbsp;</td>
                                            </tr>
                                          </table></td>
                                        <td valign="top" width="18">&nbsp;</td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr>
                                  <td valign="top"><img src="images/admin_bottomimg.gif" alt="" width="534" height="14"></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
              <tr>
                <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="30"></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td valign="top"><?php include_once('include/footer.php');?></td>
  </tr>
</table>
</body>
</html>

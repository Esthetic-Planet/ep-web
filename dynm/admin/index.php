<?php
include_once("../includes/global.inc.php");
include_once(_PATH."modules/mod_admin_login.php");

$AuthAdmin->RedirctAdm();



if(isset($_REQUEST['submit']))
{		
	$user = isset($_REQUEST['txtUserName']) ? $_REQUEST['txtUserName'] : '';
	$pass = isset($_REQUEST['txtpass']) ? $_REQUEST['txtpass'] : '';
	$AuthAdmin = $sql->SqlCheckAdminLogin($user,$pass);
	$Count = $AuthAdmin['count'];
	if($Count>0)
	{
		$Data = $AuthAdmin['Data'][0];			
		$_SESSION['AdminInfo']['id'] = $Data['UserId'];
		$_SESSION['AdminInfo']['User'] = $Data['FirstName'];			
		$_SESSION['AdminInfo']['is_superadmin'] = $Data['is_superadmin'];
		header("Location: home.php");
		exit;
	}
	else
	{
		$msg = "incorectLogin";
		header("Location: index.php?msg=$msg");
	}		
}

$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : "";


$message="";

if($msg=='logout')
	$message = "<span class=\"logoutMsgBox\"><span class='green_check_icon'></span>You have successfully logged out from <strong>$sitename</strong> Admin Panel</span>";
else if($msg=="incorectLogin")
	$message = "<span class=\"loginErrBox\"><span class='alert_icon'></span>Incorrect Username, Password, or Access Level. Please try again.</sapn>";
else if($msg=='noSess')
	$message="<span class=\"loginErrBox\">Your session has expired, Please login again to get access.<span>";
else if($msg=="emailSendMsg")
	$message="<span class=\"logoutMsgBox\">Your  login details  have been  sent to your email address. Please check your inbox.</span>";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />

<title>:: Welcome To <?=$sitename?> Cpanel ::</title>

<link href="script/style.css" rel="stylesheet" type="text/css">

<link href="script/admin.css" rel="stylesheet" type="text/css">

</head>

<body onLoad="javascript: document.frmLogin.txtUserName.focus();" >
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?></td>
  </tr>
  <tr>
    <td valign="middle" style="height:310px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?php
		if($message!='')
		{
		?>
		<tr>
            <td valign="top" align="center" style="padding:5px;"><?=$message?></td>
          </tr>
		  <?php
		  }
		  ?>
          <tr>
            <td valign="top"><table width="534" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top"><table width="534" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" valign="top" > </td>
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
                                <td width="156" align="center" valign="middle" class="grey_text"><img src="images/admin_image.gif" alt="" width="97" height="99"><br>
								Use a valid username and password to gain access to the administration console.</td>
                                <td width="234" valign="top">
								<form name="frmLogin" id="frmLogin" action="index.php" method="post">
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
                                        <td width="36%" valign="top" class="red_text">User Name</td>
                                        <td width="64%" valign="top"><input name="txtUserName" type="text" class="search_box" value="<?=$_REQUEST['txtUserName']?>"></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" valign="top" class="red_text"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
                                        </tr>
                                      <tr>
                                        <td valign="top" class="red_text">Password</td>
                                        <td valign="top"><input name="txtpass" type="password" class="search_box"></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" valign="top" class="red_text"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
                                        </tr>
                                      <tr>
                                        <td valign="top"><input type="hidden" name="submit" value="Login"></td>
                                        <td align="left" valign="top">
										<input type="image" name="loginBtn" src="images/login.gif" alt="" width="62" height="21" border="0" />
										&nbsp; 
										<img src="images/clear.gif" alt="" width="62" height="21" onClick="javascript: document.frmLogin.reset();" style="cursor:pointer;"></td>
                                      </tr>
                                      <tr>
                                        <td valign="top">&nbsp;</td>
                                        <td height="20" align="left" valign="bottom"><a href="forget-password.php" class="grey_text">Forgot Password?</a></td>
                                      </tr>
                                    </table></td>
                                  </tr>
                                  <tr>
                                    <td valign="top">&nbsp;</td>
                                  </tr>
                                </table>
								</form>
								</td>
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
    <td valign="top" ><?php include_once('include/footer.php');?></td>
  </tr>
</table>
</body>
</html>
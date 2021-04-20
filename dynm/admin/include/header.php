<?php
update_htaccess();


/* $rss_str=createRSS();

$fp=@fopen(_PATH.'esthp.rss','w+');
@fwrite($fp,$rss_str);
@fclose($fp);

*/
//print_r($_SESSION);



?><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <!--<tr>
        <td valign="top" class="top_strip"><img src="images/spacer.gif" alt="" width="1" height="3"></td>
      </tr> -->
      <tr>
        <td valign="top" class="header_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" align="center" bgcolor="#FFFFFF"><a href="<?=_WWWROOT?>admin/home.php" title="<?=$sitename?>"><img src="images/logo.jpg" alt="<?=$sitename?>"  border="0"></a></td>
          </tr>
        </table></td>
      </tr>     
      <tr>
        <td valign="middle" class="nav_bg">
		<?php 
		//print_r($_SESSION);
		if(isset($_SESSION['AdminInfo']['id'])) 
		{
		?>
		<table  border="0" align="right" cellpadding="5" cellspacing="0" width="100%">
          <tr>
		  <td width="15%"><a href="../" target="_blank" class="white_text">Site Preview</a></td>
            <td width="70%" valign="middle" class="white_text" align="center">You are logged in as: <strong><?=$_SESSION['AdminInfo']['User']?></strong> [<a href="update-profile.php" class="myaccount">My Account</a>]  <?php if(!empty($_SESSION['AdminInfo']['was_superadmin']))
			{
			?>[<a href="home.php?mode=swich2superadmin" class="myaccount">Switch Back to Super Admin Panel</a>]<?php
			}
			?>

<!--			[<a href="add-user.php?mode=edit&UserId=<? //=$_SESSION['AdminInfo']['id']?>&page=<? //=$_REQUEST['page']?>" class="myaccount">My Account</a>] -->
			


			</td>
            <td width="10%" valign="middle" align="right"><img src="images/logout.gif" alt="" width="26" height="27"></td>
            <td width="5%" valign="middle" align="right"><a href="logout.php" class="white_link">Logout</a></td>
           
          </tr>
        </table>
		<?php 
		}
		 ?>
		</td>
      </tr>
      <tr>
        <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
      </tr>     
    </table>
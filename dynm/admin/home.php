<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");

//print_r($_SESSION);
//Array ( [AdminInfo] => Array ( [id] => 10 [User] => gaurav [is_superadmin] => 0 [was_superadmin] => 1 ) )
//Array ( [AdminInfo] => Array ( [id] => 10 [User] => gaurav [is_superadmin] => 0 [was_superadmin] => 1 ) )
//Array ( [AdminInfo] => Array ( [id] => 1 [User] => Pankaj [is_superadmin] => 1 ) )

if($_REQUEST['mode']=='swich2superadmin')
{
	$admin_id=$_SESSION['AdminInfo']['was_superadmin'];
	
	$_SESSION['AdminInfo']['was_superadmin']=0;
	unset($_SESSION['AdminInfo']['was_superadmin']);
	
	$admin_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$admin_id."'");
	$admin_count = $admin_arr['count'];
	$admin_data = $admin_arr['Data'];
	$admin_id = $admin_data['UserId'];
	$admin_name = $admin_data['FirstName'];
	
	$_SESSION['AdminInfo']['is_superadmin']=1;
	$_SESSION['AdminInfo']['id'] = $admin_id;
	$_SESSION['AdminInfo']['User'] = $admin_name ;	

	header("location:home.php");
	exit;
}

$AuthAdmin->ChkLogin();

if($_REQUEST['msg']=='unauthorized')
{
	$message="<span class=\"loginErrBox\">Your are not authorized to view the requested page.<span>";
}

if($_REQUEST['msg']=='profile_updated')
{
	$message="<span class=\"logoutMsgBox\">Your profile has been updated successfully.</span>";
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
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a></div></td></tr>
 <tr>
  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
     <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
     <td width="14" valign="top">&nbsp;</td>
     <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
       <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
     <tr>
		 <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
		 <td><h1>Welcome to <?=$sitename?> Administrative Panel</h1></td>
    </tr>
	</table></td>
     </tr>
     <tr><td valign="top"><img src="images/spacer.gif" alt="" width="1" height="35"></td></tr>
	 <tr>
      <td valign="top" align="center"><table width="580" border="0" cellspacing="0" cellpadding="0">
	<?php
	if(!empty($message))
	{
	?>
	<tr>
         <td align="center" colspan="4" height="50" valign="middle" style="padding:10px;"><?=$message?></td>
    </tr>
		  <?php
		  }
		  ?>
		  <?php
		/* $unread_cmt_data = $sql->SqlRecords("esthp_tblComments","where cmt_is_read='0'");
		$unread_cmt_count = $unread_cmt_data['count'];
		$unread_cmt_arr = $unread_cmt_data['Data']; */
		 ?>
		 <?php
		 	if($_SESSION['AdminInfo']['is_superadmin']!=0)
			{
		 ?>
        <tr>
         <td width="20" valign="top">&nbsp;</td>
         <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-user-categories.php" class="cat_link">Manage Clinic Categories</a></td>
         <td width="95" valign="top">&nbsp;</td>
		 <?php
		/* $unapp_cmt_data = $sql->SqlRecords("esthp_tblComments","where cmt_status='unapproved'");
		$unapp_cmt_count = $unapp_cmt_data['count'];
		$unapp_cmt_arr = $unapp_cmt_data['Data']; */
		 ?>
         <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-user.php" class="cat_link">Manage Clinics </a> </td>
        </tr>
        <tr>
          <td height="24" valign="top">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
         <td valign="top">&nbsp;</td>
		 <?php
		/* $all_cmt_data = $sql->SqlRecords("esthp_tblComments","where 1=1");
		$all_cmt_count = $all_cmt_data['count'];
		$all_cmt_arr = $all_cmt_data['Data'];
		*/
		 ?>
         <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-customers.php" class="cat_link">Manage Users</a></td>
         <td valign="top">&nbsp;</td>
		 <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="inbox.php" class="cat_link"> 	Message Center</a></td>
		 <?php
		/* $all_vid_data = $sql->SqlRecords("esthp_tblVideos","where 1=1");
		$all_vid_count = $all_vid_data['count'];
		$all_vid_arr = $all_vid_data['Data'];
		*/
		 ?>
         <!--<td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-videos.php" class="cat_link"><? //=$all_vid_count?> <? //=$all_vid_count>1?'Videos':'Video'?></a> </td>-->
       </tr>
 	   <tr>
		 <td height="24" valign="top">&nbsp;</td>
		 <td valign="middle">&nbsp;</td>
		 <td valign="top">&nbsp;</td>
		 <td valign="top">&nbsp;</td>
	   </tr>
	   <?php } 
	   else 
	   {
	   ?>
	   <tr>
         <td width="20" valign="top">&nbsp;</td>
        <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-user.php" class="cat_link">Manage Clinics </a> </td>
         <td width="95" valign="top">&nbsp;</td>
         <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-customers.php" class="cat_link">Manage Users</a></td>
        </tr>
        <tr>
          <td height="24" valign="top">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
          <td valign="top">&nbsp;</td>
          <td valign="top">&nbsp;</td>
        </tr>
		<tr>
         <td width="20" valign="top">&nbsp;</td>
        <td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="inbox.php" class="cat_link"> 	Message Center </a> </td>
         <td width="95" valign="top">&nbsp;</td>
         <td width="230" valign="middle">&nbsp;</td>
        </tr>
	   <?php } ?>
	           <tr>
         <td valign="top">&nbsp;</td>
		 <?php
		/* $all_comp_data = $sql->SqlRecords("esthp_tblCompanies","where 1=1");
		$all_comp_count = $all_comp_data['count'];
		$all_comp_arr = $all_comp_data['Data'];
		*/
		 ?>
         <!--<td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-companies.php" class="cat_link"><? //=$all_comp_count?> <? //=$all_comp_count>1?'Companies':'Company'?></a></td> -->
         <td valign="top">&nbsp;</td>
		 <?php
		/* $all_cat_data = $sql->SqlRecords("esthp_tblProdCat","where 1=1");
		$all_cat_count = $all_cat_data['count'];
		$all_cat_arr = $all_cat_data['Data'];
		*/
		 ?>
         <!--<td width="230" valign="middle" class="catelist_bg"><img src="images/cate_bullets.gif" alt="" width="12" height="12" class="pad15"><a href="list-categories.php" class="cat_link"><? //=$all_cat_count?> <? //=$all_cat_count>1?'Categories':'Category'?></a> </td>-->
       </tr>
       </table></td>
      </tr>
      <tr> <td valign="top">&nbsp;</td>  </tr>
     </table></td>
    </tr>
    </table></td>
   </tr>
   <tr> <td valign="top"><?php include_once('include/footer.php');?></td> </tr>
 </table>
</body>
</html>
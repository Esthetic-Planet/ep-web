<?php 
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthAdmin->ChkLogin();

//echo "<pre>";
//print_r($_SESSION);
/*if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
}  */

if($_REQUEST['mode']=='login')
{
	$admin_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$_REQUEST['UserId']."'");
	$admin_count = $admin_arr['count'];
	$admin_data = $admin_arr['Data'];
	$admin_id = $admin_data['UserId'];
	$admin_name = $admin_data['FirstName'];
	
	if($admin_count>0)
	{
		$_SESSION['AdminInfo']['was_superadmin'] = $_SESSION['AdminInfo']['id'] ;
		$_SESSION['AdminInfo']['is_superadmin'] = 0;
		$_SESSION['AdminInfo']['id'] = $admin_id;
		$_SESSION['AdminInfo']['User'] = $admin_name ;			
		
		header("Location: home.php");
		exit;
	}
}
$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

if(!empty($_REQUEST['sort_feild']))
{
	$sort_feild=$_REQUEST['sort_feild'];
}
else
{
	$sort_feild='addedDate';
}

if(!empty($_REQUEST['sort_order']))
{
	$sort_order=$_REQUEST['sort_order'];
}
else
{
	$sort_order='desc';
}

// single Delete start
if($_REQUEST['delid']!="")
{
			$user_cond = " WHERE UserId= '".$_REQUEST['delid']."' "; 						
			$user_arr = $sql->SqlSingleRecord('esthp_tblUsers',$user_cond);
			$user_count = $user_arr['count'];
			$user_data = $user_arr['Data'];
			
			$id_del = $_REQUEST['delid'];
			$ConArr_del = " WHERE UserId= '$id_del' "; 
			$arrArticles_del = $sql->SqlSingleRecord('esthp_tblUsers',$ConArr_del);
			$count_del = $arrArticles_del['count'];
			$Data_del = $arrArticles_del['Data'];
			if($count_del>0)
			{
				$upload_dir= _UPLOAD_FILE_PATH."user_images/";
			
				$user_large_img =$Data_del['UserLargeImg'];
				$user_large_img_file=$upload_dir.$user_large_img ;
				@unlink($user_large_img_file);		
				
				$user_large_img_thumb_file=$upload_dir.'thumbs/'.$user_large_img ;
				@unlink($user_large_img_thumb_file);
				
				$upload_dir= _UPLOAD_FILE_PATH."user_images/small/";
				
				$user_small_image =$Data_del['UserSmallImg'];
				$user_small_image_file=$upload_dir.$user_small_image ;
				@unlink($user_small_image_file);
			
				$delid=$_REQUEST['delid'];
				$cond = " UserId = ".$delid;
				$sql->SqlDelete('esthp_tblUsers',$cond);
				
				echo "<body>";
				echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-user.php">';
				echo '<input type="hidden" name="msg" id="msg" value="deleted">';
				echo '<input type="hidden" name="page" value="'.$page.'">';
				echo '<script type="text/javascript">document.frmSu.submit();</script>';
				echo '</body>';
				exit;
			}
}
// single Delete end

// multi Delete start
/* 
if($_REQUEST['task']=='deleteAll' && (count($_REQUEST['chk'])>0))
{
	$webPages=$_REQUEST['chk'];
	
	for($i=0;$i<count($webPages);$i++)
	{
			// check the existance of record
			$ConArr_del="";
			$id_del="";
			$count_del="";
			$Data_del="";
			$id_del = $webPages[$i];
			$ConArr_del = " WHERE UserId= '$id_del' "; 						
			$arrArticles_del = $sql->SqlSingleRecord('citylifetv_tblUsers',$ConArr_del);
			$count_del = $arrArticles_del['count'];
			$Data_del = $arrArticles_del['Data'];
			if($count_del>0) // if record found
			{
				$cond = " UserId = ".$webPages[$i];
				$sql->SqlDelete('citylifetv_tblUsers',$cond);
			}	
	}
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-user.php">';
	echo '<input type="hidden" name="msg" id="msg" value="deleted">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
}
*/
// multi Delete end

$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';

if($msg=='added')
	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";
else if($msg=='updated')
	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";
else if($msg=='deleted')
	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";

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
<link href="script/pager.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-user.php">Manage Clinics</a></div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
		<td height="25" valign="top" class="grey_bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0"> <tr><td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
		<td><h1>List Clinics </h1></td>
		</tr>
		</table>
		</td>
		 </tr>
		 <tr><td valign="top" height='20' align="center">&nbsp;</td></tr>
		 <?php
		if(!empty($message))
		{
		?>
		<tr>
		<td valign="top" style="padding:15px;" align="center"><?=$message?></td>
		</tr>
		<?php
		}
		?>
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5"></td>
          </tr>
		<?php
		 $search_text=trim($_REQUEST['search_text']);
		 
		$records_per_page=50;				
		$offset = ($page-1) * $records_per_page;
		$cond="where UserId!='1'";
		
		if(!empty($search_text))
		{

			$cond.=" and (ClinicName like '%".$search_text."%' or City like '%".$search_text."%' or State like '%".$search_text."%' or Country like '%".$search_text."%' or Zip like '%".$search_text."%')";
		}
		
		$orderby=" order by ".$sort_feild." ".$sort_order;
		
		$admin_arr = $sql->SqlRecords("esthp_tblUsers",$cond,$orderby,$offset,$records_per_page);
		$count_total=$admin_arr['TotalCount'];
		$count = $admin_arr['count'];
		$Data = $admin_arr['Data'];
		 ?>
		          <tr>
          <td valign="top" align="center">
		<form method="get" action="" name="clinicSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">
               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Clinic</td>
		</tr>
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Text :</td>
                <td width='10' align="left" valign="middle">&nbsp;</td>
                <td width="334" align="left" valign="middle" class="normal_text_blue">	<input name="search_text" id="search_text"  type="text" class="input_white" size="48" value="<?=$search_text?>" ><br/> (clinic name, city, state, country, zip)</td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Search">
				</td>
              </tr>
		</table>
		</form>
		<div style="height:15px;"></div>
		</td>
		</tr>
          <tr>
<td valign="top">
<form method="post" action="" name="frmUsers">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php
		if(!empty($search_text))
		{
			?>
			   <tr>
                    <td valign="middle" align="left"  class="black_text" height='35'>Showing results for: <?=$search_text?></td></tr>
			<?php
		}
		?>
<tr>
<td height="25" valign="middle" align="left">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td valign="top" align="left" width="15%">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<!--<td align="center" valign="top"><a href="javascript:void(0)" class="add_del" onClick="multiDelete()">Delete Selected</a></td> -->
<!--<td align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td> -->
<?php
if($_SESSION['AdminInfo']['is_superadmin']==1)
{
?>
<td align="center" valign="top"><a href="add-user.php" class="add_del">Register Clinic </a></td>
<?php } ?>
</tr>
</table>
</td>
<td align="right" valign="top" width="85%">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="right" valign="middle" >
		<table style="font-size:9px;">
		<tr><td>Page:</td>
		<td>
		<?php	
		$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
		foreach ($qsA as $k=>$v) $qs .= "&$k=$v";						
		$url = "?page={@PAGE}&$qs";
		$pager = new pager($url, $count_total, $records_per_page, $page);						
		$pager->outputlinks();						
		?>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		</td>
              </tr>
              <tr>
                <td valign="top" class="border">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				 <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
				 <?php
				 if($count>0)
					{
					?>
					 <tr class="left_headbg">
					     <td width="5%" align="left" class="white_text">#</td>
					
						<!--<td width="10%" class="white_text"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td> -->
						 <td width="20%" class="white_text"><?php				 
						 if($sort_feild=='ClinicName')
						 {
						 	if($sort_order=='asc')
								$reverse_cliname='desc';
							else if($sort_order=='desc')
								$reverse_cliname='asc';
						 ?>
						<a href='list-user.php?sort_feild=ClinicName&sort_order=<?=$reverse_cliname?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Clinic Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=ClinicName&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Clinic Name</a> 
						 <?php
						 }
						?></td>
						  <td width="10%" class="white_text">Category</td>
						  	  <td width="5%" align="left" class="white_text">Display </td>
						  
						  
						<td width="10%" class="white_text"><?php				 
						 if($sort_feild=='ClinicName')
						 {
						 	if($sort_order=='asc')
								$reverse_cityname='desc';
							else if($sort_order=='desc')
								$reverse_cityname='asc';
						 ?>
						<a href='list-user.php?sort_feild=City&sort_order=<?=$reverse_cityname?>&search_text=<?=$search_text?>&page=<?=$page ?>'>City</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=City&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>City</a> 
						 <?php
						 }
						?></td>
						<td width="10%" class="white_text"><?php				 
						 if($sort_feild=='State')
						 {
						 	if($sort_order=='asc')
								$reverse_statename='desc';
							else if($sort_order=='desc')
								$reverse_statename='asc';
						 ?>
						<a href='list-user.php?sort_feild=State&sort_order=<?=$reverse_statename?>&search_text=<?=$search_text?>&page=<?=$page ?>'>State</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=State&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>State</a> 
						 <?php
						 }
						?></td>
						<td width="5%" class="white_text"><?php				 
						 if($sort_feild=='Zip')
						 {
						 	if($sort_order=='asc')
								$reverse_zip='desc';
							else if($sort_order=='desc')
								$reverse_zip='asc';
						 ?>
						<a href='list-user.php?sort_feild=Zip&sort_order=<?=$reverse_zip?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Zip</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=Zip&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Zip</a> 
						 <?php
						 }
						?></td>
						<td width="10%" class="white_text"><?php				 
						 if($sort_feild=='Country')
						 {
						 	if($sort_order=='asc')
								$reverse_country='desc';
							else if($sort_order=='desc')
								$reverse_country='asc';
						 ?>
						<a href='list-user.php?sort_feild=Country&sort_order=<?=$reverse_country?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Country</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=Country&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Country</a> 
						 <?php
						 }
						?></td>	
						<td width="5%" align="center" class="white_text"><?php				 
						 if($sort_feild=='IsActive')
						 {
						 	if($sort_order=='asc')
								$reverse_status='desc';
							else if($sort_order=='desc')
								$reverse_status='asc';
						 ?>
						<a href='list-user.php?sort_feild=IsActive&sort_order=<?=$reverse_status?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-user.php?sort_feild=IsActive&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						?></td>
						<?php
						if($_SESSION['AdminInfo']['is_superadmin']==1)
						{
						?>
						<td width="6%" align="center" class="white_text">Login</td>
						<?php } ?>
                        <td width="7%" align="center" class="white_text">Edit</td>
						<td width="7%" align="center" class="white_text">Delete</td>
						</tr>


						<?php
						if($_SESSION['AdminInfo']['is_superadmin']==1)
						{
							for($i=0; $i<$count; $i++)
							{
							?>
							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>
							<td class="black_text" ><?=($offset+$i+1)?></td>
							
							
							
							<!-- <td height="25"  class="black_text"><input type="checkbox" name="chk[]" value="<?//=$Data[$i]['UserId']?>" <? //=$Data[$i]['UserId']==1?'disabled':''?>></td> -->
						<td  class="black_text" ><?=$Data[$i]['ClinicName']?></td>
						
						  <td  class="black_text" ><?php
						  $user_cat_str_arr=array();
						  if(trim($Data[$i]['UserCategories'])!='')
						  {
						  	$user_cat_arr=explode(',',$Data[$i]['UserCategories']);
							
							foreach($user_cat_arr as $user_cat_id)
							{
								$cat_name_arr=$sql->SqlSingleRecord('esthp_tblUserCat',"where cat_id='".$user_cat_id."'");
								$user_cat_str_arr[]=$cat_name_arr['Data']['cat_name'];
							}
						  }
						  
						  echo $user_cat_str=implode(', ',$user_cat_str_arr);
						  ?></td>
						  <td  class="black_text" ><?=$Data[$i]['display_order']?></td>
						 <td class="black_text" ><?=$Data[$i]['City']?></td>
						 <td class="black_text" ><?=$Data[$i]['State']?></td>
						 <td class="black_text" ><?=$Data[$i]['Zip']?></td>
						 <td class="black_text" ><?=$Data[$i]['Country']?></td>
             			<?php $status=($Data[$i]['IsActive']=='t')? '<font color=green>+</font>' : '<font color=red>X</font>';?>
						<td align="center" class="black_text" ><?=$status?></td>
					<td  align="center" class="black_text">
						<a href="list-user.php?mode=login&UserId=<?=$Data[$i]['UserId']?>&page=<?=$page?>"><img src="images/login_button.gif" alt="" width="59" height="19" border="0"></a></td>
						<td  align="center" class="white_text"><a href="add-user.php?mode=edit&UserId=<?=$Data[$i]['UserId']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>
						 <td align="center" class="white_text" ><a href="javascript: void(0)" onclick="SingleDelete('list-user.php?delid=<?=$Data[$i]['UserId']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a>
						 </td>
						 </tr>
						 <?php
						 }
						 }
						 else {
						 	for($i=0; $i<$count; $i++)
							{
								if($_SESSION['AdminInfo']['id']==$Data[$i]['UserId'])
								{
									
							?>
							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>
							<td class="black_text" ><?=($offset+$i+1)?></td>
							<!-- <td height="25"  class="black_text"><input type="checkbox" name="chk[]" value="<?//=$Data[$i]['UserId']?>" <? //=$Data[$i]['UserId']==1?'disabled':''?>></td> -->
						<td  class="black_text" ><?=$Data[$i]['ClinicName']?></td>
						
						  <td  class="black_text" ><?php
						  $user_cat_str_arr=array();
						  if(trim($Data[$i]['UserCategories'])!='')
						  {
						  	$user_cat_arr=explode(',',$Data[$i]['UserCategories']);
							
							foreach($user_cat_arr as $user_cat_id)
							{
								$cat_name_arr=$sql->SqlSingleRecord('esthp_tblUserCat',"where cat_id='".$user_cat_id."'");
								$user_cat_str_arr[]=$cat_name_arr['Data']['cat_name'];
							}
						  }
						  
						  echo $user_cat_str=implode(', ',$user_cat_str_arr);
						  ?></td>
						 <td class="black_text" ><?=$Data[$i]['City']?></td>
						 <td class="black_text" ><?=$Data[$i]['State']?></td>
						 <td class="black_text" ><?=$Data[$i]['Zip']?></td>
						 <td class="black_text" ><?=$Data[$i]['Country']?></td>
             			<?php $status=($Data[$i]['IsActive']=='t')? '<font color=green>+</font>' : '<font color=red>X</font>';?>
						<td align="center" class="black_text" ><?=$status?></td>
						<td  align="center" class="white_text"><a href="add-user.php?mode=edit&UserId=<?=$Data[$i]['UserId']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>
						 <td align="center" class="white_text" ><a href="javascript: void(0)" onclick="SingleDelete('list-user.php?delid=<?=$Data[$i]['UserId']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a>
						 </td>
						 </tr>
						 <?php
						 
						 		}
							}
						 }
						 }
						 else
						 {
						 echo '<tr class="grey_bg"><td height="25" colspan="8" class="empty_record_txt">No records found.</td></tr>';
						 }
						?>
						</table></td>
						</tr>
						 </table>
						 </td></tr>
						 <tr><td valign="top">&nbsp;</td>
						 </tr></table>
						 </form>
			</td>
			 </tr>
			 <tr>
			   <td valign="top">&nbsp;</td>
			    </tr>
				</table></td>
				  </tr>
				  </table></td>
				   </tr>
				   <tr>
				    <td valign="top"><?php include_once('include/footer.php');?></td>
					</tr>
					</table>
					<SCRIPT type=text/javascript>
function SingleDelete(url)
{	
	if(confirm("Are you sure you want to delete the selected Record(s)?"))
	{
	document.location=url;
	}
}

function checkall(state)
{
	var frm =document.frmUsers;
	var n =frm.elements.length;
	for (i=0; i<n; i++)
	{
		if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;
	}
}
function multiDelete()
{
	var frm =document.frmUsers;
	var n =frm.elements.length;
	var checkOne = false;
	for (i=0; i<n; i++)
	{
		if(frm.elements[i].checked ==true)
		{
			checkOne=true
		}
	}
	if(checkOne)
	{
		if(confirm("Are you sure you want to delete the selected Record(s)?"))
		{
			frm.action='?task=deleteAll';
			frm.submit();
		}
	}
	else
	{
		alert("please make a selection from a list");
		return false;
	}
}
</SCRIPT>
</body>
</html>
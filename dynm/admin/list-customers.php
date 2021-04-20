<?php 
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthAdmin->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
		   
if(!empty($_REQUEST['sort_feild']))
{
	$sort_feild=$_REQUEST['sort_feild'];
}
else
{
	$sort_feild='cust_date_added';
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
			
			$id_del = $_REQUEST['delid'];
			$ConArr_del = " WHERE cust_id= '$id_del' "; 
			$arrCust_del = $sql->SqlSingleRecord('esthp_tblCustomers',$ConArr_del);
			$count_del = $arrCust_del['count'];
			$Data_del = $arrCust_del['Data'];
			if($count_del>0)
			{
				$delid=$_REQUEST['delid'];
				$cond = " cust_id = ".$delid;
				$sql->SqlDelete('esthp_tblCustomers',$cond);
				echo "<body>";
				echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-customers.php">';
				echo '<input type="hidden" name="msg" id="msg" value="deleted">';
				echo '<input type="hidden" name="page" value="'.$page.'">';
				echo '<input type="hidden" name="sort_feild" value="'.$sort_feild.'">';
				echo '<input type="hidden" name="sort_order" value="'.$sort_order.'">';
				echo '<script type="text/javascript">document.frmSu.submit();</script>';
				echo '</body>';
				exit;
			}
}



// single Delete end


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

<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<link rel="stylesheet" href="js/thickbox.css" type="text/css" media="screen" />

<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">
<link href="script/pager.css" rel="stylesheet" type="text/css">

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-customers.php">Manage Users</a></div></td>
  </tr>
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
                <td><h1>List Users </h1></td>
              </tr>
            </table></td>
          </tr>
		  
		  
		  

            <tr>
             <td valign="top" style="padding:15px;" align="center"><?=$message?></td>
          </tr>
		  
		  
		  <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5"></td>
          </tr>

          
		 <?php
		$records_per_page=50;				
		 $offset = ($page-1) * $records_per_page;
		$cond="where 1=1";
		
		
		if(!empty($search_text))
		{

			$cond.=" and (cust_email like '%".$search_text."%' or  cust_fname like '%".$search_text."%' or cust_lname like '%".$search_text."%' or cust_state like '%".$search_text."%' or cust_city like '%".$search_text."%'  or cust_country like '%".$search_text."%' or cust_zip like '%".$search_text."%')";

		}
		
		
		$orderby=" ORDER BY ".$sort_feild." ".$sort_order;
		$webPage = $sql->SqlRecords("esthp_tblCustomers",$cond,$orderby,$offset,$records_per_page);
		$count_total=$webPage['TotalCount'];
		$count = $webPage['count'];
		$Data = $webPage['Data'];
		
		
		
		if($_SESSION['AdminInfo']['is_superadmin']!=1)
		{
$clid = $_SESSION["AdminInfo"]["id"];
						 $query_sel = "SELECT * from esthp_tblUsers where UserId='$clid'";
						$res_sel = $sql->SqlExecuteQuery($query_sel);
						$Data_clid = $res_sel["Data"][0];
						$count_clid = $res_sel["count"];
						
						$catid = explode(",",$Data_clid["UserCategories"]);
						
						for($m=0; $m<count($catid); $m++)
						{
							 $ctid = $catid[$m];
							if($ctid == "2")
							{
								$table = "esthp_dentalcare";
								$query_ulist_val= "SELECT distinct d.UserId, u.* FROM esthp_dentalcare as d, esthp_tblCustomers as u where d.clinicid='$clid' and d.`UserId`=u.cust_id";
								/*$res_dental = $sql->SqlExecuteQuery($query_ulist_dental);
								$Data_dental = $res_dental["Data"];
								$count_dental = $res_dental["count"];*/
							}
							if($ctid == "3")
							{
								$table = "esthp_haircare";
								$query_ulist_val = "SELECT distinct h.UserId, u.* FROM esthp_haircare as h, esthp_tblCustomers as u where h.clinicid='$clid' and h.`UserId`=u.cust_id";
								/*$res_hair = $sql->SqlExecuteQuery($query_ulist_hair);
								$Data_hair = $res_hair["Data"];
								$count_hair = $res_hair["count"];*/
							}
							if($ctid == "4")
							{
								$table = "esthp_eyecare";
								$query_ulist_val= "SELECT distinct e.UserId, u.* FROM esthp_eyecare as e, esthp_tblCustomers as u where e.clinicid='$clid' and e.`UserId`=u.cust_id";
								/*$res_eye = $sql->SqlExecuteQuery($query_ulist_eye);
								$Data_eye = $res_eye["Data"];
								$count_eye = $res_eye["count"];*/
							}
							if($ctid == "6")
							{
								$table = "esthp_plasticsurgery";
								 $query_ulist_val = "SELECT distinct p.UserId, u.* FROM esthp_plasticsurgery as p, esthp_tblCustomers as u where p.clinicid='$clid' and p.`UserId`=u.cust_id";
								/*$res_sel_plastic = $sql->SqlExecuteQuery($query_ulist_plastic);
								$Data_plastic = $res_sel_plastic["Data"];
								$count_plastic = $res_sel_plastic["count"];*/
							}
						}
						//$res_user_val1 = $sql->SqlExecuteQuery($query_ulist_val);
						//$count_plastic_page = $res_user_val1["count"];
						//$query_ulist_val .= " LIMIT ".$offset." , $records_per_page";
						$res_user_val = $sql->SqlExecuteQuery($query_ulist_val);
						$Data_plastic = $res_user_val["Data"];
						$count_plastic = $res_user_val["count"];
						$getarruserId=array();
					
						for($mnc=0; $mnc<$count_plastic; $mnc++)
						{
												 
						$getarruserId[]=$Data_plastic[$mnc]['UserId'];
						$getarrusercust_id[]=$Data_plastic[$mnc]['cust_id'];
						$getarrusercust_fname[]=$Data_plastic[$mnc]['cust_fname'];
						$getarrusercust_lname[]=$Data_plastic[$mnc]['cust_lname'];
						$getarrusercust_email[]=$Data_plastic[$mnc]['cust_email'];
						$getarrusercust_date_added[]=$Data_plastic[$mnc]['cust_date_added'];
						$getarrusercust_country[]=$Data_plastic[$mnc]['cust_country'];
						$getarrusercust_status[]=$Data_plastic[$mnc]['cust_status'];
						
						}
						 $getuserIdimp=implode(',',$getarruserId);
						//$offset1=$offset-$count_plastic_page;
						//if($offset1 <0)$offset1=0;
						//$records_per_page1=$records_per_page-$count_plastic;
						 //	$query_ulist_val .= " LIMIT ".$offset1." , $records_per_page1";
						 if(count($getarruserId) >0)
						 {
						///get alldata from email except from form submitting in (surgery, ....) etc... 
						   $query_ulist_val_com = "SELECT distinct p.mail_sender,p.mail_reciever, u.* FROM esthp_mails as p, esthp_tblCustomers as u where  p.mail_reciever='$clid' and p.mail_sender Not IN(".$getuserIdimp.")  and p.mail_sender=u.cust_id";
						  }
						  else
						  {
						    $query_ulist_val_com = "SELECT distinct p.mail_sender,p.mail_reciever, u.* FROM esthp_mails as p, esthp_tblCustomers as u where  p.mail_reciever='$clid'  and p.mail_sender=u.cust_id";
						  } 
						 // $res_user_val_com1 = $sql->SqlExecuteQuery($query_ulist_val_com);
						 // $count_plastic_com_page = $res_user_val_com1["count"];
						   // $query_ulist_val_com .= " LIMIT ".$offset1." , $records_per_page1";
						$res_user_val_com = $sql->SqlExecuteQuery($query_ulist_val_com);
						$Data_plastic_com = $res_user_val_com["Data"];
						 $count_plastic_com = $res_user_val_com["count"];
						 //$count_total=$count_plastic_page+$count_plastic_com_page;
						 
						if($count_plastic_com >0 )
						{
						
							for($mncm=0; $mncm<$count_plastic_com; $mncm++)
								{
												 
							$getarruserId[]=$Data_plastic_com[$mncm]['cust_id'];
							$getarrusercust_id[]=$Data_plastic_com[$mncm]['cust_id'];
							$getarrusercust_fname[]=$Data_plastic_com[$mncm]['cust_fname'];
							$getarrusercust_lname[]=$Data_plastic_com[$mncm]['cust_lname'];
							$getarrusercust_email[]=$Data_plastic_com[$mncm]['cust_email'];
							$getarrusercust_date_added[]=$Data_plastic_com[$mncm]['cust_date_added'];
							$getarrusercust_country[]=$Data_plastic_com[$mncm]['cust_country'];
							$getarrusercust_status[]=$Data_plastic_com[$mncm]['cust_status'];
						
								}
						}
				}		
		
		
		 ?>
		 
		 
		 		 
		          <tr>

          <td valign="top" align="center">
		  
		  
		  
		  
		  
		<form method="get" action="" name="userSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">

               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search User</td>
		</tr>
		
		
		              <tr>
		                <td colspan="3" height="10"></td>
	                  </tr>
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Text :</td>
                <td width='10' align="left" valign="middle">&nbsp;</td>
                <td width="334" align="left" valign="middle" class="normal_text_blue">	<input name="search_text" id="search_text"  type="text" class="input_white" size="48" value="<?=$search_text?>" ><br/> (user name, email, city, state, country, zip)</td>
              </tr>
			  

			  
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Search">				</td>
              </tr>
			    <tr>
		                <td colspan="3" height="10"></td>
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
			
                <td height="25" valign="middle">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				<td valign="top" width="20%" align="left">
						<table width="0%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						<td align="center" valign="top"><!--<a href="javascript:void(0)" class="add_del" onClick="multiDelete()">Delete Selected</a> --></td>
						<td align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>
						<td align="center" valign="top"><a href="add-customer.php" class="add_del">Register User</a></td>
						</tr>
						</table>
				</td>
				
				
				<td align="right" valign="top" width="80%">
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
                    <td valign="top">
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
					<?php 
					if($count>0)
					{ 
					?>
					
					 <tr class="left_headbg">
                        <td align='left' width="10%" class="white_text">S. No.</td>
						 <td align='left' width="10%" class="white_text"><?php				 
						 if($sort_feild=='cust_fname')
						 {
						 	if($sort_order=='asc')
								$reverse_fname='desc';
							else if($sort_order=='desc')
								$reverse_fname='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_fname&sort_order=<?=$reverse_fname?>&page=<?=$page ?>'>F-Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_fname&sort_order=asc&page=<?=$page ?>'>F-Name</a> 
						 <?php
						 }
						?></td>
						 <td align='left' width="10%" class="white_text"><?php				 
						 if($sort_feild=='cust_lname')
						 {
						 	if($sort_order=='asc')
								$reverse_lname='desc';
							else if($sort_order=='desc')
								$reverse_lname='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_lname&sort_order=<?=$reverse_lname?>&page=<?=$page ?>'>L-Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_lname&sort_order=asc&page=<?=$page ?>'>L-Name</a> 
						 <?php
						 }
						?></td>
						<td align='left' width="15%" class="white_text"><?php				 
						 if($sort_feild=='cust_email')
						 {
						 	if($sort_order=='asc')
								$reverse_email='desc';
							else if($sort_order=='desc')
								$reverse_email='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_email&sort_order=<?=$reverse_email?>&page=<?=$page ?>'>Email ID</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_email&sort_order=asc&page=<?=$page ?>'>Email ID</a> 
						 <?php
						 }
						?></td>
						<td align='left' width="15%" class="white_text"><?php				 
						 if($sort_feild=='cust_date_added')
						 {
						 	if($sort_order=='asc')
								$reverse_date='desc';
							else if($sort_order=='desc')
								$reverse_date='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_date_added&sort_order=<?=$reverse_date?>&page=<?=$page ?>'>Registered On</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_date_added&sort_order=asc&page=<?=$page ?>'>Registered On</a> 
						 <?php
						 }
						?></td>
						
						
						
						
						<td align='left' width="10%" class="white_text"><?php				 
						 if($sort_feild=='cust_country')
						 {
						 	if($sort_order=='asc')
								$reverse_country='desc';
							else if($sort_order=='desc')
								$reverse_country='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_country&sort_order=<?=$reverse_country?>&page=<?=$page ?>'>Country</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_country&sort_order=asc&page=<?=$reverse_country ?>'>Country</a> 
						 <?php
						 }
						?></td>
						
						
						<td align="center" width="10%"  class="white_text"><?php				 
						 if($sort_feild=='cust_status')
						 {
						 	if($sort_order=='asc')
								$reverse_status='desc';
							else if($sort_order=='desc')
								$reverse_status='asc';
						 ?>
						<a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_status&sort_order=<?=$reverse_status?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-customers.php?search_text=<?=$search_text?>&sort_feild=cust_status&sort_order=asc&page=<?=$reverse_status ?>'>Status</a> 
						 <?php
						 }
						?></td>
						<td align="center" width="10%" class="white_text">Edit</td>
						<?php 
						if($_SESSION['AdminInfo']['is_superadmin']==1)
						{ ?>
						
						<td align="center" width="10%" class="white_text">Delete</td>
						<td align="center" width="10%" class="white_text">&nbsp;</td>
						<td align="center" width="10%" class="white_text">&nbsp;</td>
						<?php } ?>
						<?php 
						if($_SESSION['AdminInfo']['is_superadmin']!=1)
						{ ?>
						<td align="center" width="10%" class="white_text">&nbsp;</td>
						<td align="center" width="10%" class="white_text">&nbsp;</td>
						<?php } ?>
                      </tr>
					
					<?php  
					if($_SESSION['AdminInfo']['is_superadmin']==1)
					{ 
						for($i=0; $i<$count; $i++)
						{
						?>
                      <tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

                        <td align='left' height="25" width="10%" class="black_text"><?=($offset+$i+1)?></td>
						
						 <td align='left' class="black_text" width="10%" style="text-decoration:underline;"><a href="add-customer.php?mode=edit&cust_id=<?=$Data[$i]['cust_id']?>&page=<?=$page?>"><?=$Data[$i]['cust_fname']?></a></td>
						 
						 <td align='left' class="black_text" width="10%"><?=$Data[$i]['cust_lname']?></td>
						 <td align='left' class="black_text" width="15%"><?=$Data[$i]['cust_email']?></td>
						 <td align='left' class="black_text" width="15%"><?=date('jS M Y H:i:s',strtotime($Data[$i]['cust_date_added']))?></td>
			
						<td align='left' class="black_text" width="10%"><?=$Data[$i]['cust_country']?></td>
						<td align="center" class="black_text" width="10%"><?php
						if($Data[$i]['cust_status']=='inactive')
						{
							echo "<font color='#ff0000'>".$Data[$i]['cust_status']."</font>";
						}
						else
						{
							echo $Data[$i]['cust_status'];
						}
						?></td>
						  <?php 
						//  if($_SESSION['AdminInfo']['is_superadmin']==1)
						//  { ?>
						<td  align="center" class="black_text" width="10%">
						<a href="add-customer.php?mode=edit&cust_id=<?=$Data[$i]['cust_id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>
						<td align="center" class="black_text" width="10%">
						<a href="javascript: void(0)" onclick="SingleDelete('list-customers.php?delid=<?=$Data[$i]['cust_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a>
						</td>
						<?php // } ?>
						
						   <td align='left' class="black_text" width="10%">
						   <a href="add-comment.php?cust_id=<?=$Data[$i]['cust_id']?>&clnicid=<?=$_SESSION["AdminInfo"]["id"]?>&height=300&amp;width=500&amp;modal=true" class="thickbox"><div class="app_booking">Add Comment</div></a></td>
						   <td align='left' class="black_text" width="10%">
						   <a href="view-comment.php?cust_id=<?=$Data[$i]['cust_id']?>&clnicid=<?=$_SESSION["AdminInfo"]["id"]?>&height=450&amp;width=650&amp;modal=true" class="thickbox"><div class="app_booking">View Comment</div></a></td>
						</tr>
						 <?php
						 }
					} else{ 
					 
						
						 for($mn=0; $mn<count($getarruserId); $mn++)
						{
					?>
						<tr <?=($mn%2==0)? 'class="grey_bg"' : ""?>>

                        <td align='left' height="25" width="10%" class="black_text"><?=($offset+$mn+1)?></td>
						
						 <td align='left' class="black_text" width="10%" style="text-decoration:underline;"><a href="add-customer.php?mode=edit&cust_id=<?=$getarrusercust_id[$mn]?>&page=<?=$page?>"><?=$getarrusercust_fname[$mn]?></a></td>
						 
						 <td align='left' class="black_text" width="10%"><?=$getarrusercust_lname[$mn]?></td>
						 <td align='left' class="black_text" width="15%"><?=$getarrusercust_email[$mn]?></td>
						 <td align='left' class="black_text" width="15%"><?=date('jS M Y H:i:s',strtotime($getarrusercust_date_added[$mn]))?></td>
			
						<td align='left' class="black_text" width="10%"><?=$getarrusercust_country[$mn]?></td>
						<td align="center" class="black_text" width="10%"><?php
						if($getarrusercust_status[$mn]=='inactive')
						{
							echo "<font color='#ff0000'>".$getarrusercust_status[$mn]."</font>";
						}
						else
						{
							echo $getarrusercust_status[$mn];
						}
						?></td>
						<td  align="center" class="black_text" width="10%">
						<a href="add-customer.php?mode=edit&cust_id=<?=$getarrusercust_id[$mn]?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>
						   <td align='left' class="black_text" width="10%">
						   <a href="add-comment.php?cust_id=<?=$getarrusercust_id[$mn]?>&clnicid=<?=$_SESSION["AdminInfo"]["id"]?>&height=300&amp;width=500&amp;modal=true" class="thickbox"><div class="app_booking">Add Comment</div></a></td>
						   <td align='left' class="black_text" width="10%">
						   <a href="view-comment.php?cust_id=<?=$getarrusercust_id[$mn]?>&clnicid=<?=$_SESSION["AdminInfo"]["id"]?>&height=450&amp;width=650&amp;modal=true" class="thickbox"><div class="app_booking">View Comment</div></a></td>
						</tr>
						<?php		
						}			
					}
						 }
						 else
						 {
						 	echo '<tr class="grey_bg"><td height="25" colspan="8" class="empty_record_txt">No records found.</td></tr>';
						}
						?>
						</table>
						</td>
						</tr>
						</table></td>
						 </tr>
						 <tr>
						 <td valign="top">&nbsp;</td>
						 </tr>
						 </table>
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




<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthAdmin->ChkLogin();

$franchise_id=$_SESSION['AdminInfo']['id'];

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

/* 
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

*/

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
			$arrArticles_del = $sql->SqlSingleRecord('esthp_tblUsers',$ConArr_del);
			$count_del = $arrArticles_del['count'];
			$Data_del = $arrArticles_del['Data'];
			if($count_del>0) // if record found
			{
				$cond = " UserId = ".$webPages[$i];
				$sql->SqlDelete('esthp_tblUsers',$cond);
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

/* 
$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';

if($msg=='added')
	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";
else if($msg=='updated')
	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";
else if($msg=='deleted')
	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";
	
*/

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
    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-cust-franchise.php">Manage Customers</a></div></td>
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
                <td><h1>List Customers </h1></td>
              </tr>
            </table></td>
          </tr>
            <?php
			if($message!='')
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
		   
		   

		   
//print_r($_SESSION);
		   
		$records_per_page=10;				
		$offset = ($page-1) * $records_per_page;
		$cond="WHERE cust_franchise='".$franchise_id."'";
		$orderby=" ORDER BY ".$sort_feild." ".$sort_order;
		$webPage = $sql->SqlRecords("esthp_tblCustomers",$cond,$orderby,$offset,$records_per_page);
		$count_total=$webPage['TotalCount'];
		$count = $webPage['count'];
		$Data = $webPage['Data'];
		  ?>
          <tr>
          <td valign="top">
	<form method="post" action="" name="frmUsers">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			
                <td height="25" valign="middle">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>

				
				<td align="right" valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
						<td align="right" valign="middle" class="paging_bg">
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
						<a href='list-cust-franchise.php?sort_feild=cust_fname&sort_order=<?=$reverse_fname?>&page=<?=$page ?>'>F-Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-cust-franchise.php?sort_feild=cust_fname&sort_order=asc&page=<?=$page ?>'>F-Name</a> 
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
						<a href='list-cust-franchise.php?sort_feild=cust_lname&sort_order=<?=$reverse_lname?>&page=<?=$page ?>'>L-Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-cust-franchise.php?sort_feild=cust_lname&sort_order=asc&page=<?=$page ?>'>L-Name</a> 
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
						<a href='list-cust-franchise.php?sort_feild=cust_email&sort_order=<?=$reverse_email?>&page=<?=$page ?>'>Email ID</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-cust-franchise.php?sort_feild=cust_email&sort_order=asc&page=<?=$page ?>'>Email ID</a> 
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
						<a href='list-cust-franchise.php?sort_feild=cust_date_added&sort_order=<?=$reverse_date?>&page=<?=$page ?>'>Registered On</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-cust-franchise.php?sort_feild=cust_date_added&sort_order=asc&page=<?=$page ?>'>Registered On</a> 
						 <?php
						 }
						?></td>
						<td align="center" width="10%"  class="white_text">Status</td>
						<td align="center" width="10%" class="white_text">Details</td>
					
                      </tr>
					  
					  
					<?php
						for($i=0; $i<$count; $i++)
						{
						?>
                      <tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

                        <td align='left' height="25" width="10%" class="black_text"><?=($offset+$i+1)?></td>
						 <td align='left' class="black_text" width="10%"><?=$Data[$i]['cust_fname']?></td>
						 <td align='left' class="black_text" width="10%"><?=$Data[$i]['cust_lname']?></td>
						 <td align='left' class="black_text" width="15%"><?=$Data[$i]['cust_email']?></td>
						 <td align='left' class="black_text" width="15%"><?=date('jS M Y H:i:s',strtotime($Data[$i]['cust_date_added']))?></td>
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

						  
						<td  align="center" class="black_text" width="10%">
						<a href="view-cust-franchise.php?cust_id=<?=$Data[$i]['cust_id']?>&page=<?=$page?>"><img src="images/view_button.gif" alt="" width="59" height="19" border="0"></a></td>
						</tr>
						 <?php
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




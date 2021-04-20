<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
include_once(_CLASS_PATH."pager.cls.php");

$AuthAdmin->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$adminTimezone = "GMT+05:30";

// single Delete start
if($_REQUEST['delid']!="")
{
	$id_del = $_REQUEST['delid'];
	$action = "";
	if(isset($_REQUEST["action"]) && strtoupper($_REQUEST["action"]) == "DELETE")
	{
		 $ConArr_del =   " WHERE mail_Id = '$id_del' ";
		$arrArticles_del = $sql->SqlSingleRecord('esthp_mails',$ConArr_del);
		 $count_del = $arrArticles_del['count'];
		$Data_del = $arrArticles_del['Data'];	 
		if($count_del>0)
		{
		
				$delid=$_REQUEST['delid'];
				$ConArr['mail_RecieverDelete'] = 1;
				$CondArr = " WHERE mail_Id = '$id_del' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);
				header("location:inbox.php?msg=deleted");
				die();
			
		}
	}	
}

// single Delete end
// multi Delete start
if($_REQUEST['task']=='deleteAll' && (count($_REQUEST['chk'])>0))
{
	$messages = $_REQUEST['chk'];
	for($i=0;$i<count($messages);$i++)
	{
		// check the existance of record
		$ConArr_del="";
		$id_del="";
		$count_del="";
		$Data_del="";
	
		$id_del = $messages[$i];
		$ConArr_del =   " WHERE mail_Id = '$id_del' ";
		$arrArticles_del = $sql->SqlSingleRecord('esthp_mails',$ConArr_del);
		$count_del = $arrArticles_del['count'];
		$Data_del = $arrArticles_del['Data'];	 
		if($count_del>0)
		{
			
				$delid=$_REQUEST['delid'];
				$ConArr['mail_RecieverDelete'] = 1;
				$CondArr = "  WHERE  mail_Id = '$id_del' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);
			
		}
	}
	header("location:inbox.php?msg=deleted");
	die();
}



// multi Delete end

$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';
if($msg=='added')
	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";
else if($msg=='update')
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
  <tr>    <td valign="top"><?php include_once('include/header.php');?></td>  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
       <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
       <td width="14" valign="top">&nbsp;</td>
       <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>          
           <td><h1>Manage Inbox </h1></td>
          </tr>
         </table></td>
        </tr>
        <tr><td valign="top" style="padding:15px;" align="center"><?=$message?></td></tr>
        <tr><td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5"></td></tr>
<?php	$sortOrder = " mail_Id DESC";

		if(isset ($_GET["sort"]) && $_GET["sort"] != "")
		{
			$sortOrder = $_GET["sort"];
			
			
			
			/* if( stripos($sortOrder,"UserName") === false)
			{
				//$sortOrder = 'mail_' .$sortOrder;
				$sortOrder = $sortOrder;			
			} 
			*/
			
		}
		
		//$records_per_page = $conf_row["pagingSize"];
		$records_per_page = "50";
		
		$offset = ($page-1) * $records_per_page;
		
		
		
		if($_SESSION['AdminInfo']['is_superadmin']==1)
		{
			$cond = " WHERE 1=1 and (mail_type='customer_to_clinic' or mail_type='clinic_to_customer') and mail_RecieverDelete = 0 ";
		}
		else
		{
			$cond = "WHERE mail_reciever = ". $_SESSION["AdminInfo"]["id"]." and mail_type='customer_to_clinic' and mail_RecieverDelete = 0  ";		
		}
		
		//$cond = "WHERE A.mail_reciever = ". $_SESSION["AdminInfo"]["id"]." and A.mail_RecieverDelete = 0  ";
		
		//$cond1 = " WHERE A.mail_sender = U.cust_id and A.mail_RecieverDelete = 0";
		
		
		$orderby = " ORDER BY ".$sortOrder;

		$total_Page = $sql->SqlRecords("esthp_mails",$cond,$orderby,$offset,$records_per_page);
		
		$count_total=$total_Page['TotalCount'];
		
		
		$query = "SELECT * FROM esthp_mails ".$cond.$orderby." limit $offset,$records_per_page" ;
		
		

		/*	if($_SESSION['AdminInfo']['is_superadmin']!=1)
		{
			$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblCustomers U on U.cust_id = A.mail_sender   ".$cond.$orderby." limit $offset,$records_per_page" ;
		} else 
		{
			$query = "SELECT A.*, U.* FROM esthp_mails as A,esthp_tblCustomers as U  ".$cond1.$orderby." limit $offset,$records_per_page" ;
		}
		
		*/
		
		$webPage = $sql->SqlExecuteQuery($query);
		$count = $webPage['count'];
		$Data = $webPage['Data'];
		
		?>
        <tr>
         <td valign="top">
		  <form method="post" action="" name="frmMails">
		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="10%" align="center"><a href="javascript:void(0)" class="add_del" onClick="multiDelete(document.frmMails)">Delete Selected</a></td>          
               <td align="right" valign="top" width="76%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                 <td align="right" valign="middle" class="paging_bg">
				  <table style="font-size:9px;">
					<tr>
					 <td>Page:</td>
					 <td>
				<?php	$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
						foreach ($qsA as $k=>$v) $qs .= "&$k=$v";						
						$url = "?page={@PAGE}&$qs";
						$pager = new pager($url, $count_total, $records_per_page, $page);						
						$pager->outputlinks();	?>
					 </td>
					</tr>
				  </table>
				 </td>
                </tr>
               </table></td>
              </tr>
              </table></td>
            </tr>
            <tr>
             <td valign="top" class="border"><table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td valign="middle" class="left_headbg">
				 
		<?php
		if($_SESSION['AdminInfo']['is_superadmin']==1)
		{
			?>
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr height="25">
			<td width="5%" align="center"><input type="checkbox" onclick="javascript:checkall(this.checked, document.frmMails);"></td>					 
			<td width="20%" align="left" class="white_text">From&nbsp;<a href="inbox.php?sort=mail_sender asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_sender desc"><img src="images/down.gif" border="0"></a></td>
			<td width="20%" align="left" class="white_text">To&nbsp;<a href="inbox.php?sort=mail_reciever asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_reciever desc"><img src="images/down.gif" border="0"></a></td>
			<td width="30%" align="left" class="white_text">Subject&nbsp;<a href="inbox.php?sort=mail_subject asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_subject desc"><img src="images/down.gif" border="0"></a></td>
			<td width="20%" align="center" class="white_text">Date&nbsp;<a href="inbox.php?sort=mail_date asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_date desc"><img src="images/down.gif" border="0"></a></td>					                     
			<td width="5%" align="center" class="white_text"></td>					 
			</tr>
				   
		<?php 
		
		if($count>0)
		{
				 for($i=0; $i<$count; $i++)
				 {
						$mail_sender=$Data[$i]['mail_sender'];
						$mail_receiver=$Data[$i]['mail_reciever'];
						
						if($Data[$i]['mail_type']=='customer_to_clinic')
						{
							$sender_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_sender."'");
							$sender_count = $sender_arr['count'];
							$sender_data= $sender_arr['Data'];	
							$sender_fname=$sender_data['cust_fname'];
							$sender_lname=$sender_data['cust_lname'];
							$sender_name=$sender_fname.' '.$sender_lname;
						
							$receiver_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_receiver."'");
							$receiver_count = $receiver_arr['count'];
							$receiver_data= $receiver_arr['Data'];	
							$receiver_name=$receiver_data['ClinicName'];
							$receiver_fname=$receiver_data['FirstName'];
							$receiver_lname=$receiver_data['LastName'];
							$receiver_name=$receiver_name.' ['.$receiver_fname.' '.$receiver_lname.']';
							?>
							
							<tr  class="grey_bg" height="25" <?= ($i%2==0)? 'class="grey_bg"' : ""?>>
							
							<td align="center"><input type="checkbox" name="chk[]" value="<?php echo $Data[$i]['mail_Id']; ?>"></td>
							
							<td align="left" class="black_text"><a href="add-customer.php?mode=edit&cust_id=<?php echo $Data[$i]['mail_sender']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$sender_name.'</b>'; else echo $sender_name;?></a></td>
							
							<td align="left" class="black_text"><a href="add-user.php?mode=edit&UserId=<?php echo $Data[$i]['mail_reciever']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$receiver_name.'</b>'; else echo $receiver_name;?></a></td>
							
							
							<td align="left" class="black_text" nowrap="nowrap"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$Data[$i]['mail_subject'].'</b>';else echo $Data[$i]['mail_subject']; ?></a></td>
							
							<td align="center" class="black_text"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.date("j M h:i A",$Data[$i]['mail_date']).'</b>'; else echo date("j M h:i A",$Data[$i]['mail_date']);?></a></td>
							
							<td align="center" class="black_text"><a href="javascript: void(0)" onclick="SingleDelete('inbox.php?delid=<?=$Data[$i]['mail_Id']?>&action=DELETE&page=<?=$page?>');"><img src="images/delete.gif"alt="Delete" border="0"></a></td>					                    
							
							</tr>	
							
							<?php
							
						}
						else if($Data[$i]['mail_type']=='clinic_to_customer')
						{
							$sender_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_sender."'");
							$sender_count = $sender_arr['count'];
							$sender_data= $sender_arr['Data'];	
							$sender_name=$sender_data['ClinicName'];
							$sender_fname=$sender_data['FirstName'];
							$sender_lname=$sender_data['LastName'];
							$sender_name=$sender_name.' ['.$sender_fname.' '.$sender_lname.']';
							
							$receiver_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_receiver."'");
							$receiver_count = $receiver_arr['count'];
							$receiver_data= $receiver_arr['Data'];	
							$receiver_fname=$receiver_data['cust_fname'];
							$receiver_lname=$receiver_data['cust_lname'];
							$receiver_name=$receiver_fname.' '.$receiver_lname;
							?>
							
							
							<tr  class="grey_bg" height="25" <?= ($i%2==0)? 'class="grey_bg"' : ""?>>
							
							<td align="center"><input type="checkbox" name="chk[]" value="<?php echo $Data[$i]['mail_Id']; ?>"></td>
							
							<td align="left" class="black_text"><a href="add-user.php?mode=edit&UserId=<?php echo $Data[$i]['mail_sender']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$sender_name.'</b>'; else echo $sender_name;?></a></td>
							
							
							<td align="left" class="black_text"><a href="add-customer.php?mode=edit&cust_id=<?php echo $Data[$i]['mail_reciever']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$receiver_name.'</b>'; else echo $receiver_name;?></a></td>
							
							
							
							<td align="left" class="black_text" nowrap="nowrap"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$Data[$i]['mail_subject'].'</b>';else echo $Data[$i]['mail_subject']; ?></a></td>
							
							<td align="center" class="black_text"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.date("j M h:i A",$Data[$i]['mail_date']).'</b>'; else echo date("j M h:i A",$Data[$i]['mail_date']);?></a></td>
							
							<td align="center" class="black_text"><a href="javascript: void(0)" onclick="SingleDelete('inbox.php?delid=<?=$Data[$i]['mail_Id']?>&action=DELETE&page=<?=$page?>');"><img src="images/delete.gif"alt="Delete" border="0"></a></td>					                    
							
							</tr>	
								
							<?php
						
						}
												
												
				 ?>
				 
		<?php 	
				}
			  }
			  else
	 		  {
				echo '<tr class="grey_bg"><td height="25" colspan="6" class="empty_record_txt">No Record Found.</td></tr>';
			  }	?>
                 </table>
			<?php
		}
		else
		{
		?>
		 <table width="100%" border="0" cellspacing="1" cellpadding="0">
                   <tr height="25">
                     <td width="3%" align="center"><input type="checkbox" onclick="javascript:checkall(this.checked, document.frmMails);"></td>					 
					 <td width="23%" align="left" class="white_text">From&nbsp;<a href="inbox.php?sort=mail_sender asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_sender desc"><img src="images/down.gif" border="0"></a></td>
					 
                     <td width="36%" align="left" class="white_text">Subject&nbsp;<a href="inbox.php?sort=mail_subject asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_subject desc"><img src="images/down.gif" border="0"></a></td>
					 
                     <td width="15%" align="center" class="white_text">Date&nbsp;<a href="inbox.php?sort=mail_date asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="inbox.php?sort=mail_date desc"><img src="images/down.gif" border="0"></a></td>					                     
                     				 
                     <td width="4%" align="center" class="white_text"></td>					 
                   </tr>
				   
		<?php
		if($count>0)
			  {
				 for($i=0; $i<$count; $i++)
				 {
				 
						
						$mail_sender=$Data[$i]['mail_sender']; // customer
						$mail_receiver=$Data[$i]['mail_reciever']; // clinic
						
						$sender_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_sender."'");
						$sender_count = $sender_arr['count'];
						$sender_data= $sender_arr['Data'];	
						
						$sender_fname=$sender_data['cust_fname'];
						$sender_lname=$sender_data['cust_lname'];
						$sender_name=$sender_fname.' '.$sender_lname;
						
						$receiver_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_receiver."'");
						$receiver_count = $receiver_arr['count'];
						$receiver_data= $receiver_arr['Data'];	
						
						$receiver_name=$receiver_data['ClinicName'];
						
						$receiver_fname=$receiver_data['FirstName'];
						$receiver_lname=$receiver_data['LastName'];
					
						$receiver_name=$receiver_name.' ['.$receiver_fname.' '.$receiver_lname.']';
						
												
				 ?>
                   <tr  class="grey_bg" height="25" <?= ($i%2==0)? 'class="grey_bg"' : ""?>>
                     <td align="center"><input type="checkbox" name="chk[]" value="<?php echo $Data[$i]['mail_Id']; ?>"></td>
					 <td align="left" class="black_text"><a href="add-customer.php?mode=edit&cust_id=<?php echo $Data[$i]['mail_sender']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$sender_name.'</b>'; else echo $sender_name;?></a></td>
                     <td align="left" class="black_text" nowrap="nowrap"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.$Data[$i]['mail_subject'].'</b>';else echo $Data[$i]['mail_subject']; ?></a></td>
                     <td align="center" class="black_text"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php if($Data[$i]['mail_read']!=1) echo '<b>'.date("j M h:i A",$Data[$i]['mail_date']).'</b>'; else echo date("j M h:i A",$Data[$i]['mail_date']);?></a></td>
				     <td align="center" class="black_text"><a href="javascript: void(0)" onclick="SingleDelete('inbox.php?delid=<?=$Data[$i]['mail_Id']?>&action=DELETE&page=<?=$page?>');"><img src="images/delete.gif"alt="Delete" border="0"></a></td>					                    </tr>					 
		<?php 	
		}
			  }
			  else
	 		  {
				echo '<tr class="grey_bg"><td height="25" colspan="6" class="empty_record_txt">No Record Found.</td></tr>';
			  }	?>
                 </table>
				 
				 
				 
				 
		<?php
		}
		?>
				 
				 
				 
				 
				</td>

               </tr>
             </table></td>
            </tr>
            <tr><td valign="top">&nbsp;</td></tr>
           </table>
 		  </form>
		 </td>
        </tr>
        <tr><td valign="top">&nbsp;</td></tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td></tr>
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
	var frm =document.frmMails;
	var n =frm.elements.length;
	for (i=0; i<n; i++)
	{
		if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;
	}
}
function multiDelete()
{
	var frm =document.frmMails;
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
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
			if( $Data_del["mail_sender"] == 1) 
			{
				$delid=$_REQUEST['delid'];
				$ConArr['mail_SenderDelete'] = 1;
				$CondArr = " WHERE mail_Id = '$id_del' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);
				header("location:outbox.php?msg=deleted");
				die();
			}
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
			if( $Data_del["mail_sender"] == 1) 
			{
				$delid=$_REQUEST['delid'];
				$ConArr['mail_SenderDelete'] = 1;
				$CondArr = " WHERE mail_Id = '$id_del' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);
			}
		}
	}
	header("location:outbox.php?msg=deleted");
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
         <td height="25" valign="top" class="green_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           
           <td><h1>Manage Sent Mails </h1></td>
          </tr>
         </table></td>
        </tr>
        <tr><td valign="top" style="padding:15px;" align="center"><?=$message?></td></tr>
        <tr><td valign="top"><img src="images/spacer.gif" alt="" width="1" height="5"></td></tr>
<?php	$sortOrder = " mail_Id DESC";
		if(isset ($_GET["sort"]) && $_GET["sort"] != "")
		{
			$sortOrder = $_GET["sort"];
			if( stripos($sortOrder,"UserName") === false)
			{
				$sortOrder = 'mail_' .$sortOrder;			
			} 			
		}
		//$records_per_page = $conf_row["pagingSize"];
		$records_per_page = "10";
		$offset = ($page-1) * $records_per_page;
		$cond = "WHERE mail_sender = ".$_SESSION['AdminInfo']['id'] ." and mail_SenderDelete = 0  ";
		$orderby = " ORDER BY ".$sortOrder;

		$total_Page = $sql->SqlRecords("esthp_mails",$cond,$orderby,$offset,$records_per_page);
		$count_total=$total_Page['TotalCount'];
		
		$query = "SELECT A.*, U.* FROM esthp_mails A left join esthp_tblCustomers U on U.cust_id = A.mail_reciever   ".$cond.$orderby." limit $offset,$records_per_page" ;
		$webPage = $sql->SqlExecuteQuery($query);
		$count = $webPage['count'];
		$Data = $webPage['Data'];  ?>
        <tr>
         <td valign="top">
		  <form method="post" action="" name="frmMails">
		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="10%" align="center"><a href="javascript:void(0)" class="add_del" onClick="multiDelete(document.frmMails)">Supprimer les messages sélectionnés.</a></td>          
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
                 <td valign="middle" class="left_headbg"><table width="100%" border="0" cellspacing="1" cellpadding="0">
                   <tr height="25">
                     <td width="3%" align="center"><input type="checkbox" onclick="javascript:checkall(this.checked, document.frmMails);"></td>
					 <td width="22%" align="left" class="white_text">Utilisateur&nbsp;<a href="outbox.php?sort=cust_fname asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="outbox.php?sort=cust_fname desc"><img src="images/down.gif" border="0"></a></td>
                     <td width="54%" align="left" class="white_text">sujet&nbsp;<a href="outbox.php?sort=mail_subject asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="outbox.php?sort=mail_subject desc"><img src="images/down.gif" border="0"></a></td>
                     <td width="17%" align="center" class="white_text">Date&nbsp;<a href="outbox.php?sort=mail_date asc"><img src="images/top.gif" border="0"></a>&nbsp;<a href="outbox.php?sort=mail_date desc"><img src="images/down.gif" border="0"></a></td>
                     <td width="4%" align="center" class="white_text"></td>					 
                   </tr>
		<?php if($count>0)
			  {
				 for($i=0; $i<$count; $i++)
				 {
				 ?>
                   <tr height="25" <?=($i%2==0)? 'class="grey_bg"' : ""?>>
                     <td align="center"><input type="checkbox" name="chk[]" value="<?php echo $Data[$i]['mail_Id']; ?>"></td>
					 <td align="left" class="black_text"><a href="add-customer.php?mode=edit&cust_id=<?php echo $Data[$i]['cust_id']; ?>"><?php echo $Data[$i]['cust_fname']." ".$Data[$i]['cust_lname'];?></a></td>
                     <td align="left" class="black_text" nowrap="nowrap"><a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>"><?php echo $Data[$i]['mail_subject']; ?></a></td>
                     <td align="center" class="black_text"><?php echo date("j M h:i A",$Data[$i]['mail_date']);?></td>
                     <td align="center" class="black_text"><a href="javascript: void(0)" onclick="SingleDelete('outbox.php?delid=<?=$Data[$i]['mail_Id']?>&action=DELETE&page=<?=$page?>');"><img src="images/delete.gif"alt="Delete" border="0"></a></td>					                    </tr>					 
		<?php 	}
			  }
			  else
	 		  {
				echo '<tr class="grey_bg"><td height="25" colspan="5" class="empty_record_txt">No Record Found.</td></tr>';
			  }	?>
                 </table></td>

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

</body>
</html>
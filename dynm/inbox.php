<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$adminTimezone = "GMT+05:30";

$sortOrder = " mail_Id DESC";
if(isset ($_GET["sort"]) && $_GET["sort"] != "")
{
	$sortOrder = $_GET["sort"];
	if( stripos($sortOrder,"UserName") === false)
	{
		//$sortOrder = 'mail_' .$sortOrder;
		$sortOrder = $sortOrder;			
	} 
}

//$records_per_page = $conf_row["pagingSize"];
$records_per_page = "10";
$offset = ($page-1) * $records_per_page;




//$cond = "WHERE A.mail_reciever = ". $_SESSION["UserInfo"]["id"]." and A.mail_type='clinic_to_customer' and A.mail_sender=U.UserId and mail_RecieverDelete = 0  ";


//$cond = "WHERE A.mail_reciever = ". $_SESSION["UserInfo"]["id"]." and A.mail_type='clinic_to_customer' and A.mail_sender=U.UserId and mail_RecieverDelete = 0  ";


$cond = "WHERE mail_reciever = ". $_SESSION["UserInfo"]["id"]." and mail_type='clinic_to_customer' and mail_RecieverDelete = 0  ";


$orderby = " ORDER BY ".$sortOrder;


$total_Page = $sql->SqlRecords("esthp_mails",$cond,$orderby,$offset,$records_per_page);


$count_total=$total_Page['TotalCount'];


$query = "SELECT * FROM esthp_mails ".$cond.$orderby." limit $offset,$records_per_page" ;



$webPage = $sql->SqlExecuteQuery($query);
$count = $webPage['count'];
$Data = $webPage['Data'];

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
			//if( $Data_del["mail_reciever"] == 1) 
				if( $Data_del["mail_reciever"] == $_SESSION["UserInfo"]["id"]) 
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
			//if( $Data_del["mail_reciever"] == 1) 
			if( $Data_del["mail_reciever"] == $_SESSION["UserInfo"]["id"])
			{
				$delid=$_REQUEST['delid'];
				$ConArr['mail_RecieverDelete'] = 1;
				$CondArr = " WHERE mail_Id = '$id_del' ";
				$intResult = $sql->SqlUpdate('esthp_mails',$ConArr,$CondArr);
			}
		}
	}
	header("location:inbox.php?msg=deleted");
	die();
}

// multi Delete end

$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';
if($msg=='added')
	$message = "<span class=\"logoutMsgBox\">Enregistrement ajouté avec succès.</span>";
else if($msg=='update')
	$message = "<span class=\"logoutMsgBox\">Record (s) à jour avec succès.</span>";
else if($msg=='deleted')
	$message = "<span class=\"logoutMsgBox\">Record (s) supprimé avec succès.</span>";
	
?>
<?php include("header.php"); ?>

	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Boite de r&eacute;ception</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="frmMails" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					<div id="sea_mid">
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="field1_form2">
								<div id="clinicdiv">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td valign="top" style="padding:15px;" align="center" colspan="2"><?=$message?></td>
									</tr>
									<tr>
										<td valign="top" width="10%" align="center">
											<a href="javascript:void(0)" class="add_del" onClick="multiDelete(document.frmMails)">Supprimer la s&eacute;lection</a>
										</td>
										<td align="right" valign="top" width="76%">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
									<table width="100%" border="1" cellspacing="0" cellpadding="0">
										<tr height="25" class="left_headbg">
											<td width="3%" align="center"><input type="checkbox" onClick="javascript:checkall(this.checked, document.frmMails);"></td>
											<td width="23%" align="left" class="white_text">Utilisateur&nbsp;
												<a href="inbox.php?sort=FirstName asc"><img src="images/top.gif" border="0"></a>&nbsp;
												<a href="inbox.php?sort=FirstName desc"><img src="images/down.gif" border="0"></a>
											</td>
											<td width="36%" align="left" class="white_text">sujet&nbsp;
												<a href="inbox.php?sort=mail_subject asc"><img src="images/top.gif" border="0"></a>&nbsp;
												<a href="inbox.php?sort=mail_subject desc"><img src="images/down.gif" border="0"></a>
											</td>
											<td width="15%" align="center" class="white_text">Date&nbsp;
												<a href="inbox.php?sort=mail_date asc"><img src="images/top.gif" border="0"></a>&nbsp;
												<a href="inbox.php?sort=mail_date desc"><img src="images/down.gif" border="0"></a>
											</td>
											<td width="4%" align="center" class="white_text"></td>
										</tr>
										<?php if($count>0)
										 {
											 for($i=0; $i<$count; $i++)
											 {
											 
			
											 	$mail_sender=$Data[$i]['mail_sender'];
						 
												$clinic_arr = $sql->SqlSingleRecord('esthp_tblUsers',"where UserId='".$mail_sender."'");
												$clinic_count = $clinic_arr['count'];
												$clinic_data= $clinic_arr['Data'];	
												
												$clinic_name=$clinic_data['ClinicName'];
												
												$clinic_fname=$clinic_data['FirstName'];
												$clinic_lname=$clinic_data['LastName'];
												
												
												$mail_receiver=$Data[$i]['mail_reciever'];
												
												$customer_arr = $sql->SqlSingleRecord('esthp_tblCustomers',"where cust_id='".$mail_receiver."'");
												$customer_count = $customer_arr['count'];
												$customer_data= $customer_arr['Data'];	
												
												
												$customer_fname=$customer_data['FirstName'];
												$customer_lname=$customer_data['LastName'];
												
		
		
											 ?>
											 	<tr height="25" <?=($i%2==0)? 'class="grey_bg"' : ""?>>
													<td align="center">
														<input type="checkbox" name="chk[]" value="<?php echo $Data[$i]['mail_Id']; ?>">
													</td>
													<td align="left" class="black_text">
														<a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>">
															<?php if($Data[$i]['mail_read']!=1) echo '<b>'.$clinic_name.' ['.$clinic_fname.' '.$clinic_lname.'] '.'</b>'; else		echo $clinic_name.' ['. $clinic_fname." ".$clinic_lname.'] ';?>
														</a>
													</td>
													<td align="left" class="black_text" nowrap="nowrap">
														<a href="view-message.php?MId=<?php echo $Data[$i]['mail_Id']; ?>">
															<?php if($Data[$i]['mail_read']!=1)echo '<strong>'.$Data[$i]['mail_subject'].'</strong>';
															else echo $Data[$i]['mail_subject']; ?>
														</a>
													</td>
													<td align="center" class="black_text"><?php if($Data[$i]['mail_read']!=1) echo '<strong>'.date("j M h:i A",$Data[$i]['mail_date']).'</strong>'; else echo date("j M h:i A",$Data[$i]['mail_date']);?></td>
													<td align="center" class="black_text">
														<a href="javascript: void(0)" onClick="SingleDelete('inbox.php?delid=<?=$Data[$i]['mail_Id']?>&action=DELETE&page=<?=$page?>');"><img src="images/delete.gif"alt="Delete" border="0"></a>
												</td>
											</tr>
										<?php 	}
									}
									else
									{
										echo '<tr class="grey_bg"><td height="25" colspan="6" class="empty_record_txt">No Record Found.</td></tr>';
									}	
								?>
							</table>
							</div>
							</li>
						</ul>
						<div class="clear"></div>
						</div>
						
						</div>
					<div id="sea_right"></div>
					<div class="clear"></div>
					<!--End listing_page -->
				</div>
				</form>
				<!--End clinic_page -->
			
			<div class="clear"></div>
		  <!--End Form -->	
		  
			</div>
			<div class="clear"></div>
		</div>
		<!--End Right_part -->	
		<div class="clear"></div>
	  </div>	
		<!--End Middle_Area -->	
	</div>
	<!--End Page panel -->
</div>
<!--End Page Holder -->
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
<?php include("footer.php"); ?>
</body>
</html>
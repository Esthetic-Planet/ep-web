<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$hrid = $_GET['hid'];
$frm_id = $_GET['qid'];
//if(!empty($_GET['hid']))
//{
	$uid = $_SESSION['UserInfo']['id'];
	//$cond_list="where 1=1 and UserId='$uid' and hid='$hrid'";
	$cond_list="where 1=1 and UserId='$uid'";
	$orderby_list="order by hid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_haircare",$cond_list,$orderby_list);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data'][0];
//}
 if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Submit"))
{
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="fname" || $k=='lname' ||  $k=="email" || $k=="mobile" ||  $k=="landline" || $k=="city" || $k=="country" || $k=="gender"  || $k=="age" || $k=='start_age' ||  $k=="first_surgery" || $k=="second_surgery" ||  $k=="hairfall_status" || $k=="hairfall_cstatus" || $k=="nature_hair" )
		{
			$ConArr[$k]=$v;
			$Data[$k]=$v;
		}
	}
	
	if(!empty($_REQUEST["htreatment"]))
		$htreatment = implode('|',$_REQUEST["htreatment"]);
	else
		$htreatment = "";
	
	if(!empty($_REQUEST["transplant_procedure_case"]))
		$transplant_procedure_case = implode('|',$_REQUEST["transplant_procedure_case"]);
	else
		$transplant_procedure_case = "";
	
	if(!empty($_REQUEST["clinic_procedure"]))
		$linic_procedure = implode('|',$_REQUEST["clinic_procedure"]);
	else
		$clinic_procedure = "";
	
	if(!empty($_REQUEST["transplant_option"]))
		$transplant_option = implode(',',$_REQUEST["transplant_option"]);
	else
		$transplant_option = "";
		
	$ConArr['htreatment'] = $htreatment;
	$ConArr['transplant_procedure'] = $_REQUEST["transplant_procedure"];
	$ConArr['transplant_procedure_case'] = $transplant_procedure_case;
	$ConArr['clinic_loc'] = $_REQUEST["clinic_loc"];
	$ConArr['clinic_procedure'] = $linic_procedure;
	$ConArr['reply_by'] = $_REQUEST["reply_by"];
	$ConArr['transplant_option'] = $transplant_option;
	$ConArr['your_goal'] = $_REQUEST["your_goal"];
	$ConArr['heard_from'] = $_REQUEST["heard_from"];
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	$intResult = $sql->SqlInsert('esthp_dentalcare',$ConArr);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td colspan="2">Your Contact Details</td>		</tr>
		<tr>		<td>Name :	</td><td>'.$_REQUEST["fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$_REQUEST["lname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email :	</td><td>'.$_REQUEST["email"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile :	</td><td>'.$_REQUEST["mobile"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Landline :	</td><td>'.$_REQUEST["landline"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$_REQUEST["city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Country :	</td><td>'.$_REQUEST["country"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Gender :	</td><td>'.$_REQUEST["gender"].'</td>			</tr>		
		<tr>		<td colspan="2">Your Hair Situation</td>			</tr>
		<tr>		<td>Age :	</td><td>'.$_REQUEST["age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Your hairloss began at age  :	</td><td>'.$_REQUEST["start_age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If you had previous hair surgery, write your first surgery details here(date, technique, and graft number if you have the data)  :	</td><td>'.$_REQUEST["first_surgery"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Same if you had a second hair surgery :	</td><td>'.$_REQUEST["second_surgery"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Present hairloss status :	</td><td>'.$_REQUEST["hairfall_status"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Please select on the norwood/ludwig scale the hair situation you fell is closest to your present status  :	</td><td>'.$_REQUEST["hairfall_cstatus"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Nature of your hair :	</td><td>'.$_REQUEST["nature_hair"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If using a hair treatment please select the one you are using :	</td><td>'.$htreatment.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If you are considering hair transplant, which procedure are you most interrested in? :	</td><td>'.$_REQUEST["transplant_procedure"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You are specifically looking for (select at least one) :	</td><td>'.$transplant_procedure_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You are specifically interrested in our clinic of :	</td><td>'.$_REQUEST["clinic_loc"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>We can provide you with these options, please select the ones you would like :	</td><td>'.$clinic_procedure.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You prefer that we reply to you using :	</td><td>'.$_REQUEST["reply_by"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Which one of these options you feel would help you better understand hair transplant :	</td><td>'.$transplant_option.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Describe your goals here :	</td><td>'.$_REQUEST["your_goal"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You have heard from us through :	</td><td>'.$_REQUEST["heard_from"].'</td>			</tr>
	</table>
	';
	
	if($intResult)
	{
		if($_FILES['face_fwd']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['face_fwd']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['face_fwd']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['face_fwd'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['top_skull']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['top_skull']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['top_skull']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['top_skull'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['face_side']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['face_side']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['face_side']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['face_side'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['donor_area']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = $uid.'_'.time().'_'.$_FILES['donor_area']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['donor_area']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['donor_area'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
	}
	
	$clinicid = $_REQUEST["clid"];
	$where = "WHERE 1=1 and IsActive='t' and find_in_set('$frm_id',	UserCategories) and UserId='$clinicid'";
	$query = $sql->SqlRecords("esthp_tblUsers",$where);
	$total_count = $query["TotalCount"];
	$count = $query["count"];
	$Data = $query["Data"][0];
		
	$ConArr_mail = array();	
	$ConArr_mail['mail_date'] = time();
	$ConArr_mail["mail_sender"] =  $_SESSION["UserInfo"]["id"];
	$ConArr_mail["mail_reciever"] = $Data[UserId];
	$ConArr_mail["mail_subject"] = $Data[ClinicName];
	$ConArr_mail["mail_body"] = addslashes($message_body) ;	
	$ConArr_mail["mail_attachment"] = addslashes($attachmants) ;
	//$ConArr_mail["mail_ParentId"] = $parent_Id;
	$ConArr_mail["mail_ParentId"] = 0;
		
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr_mail);
	header("Location: servicelist.php");
	die();
} else  if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Update"))
{
	
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="fname" || $k=='lname' ||  $k=="email" || $k=="mobile" ||  $k=="landline" || $k=="city" || $k=="country" || $k=="gender"  || $k=="age" || $k=='start_age' ||  $k=="first_surgery" || $k=="second_surgery" ||  $k=="hairfall_status" || $k=="hairfall_cstatus" || $k=="nature_hair" )
		{
			$ConArr[$k]=$v;
			$Data[$k]=$v;
		}
	}
	
	if(!empty($_REQUEST["htreatment"]))
		$htreatment = implode('|',$_REQUEST["htreatment"]);
	else
		$htreatment = "";
	
	if(!empty($_REQUEST["transplant_procedure_case"]))
		$transplant_procedure_case = implode('|',$_REQUEST["transplant_procedure_case"]);
	else
		$transplant_procedure_case = "";
	
	if(!empty($_REQUEST["clinic_procedure"]))
		$linic_procedure = implode('|',$_REQUEST["clinic_procedure"]);
	else
		$clinic_procedure = "";
	
	if(!empty($_REQUEST["transplant_option"]))
		$transplant_option = implode('|',$_REQUEST["transplant_option"]);
	else
		$transplant_option = "";
		
	$ConArr['htreatment'] = $htreatment;
	$ConArr['transplant_procedure'] = $_REQUEST["transplant_procedure"];
	$ConArr['transplant_procedure_case'] = $transplant_procedure_case;
	$ConArr['clinic_loc'] = $_REQUEST["clinic_loc"];
	$ConArr['clinic_procedure'] = $linic_procedure;
	$ConArr['reply_by'] = $_REQUEST["reply_by"];
	$ConArr['transplant_option'] = $transplant_option;
	$ConArr['your_goal'] = $_REQUEST["your_goal"];
	$ConArr['heard_from'] = $_REQUEST["heard_from"];
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	if(!empty($hid))
	{
		$condition = " where hid='".$hid."'";
	} else {
		$condition = " where hid='".$Data_list['hid']."'";
	}
	$intResult = $sql->SqlUpdate('esthp_haircare',$ConArr,$condition);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td colspan="2">Your Contact Details</td>		</tr>
		<tr>		<td>Name :	</td><td>'.$_REQUEST["fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$_REQUEST["lname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email :	</td><td>'.$_REQUEST["email"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile :	</td><td>'.$_REQUEST["mobile"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Landline :	</td><td>'.$_REQUEST["landline"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$_REQUEST["city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Country :	</td><td>'.$_REQUEST["country"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Gender :	</td><td>'.$_REQUEST["gender"].'</td>			</tr>		
		<tr>		<td colspan="2">Your Hair Situation</td>			</tr>
		<tr>		<td>Age :	</td><td>'.$_REQUEST["age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Your hairloss began at age  :	</td><td>'.$_REQUEST["start_age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If you had previous hair surgery, write your first surgery details here(date, technique, and graft number if you have the data)  :	</td><td>'.$_REQUEST["first_surgery"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Same if you had a second hair surgery :	</td><td>'.$_REQUEST["second_surgery"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Present hairloss status :	</td><td>'.$_REQUEST["hairfall_status"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Please select on the norwood/ludwig scale the hair situation you fell is closest to your present status  :	</td><td>'.$_REQUEST["hairfall_cstatus"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Nature of your hair :	</td><td>'.$_REQUEST["nature_hair"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If using a hair treatment please select the one you are using :	</td><td>'.$htreatment.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>If you are considering hair transplant, which procedure are you most interrested in? :	</td><td>'.$_REQUEST["transplant_procedure"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You are specifically looking for (select at least one) :	</td><td>'.$transplant_procedure_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You are specifically interrested in our clinic of :	</td><td>'.$_REQUEST["clinic_loc"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>We can provide you with these options, please select the ones you would like :	</td><td>'.$clinic_procedure.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You prefer that we reply to you using :	</td><td>'.$_REQUEST["reply_by"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Which one of these options you feel would help you better understand hair transplant :	</td><td>'.$transplant_option.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Describe your goals here :	</td><td>'.$_REQUEST["your_goal"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>You have heard from us through :	</td><td>'.$_REQUEST["heard_from"].'</td>			</tr>
	</table>
	';
	
	if($_FILES['face_fwd']['name']!="")
	{
			$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
			$file_name = time().'_'.$_FILES['face_fwd']['name'];
			$upload_file=$upload_dir.$file_name ;
						
			if(move_uploaded_file($_FILES['face_fwd']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$files = $Data_list["face_fwd"];
				$file_name = $file_name."|".$files;
				$content_arr['face_fwd'] = $file_name ;
				if(!empty($hid))
				{
					$condition = " where hid='".$hid."'";
				} else {
					$condition = " where hid='".$Data_list['hid']."'";
				}
				$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
				
				if($attachmants != "")
				  $attachmants .= "|";
				$attachmants .= $file_name ;
			}
	}
	if($_FILES['top_skull']['name']!="")
	{
			$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
			$file_name =time().'_'.$_FILES['top_skull']['name'];
			$upload_file=$upload_dir.$file_name ;
						
			if(move_uploaded_file($_FILES['top_skull']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$files = $Data_list["top_skull"];
				$file_name = $file_name."|".$files;
				$content_arr['top_skull'] = $file_name ;
				if(!empty($hid))
				{
					$condition = " where hid='".$hid."'";
				} else {
					$condition = " where hid='".$Data_list['hid']."'";
				}
				$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
				
				if($attachmants != "")
				  $attachmants .= "|";
				$attachmants .= $file_name ;
			}
	}
	if($_FILES['face_side']['name']!="")
	{
			$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
			$file_name =time().'_'.$_FILES['face_side']['name'];
			$upload_file=$upload_dir.$file_name ;
						
			if(move_uploaded_file($_FILES['face_side']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$files = $Data_list["face_side"];
				$file_name = $file_name."|".$files;
				$content_arr['face_side'] = $file_name ;
				if(!empty($hid))
				{
					$condition = " where hid='".$hid."'";
				} else {
					$condition = " where hid='".$Data_list['hid']."'";
				}
				$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
				
				if($attachmants != "")
				  $attachmants .= "|";
				$attachmants .= $file_name ;
			}
	}
	if($_FILES['donor_area']['name']!="")
	{
			$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
			$file_name =time().'_'.$_FILES['donor_area']['name'];
			$upload_file=$upload_dir.$file_name ;
						
			if(move_uploaded_file($_FILES['donor_area']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$files = $Data_list["donor_area"];
				$file_name = $file_name."|".$files;
				$content_arr['donor_area'] = $file_name ;
				if(!empty($hid))
				{
					$condition = " where hid='".$hid."'";
				} else {
					$condition = " where hid='".$Data_list['hid']."'";
				}
				$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
				
				if($attachmants != "")
				  $attachmants .= "|";
				$attachmants .= $file_name ;
			}
	}

	$clinicid = $Data_list["clinicid"];
	$where = "WHERE 1=1 and IsActive='t' and find_in_set('$frm_id',	UserCategories) and UserId='$clinicid'";
	$query = $sql->SqlRecords("esthp_tblUsers",$where);
	$total_count = $query["TotalCount"];
	$count = $query["count"];
	$Data = $query["Data"][0];
		
	$ConArr_mail = array();	
	$ConArr_mail['mail_date'] = time();
	$ConArr_mail["mail_sender"] =  $_SESSION["UserInfo"]["id"];
	$ConArr_mail["mail_reciever"] = $Data[UserId];
	$ConArr_mail["mail_subject"] = $Data[ClinicName];
	$ConArr_mail["mail_body"] = addslashes($message_body) ;	
	$ConArr_mail["mail_attachment"] = addslashes($attachmants) ;
	//$ConArr_mail["mail_ParentId"] = $parent_Id;
	$ConArr_mail["mail_ParentId"] = 0;
		
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr_mail);
	header("Location: hairfrm_detail.php");
	die();
}

?>
<?php include("header.php"); ?>
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Hair Transplant Form</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						<div class="list_clinic">Online consultation request </div>
						
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="list_font">your contact details:</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Name :*</li>
							<li class="field1_form">
								<div id="clinicdiv">
									<input type="text" value="<?php echo $Data_list["fname"]; ?>" name="fname" id="chk_fname" title="Please enter your name" class="textbox2">
								</div>
							</li>
						</ul>
						<div class="clear"></div>
						
						<ul>
							<li class="field_name_form">Surname :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["lname"]; ?>" name="lname" class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Email :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["email"]; ?>" name="email"  id="chkemail_email" class="textbox2" title="Please eneter valid email address"> </li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Cellphone :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["mobile"]; ?>" name="mobile" id="chkphone_mobile"  class="textbox2" title="Please enter your Cellphone number"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Téléphone7 :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["landline"]; ?>" name="landline"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Ville :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["city"]; ?>" name="city"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Pays :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["country"]; ?>" name="country"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Gender :</li>
							<li class="field1_form">
								<input type="radio" value="male" name="gender" <?=($Data_list['gender']=='male' || $Data_list['gender']=='' ? 'checked' : '')?>>male<br>
								<input type="radio" value="female" name="gender" <?=($Data_list['gender']=='female' || $Data_list['gender']=='' ? 'checked' : '')?>>female
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="list_font">Your hair situation:</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Age :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["age"]; ?>" id="chkphone_age" name="age"  class="textbox2" title="Please enter your age"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Your hairloss began at age :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["start_age"]; ?>" name="start_age" id="chkphone_start_age" title="Please enter the hair fall start age"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">If you had previous hair surgery, write your first surgery details here(date, technique, and graft number if you have the data) a :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["first_surgery"]; ?>" name="first_surgery"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Same if you had a second hair surgery :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["second_surgery"]; ?>" name="second_surgery"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Present hairloss status :*</li>
							<li class="field1_form">
								<select name="hairfall_status" class="listmenu" id="chksbox_hairfall_status" title="Please select the hairfall status">
									<option value="">Select...</option>
									<option value="continued" <?php if($Data_list["hairfall_status"]=="continued"){?> selected="selected" <?php } ?>>continued</option>
									<option value="slowed_down" <?php if($Data_list["hairfall_status"]=="slowed_down"){?> selected="selected" <?php } ?>>slowed down</option>
									<option value="stabilised" <?php if($Data_list["hairfall_status"]=="stabilised"){?> selected="selected" <?php } ?>> stabilised</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Please select on the norwood/ludwig scale the hair situation you fell is closest to your present status :*</li>
							<li class="field1_form">
								<select name="hairfall_cstatus" class="listmenu">
									<option value="">Select...</option>
	<option value="Men_class_1" <?php if($Data_list["hairfall_cstatus"]=="Men_class_1"){?> selected="selected" <?php } ?>>Men class 1</option>
	<option value="Men_class_2" <?php if($Data_list["hairfall_cstatus"]=="Men_class_2"){?> selected="selected" <?php } ?>>Men class 2</option>
	<option value="Men_class_3" <?php if($Data_list["hairfall_cstatus"]=="Men_class_3"){?> selected="selected" <?php } ?>>Men class 3</option>
	<option value="Men_class_4" <?php if($Data_list["hairfall_cstatus"]=="Men_class_4"){?> selected="selected" <?php } ?>>Men class 4</option>
	<option value="Men_class_5" <?php if($Data_list["hairfall_cstatus"]=="Men_class_5"){?> selected="selected" <?php } ?>>Men class 5</option>
	<option value="Men_class_6" <?php if($Data_list["hairfall_cstatus"]=="Men_class_6"){?> selected="selected" <?php } ?>>Men class 6</option>
	<option value="Men_class_7" <?php if($Data_list["hairfall_cstatus"]=="Men_class_7"){?> selected="selected" <?php } ?>>Men class 7</option>
	<option value="Women_class_1" <?php if($Data_list["hairfall_cstatus"]=="Women_class_1"){?> selected="selected" <?php } ?>>Women class 1</option>
	<option value="Women_class_2" <?php if($Data_list["hairfall_cstatus"]=="Women_class_2"){?> selected="selected" <?php } ?>>Women class 2</option>
	<option value="Women_class_3" <?php if($Data_list["hairfall_cstatus"]=="Women_class_3"){?> selected="selected" <?php } ?>>Women class 3</option>
								</select> 
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">&nbsp;</li>
							<li class="field1_form">
								<img width="320" height="397" alt="&lt;Norwood scale&gt;" src="images/norwood.jpg">
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">&nbsp;</li>
							<li class="field1_form">
								<img width="293" height="211" alt="&lt;ludwig scale&gt;" src="images/ludwing_grade.jpg">
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Nature of your hair :</li>
							<li class="field1_form">
								<select name="nature_hair" class="listmenu">
									<option value="">Select...</option>
									<option value="straight" <?php if($Data_list["nature_hair"]=="straight"){?> selected="selected" <?php } ?>>straight</option>
									<option value="flex" <?php if($Data_list["nature_hair"]=="flex"){?> selected="selected" <?php } ?>>flex</option>
									<option value="wavy" <?php if($Data_list["nature_hair"]=="wavy"){?> selected="selected" <?php } ?>>wavy</option>
									<option value="curly" <?php if($Data_list["nature_hair"]=="curly"){?> selected="selected" <?php } ?>>curly</option>
									<option value="african_hair" <?php if($Data_list["nature_hair"]=="african_hair"){?> selected="selected" <?php } ?>>african hair</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">If using a hair treatment please select the one you are using :</li>
							<?php
								$get_value = $Data_list["htreatment"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="none" <?php if(in_array("none", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> none
								  <input type="checkbox" value="minoxidil 2%" <?php if(in_array("minoxidil 2%", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> minoxidil 2%<br>
								  <input type="checkbox" value="minoxidil 5%" <?php if(in_array("minoxidil 5%", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> minoxidil 5%<br>
								  <input type="checkbox" value="finasteride 1mg (propecia)" <?php if(in_array("finasteride 1mg (propecia)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> finasteride 1mg (propecia)<br>
								  <input type="checkbox" value="finasteride 5mg(proscar)" <?php if(in_array("finasteride 5mg(proscar)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> finasteride 5mg(proscar)<br>
								  <input type="checkbox" value="dutasteride(avodart)" <?php if(in_array("dutasteride(avodart)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> dutasteride(avodart)<br>
								  <input type="checkbox" value="saw palmetto" <?php if(in_array("saw palmetto", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> saw palmetto<br>
								  <input type="checkbox" value="mesotherapie" <?php if(in_array("mesotherapie", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> mesotherapie
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="list_font">Surgery preferences :</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">If you are considering hair transplant, which procedure are you most interrested in? :</li>
							<li class="field1_form">
								<select name="transplant_procedure" class="listmenu">
									<option value="">Select...</option>
									<option value="FUT" <?php if($Data_list["transplant_procedure"]=="FUT"){?> selected="selected" <?php } ?>>FUT</option>
									<option value="FUE(scarless)" <?php if($Data_list["transplant_procedure"]=="FUE(scarless)"){?> selected="selected" <?php } ?>>FUE(scarless)</option>
									<option value="BHT(Body_Hair)" <?php if($Data_list["transplant_procedure"]=="BHT(Body_Hair)"){?> selected="selected" <?php } ?>>BHT(Body Hair)</option>
									<option value="Combo(FUE_FUT_BHT)" <?php if($Data_list["transplant_procedure"]=="Combo(FUE_FUT_BHT)"){?> selected="selected" <?php } ?>>Combo(FUE &amp; FUT &amp; BHT)</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">You are specifically looking for (select at least one):  </li>
							<?php
								$get_value = $Data_list["transplant_procedure_case"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="informations on medical treatments" <?php if(in_array("informations on medical treatments", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]"> informations on medical treatments<br>
							  <input type="checkbox" value="informations on surgical treatment (hair transplant)" <?php if(in_array("informations on surgical treatment (hair transplant)", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]"> informations on surgical treatment (hair transplant)<br>
							  <input type="checkbox" value="invoice for hair transplant" <?php if(in_array("invoice for hair transplant", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]"> invoice for hair transplant 
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">You are specifically interrested in our clinic of :</li>
							<li class="field1_form">
								<select name="clinic_loc" class="listmenu">
									<option value="">Select...</option>
									<option value="Bruxelles" <?php if($Data_list["clinic_loc"]=="Bruxelles"){?> selected="selected" <?php } ?>>Bruxelles</option>
									<option value="New-York" <?php if($Data_list["clinic_loc"]=="New-York"){?> selected="selected" <?php } ?>>New-York</option>
									<option value="Miami" <?php if($Data_list["clinic_loc"]=="Miami"){?> selected="selected" <?php } ?>>Miami</option>
									<option value="Istanbul" <?php if($Data_list["clinic_loc"]=="Istanbul"){?> selected="selected" <?php } ?>>Istanbul</option>
									<option value="Tunis" <?php if($Data_list["clinic_loc"]=="Tunis"){?> selected="selected" <?php } ?>>Tunis</option>
									<option value="New_Delhi" <?php if($Data_list["clinic_loc"]=="New_Delhi"){?> selected="selected" <?php } ?>>New Delhi</option>
									<option value="Bangkok" <?php if($Data_list["clinic_loc"]=="Bangkok"){?> selected="selected" <?php } ?>>Bangkok</option>
									<option value="all_clinics" <?php if($Data_list["clinic_loc"]=="all_clinics"){?> selected="selected" <?php } ?>>all clinics</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">We can provide you with these options, please select the ones you would like:  </li>
							<?php
								$get_value = $Data_list["clinic_procedure"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="photo&amp;email estimation" <?php if(in_array("photo&amp;email estimation", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">photo&amp;email estimation</font><br>
								<input type="checkbox" value="webcam consultation" <?php if(in_array("webcam consultation", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">webcam consultation<br>
								<input type="checkbox" value="phonemeeting" <?php if(in_array("phonemeeting", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">phonemeeting<br>
								<input type="checkbox" value="direct office consultation in Paris, London or Abu Dabhi" <?php if(in_array("direct office consultation in Paris, London or Abu Dabhi", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">direct office consultation in Paris, London or Abu Dabhi
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">You prefer that we reply to you using :</li>
							<li class="field1_form">
								<select name="reply_by" class="listmenu">
									<option value="">Select...</option>
									<option value="email" <?php if($Data_list["reply_by"]=="email"){?> selected="selected" <?php } ?>>email</option>
									<option value="telephone" <?php if($Data_list["reply_by"]=="telephone"){?> selected="selected" <?php } ?>>telephone</option>
									<option value="skype" <?php if($Data_list["reply_by"]=="skype"){?> selected="selected" <?php } ?>>skype</option>
									<option value="all_of_the_above" <?php if($Data_list["reply_by"]=="all_of_the_above"){?> selected="selected" <?php } ?>>all of the above</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Which one of these options you feel would help you better understand hair transplant:  </li>
							<?php
								$get_value = $Data_list["transplant_option"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="meet a patient" <?php if(in_array("meet a patient", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> meet a patient<br>
							  <input type="checkbox" value="talk to a patient" <?php if(in_array("talk to a patient", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> talk to a patient<br>
							  <input type="checkbox" value="see a surgery" <?php if(in_array("see a surgery", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> see a surgery<br>
							  <input type="checkbox" value="in-depth consultation" <?php if(in_array("in-depth consultation", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> in-depth consultation
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Describe your goals here :*</li>
							<li class="field1_form">
								<textarea rows="10" cols="45" name="your_goal"  class="textbox_form"><?php echo $Data_list["your_goal"]; ?></textarea> 
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">You have heard from us through :</li>
							<li class="field1_form">
								<select name="heard_from" class="listmenu">
									<option value="">Select...</option>
									<option value="TV" <?php if($Data_list["heard_from"]=="TV"){?> selected="selected" <?php } ?>>TV</option>
									<option value="radio" <?php if($Data_list["heard_from"]=="radio"){?> selected="selected" <?php } ?>>radio</option>
									<option value="newspaper" <?php if($Data_list["heard_from"]=="newspaper"){?> selected="selected" <?php } ?>>newspaper</option>
									<option value="google" <?php if($Data_list["heard_from"]=="google"){?> selected="selected" <?php } ?>>google</option>
									<option value="yahoo" <?php if($Data_list["heard_from"]=="yahoo"){?> selected="selected" <?php } ?>>yahoo</option>
									<option value="msn(bing)" <?php if($Data_list["heard_from"]=="msn(bing)"){?> selected="selected" <?php } ?>>msn(bing)</option>
									<option value="word_of_mouth" <?php if($Data_list["heard_from"]=="word_of_mouth"){?> selected="selected" <?php } ?>>word of mouth</option>
									<option value="forums" <?php if($Data_list["heard_from"]=="forums"){?> selected="selected" <?php } ?>>forums</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Enter a pictures facing forward
							</li>
							<li class="field1_form">
								<input type="file" id="face_fwd" name="face_fwd"> (2 Mo maximum)
								<?php
									$face_fwd=explode("|",$Data_list['face_fwd']);
									$get_face_fwd = $face_fwd[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_face_fwd))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_face_fwd?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>

							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Enter a picture of the top of your skull
							</li>
							<li class="field1_form">
								<input type="file" id="top_skull" name="top_skull"> (2 Mo maximum)
								<?php
									$top_skull=explode("|",$Data_list['top_skull']);
									$get_top_skull = $top_skull[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_top_skull))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_top_skull?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Enter a picture from the sides
							</li>
							<li class="field1_form">
								<input type="file" id="face_side" name="face_side"> (2 Mo maximum)
								<?php
									$face_side=explode("|",$Data_list['face_side']);
									$get_face_side = $face_side[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_face_side))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_face_side?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Enter a picture of you donor area
							</li>
							<li class="field1_form">
								<input type="file" id="donor_area" name="donor_area"> (2 Mo maximum)
								<?php
									$donor_area=explode("|",$Data_list['donor_area']);
									$get_donor_area = $donor_area[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_donor_area))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_donor_area?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">&nbsp;</li>
							<li class="field">
							<?php
								if($count_list > 0)
								{
									$btnName = "Update";
								}
								else if(isset($_REQUEST['hid']) && $_REQUEST['hid']!='')
								{
									$btnName = "Update";
								}
								else
								{
									$btnName = "Submit";
								}
							?>
								<input type="reset" value=" Reset " name="Reset">
								<!--<input type="submit" value="Envoyer" name="envoi">-->
								<input type="submit" value="<?php echo $btnName; ?>" name="submit">
								<!--<input name="submit" type="submit" class="submit1"  value="Search Now"/>-->	
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
<?php include("footer.php"); ?>
</body>
</html>
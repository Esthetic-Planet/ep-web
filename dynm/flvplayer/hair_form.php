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
	
	$cond_userdetail="where 1=1 and cust_id='$uid'";
	$orderby_userdetail="order by cust_id desc";
	$cat_arr_userdetail = $sql->SqlRecords("esthp_tblCustomers",$cond_userdetail,$orderby_userdetail);
	$count_total_userdetail=$cat_arr_userdetail['TotalCount'];
	$count_userdetail = $cat_arr_userdetail['count'];
	$Data_userdetail = $cat_arr_userdetail['Data'][0];
	
	//}
 if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Submit"))
{
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	$ConArr['fname'] = $Data_userdetail["cust_fname"];
	$ConArr['lname'] = $Data_userdetail["cust_lname"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['country'] = $Data_userdetail["cust_country"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="gender"  || $k=="age" || $k=='start_age' ||  $k=="first_surgery" || $k=="second_surgery" ||  $k=="hairfall_status" || $k=="hairfall_cstatus" || $k=="nature_hair" )
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
	$intResult = $sql->SqlInsert('esthp_haircare',$ConArr);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td colspan="2">Your Contact Details</td>		</tr>
		<tr>		<td>Name :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$Data_userdetail["cust_lname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email :	</td><td>'.$Data_userdetail["cust_email"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile :	</td><td>'.$Data_userdetail["cust_phone"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$Data_userdetail["cust_city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Country :	</td><td>'.$Data_userdetail["cust_country"].'</td>			</tr>
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
	
	$to  = $Data["UserId"]; // note the comma
	$to1  = $_SESSION["UserInfo"]["id"]; // note the comma
	$sub = $Data[ClinicName];
	$subject = "New Request for ".$sub;
	$subject1 = "Thanks for Request of".$sub;
	$fname = $Data_userdetail["cust_fname"];
	$lname = $Data_userdetail["cust_lname"];
	$message = "Dear ". $fname. " ".$lname."<br><br>a new message from ". $sub.".<br><br>Thanks<br>Esthetic Planet";
	$message1 = "Dear ". $_SESSION["UserInfo"]["fname"]. " ".$_SESSION["UserInfo"]["lname"]."<br><br>un message de ". $sub.".est arrivé sur votre espace client Esthetic-Planet. Clickez ici pour y acceder<a href='http://www.mosaic-service-demo.com/esthetic_planet/'>Login Here</a><br><br>Thanks<br>Esthetic Planet";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$fname.' '.$lname.' <'.$_SESSION["UserInfo"]["id"].'>' . "\r\n";
	$headers1 .= 'From: '.$Data["UserId"] . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers);
	mail($to1, $subject1, $message1, $headers1);
	
	header("Location: hairfrm_detail.php");
	die();
} else  if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Update"))
{
	
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	$ConArr['fname'] = $Data_userdetail["cust_fname"];
	$ConArr['lname'] = $Data_userdetail["cust_lname"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['country'] = $Data_userdetail["cust_country"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="gender"  || $k=="age" || $k=='start_age' ||  $k=="first_surgery" || $k=="second_surgery" ||  $k=="hairfall_status" || $k=="hairfall_cstatus" || $k=="nature_hair" )
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
		<tr>		<td>Name :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$Data_userdetail["cust_lname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email :	</td><td>'.$Data_userdetail["cust_email"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile :	</td><td>'.$Data_userdetail["cust_phone"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$Data_userdetail["cust_city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Country :	</td><td>'.$Data_userdetail["cust_country"].'</td>			</tr>
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
	
	$to  = $Data["UserId"]; // note the comma
	$to1  = $_SESSION["UserInfo"]["id"]; // note the comma
	$sub = $Data[ClinicName];
	$subject = "New Request for ".$sub;
	$subject1 = "Thanks for Request of".$sub;
	$fname = $Data_userdetail["cust_fname"];
	$lname = $Data_userdetail["cust_lname"];
	$message = "Dear ". $fname. " ".$lname."<br><br>a new message from ". $sub.".<br><br>Thanks<br>Esthetic Planet";
	$message1 = "Dear ". $_SESSION["UserInfo"]["fname"]. " ".$_SESSION["UserInfo"]["lname"]."<br><br>un message de ". $sub.".est arrivé sur votre espace client Esthetic-Planet. Clickez ici pour y acceder<a href='http://www.mosaic-service-demo.com/esthetic_planet/'>Login Here</a><br><br>Thanks<br>Esthetic Planet";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$fname.' '.$lname.' <'.$_SESSION["UserInfo"]["id"].'>' . "\r\n";
	$headers1 .= 'From: '.$Data["UserId"] . "\r\n";

	// Mail it
	$a= mail($to, $subject, $message, $headers);
	mail($to1, $subject1, $message1, $headers1);
	
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
				<div class="login_hea">Formulaire Greffe de Cheveux</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						<div class="list_clinic">demander une consultation en ligne </div>
						
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="list_font">Vos cheveux situation:</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Sexe :</li>
							<li class="field1_form">
								<input type="radio" value="male" name="gender" <?=($Data_list['gender']=='male' || $Data_list['gender']=='' ? 'checked' : '')?>>male<br>
								<input type="radio" value="female" name="gender" <?=($Data_list['gender']=='female' || $Data_list['gender']=='' ? 'checked' : '')?>>féminin
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Âge :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["age"]; ?>" id="chkphone_age" name="age"  class="textbox2" title="Please enter your age"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Votre perte de cheveux a commencé à l'âge de :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["start_age"]; ?>" name="start_age" id="chkphone_start_age" title="Please enter the hair fall start age"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Si vous avez eu la chirurgie cheveux précédente, écrire les détails de votre première intervention ici (date, technique, et le numéro de greffe si vous avez les données) :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["first_surgery"]; ?>" name="first_surgery"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Même si vous avez eu une chirurgie second cheveu :</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["second_surgery"]; ?>" name="second_surgery"  class="textbox2"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Présent calvitie statutX :*</li>
							<li class="field1_form">
								<select name="hairfall_status" class="listmenu" id="chksbox_hairfall_status" title="Please select the hairfall status">
									<option value="">Sélectionnez ...</option>
									<option value="continued" <?php if($Data_list["hairfall_status"]=="continued"){?> selected="selected" <?php } ?>>suite</option>
									<option value="slowed_down" <?php if($Data_list["hairfall_status"]=="slowed_down"){?> selected="selected" <?php } ?>>ralenti</option>
									<option value="stabilised" <?php if($Data_list["hairfall_status"]=="stabilised"){?> selected="selected" <?php } ?>> stabilisée</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">S'il vous plaît sélectionnez le Norwood / Ludwig échelle de la situation cheveux tu es tombé est plus proche de votre situation actuelle :*</li>
							<li class="field1_form">
								<select name="hairfall_cstatus" class="listmenu">
									<option value="">Select...</option>
	<option value="Men_class_1" <?php if($Data_list["hairfall_cstatus"]=="Men_class_1"){?> selected="selected" <?php } ?>>Les hommes de la classe 1
</option>
	<option value="Men_class_2" <?php if($Data_list["hairfall_cstatus"]=="Men_class_2"){?> selected="selected" <?php } ?>>Les hommes de la classe 2</option>
	<option value="Men_class_3" <?php if($Data_list["hairfall_cstatus"]=="Men_class_3"){?> selected="selected" <?php } ?>>Les hommes de la classe 3</option>
	<option value="Men_class_4" <?php if($Data_list["hairfall_cstatus"]=="Men_class_4"){?> selected="selected" <?php } ?>>Les hommes de la classe 4</option>
	<option value="Men_class_5" <?php if($Data_list["hairfall_cstatus"]=="Men_class_5"){?> selected="selected" <?php } ?>>Les hommes de la classe 5</option>
	<option value="Men_class_6" <?php if($Data_list["hairfall_cstatus"]=="Men_class_6"){?> selected="selected" <?php } ?>>Les hommes de la classe 6</option>
	<option value="Men_class_7" <?php if($Data_list["hairfall_cstatus"]=="Men_class_7"){?> selected="selected" <?php } ?>>Les hommes de la classe 7</option>
	<option value="Women_class_1" <?php if($Data_list["hairfall_cstatus"]=="Women_class_1"){?> selected="selected" <?php } ?>>la classe des femmes 1</option>
	<option value="Women_class_2" <?php if($Data_list["hairfall_cstatus"]=="Women_class_2"){?> selected="selected" <?php } ?>>la classe des femmes 2</option>
	<option value="Women_class_3" <?php if($Data_list["hairfall_cstatus"]=="Women_class_3"){?> selected="selected" <?php } ?>>la classe des femmes 3</option>
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
							<li class="field_name_form">Nature de vos cheveux :</li>
							<li class="field1_form">
								<select name="nature_hair" class="listmenu">
									<option value="">Sélectionnez ...</option>
									<option value="straight" <?php if($Data_list["nature_hair"]=="straight"){?> selected="selected" <?php } ?>>tout droit</option>
									<option value="flex" <?php if($Data_list["nature_hair"]=="flex"){?> selected="selected" <?php } ?>>fléchir</option>
									<option value="wavy" <?php if($Data_list["nature_hair"]=="wavy"){?> selected="selected" <?php } ?>>ondulé</option>
									<option value="curly" <?php if($Data_list["nature_hair"]=="curly"){?> selected="selected" <?php } ?>>frisé</option>
									<option value="african_hair" <?php if($Data_list["nature_hair"]=="african_hair"){?> selected="selected" <?php } ?>>Les cheveux africains</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Si vous utilisez un traitement de cheveux s'il vous plaît sélectionnez celui que vous utilisez :</li>
							<?php
								$get_value = $Data_list["htreatment"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="none" <?php if(in_array("none", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> aucun
								  <input type="checkbox" value="minoxidil 2%" <?php if(in_array("minoxidil 2%", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> minoxidil à 2%<br>
								  <input type="checkbox" value="minoxidil 5%" <?php if(in_array("minoxidil 5%", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> minoxidil à 5%<br>
								  <input type="checkbox" value="finasteride 1mg (propecia)" <?php if(in_array("finasteride 1mg (propecia)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> 1mg finastéride (Propecia)<br>
								  <input type="checkbox" value="finasteride 5mg(proscar)" <?php if(in_array("finasteride 5mg(proscar)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> 5mg finastéride (Proscar)<br>
								  <input type="checkbox" value="dutasteride(avodart)" <?php if(in_array("dutasteride(avodart)", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> dutastéride (Avodart)<br>
								  <input type="checkbox" value="saw palmetto" <?php if(in_array("saw palmetto", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> le palmier nain<br>
								  <input type="checkbox" value="mesotherapie" <?php if(in_array("mesotherapie", $getval)) {?> checked="checked" <?php } ?> name="htreatment[]"> Mésothérapie
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="list_font">Chirurgie préférences :</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Si vous envisagez de greffe de cheveux, la procédure qui vous intéresse dans la plupart des? :</li>
							<li class="field1_form">
								<select name="transplant_procedure" class="listmenu">
									<option value="">Sélectionnez ...</option>
									<option value="FUT" <?php if($Data_list["transplant_procedure"]=="FUT"){?> selected="selected" <?php } ?>>FUT</option>
									<option value="FUE(scarless)" <?php if($Data_list["transplant_procedure"]=="FUE(scarless)"){?> selected="selected" <?php } ?>>FUE (cicatrice)</option>
									<option value="BHT(Body_Hair)" <?php if($Data_list["transplant_procedure"]=="BHT(Body_Hair)"){?> selected="selected" <?php } ?>>BHT (poils)</option>
									<option value="Combo(FUE_FUT_BHT)" <?php if($Data_list["transplant_procedure"]=="Combo(FUE_FUT_BHT)"){?> selected="selected" <?php } ?>>Combo (FUE et FUT & BHT)</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Vous êtes spécifiquement à la recherche d'(sélectionner au moins un):  </li>
							<?php
								$get_value = $Data_list["transplant_procedure_case"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="informations on medical treatments" <?php if(in_array("informations on medical treatments", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]">informations sur les traitements médicaux<br>
							  <input type="checkbox" value="informations on surgical treatment (hair transplant)" <?php if(in_array("informations on surgical treatment (hair transplant)", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]"> informations sur le traitement chirurgical (greffe de cheveux)<br>
							  <input type="checkbox" value="invoice for hair transplant" <?php if(in_array("invoice for hair transplant", $getval)) {?> checked="checked" <?php } ?> name="transplant_procedure_case[]">facture pour les cheveux transplantés
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Vous êtes intéressé plus particulièrement dans notre clinique de :</li>
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
									<option value="all_clinics" <?php if($Data_list["clinic_loc"]=="all_clinics"){?> selected="selected" <?php } ?>>toutes les cliniques</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Nous pouvons vous fournir ces options, s'il vous plaît sélectionnez ceux que vous souhaitez:  </li>
							<?php
								$get_value = $Data_list["clinic_procedure"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="photo&amp;email estimation" <?php if(in_array("photo&amp;email estimation", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">estimation photo & e-mail</font><br>
								<input type="checkbox" value="webcam consultation" <?php if(in_array("webcam consultation", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">consultation webcam<br>
								<input type="checkbox" value="phonemeeting" <?php if(in_array("phonemeeting", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">phonemeeting<br>
								<input type="checkbox" value="direct office consultation in Paris, London or Abu Dabhi" <?php if(in_array("direct office consultation in Paris, London or Abu Dabhi", $getval)) {?> checked="checked" <?php } ?> name="clinic_procedure[]">Bureau de consultation directe à Paris, Londres ou Abu Dabhi
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Vous préférez que nous vous répondre à l'aide :</li>
							<li class="field1_form">
								<select name="reply_by" class="listmenu">
									<option value="">Sélectionnez ...</option>
									<option value="email" <?php if($Data_list["reply_by"]=="email"){?> selected="selected" <?php } ?>>e-mail</option>
									<option value="telephone" <?php if($Data_list["reply_by"]=="telephone"){?> selected="selected" <?php } ?>>téléphone</option>
									<option value="skype" <?php if($Data_list["reply_by"]=="skype"){?> selected="selected" <?php } ?>>Skype</option>
									<option value="all_of_the_above" <?php if($Data_list["reply_by"]=="all_of_the_above"){?> selected="selected" <?php } ?>>tout ce qui précède</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Laquelle de ces options à votre avis, vous aider à mieux comprendre les cheveux transplantés:  </li>
							<?php
								$get_value = $Data_list["transplant_option"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="meet a patient" <?php if(in_array("meet a patient", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]">répondre à un patient<br>
							  <input type="checkbox" value="talk to a patient" <?php if(in_array("talk to a patient", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> parler à un patient<br>
							  <input type="checkbox" value="see a surgery" <?php if(in_array("see a surgery", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> voir une intervention chirurgicale<br>
							  <input type="checkbox" value="in-depth consultation" <?php if(in_array("in-depth consultation", $getval)) {?> checked="checked" <?php } ?> name="transplant_option[]"> consultation en profondeur
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Décrivez vos objectifs ici :*</li>
							<li class="field1_form">
								<textarea rows="10" cols="45" name="your_goal"  class="textbox_form"><?php echo $Data_list["your_goal"]; ?></textarea> 
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Vous avez entendu parler de nous par le biais :</li>
							<li class="field1_form">
								<select name="heard_from" class="listmenu">
									<option value="">Sélectionnez ...</option>
									<option value="TV" <?php if($Data_list["heard_from"]=="TV"){?> selected="selected" <?php } ?>>TV</option>
									<option value="radio" <?php if($Data_list["heard_from"]=="radio"){?> selected="selected" <?php } ?>>radio</option>
									<option value="newspaper" <?php if($Data_list["heard_from"]=="newspaper"){?> selected="selected" <?php } ?>>journal</option>
									<option value="google" <?php if($Data_list["heard_from"]=="google"){?> selected="selected" <?php } ?>>google</option>
									<option value="yahoo" <?php if($Data_list["heard_from"]=="yahoo"){?> selected="selected" <?php } ?>>yahoo</option>
									<option value="msn(bing)" <?php if($Data_list["heard_from"]=="msn(bing)"){?> selected="selected" <?php } ?>>msn(bing)</option>
									<option value="word_of_mouth" <?php if($Data_list["heard_from"]=="word_of_mouth"){?> selected="selected" <?php } ?>>le bouche à oreille
</option>
									<option value="forums" <?php if($Data_list["heard_from"]=="forums"){?> selected="selected" <?php } ?>>forums</option>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Veuillez entrer une des images vers l'avant
							</li>
							<li class="field1_form">
								<input type="file" id="face_fwd" name="face_fwd"> (Maximum de 2 Mo)
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
								Entrez une image du sommet de votre crâne
							</li>
							<li class="field1_form">
								<input type="file" id="top_skull" name="top_skull"> (Maximum de 2 Mo)
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
								Entrez une image sur les côtés
							</li>
							<li class="field1_form">
								<input type="file" id="face_side" name="face_side"> (Maximum de 2 Mo)
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
								Entrez une photo de vous zone donneuse
							</li>
							<li class="field1_form">
								<input type="file" id="donor_area" name="donor_area"> (Maximum de 2 Mo)
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
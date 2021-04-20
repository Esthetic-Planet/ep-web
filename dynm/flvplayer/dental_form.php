<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$dtid = $_GET['did'];
$frm_id = $_GET['qid'];
//if(!empty($_GET['did']))
//{
	$uid = $_SESSION['UserInfo']['id'];
	//$cond_list="where 1=1 and UserId='$uid' and hid='$dtid'";
	$cond_list="where 1=1 and UserId='$uid'";
	$orderby_list="order by hid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_dentalcare",$cond_list,$orderby_list);
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

//if(isset($_POST['envoi']) && ($_REQUEST['envoi'] == "Envoyer"))
if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Submit"))
{
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	$ConArr['name'] = $Data_userdetail["cust_fname"];
	$ConArr['surname'] = $Data_userdetail["cust_lname"];
	$ConArr['age'] = $_REQUEST["age"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	$ConArr['do_smoke'] = $_REQUEST["dental_desc"];
		
	
		if(!empty($_REQUEST["teeth_up_case"]))
			$teeth_up_case = implode('|',$_REQUEST["teeth_up_case"]);
		else
			$teeth_up_case = "";
		if(!empty($_REQUEST["teeth_low_case"]))
			$teeth_low_case = implode('|',$_REQUEST["teeth_low_case"]);
		else
			$teeth_low_case = "";
	
	$ConArr['teeth_up_case'] = $teeth_up_case;
	$ConArr['teeth_low_case'] = $teeth_low_case;
	$ConArr['dental_desc'] = $_REQUEST["dental_desc"];
	$ConArr['allergy_reason'] = $_REQUEST["allergy_reason"];
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	$intResult = $sql->SqlInsert('esthp_dentalcare',$ConArr);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td>Name :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$Data_userdetail["cust_lname"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Age :	</td><td>'.$_REQUEST["age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile Number :	</td><td>'.$Data_userdetail["cust_phone"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$Data_userdetail["cust_city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email-ID :	</td><td>'.$Data_userdetail["cust_email"].'</td>			</tr>	
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Do you smoke? :	</td><td>'.$_REQUEST["do_smoke"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>All upper teeth :	</td><td>'.$teeth_up_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>All lower teeth :	</td><td>'.$teeth_low_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Here describe the dental care that you have ever had, and those you want to achieve :	</td><td>'.$_REQUEST["dental_desc"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Known allergies and current medical :	</td><td>'.$_REQUEST["allergy_reason"].'</td>			</tr>
	</table>
	';
	
	$attachmants = "";
	
	if($intResult)
	{
		if($_FILES['dental_panoramic']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['dental_panoramic']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['dental_panoramic']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['dental_panoramic'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo1']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo1']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['image1'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo2']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['image2'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo3']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['image3'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo4']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['image4'] = $file_name ;
					$condition = " where hid ='".$intResult."'";
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
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
	
	
	header("Location: dentalfrm_detail.php");
	die();
}  else  if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Update"))
{
	
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	$ConArr['name'] = $Data_userdetail["cust_fname"];
	$ConArr['surname'] = $Data_userdetail["cust_lname"];
	$ConArr['age'] = $_REQUEST["age"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	$ConArr['do_smoke'] = $_REQUEST["dental_desc"];
		
	if(!empty($_REQUEST["teeth_up_case"]))
		$teeth_up_case = implode('|',$_REQUEST["teeth_up_case"]);
	else
		$teeth_up_case = "";
	if(!empty($_REQUEST["teeth_low_case"]))
		$teeth_low_case = implode('|',$_REQUEST["teeth_low_case"]);
	else
		$teeth_low_case = "";
	
	$ConArr['teeth_up_case'] = $teeth_up_case;
	$ConArr['teeth_low_case'] = $teeth_low_case;
	$ConArr['dental_desc'] = $_REQUEST["dental_desc"];
	$ConArr['allergy_reason'] = $_REQUEST["allergy_reason"];
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	if(!empty($dtid))
	{
		$condition = " where hid='".$dtid."'";
	} else {
		$condition = " where hid='".$Data_list['hid']."'";
	}
	$intResult = $sql->SqlUpdate('esthp_dentalcare',$ConArr,$condition);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td>Name :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Surname :	</td><td>'.$Data_userdetail["cust_lname"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Age :	</td><td>'.$_REQUEST["age"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Mobile Number :	</td><td>'.$Data_userdetail["cust_phone"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>City :	</td><td>'.$Data_userdetail["cust_city"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Email-ID :	</td><td>'.$Data_userdetail["cust_email"].'</td>			</tr>			
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Do you smoke? :	</td><td>'.$_REQUEST["do_smoke"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>All upper teeth :	</td><td>'.$teeth_up_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>All lower teeth :	</td><td>'.$teeth_low_case.'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Here describe the dental care that you have ever had, and those you want to achieve :	</td><td>'.$_REQUEST["dental_desc"].'</td>			</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
		<tr>		<td>Known allergies and current medical :	</td><td>'.$_REQUEST["allergy_reason"].'</td>			</tr>
	</table>
	';
	
	$attachmants = "";
	
	
		if($_FILES['dental_panoramic']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['dental_panoramic']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['dental_panoramic']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["dental_panoramic"];
					$file_name = $file_name."|".$files;
					$content_arr['dental_panoramic'] = $file_name ;
					//$condition = " where hid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where hid='".$dtid."'";
					} else {
						$condition = " where hid='".$Data_list['hid']."'";
					}
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo1']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo1']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["image1"];
					$file_name = $file_name."|".$files;
					$content_arr['image1'] = $file_name ;
					//$condition = " where hid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where hid='".$dtid."'";
					} else {
						$condition = " where hid='".$Data_list['hid']."'";
					}
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo2']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["image2"];
					$file_name = $file_name."|".$files;
					$content_arr['image2'] = $file_name ;
					//$condition = " where hid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where hid='".$dtid."'";
					} else {
						$condition = " where hid='".$Data_list['hid']."'";
					}
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo3']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["image3"];
					$file_name = $file_name."|".$files;
					$content_arr['image3'] = $file_name ;
					//$condition = " where hid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where hid='".$dtid."'";
					} else {
						$condition = " where hid='".$Data_list['hid']."'";
					}
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo4']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['photo4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["image4"];
					$file_name = $file_name."|".$files;
					$content_arr['image4'] = $file_name ;
					//$condition = " where hid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where hid='".$dtid."'";
					} else {
						$condition = " where hid='".$Data_list['hid']."'";
					}
					$sql->SqlUpdate('esthp_dentalcare',$content_arr,$condition);
					
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
	mail($to, $subject, $message, $headers);
	mail($to1, $subject1, $message1, $headers1);
	
	header("Location: dentalfrm_detail.php");
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
				<div class="login_hea">Formulaire dentaire</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						<div class="list_clinic">Formulaire de Demande de devis Dentaire</div>
						
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="field_name_form">Age :*</li>
							<li class="field1_form"><input type="text" value="<?php echo $Data_list["age"]; ?>" name="age" id="chkphone_age"  class="textbox2" title=" Veuillez renseigner votre age
		"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Fumez-vous? :* </li>
							<li class="field1_form">
								<input type="radio" value="oui" name="do_smoke" <?=($Data_list['do_smoke']=='oui' || $Data_list['do_smoke']=='' ? 'checked' : '')?> id="chkradio_do_smoke" title="Veuillez indiquer si vous fumez">oui<br>
								<input type="radio" value="non" name="do_smoke" <?=($Data_list['do_smoke']=='non' || $Data_list['do_smoke']=='' ? 'checked' : '')?> id="chkradio_do_smoke" title="Veuillez indiquer si vous fumez">non<br>
								<input type="radio" value="occasionnellement" <?=($Data_list['do_smoke']=='occasionnellement' || $Data_list['do_smoke']=='' ? 'checked' : '')?> id="chkradio_do_smoke" name="do_smoke" title="Veuillez indiquer si vous fumez">occasionnellement
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<?php
								$get_value = $Data_list["teeth_up_case"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="27" <?php if(in_array("27", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="26" <?php if(in_array("26", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="25" <?php if(in_array("25", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="24" <?php if(in_array("24", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="23" <?php if(in_array("23", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="22" <?php if(in_array("22", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="21" <?php if(in_array("21", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="11" <?php if(in_array("11", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="12" <?php if(in_array("12", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="13" <?php if(in_array("13", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="14" <?php if(in_array("14", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="15" <?php if(in_array("15", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="16" <?php if(in_array("16", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="17" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
								<input type="checkbox" value="TOUTES DENTS SUPERIEURES" <?php if(in_array("TOUTES DENTS SUPERIEURES", $getval)) {?> checked="checked" <?php } ?> name="teeth_up_case[]">
							</li>
							<li class="field1_form1">
								&nbsp; 27 &nbsp; 26 &nbsp;&nbsp; 25 &nbsp;&nbsp; 24 &nbsp; 23 &nbsp; 22 &nbsp; 
								21 &nbsp;&nbsp; 11 &nbsp;&nbsp; 12 &nbsp;&nbsp; 13 &nbsp;&nbsp; 14 &nbsp; 15 
								&nbsp; 16 &nbsp;&nbsp; 17 &nbsp;&nbsp; TOUTES DENTS SUPERIEURES
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Cochez les dents à soigner :</li>
							<li class="field1_form">
								<img width="200" height="300" alt="&lt;schema dentaire europe-dentaire.com&gt;" src="images/schemadentaire.gif"></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<?php
								$get_value = $Data_list["teeth_low_case"];
								$getval = explode("|",$get_value);
							?>
							<li class="field1_form">
								<input type="checkbox" value="37" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="36" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="35" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="34" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="33" <?php if(in_array("17", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="32" <?php if(in_array("32", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="31" <?php if(in_array("31", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="41" <?php if(in_array("41", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="42" <?php if(in_array("42", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="43" <?php if(in_array("43", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="44" <?php if(in_array("44", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="45" <?php if(in_array("45", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="46" <?php if(in_array("46", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="47" <?php if(in_array("47", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
								<input type="checkbox" value="TOUTES DENTS INFERIEURES" <?php if(in_array("TOUTES DENTS INFERIEURES", $getval)) {?> checked="checked" <?php } ?> name="teeth_low_case[]">
							</li>
							<li class="field1_form1">
								&nbsp; 37 &nbsp; 36 &nbsp;&nbsp; 35 &nbsp;&nbsp; 34 &nbsp;&nbsp; 33 &nbsp;&nbsp; 
								32 &nbsp;&nbsp; 31 &nbsp;&nbsp; 41 &nbsp;&nbsp; 42 &nbsp; 43 &nbsp; 
								44 &nbsp; 45 &nbsp; 46 &nbsp;&nbsp;&nbsp; 47 &nbsp;&nbsp; TOUTES DENTS INFERIEURES
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Décrivez ici les soins dentaires que vous avez déja eu, et ceux que vous souhaitez réaliser :</li>
							<li class="field1_form">
								<textarea rows="10" cols="45" name="dental_desc"  class="textbox_form"><?php echo $Data_list["dental_desc"]; ?></textarea></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Allergies connues et actuels traitements médicaux :</li>
							<li class="field1_form">
								<textarea rows="10" cols="45" name="allergy_reason"  class="textbox_form"><?php echo $Data_list["allergy_reason"]; ?></textarea></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Panoramique dentaire
							</li>
							<li class="field1_form">
								<input type="file" id="dental_panoramic" name="dental_panoramic"> (6 Mo maximum)
								<?php
									//$dental_panoramic=$Data_list['dental_panoramic'];
									$dental_panoramic=explode("|",$Data_list['dental_panoramic']);
									$get_dental_panoramic = $dental_panoramic[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_dental_panoramic))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_dental_panoramic?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Photo 1
							</li>
							<li class="field1_form">
								<input type="file" id="photo1" name="photo1"> (6 Mo maximum)
								<?php
									//$photo1=$Data_list['photo1'];
									$photo1=explode("|",$Data_list['photo1']);
									$get_photo1 = $photo1[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_photo1))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_photo1?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Photo 2
							</li>
							<li class="field1_form">
								<input type="file" id="photo2" name="photo2"> (6 Mo maximum)
								<?php
									//$photo2=$Data_list['photo2'];
									$photo2=explode("|",$Data_list['photo2']);
									$get_photo2 = $photo2[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_photo2))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_photo2?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Photo 3
							</li>
							<li class="field1_form">
								<input type="file" id="photo3" name="photo3"> (6 Mo maximum)
								<?php
									//$photo3=$Data_list['photo3'];
									$photo3=explode("|",$Data_list['photo3']);
									$get_photo3 = $photo3[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_photo3))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_photo3?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Photo 4
							</li>
							<li class="field1_form">
								<input type="file" id="photo4" name="photo4"> (6 Mo maximum)
								<?php
									$photo4=explode("|",$Data_list['photo4']);
									$get_photo4 = $photo4[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_photo4))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_photo4?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
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
								else if(isset($_REQUEST['did']) && $_REQUEST['did']!='')
								{
									$btnName = "Update";
								}
								else
								{
									$btnName = "Submit";
								}
							?>
								<input type="reset" value=" Effacer " name="Reset">
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

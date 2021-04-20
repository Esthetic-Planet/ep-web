<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$pid = $_GET['pid'];
$frm_id = $_GET['qid'];
//if(!empty($_GET['pid']))
//{
	$uid = $_SESSION['UserInfo']['id'];
	//$cond_list="where 1=1 and UserId='$uid' and pid='$pid'";
	$cond_list="where 1=1 and UserId='$uid' and clinicid='0'";
	$orderby_list="order by pid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_plasticsurgery",$cond_list,$orderby_list);
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

$frm_id = $_REQUEST['qid'];

//if(isset($_POST['envoi']) && ($_REQUEST['envoi'] == "Envoyer"))
if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Submit"))
{
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	//$ConArr['clinicid'] = $_REQUEST["clid"];
	$ConArr['clinicid'] = 0;
	
	$ConArr['fname'] = $Data_userdetail["cust_fname"];
	$ConArr['lname'] = $Data_userdetail["cust_lname"];
	$ConArr['age'] = $_REQUEST["age"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['will_heal'] = $_REQUEST["will_heal"];
	$ConArr['country'] = $Data_userdetail["cust_country"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="treatment_requested" || $k=="second_pro_treatment" || $k=="you_prefer" || $k=='contact_mode' ||  $k=="heard_from" || $k=="prefer_mode" || $k=="allergy_knwn" || $k=='cmedical_treatment' ||  $k=="convey_surgen" )
		{
			$ConArr[$k]=$v;
			$Data[$k]=$v;
		}
	}
	
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	$intResult = $sql->SqlInsert('esthp_plasticsurgery',$ConArr);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>			<td>Nom :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Prénom :	</td><td>'.$Data_userdetail["cust_lname"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Age :	</td><td>'.$_REQUEST["age"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Téléphone :	</td><td>'.$Data_userdetail["cust_phone"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Normalement vous cicatrisez (Bien, Plutôt bien, plutôt mal, trés mal et en relief) :	</td><td>'.$_REQUEST["will_heal"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Pays :	</td><td>'.$Data_userdetail["cust_country"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Ville :	</td><td>'.$Data_userdetail["cust_city"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Email :	</td><td>'.$Data_userdetail["cust_email"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Traitement souhaité :	</td><td>'.$_REQUEST["treatment_requested"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Deuxieme traitement envisagé :	</td><td>'.$_REQUEST["second_pro_treatment"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Vous préférez :	</td><td>'.$_REQUEST["you_prefer"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Comment préférez vous être contacté(e) :</td><td>'.$_REQUEST["contact_mode"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Comment avez-vous connu Esthetic-Planet? :</td><td>'.$_REQUEST["heard_from"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Préférez-vous? :</td><td>'.$_REQUEST["prefer_mode"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Allergies Connues :</td><td>'.$_REQUEST["allergy_knwn"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Suivez-vous actuellement un/des traitements médicaux :</td><td>'.$_REQUEST["cmedical_treatment"].'</td></tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Les objectifs que vous souhaitez transmettre au chirurgien :</td><td>'.$_REQUEST["convey_surgen"].'</td></tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Les objectifs que vous souhaitez transmettre au chirurgien :</td><td>'.$_REQUEST["convey_surgen"].'</td></tr>
	</table>	';
	
	
	$attachmants = "";
	
		if($_FILES['photo1']['name']!="")
		{
		if($_FILES['photo1']['size'] >2000000 || $_FILES['photo1']['error'])
	{
	
	header("Location: plastic_surgery_form.php?mseg=photo1&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
		
				$upload_dir = _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo1']['name'];
				$upload_file = $upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['photo1'] = $file_name ;
					$condition = " where pid ='".$intResult."'";
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo2']['name']!="")
		{
		if($_FILES['photo2']['size'] >2000000 || $_FILES['photo2']['error'])
	{
	
header("Location: plastic_surgery_form.php?mseg=photo2&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['photo2'] = $file_name ;
					$condition = " where pid ='".$intResult."'";
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo3']['name']!="")
		{
		if($_FILES['photo3']['size'] >2000000 || $_FILES['photo3']['error'])
	{
	
header("Location: plastic_surgery_form.php?mseg=photo3&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['photo3'] = $file_name ;
					$condition = " where pid ='".$intResult."'";
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['photo4']['name']!="")
		{
		
		if($_FILES['photo4']['size'] >2000000 || $_FILES['photo4']['error'])
	{
	
header("Location: plastic_surgery_form.php?mseg=photo4&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['photo4'] = $file_name ;
					$condition = " where pid ='".$intResult."'";
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		
		$clinicid = $_REQUEST["clid"];
		$where = "WHERE 1=1 and IsActive='t' and find_in_set('$frm_id',	UserCategories) and UserId='$clinicid'";
		$query = $sql->SqlRecords("esthp_tblUsers",$where);
		$total_count = $query["TotalCount"];
		$count = $query["count"];
		$Data = $query["Data"][0];
	if($count >0)
	{
		$ConArr_mail = array();	
		$ConArr_mail['mail_date'] = time();
		$ConArr_mail["mail_sender"] =  $_SESSION["UserInfo"]["id"];
		$ConArr_mail["mail_reciever"] = $Data[UserId];
		$ConArr_mail["mail_type"] = "customer_to_clinic";
		$ConArr_mail["mail_subject"] = $Data[ClinicName];
		$ConArr_mail["mail_body"] = htmlspecialchars(addslashes($message_body));	
		$ConArr_mail["mail_attachment"] = addslashes($attachmants) ;

	//$ConArr_mail["mail_ParentId"] = $parent_Id;
	$ConArr_mail["mail_ParentId"] = 0;
		
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr_mail);
	
	$super_admin_arr = $sql->SqlSuperAdmin();	
							$Count = $super_admin_arr['count'];
							$admin_arr = $super_admin_arr['Data'][0];	
							$admin_email =$admin_arr['LoginEmail'];
	// Mail it
							
					$admin_arr['FirstName'].' '.$admin_arr['LastName'] ;
	$to  = $Data["LoginEmail"];
	$to1  = $_SESSION["UserInfo"]["id"]; // note the comma
	$sub = $Data[ClinicName];
	$subject = "New Request for ".$sub;
	$subject1 = "Thanks for Request of".$sub;
	$fname = $Data_userdetail["cust_fname"];
	$lname = $Data_userdetail["cust_lname"];
	$message =$Data[FirstName]. " ".$Data[LastName]." un message de ".$Data[ClinicName]." est arrivé sur votre espace client Esthetic-Planet. Cliquez ici pour y acceder "._ADMIN_WWWROOT."";
	//$message1 = "Dear ". $_SESSION["UserInfo"]["fname"]. " ".$_SESSION["UserInfo"]["lname"]."<br><br>un message de ". $sub.".est arrivé sur votre espace client Esthetic-Planet. Clickez ici pour y acceder<a href='http://www.mosaic-service-demo.com/esthetic_planet/'>Login Here</a><br><br>Thanks<br>Esthetic Planet";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$admin_arr['FirstName'].' '.$admin_arr['LastName'].' <'.$admin_email.'>' . "\r\n";
	$headers1 .= 'From: '.$Data["UserId"] . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers);
	//mail($to1, $subject1, $message1, $headers1);
	header("Location: plasticsurgeryfrm_detail.php?msg=thk");
	die();
}	
	header("Location: plasticsurgeryfrm_detail.php");
	die();
} else  if(isset($_POST['submit']) && (($_REQUEST['submit'] == "Update")||($_REQUEST['submit'] == "envoyer")))
{
	
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	//$ConArr['clinicid'] = $_REQUEST["clid"];
	$ConArr['clinicid'] = 0;
	$ConArr['fname'] = $Data_userdetail["cust_fname"];
	$ConArr['lname'] = $Data_userdetail["cust_lname"];
	$ConArr['age'] = $_REQUEST["age"];
	$ConArr['mobile'] = $Data_userdetail["cust_phone"];
	$ConArr['will_heal'] = $_REQUEST["will_heal"];
	$ConArr['country'] = $Data_userdetail["cust_country"];
	$ConArr['city'] = $Data_userdetail["cust_city"];
	$ConArr['email'] = $Data_userdetail["cust_email"];
	
	foreach($ReqArr as $k=>$v)
	{
		if($k=="treatment_requested" || $k=="second_pro_treatment" || $k=="you_prefer" || $k=='contact_mode' ||  $k=="heard_from" || $k=="prefer_mode" || $k=="allergy_knwn" || $k=='cmedical_treatment' ||  $k=="convey_surgen" )
		{
			$ConArr[$k]=$v;
			$Data[$k]=$v;
		}
	}
	
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	if(!empty($pid))
	{
		$condition = " where pid='".$Data_list['pid']."'";
	} else {
		$condition = " where pid='".$Data_list['pid']."'";
	}
	$intResult = $sql->SqlUpdate('esthp_plasticsurgery',$ConArr,$condition);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>			<td>Nom :	</td><td>'.$Data_userdetail["cust_fname"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Prénom :	</td><td>'.$Data_userdetail["cust_lname"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Age :	</td><td>'.$_REQUEST["age"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Téléphone :	</td><td>'.$Data_userdetail["cust_phone"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Normalement vous cicatrisez (Bien, Plutôt bien, plutôt mal, trés mal et en relief) :	</td><td>'.$_REQUEST["will_heal"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Pays :	</td><td>'.$Data_userdetail["cust_country"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Ville :	</td><td>'.$Data_userdetail["cust_city"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Email :	</td><td>'.$Data_userdetail["cust_email"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Traitement souhaité :	</td><td>'.$_REQUEST["treatment_requested"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Deuxieme traitement envisagé :	</td><td>'.$_REQUEST["second_pro_treatment"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Vous préférez :	</td><td>'.$_REQUEST["you_prefer"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Comment préférez vous être contacté(e) :</td><td>'.$_REQUEST["contact_mode"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Comment avez-vous connu Esthetic-Planet? :</td><td>'.$_REQUEST["heard_from"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Préférez-vous? :</td><td>'.$_REQUEST["prefer_mode"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr>			<td>Allergies Connues :</td><td>'.$_REQUEST["allergy_knwn"].'</td>		</tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Suivez-vous actuellement un/des traitements médicaux :</td><td>'.$_REQUEST["cmedical_treatment"].'</td></tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Les objectifs que vous souhaitez transmettre au chirurgien :</td><td>'.$_REQUEST["convey_surgen"].'</td></tr>
		<tr>			<td colspan="2">&nbsp;</td>		</tr>
		<tr><td>Les objectifs que vous souhaitez transmettre au chirurgien :</td><td>'.$_REQUEST["convey_surgen"].'</td></tr>
	</table>	';
	
	
	$attachmants = "";
	
		if($_FILES['photo1']['name']!="")
		{
		if($_FILES['photo1']['size'] >2000000 || $_FILES['photo1']['error'])
	{
	
	header("Location: plastic_surgery_form.php?mseg=photo1&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir = _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo1']['name'];
				$upload_file = $upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["photo1"];
					$file_name = $file_name."|".$files;
					$content_arr['photo1'] = $file_name ;
					if(!empty($pid))
					{
						$condition = " where pid='".$pid."'";
					} else {
						$condition = " where pid='".$Data_list['pid']."'";
					}
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}else {  if($attachmants != "" && $Data_list["photo1"]!="")	  $attachmants .= "|";
				$attachmants .= $Data_list["photo1"] ; }
		if($_FILES['photo2']['name']!="")
		{
		if($_FILES['photo2']['size'] >2000000 || $_FILES['photo2']['error'])
	{
	
	header("Location: plastic_surgery_form.php?mseg=photo2&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["photo2"];
					$file_name = $file_name."|".$files;
					$content_arr['photo2'] = $file_name ;
					if(!empty($pid))
					{
						$condition = " where pid='".$pid."'";
					} else {
						$condition = " where pid='".$Data_list['pid']."'";
					}
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}else {  if($attachmants != "" && $Data_list["photo2"]!="")	  $attachmants .= "|";
				$attachmants .= $Data_list["photo2"] ; }
		if($_FILES['photo3']['name']!="")
		{
		
		if($_FILES['photo3']['size'] >2000000 || $_FILES['photo3']['error'])
	{
	
	header("Location: plastic_surgery_form.php?mseg=photo3&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["photo3"];
					$file_name = $file_name."|".$files;
					$content_arr['photo3'] = $file_name ;
					if(!empty($pid))
					{
						$condition = " where pid='".$pid."'";
					} else {
						$condition = " where pid='".$Data_list['pid']."'";
					}
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}else {  if($attachmants != "" && $Data_list["photo3"]!="")	  $attachmants .= "|";
				$attachmants .= $Data_list["photo3"] ; }
		if($_FILES['photo4']['name']!="")
		{
		
		if($_FILES['photo4']['size'] >2000000 || $_FILES['photo4']['error'])
	{
	
	header("Location: plastic_surgery_form.php?mseg=photo3&pid=".$_REQUEST['pid']."&qid=".$_REQUEST['qid']."&clid=".$_REQUEST['clid']);
	die();
	}
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name = time().'_'.$_FILES['photo4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['photo4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["photo4"];
					$file_name = $file_name."|".$files;
					$content_arr['photo4'] = $file_name ;
					if(!empty($pid))
					{
						$condition = " where pid='".$pid."'";
					} else {
						$condition = " where pid='".$Data_list['pid']."'";
					}
					$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		} else {  if($attachmants != "" && $Data_list["photo4"]!="")	  $attachmants .= "|";
				$attachmants .= $Data_list["photo4"] ; }
		
		$clinicid = $_REQUEST["clid"];
		$where = "WHERE 1=1 and IsActive='t' and find_in_set('$frm_id',	UserCategories) and UserId='$clinicid'";
		$query = $sql->SqlRecords("esthp_tblUsers",$where);
		$total_count = $query["TotalCount"];
		$count = $query["count"];
		$Data = $query["Data"][0];
	if($count >0)
	{
		$ConArr_mail = array();	
		$ConArr_mail['mail_date'] = time();
		$ConArr_mail["mail_sender"] =  $_SESSION["UserInfo"]["id"];
		$ConArr_mail["mail_reciever"] = $Data[UserId];
		$ConArr_mail["mail_type"] = "customer_to_clinic";
		$ConArr_mail["mail_subject"] = $Data[ClinicName];
		$ConArr_mail["mail_body"] = addslashes($message_body) ;	
		$ConArr_mail["mail_attachment"] = addslashes($attachmants) ;

	//$ConArr_mail["mail_ParentId"] = $parent_Id;
	$ConArr_mail["mail_ParentId"] = 0;
		
	$intResult = $sql->SqlInsert('esthp_mails',$ConArr_mail);
	
	$super_admin_arr = $sql->SqlSuperAdmin();	
							$Count = $super_admin_arr['count'];
							$admin_arr = $super_admin_arr['Data'][0];	
							$admin_email =$admin_arr['LoginEmail'];
	// Mail it
							
					$admin_arr['FirstName'].' '.$admin_arr['LastName'] ;
	$to  = $Data["LoginEmail"];
	$to1  = $_SESSION["UserInfo"]["id"]; // note the comma
	$sub = $Data[ClinicName];
	$subject = "New Request for ".$sub;
	$subject1 = "Thanks for Request of".$sub;
	$fname = $Data_userdetail["cust_fname"];
	$lname = $Data_userdetail["cust_lname"];
	$message =$Data[FirstName]. " ".$Data[LastName]." un message de ".$Data[ClinicName]." est arrivé sur votre espace client Esthetic-Planet. Cliquez ici pour y acceder "._ADMIN_WWWROOT."";
	//$message1 = "Dear ". $_SESSION["UserInfo"]["fname"]. " ".$_SESSION["UserInfo"]["lname"]."<br><br>un message de ". $sub.".est arrivé sur votre espace client Esthetic-Planet. Clickez ici pour y acceder<a href='http://www.mosaic-service-demo.com/esthetic_planet/'>Login Here</a><br><br>Thanks<br>Esthetic Planet";
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$admin_arr['FirstName'].' '.$admin_arr['LastName'].' <'.$admin_email.'>' . "\r\n";
	$headers1 .= 'From: '.$Data["UserId"] . "\r\n";

	// Mail it
	mail($to, $subject, $message, $headers);
	//mail($to1, $subject1, $message1, $headers1);
	header("Location: plasticsurgeryfrm_detail.php?msg=thk");
	die();
	}
	header("Location: plasticsurgeryfrm_detail.php");
	die();
}
$mesg="";
if($_REQUEST['mseg']!="")
{
	
	if($_REQUEST['mseg']=="photo1") $mesg="File Size Error In "."Photo 1";
	if($_REQUEST['mseg']=="photo2") $mesg="File Size Error In "."Photo 2";
	if($_REQUEST['mseg']=="photo3") $mesg="File Size Error In "."Photo 3";
	if($_REQUEST['mseg']=="photo4") $mesg="File Size Error In "."Photo 4";
}
?>
<?php include("header.php"); ?>

<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea"><?php header('Content-Type: text/html; charset=utf-8'); ?>Formulaire Chirurgie esthétique</div>
				<div class="clear"></div>
					<div><b><?php echo $mesg; ?></b></div>
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						<div class="list_clinic">Demande de devis</div>
						
						<!--Start form -->
						<div id="form">
						<ul>
							<li class="field_name_form">Age :*</li>
							<li class="field1_form"><input name="age" type="text"  class="textbox2" id="age" value="<?php echo $Data_list["age"]; ?>">
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Normalement vous cicatrisez (Bien, Plutôt bien, plutôt mal, trés mal et en relief). :</li>
							<li class="field1_form"><input name="will_heal" type="text"  class="textbox2" id="will_heal" value="<?php echo $Data_list["will_heal"]; ?>">
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Traitement souhaité :</li>
							<li class="field1_form">
								<select name="treatment_requested" class="listmenu" id="treatment_requested">
		                            <option value="">Sélectionner...</option>
        		                    <option value="Lifting Cervico Facial (L.C.F)" <?php if($Data_list["treatment_requested"]=="Lifting Cervico Facial (L.C.F)"){?> selected="selected" <?php } ?>>Lifting Cervico Facial (L.C.F)</option>
                		            <option value="Lifting Complet du visage (L.C.F+Botox)" <?php if($Data_list["treatment_requested"]=="Lifting Complet du visage (L.C.F+Botox)"){?> selected="selected" <?php } ?>>Lifting Complet du visage (L.C.F+Botox)</option>
                        		    <option value="Reprise de cicatrice" <?php if($Data_list["treatment_requested"]=="Reprise de cicatrice"){?> selected="selected" <?php } ?>>Reprise de cicatrice</option>
		                            <option value="Chirurgie des Oreilles" <?php if($Data_list["treatment_requested"]=="Chirurgie des Oreilles"){?> selected="selected" <?php } ?>>Chirurgie des Oreilles</option>
        		                    <option value="Chirurgie des Paupieres" <?php if($Data_list["treatment_requested"]=="Chirurgie des Paupieres"){?> selected="selected" <?php } ?>>Chirurgie des Paupieres</option>
                		            <option value="Blepharo 2 Paupieres Superieures" <?php if($Data_list["treatment_requested"]=="Blepharo 2 Paupieres Superieures"){?> selected="selected" <?php } ?>>Blepharo 2 Paupieres Superieures</option>
                        		    <option value="Blepharo 2 Paupieres Inferieures" <?php if($Data_list["treatment_requested"]=="Blepharo 2 Paupieres Inferieures"){?> selected="selected" <?php } ?>>Blepharo 2 Paupieres Inferieures</option>
		                            <option value="Blepharo 4 Paupieres" <?php if($Data_list["treatment_requested"]=="Blepharo 4 Paupieres"){?> selected="selected" <?php } ?>>Blepharo 4 Paupieres</option>
        			                <option value="Chirurgie du Nez" <?php if($Data_list["treatment_requested"]=="Chirurgie du Nez"){?> selected="selected" <?php } ?>>Chirurgie du Nez</option>
                    	    	    <option value="Rhinoplastie (bosse et pointe)" <?php if($Data_list["treatment_requested"]=="Rhinoplastie (bosse et pointe)"){?> selected="selected" <?php } ?>>Rhinoplastie (bosse et pointe)</option>
                        	    	<option value="Augmentation des levres (Lipo Filling)" <?php if($Data_list["treatment_requested"]=="Augmentation des levres (Lipo Filling)"){?> selected="selected" <?php } ?>>Augmentation des levres (Lipo Filling)</option>
		                            <option value="Chirurgie du Menton" <?php if($Data_list["treatment_requested"]=="Chirurgie du Menton"){?> selected="selected" <?php } ?>>Chirurgie du Menton</option>
        		                    <option value="Genioplastie" <?php if($Data_list["treatment_requested"]=="Genioplastie"){?> selected="selected" <?php } ?>>Genioplastie</option>
                		            <option value="Chirurgie du Cou" <?php if($Data_list["treatment_requested"]=="Chirurgie du Cou"){?> selected="selected" <?php } ?>>Chirurgie du Cou</option>
                        		    <option value="Liposuccion du cou" <?php if($Data_list["treatment_requested"]=="Liposuccion du cou"){?> selected="selected" <?php } ?>>Liposuccion du cou</option>
		                            <option value="Chirurgie de la poitrine" <?php if($Data_list["treatment_requested"]=="Chirurgie de la poitrine"){?> selected="selected" <?php } ?>>Chirurgie de la poitrine</option>
        		                    <option value="Augmentation mammaire (protheses rondes)" <?php if($Data_list["treatment_requested"]=="Augmentation mammaire (protheses rondes)"){?> selected="selected" <?php } ?>>Augmentation mammaire (protheses rondes)</option>
                		            <option value="Augmentation mammaire (protheses anatomiques)" <?php if($Data_list["treatment_requested"]=="Augmentation mammaire (protheses anatomiques)"){?> selected="selected" <?php } ?>>Augmentation mammaire (protheses anatomiques)</option>
                        		    <option value="Changement de protheses mammaires (protheses rondes)" <?php if($Data_list["treatment_requested"]=="Changement de protheses mammaires (protheses rondes)"){?> selected="selected" <?php } ?>>Changement de protheses mammaires (protheses rondes)</option>
		                            <option value="Lifting des seins (sans protheses)" <?php if($Data_list["treatment_requested"]=="Lifting des seins (sans protheses)"){?> selected="selected" <?php } ?>>Lifting des seins (sans protheses)</option>
        		                    <option value="Lifting des seins (avec protheses rondes)" <?php if($Data_list["treatment_requested"]=="Lifting des seins (avec protheses rondes)"){?> selected="selected" <?php } ?>>Lifting des seins (avec protheses rondes)</option>
                		            <option value="Lifting des seins (avec protheses anatomiques)" <?php if($Data_list["treatment_requested"]=="Lifting des seins (avec protheses anatomiques)"){?> selected="selected" <?php } ?>>Lifting des seins (avec protheses anatomiques)</option>
                        		    <option value="Reduction Mammaire" <?php if($Data_list["treatment_requested"]=="Reduction Mammaire"){?> selected="selected" <?php } ?>>Reduction Mammaire</option>
		                            <option value="Gynecomastie (Reduction poitrine homme)" <?php if($Data_list["treatment_requested"]=="Gynecomastie (Reduction poitrine homme)"){?> selected="selected" <?php } ?>>Gynecomastie (Reduction poitrine homme)</option>
        		                    <option value="Chirurgie de l\'Abdomen" <?php if($Data_list["treatment_requested"]=="Chirurgie de l\'Abdomen"){?> selected="selected" <?php } ?>>Chirurgie de l\'Abdomen</option>
                		            <option value="Mini-lift abdominal" <?php if($Data_list["treatment_requested"]=="Mini-lift abdominal"){?> selected="selected" <?php } ?>>Mini-lift abdominal</option>
                        		    <option value="Abdominoplastie" <?php if($Data_list["treatment_requested"]=="Abdominoplastie"){?> selected="selected" <?php } ?>>Abdominoplastie</option>
		                            <option value="Liposuccion (Liposculpture)" <?php if($Data_list["treatment_requested"]=="Liposuccion (Liposculpture)"){?> selected="selected" <?php } ?>>Liposuccion (Liposculpture)</option>
        		                    <option value="Liposuccion abdomen" <?php if($Data_list["treatment_requested"]=="Liposuccion abdomen"){?> selected="selected" <?php } ?>>Liposuccion abdomen</option>
                		            <option value="Liposuccion 1 à&nbsp;  2 zones  (Petite)" <?php if($Data_list["treatment_requested"]=="Liposuccion 1 à&nbsp;  2 zones  (Petite)"){?> selected="selected" <?php } ?>>Liposuccion 1 à&nbsp;  2 zones  (Petite)</option>
                        		    <option value="Liposuccion 3 à&nbsp;  4 zones" <?php if($Data_list["treatment_requested"]=="Liposuccion 3 à&nbsp;  4 zones"){?> selected="selected" <?php } ?>>Liposuccion 3 à&nbsp;  4 zones</option>
		                            <option value="Liposuccion plus de 4 zones" <?php if($Data_list["treatment_requested"]=="Liposuccion plus de 4 zones"){?> selected="selected" <?php } ?>>Liposuccion plus de 4 zones</option>
        		                    <option value="Chirurgie des Cuisses" <?php if($Data_list["treatment_requested"]=="Chirurgie des Cuisses"){?> selected="selected" <?php } ?>>Chirurgie des Cuisses</option>
                		            <option value="Lifting face interieure des cuisses" <?php if($Data_list["treatment_requested"]=="Lifting face interieure des cuisses"){?> selected="selected" <?php } ?>>Lifting face interieure des cuisses</option>
                        		    <option value="Chirurgie Intime" <?php if($Data_list["treatment_requested"]=="Chirurgie Intime"){?> selected="selected" <?php } ?>>Chirurgie Intime</option>
		                            <option value="Hymenoplastie (refection de l\'hymen)" <?php if($Data_list["treatment_requested"]=="Hymenoplastie (refection de l\'hymen)"){?> selected="selected" <?php } ?>>Hymenoplastie (refection de l\'hymen)</option>
        		                    <option value="Reduction des levres vaginales" <?php if($Data_list["treatment_requested"]=="Reduction des levres vaginales"){?> selected="selected" <?php } ?>>Reduction des levres vaginales</option>
                		            <option value="Prothese testiculaire siliconee" <?php if($Data_list["treatment_requested"]=="Prothese testiculaire siliconee"){?> selected="selected" <?php } ?>>Prothese testiculaire siliconee</option>
                        		    <option value="Medecine esthetique" <?php if($Data_list["treatment_requested"]=="Medecine esthetique"){?> selected="selected" <?php } ?>>Medecine esthetique</option>
		                            <option value="Traitement des rides au Botox (3 zones)" <?php if($Data_list["treatment_requested"]=="Traitement des rides au Botox (3 zones)"){?> selected="selected" <?php } ?>>Traitement des rides au Botox (3 zones)</option>
        			                <option value="Comblement des rides peribuccales" <?php if($Data_list["treatment_requested"]=="Comblement des rides peribuccales"){?> selected="selected" <?php } ?>>Comblement des rides peribuccales</option>
                    	    </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Deuxieme traitement envisagé :</li>
							<li class="field1_form">
								<select name="second_pro_treatment"  class="listmenu" id="second_pro_treatment">
									<option value="">Sélectionner...</option>
									<option value="Lifting Cervico Facial (L.C.F)" <?php if($Data_list["second_pro_treatment"]=="Lifting Cervico Facial (L.C.F)"){?> selected="selected" <?php } ?>>Lifting Cervico Facial (L.C.F)</option>
									<option value="Lifting Complet du visage (L.C.F+Botox)" <?php if($Data_list["second_pro_treatment"]=="Lifting Complet du visage (L.C.F+Botox)"){?> selected="selected" <?php } ?>>Lifting Complet du visage (L.C.F+Botox)</option>
									<option value="Reprise de cicatrice" <?php if($Data_list["second_pro_treatment"]=="Reprise de cicatrice"){?> selected="selected" <?php } ?>>Reprise de cicatrice</option>
									<option value="Chirurgie des Oreilles" <?php if($Data_list["second_pro_treatment"]=="Chirurgie des Oreilles"){?> selected="selected" <?php } ?>>Chirurgie des Oreilles</option>
									<option value="Chirurgie des Paupieres" <?php if($Data_list["second_pro_treatment"]=="Chirurgie des Paupieres"){?> selected="selected" <?php } ?>>Chirurgie des Paupieres</option>
									<option value="Blepharo 2 Paupieres Superieures" <?php if($Data_list["second_pro_treatment"]=="Blepharo 2 Paupieres Superieures"){?> selected="selected" <?php } ?>>Blepharo 2 Paupieres Superieures</option>
									<option value="Blepharo 2 Paupieres Inferieures" <?php if($Data_list["second_pro_treatment"]=="Blepharo 2 Paupieres Inferieures"){?> selected="selected" <?php } ?>>Blepharo 2 Paupieres Inferieures</option>
									<option value="Blepharo 4 Paupieres" <?php if($Data_list["second_pro_treatment"]=="Blepharo 4 Paupieres"){?> selected="selected" <?php } ?>>Blepharo 4 Paupieres</option>
									<option value="Chirurgie du Nez" <?php if($Data_list["second_pro_treatment"]=="Chirurgie du Nez"){?> selected="selected" <?php } ?>>Chirurgie du Nez</option>
									<option value="Rhinoplastie (bosse et pointe)" <?php if($Data_list["second_pro_treatment"]=="Rhinoplastie (bosse et pointe)"){?> selected="selected" <?php } ?>>Rhinoplastie (bosse et pointe)</option>
									<option value="Augmentation des levres (Lipo Filling)" <?php if($Data_list["second_pro_treatment"]=="Augmentation des levres (Lipo Filling)"){?> selected="selected" <?php } ?>>Augmentation des levres (Lipo Filling)</option>
									<option value="Chirurgie du Menton" <?php if($Data_list["second_pro_treatment"]=="Chirurgie du Menton"){?> selected="selected" <?php } ?>>Chirurgie du Menton</option>
									<option value="Genioplastie" <?php if($Data_list["second_pro_treatment"]=="Genioplastie"){?> selected="selected" <?php } ?>>Genioplastie</option>
									<option value="Chirurgie du Cou" <?php if($Data_list["second_pro_treatment"]=="Chirurgie du Cou"){?> selected="selected" <?php } ?>>Chirurgie du Cou</option>
									<option value="Liposuccion du cou" <?php if($Data_list["second_pro_treatment"]=="Liposuccion du cou"){?> selected="selected" <?php } ?>>Liposuccion du cou</option>
									<option value="Chirurgie de la poitrine" <?php if($Data_list["second_pro_treatment"]=="Chirurgie de la poitrine"){?> selected="selected" <?php } ?>>Chirurgie de la poitrine</option>
									<option value="Augmentation mammaire (protheses rondes)" <?php if($Data_list["second_pro_treatment"]=="Augmentation mammaire (protheses rondes)"){?> selected="selected" <?php } ?>>Augmentation mammaire (protheses rondes)</option>
									<option value="Augmentation mammaire (protheses anatomiques)" <?php if($Data_list["second_pro_treatment"]=="Augmentation mammaire (protheses anatomiques)"){?> selected="selected" <?php } ?>>Augmentation mammaire (protheses anatomiques)</option>
									<option value="Changement de protheses mammaires (protheses rondes)" <?php if($Data_list["second_pro_treatment"]=="Changement de protheses mammaires (protheses rondes)"){?> selected="selected" <?php } ?>>Changement de protheses mammaires (protheses rondes)</option>
									<option value="Lifting des seins (sans protheses)" <?php if($Data_list["second_pro_treatment"]=="Lifting des seins (sans protheses)"){?> selected="selected" <?php } ?>>Lifting des seins (sans protheses)</option>
									<option value="Lifting des seins (avec protheses rondes)" <?php if($Data_list["second_pro_treatment"]=="Lifting des seins (avec protheses rondes)"){?> selected="selected" <?php } ?>>Lifting des seins (avec protheses rondes)</option>
									<option value="Lifting des seins (avec protheses anatomiques)" <?php if($Data_list["second_pro_treatment"]=="Lifting des seins (avec protheses anatomiques)"){?> selected="selected" <?php } ?>>Lifting des seins (avec protheses anatomiques)</option>
									<option value="Reduction Mammaire" <?php if($Data_list["second_pro_treatment"]=="Reduction Mammaire"){?> selected="selected" <?php } ?>>Reduction Mammaire</option>
									<option value="Gynecomastie (Reduction poitrine homme)" <?php if($Data_list["second_pro_treatment"]=="Gynecomastie (Reduction poitrine homme)"){?> selected="selected" <?php } ?>>Gynecomastie (Reduction poitrine homme)</option>
									<option value="Chirurgie de l\'Abdomen" <?php if($Data_list["second_pro_treatment"]=="Chirurgie de l\'Abdomen"){?> selected="selected" <?php } ?>>Chirurgie de l\'Abdomen</option>
									<option value="Mini-lift abdominal" <?php if($Data_list["second_pro_treatment"]=="Mini-lift abdominal"){?> selected="selected" <?php } ?>>Mini-lift abdominal</option>
									<option value="Abdominoplastie" <?php if($Data_list["second_pro_treatment"]=="Abdominoplastie"){?> selected="selected" <?php } ?>>Abdominoplastie</option>
									<option value="Liposuccion (Liposculpture)" <?php if($Data_list["second_pro_treatment"]=="Liposuccion (Liposculpture)"){?> selected="selected" <?php } ?>>Liposuccion (Liposculpture)</option>
									<option value="Liposuccion abdomen" <?php if($Data_list["second_pro_treatment"]=="Liposuccion abdomen"){?> selected="selected" <?php } ?>>Liposuccion abdomen</option>
									<option value="Liposuccion 1 à&nbsp;  2 zones  (Petite)" <?php if($Data_list["second_pro_treatment"]=="Liposuccion 1 à&nbsp;  2 zones  (Petite)"){?> selected="selected" <?php } ?>>Liposuccion 1 à&nbsp;  2 zones  (Petite)</option>
									<option value="Liposuccion 3 à&nbsp;  4 zones" <?php if($Data_list["second_pro_treatment"]=="Liposuccion 3 à&nbsp;  4 zones"){?> selected="selected" <?php } ?>>Liposuccion 3 à&nbsp;  4 zones</option>
									<option value="Liposuccion plus de 4 zones" <?php if($Data_list["second_pro_treatment"]=="Liposuccion plus de 4 zones"){?> selected="selected" <?php } ?>>Liposuccion plus de 4 zones</option>
									<option value="Chirurgie des Cuisses" <?php if($Data_list["second_pro_treatment"]=="Chirurgie des Cuisses"){?> selected="selected" <?php } ?>>Chirurgie des Cuisses</option>
									<option value="Lifting face interieure des cuisses" <?php if($Data_list["second_pro_treatment"]=="Lifting face interieure des cuisses"){?> selected="selected" <?php } ?>>Lifting face interieure des cuisses</option>
									<option value="Chirurgie Intime" <?php if($Data_list["second_pro_treatment"]=="Chirurgie Intime"){?> selected="selected" <?php } ?>>Chirurgie Intime</option>
									<option value="Hymenoplastie (refection de l\'hymen)" <?php if($Data_list["second_pro_treatment"]=="Hymenoplastie (refection de l\'hymen)"){?> selected="selected" <?php } ?>>Hymenoplastie (refection de l\'hymen)</option>
									<option value="Reduction des levres vaginales" <?php if($Data_list["second_pro_treatment"]=="Reduction des levres vaginales"){?> selected="selected" <?php } ?>>Reduction des levres vaginales</option>
									<option value="Prothese testiculaire siliconee" <?php if($Data_list["second_pro_treatment"]=="Prothese testiculaire siliconee"){?> selected="selected" <?php } ?>>Prothese testiculaire siliconee</option>
									<option value="Medecine esthetique" <?php if($Data_list["second_pro_treatment"]=="Medecine esthetique"){?> selected="selected" <?php } ?>>Medecine esthetique</option>
									<option value="Traitement des rides au Botox (3 zones)" <?php if($Data_list["second_pro_treatment"]=="Traitement des rides au Botox (3 zones)"){?> selected="selected" <?php } ?>>Traitement des rides au Botox (3 zones)</option>
									<option value="Comblement des rides peribuccales" <?php if($Data_list["second_pro_treatment"]=="Comblement des rides peribuccales"){?> selected="selected" <?php } ?>>Comblement des rides peribuccales</option>
                        </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Vous préférez :</li>
							<li class="field1_form">
								<select name="you_prefer" class="listmenu" id="you_prefer">
									<option value="">Sélectionner...</option>
									<option value="Une consultation webcam" <?php if($Data_list["you_prefer"]=="Une consultation webcam"){?> selected="selected" <?php } ?>>Une consultation webcam</option>
									<option value="Une consultation par photos et email" <?php if($Data_list["you_prefer"]=="Une consultation par photos et email"){?> selected="selected" <?php } ?>>Une consultation par photos et email</option>
									<option value="Une consultation directe" <?php if($Data_list["you_prefer"]=="Une consultation directe"){?> selected="selected" <?php } ?>>Une consultation directe</option>
							  </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Comment préférez vous être contacté(e) :</li>
							<li class="field1_form">
								<select name="contact_mode" class="listmenu" id="contact_mode">
									<option value="">Sélectionner...</option>
									<option value="Téléphone" <?php if($Data_list["contact_mode"]=="Téléphone"){?> selected="selected" <?php } ?>>Téléphone</option>
									<option value="Email" <?php if($Data_list["contact_mode"]=="Email"){?> selected="selected" <?php } ?>>Email</option>
							  </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Comment avez-vous connu Esthetic-Planet? :</li>
							<li class="field1_form">
								<select name="heard_from" class="listmenu" id="heard_from" style="">
									<option value="">Sélectionner...</option>
									<option value="TV" <?php if($Data_list["heard_from"]=="TV"){?> selected="selected" <?php } ?>>TV</option>
									<option value="Radio" <?php if($Data_list["heard_from"]=="Radio"){?> selected="selected" <?php } ?>>Radio</option>
									<option value="Journaux" <?php if($Data_list["heard_from"]=="Journaux"){?> selected="selected" <?php } ?>>Journaux</option>
									<option value="Bouche à&nbsp; oreilles" <?php if($Data_list["heard_from"]=="Bouche à&nbsp; oreilles"){?> selected="selected" <?php } ?>>Bouche à&nbsp; oreilles</option>
									<option value="Google" <?php if($Data_list["heard_from"]=="Google"){?> selected="selected" <?php } ?>>Google</option>
									<option value="Yahoo" <?php if($Data_list["heard_from"]=="Yahoo"){?> selected="selected" <?php } ?>>Yahoo</option>
									<option value="Msn" <?php if($Data_list["heard_from"]=="Msn"){?> selected="selected" <?php } ?>>Msn</option>
									<option value="Forums" <?php if($Data_list["heard_from"]=="Forums"){?> selected="selected" <?php } ?>>Forums</option>
							  </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Préférez-vous? :</li>
							<li class="field1_form">
								<select name="prefer_mode" class="listmenu" id="prefer_mode" style="">
									<option value="">Sélectionner...</option>
									<option value="Parler à&nbsp; un patient" <?php if($Data_list["prefer_mode"]=="Parler à&nbsp; un patient"){?> selected="selected" <?php } ?>>Parler à&nbsp; un patient</option>
									<option value="Rencontrer un patient" <?php if($Data_list["prefer_mode"]=="Rencontrer un patient"){?> selected="selected" <?php } ?>>Rencontrer un patient</option>
									<option value="Rencontrer l\'equipe Esthetic-Planet" <?php if($Data_list["prefer_mode"]=="Rencontrer l\'equipe Esthetic-Planet"){?> selected="selected" <?php } ?>>Rencontrer l\'equipe Esthetic-Planet</option>
							  </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Allergies Connues :</li>
							<li class="field1_form">
								<textarea name="allergy_knwn" cols="45" rows="10"  class="textbox_form" id="allergy_knwn"><?php echo $Data_list["allergy_knwn"]; ?></textarea>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Suivez-vous actuellement un/des traitements médicaux :</li>
							<li class="field1_form">
								<textarea name="cmedical_treatment" cols="45" rows="10"  class="textbox_form" id="cmedical_treatment"><?php echo $Data_list["cmedical_treatment"]; ?></textarea>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">Les objectifs que vous souhaitez transmettre au chirurgien :</li>
							<li class="field1_form">
								<textarea name="convey_surgen" cols="45" rows="10"  class="textbox_form" id="convey_surgen"><?php echo $Data_list["convey_surgen"]; ?></textarea>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form">
								Photo 1
							</li>
							<li class="field1_form">
								<input type="file" id="fichier2" name="photo1"> 
								(2 Mo maximum)
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
								<input type="file" id="fichier3" name="photo2"> 
								(2 Mo maximum)
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
								<input type="file" id="fichier4" name="photo3"> 
								(2 Mo maximum)
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
								<input type="file" id="fichier5" name="photo4"> 
								(2 Mo maximum)
								<?php
									//$photo4=$Data_list['photo4'];
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
								else if(isset($_REQUEST['pid']) && $_REQUEST['pid']!='')
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
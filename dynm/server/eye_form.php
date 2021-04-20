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
	//$cond_list="where 1=1 and UserId='$uid' and eid='$dtid'";
	$cond_list="where 1=1 and UserId='$uid'";
	$orderby_list="order by eid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_eyecare",$cond_list,$orderby_list);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data'][0];
	
//}

//if(isset($_POST['envoi']) && ($_REQUEST['envoi'] == "Envoyer"))
if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Submit"))
{
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	if(!empty($_REQUEST["title"]))
		$title = implode('|',$_REQUEST["title"]);
	else
		$title = "";
		
	$ConArr['title'] = $title;		
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	$intResult = $sql->SqlInsert('esthp_eyecare',$ConArr);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td>Title :	</td><td>'.$_REQUEST["title"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
	</table>
	';
	
	$attachmants = "";
	
	if($intResult)
	{
		if($_FILES['doc1']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc1']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['doc1'] = $file_name ;
					$condition = " where eid ='".$intResult."'";
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc2']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['doc2'] = $file_name ;
					$condition = " where eid ='".$intResult."'";
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc3']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['doc3'] = $file_name ;
					$condition = " where eid ='".$intResult."'";
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc4']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['doc4'] = $file_name ;
					$condition = " where eid ='".$intResult."'";
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc5']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc5']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc5']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$content_arr['doc5'] = $file_name ;
					$condition = " where eid ='".$intResult."'";
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
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
}  else  if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Update"))
{
	
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$ConArr['form_id'] = $_REQUEST['qid'];
	$ConArr['UserId'] = $_SESSION['UserInfo']['id'];
	$ConArr['clinicid'] = $_REQUEST["clid"];
	
	if(!empty($_REQUEST["title"]))
		$title = implode('|',$_REQUEST["title"]);
	else
		$title = "";
		
	$ConArr['title'] = $title;		
	$ConArr['addedDate'] = date("Y-m-d H:i:s",time());
	
	$ConArr=add_slashes_arr($ConArr);	
	if(!empty($dtid))
	{
		$condition = " where eid='".$dtid."'";
	} else {
		$condition = " where eid='".$Data_list['eid']."'";
	}
	$intResult = $sql->SqlUpdate('esthp_eyecare',$ConArr,$condition);
	
	$message_body = '<table cellpadding="0" cellspacing="0" border="0">
		<tr>		<td>Title :	</td><td>'.$_REQUEST["title"].'</td>		</tr>
		<tr>		<td colspan="2">&nbsp;</td>			</tr>
	</table>
	';
	
	$attachmants = "";
	
	
		if($_FILES['doc1']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc1']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc1']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["doc1"];
					$file_name = $file_name."|".$files;
					$content_arr['doc1'] = $file_name ;
					//$condition = " where eid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where eid='".$dtid."'";
					} else {
						$condition = " where eid='".$Data_list['eid']."'";
					}
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc2']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc2']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc2']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["doc2"];
					$file_name = $file_name."|".$files;
					$content_arr['doc2'] = $file_name ;
					//$condition = " where eid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where eid='".$dtid."'";
					} else {
						$condition = " where eid='".$Data_list['eid']."'";
					}
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc3']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc3']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc3']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["doc3"];
					$file_name = $file_name."|".$files;
					$content_arr['doc3'] = $file_name ;
					//$condition = " where eid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where eid='".$dtid."'";
					} else {
						$condition = " where eid='".$Data_list['eid']."'";
					}
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc4']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc4']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc4']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["doc4"];
					$file_name = $file_name."|".$files;
					$content_arr['doc4'] = $file_name ;
					//$condition = " where eid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where eid='".$dtid."'";
					} else {
						$condition = " where eid='".$Data_list['eid']."'";
					}
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
					if($attachmants != "")
					  $attachmants .= "|";
					$attachmants .= $file_name ;
				}
		}
		if($_FILES['doc5']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."mail_attachment/";
				$file_name =time().'_'.$_FILES['doc5']['name'];
				$upload_file=$upload_dir.$file_name ;
							
				if(move_uploaded_file($_FILES['doc5']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					$files = $Data_list["doc5"];
					$file_name = $file_name."|".$files;
					$content_arr['doc5'] = $file_name ;
					//$condition = " where eid ='".$dtid."'";
					if(!empty($dtid))
					{
						$condition = " where eid='".$dtid."'";
					} else {
						$condition = " where eid='".$Data_list['eid']."'";
					}
					$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
					
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
	
	header("Location: eyefrm_detail.php");
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
				<div class="login_hea">chirurgie des yeux</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)" enctype="multipart/form-data">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						
						<!--Start form -->
						<div id="form">
						<ul>
							<?php
								$get_value = $Data_list["title"];
								$getval = explode("|",$get_value);
							?>
							<li>Vous souhaitez corriger : </li>
							<li class="field1_form">
								<input type="checkbox" value="Myopie" <?php if(in_array("Myopie", $getval)) {?> checked="checked" <?php } ?> name="title[]">Myopie <br>
								<input type="checkbox" value="Presbytie" <?php if(in_array("Presbytie", $getval)) {?> checked="checked" <?php } ?> name="title[]">Presbytie <br>
								<input type="checkbox" value="astigmatisme" <?php if(in_array("astigmatisme", $getval)) {?> checked="checked" <?php } ?> name="title[]">astigmatisme 
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li><strong>documents à joindre</strong></li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">
								topographie
							</li>
							<li class="field1_form">
								<input type="file" id="doc1" name="doc1">
								<?php
									//$dental_panoramic=$Data_list['dental_panoramic'];
									$doc1=explode("|",$Data_list['doc1']);
									$get_doc1 = $doc1[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_doc1))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_doc1?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">
								Pentacam
							</li>
							<li class="field1_form">
								<input type="file" id="doc2" name="doc2">
								<?php
									//$photo1=$Data_list['photo1'];
									$doc2=explode("|",$Data_list['doc2']);
									$get_doc2 = $doc2[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_doc2))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_doc2?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">
								Pachymetrie
							</li>
							<li class="field1_form">
								<input type="file" id="doc3" name="doc3">
								<?php
									//$photo2=$Data_list['photo2'];
									$doc3=explode("|",$Data_list['doc3']);
									$get_doc3 = $doc3[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_doc3))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_doc3?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">
								autres documents  que vous souhaitez transmettre au chirurgien
							</li>
							<li class="field1_form">
								<input type="file" id="doc4" name="doc4">
								<?php
									//$photo3=$Data_list['photo3'];
									$doc4=explode("|",$Data_list['doc4']);
									$get_doc4 = $doc4[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_doc4))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_doc4?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">
								autres documents  que vous souhaitez transmettre au chirurgien
							</li>
							<li class="field1_form">
								<input type="file" id="doc5" name="doc5">
								<?php
									$doc5=explode("|",$Data_list['doc5']);
									$get_doc5 = $doc5[0];
									if(is_file(_UPLOAD_FILE_PATH."mail_attachment/".$get_doc5))
									{
									?>
									<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$get_doc5?>" rel="facebox"><img border='0' src='images/image_icon.gif' alt='Click to View'></a>
									<?
									}
									?>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name_form" style="width:160px;">&nbsp;</li>
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

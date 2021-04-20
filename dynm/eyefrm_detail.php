<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

/* for paging the calulation	*/
/*$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$records_per_page=15;				
$offset = ($page-1) * $records_per_page; */
/* for paging the calulation	*/
$qid = $_REQUEST['qid'];
$uid = $_SESSION['UserInfo']['id'];
$cond_list="where 1=1 and UserId='$uid' and clinicid='0'";
$orderby_list="order by eid desc";
$cat_arr_list = $sql->SqlRecords("esthp_eyecare",$cond_list,$orderby_list);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'];

if(isset($_REQUEST['act']) && ($_REQUEST['act']=='delfrmallimg'))
{
	$eid = $_GET['eid'];
	$content_arr=array();
	$get_id = explode("_",$eid);
	$get_type = $_GET["type"];
	$gid = $get_id["0"];
	$rmv_index = $get_id["1"];
	
	$cond_list="where 1=1 and UserId='$uid' and eid='$gid'";
	$orderby_list="order by eid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_eyecare",$cond_list,$orderby_list);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data']["0"];
	
	if($get_type == "doc1") 
	{	
		$get_img_name = explode("|",$Data_list["doc1"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['doc1'] = $get_images ;
		$condition = " where eid ='".$eid."'";
		$sql->SqlUpdate('esthp_eyecare ',$content_arr,$condition);
	} 
	else if($get_type == "doc2")  
	{	
		$get_img_name = explode("|",$Data_list["image1"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['image1'] = $get_images ;
		$condition = " where eid ='".$eid."'";
		$sql->SqlUpdate('esthp_eyecare ',$content_arr,$condition);
	}
	
	else if($get_type == "doc3")  
	{	
		$get_img_name = explode("|",$Data_list["doc3"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['doc3'] = $get_images ;
		$condition = " where eid ='".$eid."'";
		$sql->SqlUpdate('esthp_eyecare',$content_arr,$condition);
	}
	
	else if($get_type == "doc4")  
	{	
		$get_img_name = explode("|",$Data_list["doc4"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['doc4'] = $get_images ;
		$condition = " where eid ='".$eid."'";
		$sql->SqlUpdate('esthp_eyecare ',$content_arr,$condition);
	} 
	
	else if($get_type == "doc5")  
	{	
		$get_img_name = explode("|",$Data_list["doc5"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['doc5'] = $get_images ;
		$condition = " where eid ='".$eid."'";
		$sql->SqlUpdate('esthp_eyecare ',$content_arr,$condition);
	} 
	
	header("location:eyefrm_detail.php");
}
$message="";
$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';
if($msg=='thk')
	$message = "<span class=\"logoutMsgBox\"> Votre formulaire a été envoyé </span>";
else if($msg=='update')
	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";
else if($msg=='deleted')
	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";
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
				<div><?=$message?></div>
				<!--Start clinic_page -->
				<div id="clinic_page">
					<!--Start sea_mid -->
					<div class="clear"></div>
					
					<!--End listing_page -->
					<form name="cliniclist" id="cliniclist" method="post" action="">
					<div id="listing_page">
						<div class="clear"></div>
						<div align="right">
						<?php
						/*$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
						foreach ($qsA as $k=>$v) $qs .= "&$k=$v";
						$url = "?page={@PAGE}&$qs";
						$pager = new pager($url, $count_total_list, $records_per_page, $page);
						$pager->outputlinks(); */
						?>
						</div>
						<!--Start listing_box -->
						<div class="listing_box">
						<div id="form">
						<ul>
							<li class="field1_form">
								<input type="checkbox" name="hair_frm" id="hair_frm" > chirurgie des yeux
							</li>
							<li class="field_name_form">
								<a href="eye_form.php?did=<?php echo $Data_list[0]["eid"] ;?>&qid=<?php echo $Data_list[0]["form_id"] ;?>&clid=<?php echo $Data_list[0]["clinicid"] ?>"><img src="images/b_edit.png" border="0"></a>
							</li>
						</ul>
						<div class="clear"></div>
						<?php if($count_list > 0) { ?>
					<span class="black">Uploaded Documents: topographie</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["doc1"]) )
							{
								$doc1=explode("|",$Data_list[$i]['doc1']);
								$cnt = count($doc1);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["eid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$doc1[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$doc1[$k]?>' alt='' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','doc1');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Documents: Pentacam</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["doc2"]) )
							{
								$image1=explode("|",$Data_list[$i]['doc2']);
								$cnt = count($image1);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["eid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image1[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image1[$k]?>' alt='' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','doc2');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: Pachymetrie</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["doc3"]) )
							{
								$image2=explode("|",$Data_list[$i]['doc3']);
								$cnt = count($image2);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["eid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image2[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image2[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','doc3');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: autres documents  que vous souhaitez transmettre au chirurgien</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["doc4"]) )
							{
								$image3=explode("|",$Data_list[$i]['doc4']);
								$cnt = count($image3);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["eid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image3[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image3[$k]?>' alt='' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','doc4');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: autres documents  que vous souhaitez transmettre au chirurgien</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["doc5"]) )
							{
								$image4=explode("|",$Data_list[$i]['doc5']);
								$cnt = count($image4);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["eid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image4[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$image4[$k]?>' alt='' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','doc5');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} }  else { echo "<span style='color:red; font-size:16px;'>Aucun enregistrement trouvé</span>"; }?>
					</div>
						</div>
						<!--End listing_box -->
						<div class="clear"></div>
						
						<div class="listing_box">
							<div class="listing_content">
								<!--<div class="selectall"><img src="images/send_mail.gif" /></div>-->
						<div class="next" align="right">&nbsp;</div>
						<div class="clear"></div>
							</div>
						</div>
						<!--End listing_box -->
						<div class="clear"></div>
						
					</div>
					</form>
				</div>
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
<script>
function delete_frmallImage(id,type)
{
	if(confirm("Are you sure to delete image?" ))
	{
		window.location.href="eyefrm_detail.php?act=delfrmallimg&eid="+id+"&type="+type; 
	}
}
</script>
<!--End Page Holder -->
<?php include("footer.php"); ?>
</body>
</html>
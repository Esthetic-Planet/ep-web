<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$qid = $_REQUEST['qid'];
$uid = $_SESSION['UserInfo']['id'];
$cond_list="where 1=1 and UserId='$uid'";
$orderby_list="order by hid desc";
$cat_arr_list = $sql->SqlRecords("esthp_haircare",$cond_list,$orderby_list);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'];

if(isset($_REQUEST['act']) && ($_REQUEST['act']=='delfrmallimg'))
{
	$hid = $_GET['hid'];
	$content_arr=array();
	$get_id = explode("_",$hid);
	$get_type = $_GET["type"];
	$gid = $get_id["0"];
	$rmv_index = $get_id["1"];
	
	$cond_list="where 1=1 and UserId='$uid' and hid='$gid'";
	$orderby_list="order by hid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_haircare",$cond_list,$orderby_list);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data']["0"];
	
	if($get_type == "face_fwd") 
	{	
		$get_img_name = explode("|",$Data_list["face_fwd"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['face_fwd'] = $get_images ;
		$condition = " where hid ='".$hid."'";
		$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
	} 
	else if($get_type == "top_skull")  
	{	
		$get_img_name = explode("|",$Data_list["top_skull"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['top_skull'] = $get_images ;
		$condition = " where hid ='".$hid."'";
		$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
	}
	
	else if($get_type == "face_side")  
	{	
		$get_img_name = explode("|",$Data_list["face_side"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['face_side'] = $get_images ;
		$condition = " where hid ='".$hid."'";
		$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
	}
	
	else if($get_type == "donor_area")  
	{	
		$get_img_name = explode("|",$Data_list["donor_area"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['donor_area'] = $get_images ;
		$condition = " where hid ='".$hid."'";
		$sql->SqlUpdate('esthp_haircare',$content_arr,$condition);
	}
	
	header("location:hairfrm_detail.php");
}

?>
<?php include("header.php"); ?>
		
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Formulaire greffe de cheveux </div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<div id="clinic_page">
					<!--Start sea_mid -->
					<div class="clear"></div>
					
					<!--End listing_page -->
					<form name="cliniclist" id="cliniclist" method="post" action="">
					<div id="listing_page">
						<div class="clear"></div>
						<div align="right">
						</div>
						<!--Start listing_box -->
						<div class="listing_box">
						<div id="form">
						<?php
							if(!empty($Data_list["0"]["fname"]) )
							{
							?>
							<ul>
							<li class="field1_form">
								<input type="checkbox" name="hair_frm" id="hair_frm" > <?php echo $Data_list["0"]["fname"] ;?> <?php echo $Data_list["0"]["lname"] ;?>
							</li>
							<li class="field_name_form">
								<a href="hair_form.php?hid=<?php echo $Data_list["0"]["hid"] ;?>&qid=<?php echo $Data_list["0"]["form_id"] ;?>&clid=<?php echo $Data_list[0]["clinicid"] ?>"><img src="images/b_edit.png" border="0"></a>
							</li>
						</ul>
						<div class="clear"></div>
						<?php } ?>
						<span class="black">Uploaded Images: Facing Forward</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["face_fwd"]) )
							{
								$face_side=explode("|",$Data_list[$i]['face_fwd']);
								$cnt = count($face_side);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["hid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$face_side[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$face_side[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','face_fwd');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: top of your skull </span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["top_skull"]) )
							{
								$top_skull=explode("|",$Data_list[$i]['top_skull']);
								$cnt = count($top_skull);
								for($k=0; $k<$cnt; $k++)
								{
									$gid1= $Data_list[$i]["hid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$top_skull[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$top_skull[$k]?>' alt='Click to View' height="50" width="70"></a>
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','top_skull');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: From the side </span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["face_side"]) )
							{
								$face_side=explode("|",$Data_list[$i]['face_side']);
								$cnt = count($face_side);
								for($k=0; $k<$cnt; $k++)
								{
									$gid1= $Data_list[$i]["hid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$face_side[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$face_side[$k]?>' alt='Click to View' height="50" width="70"></a>							
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','face_side');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: Donor Area </span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["donor_area"]) )
							{
								$donor_area=explode("|",$Data_list[$i]['donor_area']);
								$cnt = count($donor_area);
								for($k=0; $k<$cnt; $k++)
								{
									$gid1= $Data_list[$i]["hid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$donor_area[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$donor_area[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','donor_area');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
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
		window.location.href="hairfrm_detail.php?act=delfrmallimg&hid="+id+"&type="+type; 
	}
}
</script>
<!--End Page Holder -->
<?php include("footer.php"); ?>
</body>
</html>
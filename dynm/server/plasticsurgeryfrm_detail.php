<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

/* for paging the calulation	*/
/*$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$records_per_page=15;				
$offset = ($page-1) * $records_per_page;*/
/* for paging the calulation	*/

$qid = $_REQUEST['qid'];
$uid = $_SESSION['UserInfo']['id'];
$cond_list="where 1=1 and UserId='$uid'";
$orderby_list="order by pid desc";
$cat_arr_list = $sql->SqlRecords("esthp_plasticsurgery",$cond_list,$orderby_list);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'];

if(isset($_REQUEST['act']) && ($_REQUEST['act']=='delfrmallimg'))
{
	$pid = $_GET['pid'];
	$content_arr=array();
	$get_id = explode("_",$pid);
	$get_type = $_GET["type"];
	$gid = $get_id["0"];
	$rmv_index = $get_id["1"];
	
	$cond_list="where 1=1 and UserId='$uid' and pid='$gid'";
	$orderby_list="order by hid desc";
	$cat_arr_list = $sql->SqlRecords("esthp_plasticsurgery",$cond_list,$orderby_list);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data']["0"];
	
	if($get_type == "photo1") 
	{	
		$get_img_name = explode("|",$Data_list["photo1"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['photo1'] = $get_images ;
		$condition = " where pid ='".$pid."'";
		$sql->SqlUpdate('esthp_plasticsurgery ',$content_arr,$condition);
	} 
	else if($get_type == "photo2")  
	{	
		$get_img_name = explode("|",$Data_list["photo2"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['photo2'] = $get_images ;
		$condition = " where pid ='".$pid."'";
		$sql->SqlUpdate('esthp_plasticsurgery ',$content_arr,$condition);
	}
	
	else if($get_type == "photo3")  
	{	
		$get_img_name = explode("|",$Data_list["photo3"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['photo3'] = $get_images ;
		$condition = " where pid ='".$pid."'";
		$sql->SqlUpdate('esthp_plasticsurgery',$content_arr,$condition);
	}
	
	else if($get_type == "photo4")  
	{	
		$get_img_name = explode("|",$Data_list["photo4"]);
		
		unset($get_img_name[$rmv_index]);
		$get_images = implode("|",$get_img_name);
	
		$content_arr['photo4'] = $get_images ;
		$condition = " where pid ='".$pid."'";
		$sql->SqlUpdate('esthp_plasticsurgery ',$content_arr,$condition);
	} 
	header("location:plasticsurgeryfrm_detail.php");
}

?>
<?php include("header.php"); ?>

	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Plastic Surgery Form Listing</div>
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
						<?php
							if(!empty($Data_list[0]["fname"]) )
							{
							?>
							
							<ul>
							<li class="field1_form">
								<input type="checkbox" name="hair_frm" id="hair_frm" > <?php echo $Data_list[0]["fname"] ;?> <?php echo $Data_list[0]["lname"] ;?>
							</li>
							<li class="field_name_form">
								<a href="plastic_surgery_form.php?pid=<?php echo $Data_list[0]["pid"] ;?>&qid=<?php echo $Data_list["0"]["form_id"] ;?>&clid=<?php echo $Data_list[0]["clinicid"] ?>"><img src="images/b_edit.png" border="0"></a>
							</li>
						</ul>
						<div class="clear"></div>
						<?php 
						} 
					?>
					<span class="black">Uploaded Images: Photo1</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["photo1"]) )
							{
								$photo1=explode("|",$Data_list[$i]['photo1']);
								$cnt = count($photo1);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["pid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo1[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo1[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','photo1');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: Photo2</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["photo2"]) )
							{
								$photo2=explode("|",$Data_list[$i]['photo2']);
								$cnt = count($photo2);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["pid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo2[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo2[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','photo2');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: Photo3</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["photo3"]) )
							{
								$photo3=explode("|",$Data_list[$i]['photo3']);
								$cnt = count($photo3);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["pid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo3[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo3[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','photo3');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
							</li>
						</ul>
						<div class="clear"></div>
					<?php } } 
					} ?>
					<span class="black">Uploaded Images: Photo4</span><br><br>
						<?php 
						for($i=0; $i<$count_list; $i++)
						{
							if(!empty($Data_list[$i]["photo4"]) )
							{
								$photo4=explode("|",$Data_list[$i]['photo4']);
								$cnt = count($photo4);
								for($k=0; $k<$cnt; $k++)
								{ 
									$gid1= $Data_list[$i]["pid"];
									$gid = $gid1."_".$k;
					?>
						<ul>
							<li class="field1_form">
								<a href="<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo4[$k]?>" rel="facebox"><img border='0' src='<?=_UPLOAD_FILE_URL?>mail_attachment/<?=$photo4[$k]?>' alt='Click to View' height="50" width="70"></a>
								
							</li>
							<li class="field_name_form">
								<a href="javascript:void(0);" onClick="javascript:delete_frmallImage('<?=$gid?>','photo4');"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
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
		window.location.href="plasticsurgeryfrm_detail.php?act=delfrmallimg&pid="+id+"&type="+type; 
	}
}
</script>
<!--End Page Holder -->
<?php include("footer.php"); ?>
</body>
</html>
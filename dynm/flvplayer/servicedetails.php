<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

/* for paging the calulation	*/
$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$records_per_page=5;				
$offset = ($page-1) * $records_per_page;
/* for paging the calulation	*/

$get_cid = $_REQUEST['cid'];
$cond_list="where 1=1 and IsActive='t' and UserId='$get_cid'  ";
$orderby_list="order by ClinicName asc";
$cat_arr_list = $sql->SqlRecords("esthp_tblUsers",$cond_list,$orderby_list,$offset,$records_per_page);
$count_total_list=$cat_arr_list['TotalCount'];
$count_list = $cat_arr_list['count'];
$Data_list = $cat_arr_list['Data'];

?>
<?php include("header.php"); ?>

	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Service Details</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<div id="clinic_page">
					<!--Start sea_mid -->
					<div class="clear"></div>
					
					<!--End listing_page -->
					<form name="cliniclist" id="cliniclist" method="post" action="">
					<div id="listing_page">
						<div class="clear"></div>
						
						<!--Start listing_box -->
						<?php
						for($i=0; $i<$count_list; $i++)
						{
						?>
						<div class="listing_box1">
							<div class="listing_content">
								<div class="list_part4"><span class="black"><?php echo $Data_list[$i]["ClinicName"] ;?></span><br /><br />
								<a href="<?=_UPLOAD_FILE_URL?>user_images/<?php echo $Data_list[$i]["UserLargeImg"] ;?>" rel="facebox">
								<img src="<?=_UPLOAD_FILE_URL?>user_images/small/<?php echo $Data_list[$i]["UserSmallImg"] ;?>" height="110" width="120" align="left" />
								</a>
								<?php echo $Data_list[$i]["ClinicLongDescription"] ;?>
								<p>&nbsp;</p>
								</div>
								<div class="next1" align="right" style="padding-bottom:10px;"><a href="<?php echo $_SERVER['HTTP_REFERER'];?>"><img src="images/go_back.jpg" border="0" /></a> <a href="quote.php?qid=<?php echo $_GET["qid"]; ?>&clid=<?php echo $_GET["cid"] ;?>"><img src="images/send_mail.gif" border="0" /></a></div>
								<div class="clear"></div>
							</div>
						</div>
						<?php 
						}
						?>
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
<!--End Page Holder -->
<?php include("footer.php"); ?>
</body>
</html>
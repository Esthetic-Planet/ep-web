<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
$AuthUser->ChkLogin();

$cond="where 1=1 and cat_status='active'";
$orderby="order by cat_name asc";
$cat_arr = $sql->SqlRecords("esthp_tblUserCat",$cond,$orderby);
$count_total=$cat_arr['TotalCount'];
$count = $cat_arr['count'];
$Data = $cat_arr['Data'];

//echo "<pre>";
//print_r($Data);
?>

<?php include("header.php"); ?>
	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
			<div style="float:left; width:100%" class="login_hea">
				<div style="float:left; width:83%" >LES SOINS</div><div style="float:left;  font-size:18px; width:17%"> 
				<a   href="pdf/testing.pdf" target="_blank"><img src="images/user_btn.jpg" /></a></div>
				</div>
				<div class="clear"></div>
				
				<!--Start form -->
				<!--Start images_box -->


			<div id="images_box">
				<div class="image1">
					<a href="servicelist.php?sid=<?php echo $Data["0"]["cat_id"]?>"><img src="images/ser_image1.jpg" /></a>
				</div>
				<div class="image2">
					<a href="servicelist.php?sid=<?php echo $Data["2"]["cat_id"]?>"><img src="images/ser_image2.jpg" /></a>
				</div>
				<div class="clear"></div>
				<div class="image2">
					<a href="servicelist.php?sid=<?php echo $Data["1"]["cat_id"]?>"><img src="images/ser_image4.jpg" /></a>
				</div>
				<div class="image1">
					<a href="servicelist.php?sid=<?php echo $Data["3"]["cat_id"]?>"><img src="images/ser_image3.jpg" /></a>
				</div>
				<div class="clear"></div>
			</div>
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

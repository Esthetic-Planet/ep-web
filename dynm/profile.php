<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();


?>
<?php include("header.php"); ?>

	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">Mon dossier</div>
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
							<li class="field1_form">
								<input type="checkbox" name="hair_frm" id="hair_frm" > <a href="hairfrm_detail.php?qid=3">Formulaire greffe de cheveux</a>
							</li>
							<li class="field_name_form">
								<!--Edit-->
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field1_form">
								<input type="checkbox" name="dental_frm" id="dental_frm" > <a href="dentalfrm_detail.php?qid=2">Formulaire dentaire</a>
							</li>
							<li class="field_name_form">
								<!--Edit-->
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field1_form">
								<input type="checkbox" name="plasticsurgery_frm" id="plasticsurgery_frm" > <a href="plasticsurgeryfrm_detail.php?qid=6">Formulaire chirurgie esth&eacute;tique</a>
							</li>
							<li class="field_name_form">
								<!--Edit-->
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field1_form">
								<input type="checkbox" name="eye_frm" id="eye_frm" > <a href="eyefrm_detail.php?qid=4">chirurgie des yeux</a>
							</li>
							<li class="field_name_form">
								<!--Edit-->
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
			<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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

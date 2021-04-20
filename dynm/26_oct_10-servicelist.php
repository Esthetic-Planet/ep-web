<?php
include_once("includes/global.inc.php");
require_once(_PATH."modules/mod_user_login.php");
include_once(_CLASS_PATH."pager.cls.php");
$AuthUser->ChkLogin();

$sid = $_REQUEST["sid"];
$usercategory = $_REQUEST["services"];
$clinicid = $_REQUEST["ClinicName"];
$city = $_REQUEST["city"];
$country = $_REQUEST["country"];

/* start query for fetching the services data	*/
$cond="where 1=1 and cat_status='active'";
$orderby="order by cat_name asc";
$cat_arr = $sql->SqlRecords("esthp_tblUserCat",$cond,$orderby);
$count_total=$cat_arr['TotalCount'];
$count = $cat_arr['count'];
$Data = $cat_arr['Data'];
/* end query for fetching the services data	*/

/* start query for fetching the country list	*/
$country_condition="order by countries_name";
$country_record_arr=$sql->SqlRecordMisc('esthp_tblCountries', $country_condition);
$total_countries=$country_record_arr['count'];
$country_records=$country_record_arr['Data'];
/* end query for fetching the country list	*/

/* for paging the calulation	*/
$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$records_per_page=8;				
$offset = ($page-1) * $records_per_page;
/* for paging the calulation	*/

if(isset($_POST['submit']) && ($_REQUEST['submit'] == "Recherche"))
{
	$where_list = "";
	if(!empty($usercategory))
	{
		$where_list .= "FIND_IN_SET( '$usercategory' , UserCategories ) ";
	}
	if(!empty($clinicid))
	{
		$where_list .= "and UserId='$clinicid' ";
	}
	if(!empty($city))
	{
		$where_list .= "and City like '%$city%' ";
	}
	if(!empty($country))
	{
		$where_list .= "and Country like '%$country%' ";
	}
	$cond_list="where 1=1 and IsActive='t' and UserId!=1 and ".$where_list;
	$orderby_list="order by ClinicName asc";
	$cat_arr_list = $sql->SqlRecords("esthp_tblUsers",$cond_list,$orderby_list,$offset,$records_per_page);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data'];
	
} 
else
{
	$where = "";
	if(!empty($sid))
	{
		$where .= "and FIND_IN_SET( '$sid' , UserCategories ) ";
	}
	$where .=  "and IsActive='t' and UserId!=1";
	$cond_list="where 1=1 ". $where;
	$orderby_list="order by ClinicName asc";
	$cat_arr_list = $sql->SqlRecords("esthp_tblUsers",$cond_list,$orderby_list,$offset,$records_per_page);
	$count_total_list=$cat_arr_list['TotalCount'];
	$count_list = $cat_arr_list['count'];
	$Data_list = $cat_arr_list['Data'];
}
?>
<?php include("header.php"); ?>
<?php header('Content-Type: text/html; charset=utf-8'); ?>

<script>
function onchangeajax(pid)
{ 
	 xmlHttp=GetXmlHttpObject()
	 if (xmlHttp==null)
	 {
		 alert ("Browser does not support HTTP Request")
		 return
	 }

	 var url="cliniclist.php";
	 url=url+"?pid="+pid
	 url=url+"&sid="+Math.random()
	 document.getElementById("clinicdiv").innerHTML='Please wait..<img border="0" src="images/ajax-loader.gif">'

	 xmlHttp.open("GET",url,true)
	 xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
	 xmlHttp.onreadystatechange = function() 
	 {
        if (xmlHttp.readyState == 4) 
		{
			 document.getElementById("clinicdiv").innerHTML=xmlHttp.responseText;
		}
    }	

	 xmlHttp.send('');

 }

 function stateChanged()
 {
	 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	 {
		 return true;
	 }
 }

function GetXmlHttpObject()
{
	var objXMLHttp=null
	if (window.XMLHttpRequest)
	{
		objXMLHttp=new XMLHttpRequest()
	}
	else if (window.ActiveXObject)
	{
		objXMLHttp=new ActiveXObject("Microsoft.XMLHTTP")
	}
	return objXMLHttp;
 }
 
 function checkall(state)
{
	var frm =document.search;
	var n =frm.elements.length;
	for (i=0; i<n; i++)
	{
		if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;
	}
}
</script>


	<!--Start middle_area -->
	<div id="middle_area">
		<?php include("left.php"); ?>
		
		<!--Start right_part -->
		<div id="right_part">
			<div id="content_area">
				<div class="login_hea">LISTE DES CLINIQUES</div>
				<div class="clear"></div>
				
				<!--Start clinic_page -->
				<form name="search" id="search" method="post" action="" onSubmit="return ValidateForm(this)">
				<div id="clinic_page">
					<div id="sea_left"></div>
					
					<!--Start sea_mid -->
					
					<div id="sea_mid">
						<div class="list_clinic">Rechercher les cliniques </div>
						<!--Start form -->
						
							<div id="form">
						<ul>
							<li class="field_name">Spécialités :</li>
							<li class="field1">
							<?php //echo "===".$usercategory; ?>
								
							  <select name="services" class="listmenu" id="chksbox_country" title="Please select the Services" onChange="return onchangeajax(this.value)";>
                                <option>---- Choisissez-en un ----</option>
								<?php
								for($i=0; $i<$count; $i++)
								{
									if(!empty($usercategory))
									{
								?>
                                <option value="<?php echo $Data[$i]["cat_id"]?>" <?php if(($usercategory == $Data[$i]["cat_id"])) {?> selected="selected" <?php } ?>><?php echo $Data[$i]["cat_name"]?></option>
								<?php 
									}
									else 
									{ ?>
									<option value="<?php echo $Data[$i]["cat_id"]?>" <?php if(($sid == $Data[$i][cat_id])) {?> selected="selected" <?php } ?>><?php echo $Data[$i]["cat_name"]?></option>
									<?php }
								}
								?>
                              </select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
							<li class="field_name">Nom de la clinique :</li>
							<li class="field">
								<div id="clinicdiv">
									<?php
									$val=$_GET['sid'];
									?>
									<select name="ClinicName" id="ClinicName" class="listmenu">
										<option value="">---- Sélectionnez Clinique ----</option>
										<?php	
										$cond="where 1=1 and find_in_set('$val',UserCategories) = true and IsActive='t'";
										$orderby="order by ClinicName asc";
										$cat_arr = $sql->SqlRecords("esthp_tblUsers",$cond,$orderby);
										$count_total=$cat_arr['TotalCount'];
										$count = $cat_arr['count'];
										$Data = $cat_arr['Data'];
		
										for($i=0; $i<$count_total; $i++)
										{ ?>
											<option value="<?php echo $Data[$i]['UserId']; ?>" <?php if($Data[$i]['UserId'] == $clinicid) {?> selected="selected" <?php }?>><?php echo $Data[$i]['ClinicName']; ?></option>		
									<?php	} ?>
								</select>
								</div>
							</li>
						</ul>
						<div class="clear"></div>
						<?php /*echo "<pre>";
						print_r($Data_list);
						echo "</pre>";*/
						?>
						<ul>
							<li class="field_name">ville :</li>
							<li class="field1"><input type="text" class="textbox2" name="city" id="city" value="<?php echo $city; ?>" /></li>
							<li class="field_name1" style="padding-left:25px;">Pays :</li>
							<li class="field1">
								<select class="listmenu" name="country" id="country">
									<option value="">Choisir un pays</option>
									<?php
									for($j=0; $j<$count_list; $j++)
									{
									/*foreach($country_records as $countrylist)
									{*/
									if(!empty($Data_list[$j]['Country']))
									{
									?>
										<option value="<?php echo $Data_list[$j]['Country']; ?>" <?php if($Data_list[$j]['Country'] == $country) {?> selected="selected" <?php }?>><?=$Data_list[$j]['Country']?></option>
								<?php
									}
								}
								?>
								</select>
							</li>
						</ul>
						<div class="clear"></div>
						<ul>
				<li class="field_name">&nbsp;</li>
				<li class="field"><input name="submit" type="submit" class="submit1"  value="Recherche"/></li>
		  	</ul>
			<div class="clear"></div>
						</div>
						
						</div>
					<div id="sea_right"></div>
					<div class="clear"></div>
					
					<!--End listing_page -->
					<div id="listing_page">
						<div class="selectall">&nbsp;</div>
						<div class="next" align="right">
						<?php	
						$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
						foreach ($qsA as $k=>$v) $qs .= "&$k=$v";						
						$url = "?page={@PAGE}&$qs";
						$pager = new pager($url, $count_total_list, $records_per_page, $page);						
						$pager->outputlinks();						
						?>
						</div>
						<div class="clear"></div>
						
						<!--Start listing_box -->
						<?php
						if($count_list > '0') { 
						for($i=0; $i<$count_list; $i++)
						{
						?>
						<div class="listing_box">
							<div class="listing_content">
								
								<div class="list_part2"><img src="<?=_UPLOAD_FILE_URL?>user_images/small/<?php echo $Data_list[$i]["UserSmallImg"] ;?>" height="110" width="120" /></div>
								<div class="list_part3"><span class="black"><?php echo $Data_list[$i]["ClinicName"] ;?></span><br />
								<?php echo $Data_list[$i]["Address1"] ;?>
								<?php echo $Data_list[$i]["Address2"] ;?>,
								<?php echo $Data_list[$i]["City"] ;?>
								(<?php echo $Data_list[$i]["State"] ;?>)
								<?php echo $Data_list[$i]["Country"] ;?>
								Tél : <?php echo $Data_list[$i]["Phone"] ;?>
								<p>&nbsp;</p>
								<?php echo $Data_list[$i]["ClinicDescription"] ;?>
								<p>&nbsp;</p>
								<?php
								if(!empty($sid) || (!empty($usercategory)))
								{
									if(!empty($usercategory))
									{
										$link = $usercategory;
									}
									else
									{
										$link = $sid;
									}
								?>
								<span class="more">
									<a href="servicedetails.php?qid=<?php echo $link; ?>&cid=<?php echo $Data_list[$i]["UserId"] ;?>">read more...</a>
								</span>
								<div class="next1" align="right"><a href="compose.php?clnic=<?php echo $Data_list[$i]["UserId"] ;?>"><img src="images/contact-button.gif" border="0" /></a><a href="quote.php?qid=<?php echo $link; ?>&clid=<?php echo $Data_list[$i]["UserId"] ;?>"><img src="images/send_mail.gif" border="0" /></a></div>
								<?php } ?>
								</div>
								<div class="clear"></div>
							</div>
						</div>
						<?php 
						} } else { echo "<div style='color:red; font-size:20px;'>Aucune clinique disponible</div>"; }
						?>
						<!--End listing_box -->
						<div class="clear"></div>
						
						<div class="listing_box">
							<div class="listing_content">
								
						<div class="next" align="right">
						<?php	
						$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
						foreach ($qsA as $k=>$v) $qs .= "&$k=$v";						
						$url = "?page={@PAGE}&$qs";
						$pager = new pager($url, $count_total_list, $records_per_page, $page);						
						$pager->outputlinks();						
						?>
						</div>
						<div class="clear"></div>
							</div>
						</div>
						<!--End listing_box -->
						<div class="clear"></div>
						
					</div>
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

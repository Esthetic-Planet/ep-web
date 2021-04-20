<?php
include_once("includes/global.inc.php");

$val=$_REQUEST['pid'];
?>
<select name="ClinicName" id="ClinicName" class="listmenu">
	<option value="">---- Select Clinic ----</option>
	<?php	
		$cond="where 1=1 and find_in_set('$val',UserCategories) = true and IsActive='t'";
		$orderby="order by ClinicName asc";
		$cat_arr = $sql->SqlRecords("esthp_tblUsers",$cond,$orderby);
		$count_total=$cat_arr['TotalCount'];
		$count = $cat_arr['count'];
		$Data = $cat_arr['Data'];
		
		for($i=0; $i<$count_total; $i++)
		{ ?>
			<!--<option value="<?php echo $Data[$i]['UserId']; ?>"<?php echo ($Data['Parent']==$DataDest[$i]['SiteUrl'])?" selected":"";	?>>-->
			<option value="<?php echo $Data[$i]['UserId']; ?>"><?php echo $Data[$i]['ClinicName']; ?></option>		
	<?php	} ?>
</select>
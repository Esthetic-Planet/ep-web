<?php
include_once("../includes/global.inc.php");
?>
<?php

    $id = $_REQUEST['id'];
    $val = $_REQUEST["val"];
	$records_per_page=1000;				
	$offset = ($page-1) * $records_per_page;
	if($id=="")
	{
		$cond="WHERE status='active' and dest_id = ''";
	}
	else
	{
		$cond="WHERE status='active' and dest_id = $id";
	}

	$orderby=" ORDER BY id DESC";

	$webPage = $sql->SqlRecords("mos_tblWebpage",$cond,$orderby,$offset=0,$records_per_page);

	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];

	

?>

<?php

		if($count>0)

		{

		?>

			<select name="url" class="input_white">			

		<?php

			for($i=0; $i<$count; $i++)
			{
					$sel ="";
					if($val == $Data[$i]['id'])
					$sel = "selected";					
					
			?>

			<option value="webpage.php?page=<?=$Data[$i]['id']?>" <?=$sel?>><?=$Data[$i]['name']?></option>

			<?php

			}

			?>

			</select>

		<?php

		}

		else

		{

		?>

		<select name="url" class="input_white" size="1">

			<option value="index.php" selected="selected">Webpage</option>

		</select>

		<?php

		}
		?>
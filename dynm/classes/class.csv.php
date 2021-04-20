<?
mysql_pconnect($_dbconfig['host'], $_dbconfig['user'], $_dbconfig['pass']);
@mysql_select_db($_dbconfig['dbname']) or die ("Unable to select database");

CLASS  CSV{
var $sql;
function getcsvmysql($sql,$head_name)
{

	$result = mysql_query($sql);
	$count = mysql_num_fields($result);
	for ($i = 0; $i < $count; $i++){
		$header .= str_replace("_"," ",strtoupper(mysql_field_name($result, $i))).",";
	}


	while($row = mysql_fetch_row($result)){
		$i=0;
		$line = '';
		foreach($row as $value){
				if(empty($value)){
					$value = "\t";
				}
				$value = str_replace('"', '""', $value);
				$value = $value . ",";
				$line .= $value;
				++$i;
		}

		$data .= trim($line)."\n";
	}

	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
	$data = str_replace("\r", "", $data);

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$head_name.".csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $header."\n".$data;

}
}
?>

<?
mysql_pconnect($_dbconfig['host'], $_dbconfig['user'], $_dbconfig['pass']);
@mysql_select_db($_dbconfig['dbname']) or die ("Unable to select database");

CLASS  Excel{
var $sql;
function getexcelmysql($sql,$head_name)
{

	$result = mysql_query($sql);
	$count = mysql_num_fields($result);
	//for ($i = 0; $i < $count; $i++){
	
	//$header .= str_replace(","," ",strtoupper(mysql_field_name($result, $i)))."\t";
	//}
	$strHeadNames = "Agent,Address .2,Arrival Dt_DATE9,City,Cleaning Fee,Credit Card_Number,Depart Date_DATE9,Waiver_$,Name_First,Name_Last,Phone_E-Mail,Reservation Fee,Resort,Security Deposit,State,Street,Unit Description,Zip Code,Party Size_Adults,Party Size_Children,Rate_Special,Credit Card_Cardholder,Credit Card_Relationship,Credit Card_Your Company,Credit Card_Verif Code,Credit Card_Expir Month,Credit Card_Expir Year,Name_Middle Initial,Requests_Bedding,Requests_Smoking,Requests_Occassion,Requests_Misc,Credit Card_Phone .,Payment_Final Due Date_DATE9,Mgn Co_Money Due,Tax Amount,Date_Booking_DATE9,Ad Source,Depositamo,Country,Credit Card_Phone Ext,Credit Card_Phone Country,Confirm .,Depositnum,Depositdat_DATE9,ImportedFromAccess_DATE9,ImportedToApproach,Commission Due,Management Co";
	$arrHeadNames = explode(",",$strHeadNames);
	for ($i = 0; $i < count($arrHeadNames); $i++)
	{
	
	$header .= $arrHeadNames[$i]."\t";
	}

	while($row = mysql_fetch_row($result)){
		$i=0;
		$line = '';
		foreach($row as $value){
				if(empty($value)){
					$value = "\t";
				}
				$value = str_replace('"', '""', $value);
				$value = '"' . $value . '"' . "\t";
				$line .= $value;
				++$i;
		}

		$data .= trim($line)."\n";
	}

	# this line is needed because returns embedded in the data have "\r"
	# and this looks like a "box character" in Excel
	$data = str_replace("\r", "", $data);

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$head_name.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo $header."\n".$data;

}
}
?>


 <BR><BR>
 
       <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
 <div align="center">
   <center>
   <table border="0" width="266">
     <tr>
       <td width="266"><i><font face="Arial" size="2"><b>Enter your UPS tracking number below...<img src="http://www.atticghost.com/images/LOGO_L.GIF" align="right" border="0" width="65" height="80" alt="UPS Logo">
         </b></font></i>
 <br>
       <input type="hidden" name="action" value="track">
       <input class="track1" type="text" name="tracknum" value="<?php echo $_POST['tracknum'] ?>" maxlength="100" size="20"><br>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
       <input class="track2" type="submit" name="button" value="Track!">
 
       </td>
     </tr>
   </table>
   </center>
 </div>
       </form>

 <?php
//////////// begin tracking script  ////////////
 if($_POST['action'] == "track"){
$_POST['tracknum'] = substr(eregi_replace("[^A-z0-9. -]", "", $_POST['tracknum']),0,100); /// just a simple filter and to limit any number to 100 characters for safety sake
$userid_pass = "XXXXXXXXXXXX";  /// The username and password from UPS (username and password are the same)
$access_key = "XXXXXXXXXXXXX";  //// license key from UPS
$upsURL = "https://XXXXXXXXXX.ups.com/XXXXXXXXXXXXXXX"; /// This will be provided to you by UPS
$activity = "activity"; /// UPS activity code

///// The below variable is the query string to be posted. /////
 $y = "<?xml version=\"1.0\"?><AccessRequest xml:lang=\"en-US\"><AccessLicenseNumber>".$access_key."</AccessLicenseNumber><UserId>".$userid_pass."</UserId><Password>".$userid_pass."</Password></AccessRequest><?xml version=\"1.0\"?><TrackRequest xml:lang=\"en-US\"><Request><TransactionReference><CustomerContext>Example 1</CustomerContext><XpciVersion>1.0001</XpciVersion></TransactionReference><RequestAction>Track</RequestAction><RequestOption>".$activity."</RequestOption></Request><TrackingNumber>".$_POST['tracknum']."</TrackingNumber></TrackRequest>";
//////
 /////////////////// begin the cURL engine /////////////////////
///////////////////////////////////////////////////////////////
//////////////////// What a powerful utility! /////////////////
///////////////////////////////////////////////////////////////
 $ch = curl_init(); /// initialize a cURL session
 curl_setopt ($ch, CURLOPT_URL,$upsURL); /// set the post-to url (do not include the ?query+string here!)
 curl_setopt ($ch, CURLOPT_HEADER, 0); /// Header control
 curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);/// Use this to prevent PHP from verifying the host (later versions of PHP including 5)
 /// If the script you were using with cURL has stopped working. Likely adding the line above will solve it.
 curl_setopt($ch, CURLOPT_POST, 1);  /// tell it to make a POST, not a GET
 curl_setopt($ch, CURLOPT_POSTFIELDS, $y);  /// put the query string here starting with "?" 
 curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); /// This allows the output to be set into a variable $xyz
 $upsResponse = curl_exec ($ch); /// execute the curl session and return the output to a variable $xyz
 curl_close ($ch); /// close the curl session
////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
///////////////////  end the cURL Engine  /////////////////
 
 
 //////////// begin xml parser Class function ////////////
/////////////////////////////////////////////
/////// class function taken from http://www.hansanderson.com/php/xml/class.xml.php.txt

 class xml_container {
 
 	function store($k,$v) {
 		$this->{$k}[] = $v;
 	}
 
 }
 class xml { 
 
 	var $current_tag=array();
 	var $xml_parser;
 	var $Version = 1.0;
 	var $tagtracker = array();
 
 	function startElement($parser, $name, $attrs) {
 
 		array_push($this->current_tag, $name);
 
 		$curtag = implode("_",$this->current_tag);
 
 		if(isset($this->tagtracker["$curtag"])) {
 			$this->tagtracker["$curtag"]++;
 		} else {
 			$this->tagtracker["$curtag"]=0;
 		}
 
 
 		if(count($attrs)>0) {
 			$j = $this->tagtracker["$curtag"];
 			if(!$j) $j = 0;
 
 			if(!is_object($GLOBALS[$this->identifier]["$curtag"][$j])) {
 				$GLOBALS[$this->identifier]["$curtag"][$j] = new xml_container;
 			}
 
 			$GLOBALS[$this->identifier]["$curtag"][$j]->store("attributes",$attrs);
                 }
 
 	} // end function startElement
 
 
 
 	/* when expat hits a closing tag, it fires up this function */
 
 	function endElement($parser, $name) {
 
 		$curtag = implode("_",$this->current_tag); 	// piece together tag
 								// before we pop it off,
 								// so we can get the correct
 								// cdata
 
 		if(!$this->tagdata["$curtag"]) {
 			$popped = array_pop($this->current_tag); // or else we screw up where we are
 			return; 	// if we have no data for the tag
 		} else {
 			$TD = $this->tagdata["$curtag"];
 			unset($this->tagdata["$curtag"]);
 		}
 
 		$popped = array_pop($this->current_tag);
 								// we want the tag name for
 								// the tag above this, it 
 								// allows us to group the
 								// tags together in a more
 								// intuitive way.
 
 		if(sizeof($this->current_tag) == 0) return; 	// if we aren't in a tag
 
 		$curtag = implode("_",$this->current_tag); 	// piece together tag
 								// this time for the arrays
 
 		$j = $this->tagtracker["$curtag"];
 		if(!$j) $j = 0;
 
 		if(!is_object($GLOBALS[$this->identifier]["$curtag"][$j])) {
 			$GLOBALS[$this->identifier]["$curtag"][$j] = new xml_container;
 		}
 
 		$GLOBALS[$this->identifier]["$curtag"][$j]->store($name,$TD); #$this->tagdata["$curtag"]);
 		unset($TD);
 		return TRUE;
 	}
 
 
 
 	/* when expat finds some internal tag character data,
 	   it fires up this function */
 
 	function characterData($parser, $cdata) {
 		$curtag = implode("_",$this->current_tag); // piece together tag		
 		$this->tagdata["$curtag"] .= $cdata;
 	}
 
 
 	/* this is the constructor: automatically called when the class is initialized */
 
 	function xml($data,$identifier='xml') {  
 
 		$this->identifier = $identifier;
 
 		// create parser object
 		$this->xml_parser = xml_parser_create();
 
 		// set up some options and handlers
 		xml_set_object($this->xml_parser,$this);
 		xml_parser_set_option($this->xml_parser,XML_OPTION_CASE_FOLDING,0);
 		xml_set_element_handler($this->xml_parser, "startElement", "endElement");
 		xml_set_character_data_handler($this->xml_parser, "characterData");
 
 		if (!xml_parse($this->xml_parser, $data, TRUE)) {
 			sprintf("XML error: %s at line %d",
 			xml_error_string(xml_get_error_code($this->xml_parser)),
 			xml_get_current_line_number($this->xml_parser));
 		}
 
 		// we are done with the parser, so let's free it
 		xml_parser_free($this->xml_parser);
 
 	}  // end constructor: function xml()
 
 
 } // thus, we end our class xml
///////////////////////////////////////////////////
/////////// end XML Class  //////////////////////// 

$obj = new xml($upsResponse,"xml"); /// create the object
$nine = trim($xml["TrackResponse_Response"][0]->ResponseStatusCode[0]);
////////////////////////
if($nine == "1"){
			$seven = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->AddressLine1[0] . "\n";
			$six = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->AddressLine2[0] . "\n";
			$five = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->City[0] . "\n";
			$four = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->StateProvinceCode[0] . "\n";
			$three = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->PostalCode[0] . "\n";
			$two = $xml["TrackResponse_Shipment_ShipTo_Address"][0]->CountryCode[0] . "\n";
			$twelve = $xml["TrackResponse_Shipment_Package_PackageWeight_UnitOfMeasurement"][0]->Code[0] . "\n";
			$eleven = $xml["TrackResponse_Shipment_Package_PackageWeight"][0]->Weight[0] . "\n";
			$thirteen = $xml["TrackResponse_Shipment_Service"][0]->Description[0] . "\n";
///current location
			$fourteen = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation"][0]->Description[0] . "\n";
			$eighteen = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][0]->City[0] . "\n";
			$nineteen = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][0]->CountryCode[0] . "\n";
			$twenty = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][0]->StateProvinceCode[0] . "\n";
			$fifteen = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation"][0]->SignedForByName[0] . "\n";
// end location
			$sixteen = $xml["TrackResponse_Shipment_Package_Activity_Status_StatusType"][0]->Description[0] . "\n";
			$seventeen = $xml["TrackResponse_Shipment_Package_Activity_Status_StatusType"][0]->Code[0] . "\n";
			$twentyfour = $xml["TrackResponse_Shipment_Package_Activity"][0]->Date[0] . "\n";
			$twentyfive = $xml["TrackResponse_Shipment_Package_Activity"][0]->Time[0] . "\n";
$yearx = substr("$twentyfour", 0, 4);
$monthx = substr("$twentyfour", 4, 2);
$dayx = substr("$twentyfour", 6, 2); 
$hhx = substr("$twentyfive", 0, 2);
$mmx = substr("$twentyfive", 2, 2);
$ssx = substr("$twentyfive", 4, 2);
$seventeen = trim($seventeen);
switch($seventeen){
case I:
$stat = "In transit";
BREAK;
case D:
$stat = "Delivered";
BREAK;
case X:
$stat = "Exception";
BREAK;
case P:
$stat = "Pickup";
BREAK;
case M:
$stat = "Manifest Pickup";
BREAK;
}
?>
<div align="center">
  <center><font color="#000080" size="1" face="Verdana">Tracking Number: <b><?php echo $_POST['tracknum'] ?></b></font>
  <table border="1" cellspacing="0" cellpadding="0" width="306"><tr><td width="374">
  <table border="0" cellspacing="0" cellpadding="0" width="362">
    <tr>
      <td colspan="2" width="360" bgcolor="#AE9159"><b><font color="#FFFFFF" size="2" face="Verdana"><i>Status:</i>
        </font><font color="#000080" size="1" face="Verdana"> <?php echo $stat ?> </font><font color="#FFFFFF" size="2" face="Verdana"> 
        </font><font color="#000080" size="1" face="Verdana"><?php if($seventeen == "D"){echo("Left at: $fourteen");} ?></font></b></td>
    </tr>
    <tr>
      <td align="right" nowrap width="114" bgcolor="#FFFFCC"><font size="1" face="Verdana"><b>Shipping Method:</b></font></td>
      <td width="244" bgcolor="#FFFFCC"><font face="Verdana" size="1" color="#000080"><?php echo $thirteen ?></font></td>
    </tr>
    <tr>
      <td align="right" width="114" bgcolor="#FFFFCC"><font size="1" face="Verdana"><b>Weight:</b></font></td>
      <td width="244" bgcolor="#FFFFCC"><font face="Verdana" size="1" color="#000080"><?php echo "$eleven $twelve" ?></font></td>
    </tr>
    <tr>
      <td colspan="2" width="360" align="center">
      </td>
    </tr>
    <tr>
      <td colspan="2" width="360" align="left" bgcolor="#AE9159"><!--
        <font face="Verdana" size="2" color="#FFFFFF"><b><i>Destined for:</i></font></b> -->
<font color="#000080" size="1" face="Verdana"><b><?php echo "$monthx/$dayx/$yearx" ?></font> - <font color="#000080" size="1" face="Verdana"><b><?php echo "$hhx:$mmx:$ssx" ?></b></font></font>
      </td>
    </tr>

    <tr>
      <td width="114" align="right" bgcolor="#FFFFCC" valign="top">
        <b><font face="Verdana" size="1"><?php if($stat == "I"){$sixteen = trim($sixteen);echo("$sixteen");}else{$sixteen = trim($sixteen);echo("$sixteen");} ?>:</font></b>
      </td>
      <td width="244" bgcolor="#FFFFCC">
        <font face="Verdana" color="#000080" size="1">
<?php if($eighteen){echo("$eighteen, ");}if($twenty){echo("$twenty ");}if($nineteen){echo("$nineteen");} ?></font>
      </td>
    </tr>
    <tr>
      <td colspan="2" width="360"><font face="Verdana" size="2"><b><?php if($seventeen == "D"){echo("Signed for by: $fifteen");} ?></b></font></td>
    </tr>
    <tr>
      <td colspan="2" width="360">

</td>
    </tr>
  </table>
  </td></tr></table>
  </center>
</div>


<?php
}else{
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
$eight = $xml["TrackResponse_Response_Error"][0]->ErrorDescription[0];
echo "<center><b><font color='#FF0000'>".$eight."</font></b></center>";
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////
}  /// end if nine is 1 or 0
/////////////////
/////////// end xml parser  /////
}    ///// end if action is track
?>
<BR>
<?php
if($nine == "1"){
$bgcolor = "#E1E1E1";
echo("<center><b>Package History</b></center>
<font face=\"Verdana\" size=\"1\">
<table border='0' align=\"center\"><tr><td nowrap width='20%' bgcolor='#C0C0C0'><B><font face=\"Verdana\" color=\"#000000\" size=\"1\">Date</font></b></td><td nowrap width='20%' bgcolor='#C0C0C0'><B><font face=\"Verdana\" color=\"#000000\" size=\"1\">Time</font></b></td><td nowrap width='20%' bgcolor='#C0C0C0'><B><font face=\"Verdana\" color=\"#000000\" size=\"1\">Location</font></b></td><td width='40%' width='20%' bgcolor='#C0C0C0'><B><font face=\"Verdana\" color=\"#000000\" size=\"1\">Activity</font></b></td></tr>");
for($i=0;$i<count($xml["TrackResponse_Shipment_Package_Activity"]);$i++) {
			$twentyone = $xml["TrackResponse_Shipment_Package_Activity_Status_StatusType"][$i]->Description[0] . "\n";
			$twentytwo = $xml["TrackResponse_Shipment_Package_Activity"][$i]->Date[0] . "\n";
			$twentythree = $xml["TrackResponse_Shipment_Package_Activity"][$i]->Time[0] . "\n";
			$twentyfour = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][$i]->City[0] . "\n";
			$twentyfive = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][$i]->StateProvinceCode[0] . "\n";
			$twentysix = $xml["TrackResponse_Shipment_Package_Activity_ActivityLocation_Address"][$i]->CountryCode[0] . "\n";


$year = substr("$twentytwo", 0, 4);
$month = substr("$twentytwo", 4, 2);
$day = substr("$twentytwo", 6, 2); 

$hh = substr("$twentythree", 0, 2);
$mm = substr("$twentythree", 2, 2);
$ss = substr("$twentythree", 4, 2);
echo("<tr>");
if($xday != $day){

if($bgcolor == "#E1E1E1"){
$bgcolor = "#EFEEED";
///echo("E1E1E1");
}else{
$bgcolor = "#E1E1E1";
///echo("EFEEED");
}

echo("<td nowrap width='20%' bgcolor='".$bgcolor."'><B><font face=\"Verdana\" color=\"#000080\" size=\"1\">".$month."/".$day."/".$year."</font></b></td>");

}else{
echo("<td nowrap width='20%' bgcolor='".$bgcolor."'>&nbsp;</td>");
}

$xmonth = $month;
$xday = $day;
$xyear = $xyear;

echo("<td nowrap width='20%' bgcolor='".$bgcolor."'><font face=\"Verdana\" color=\"#000000\" size=\"1\"><i>".$hh.":".$mm.":".$ss."</i></font></td><td nowrap width='20%' bgcolor='".$bgcolor."'><font face=\"Verdana\" color=\"#000000\" size=\"1\">".$twentyfour." ".$twentyfive." ".$twentysix."</font></td><td width='40%' bgcolor='".$bgcolor."'><font face=\"Verdana\" color=\"#000080\" size=\"1\">".$twentyone."</font></td></tr>");
}

echo("
</table>
</font>
<BR>");

echo("<font face=\"Verdana\" color=\"#000000\" size=\"1\">Results provided by UPS ".date("F j, Y, g:i a T").".<BR><BR>
<b>NOTICE:</b> UPS authorizes you to use UPS tracking systems solely to track shipments tendered by or for you to UPS for delivery and for no other purpose. Any other use of UPS tracking systems and information is strictly prohibited.
</font><BR><BR>
");
}  /// end if 17 is X
 ?>
 <BR>
 <!-- end main content -->  
         

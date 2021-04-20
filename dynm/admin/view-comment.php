<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");

$id= $_REQUEST["cust_id"];
$clid=$_REQUEST["clnicid"];

/*$query_sel = "select * from esthp_comment where cust_id='$id'";
$res_sel = $sql->SqlExecuteQuery($query_sel);
$Data = $res_sel["Data"][0];*/

if($clid == "1")
{
	$query_sel = "SELECT cm.*, cm.id as comid, cu.cust_fname,cu.cust_lname,cu.cust_email FROM esthp_comment as cm, esthp_tblCustomers as cu where  cm.cust_id='$id' and cm.cust_id=cu.cust_id order by Added_date desc";
} else {
	$query_sel = "SELECT cm.*, cm.id as comid, cu.cust_fname,cu.cust_lname,cu.cust_email FROM esthp_comment as cm, esthp_tblCustomers as cu where cm.clinicid='$clid' and cm.cust_id='$id' and cm.cust_id=cu.cust_id order by Added_date desc";
}
$res_sel = $sql->SqlExecuteQuery($query_sel);
$Data = $res_sel["Data"];
$count = $res_sel["count"];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>View Comment</title>
<script type="text/javascript" src="js/jquery-latest.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<link rel="stylesheet" href="js/thickbox.css" type="text/css" media="screen" />
<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">
<link href="script/pager.css" rel="stylesheet" type="text/css">
</head>

<body>
<p align="right"><a href="list-customers.php">Close</a></p>
<h1>View Comments</h1><br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ECECEC;">
  <tr class="left_headbg">
  	<td class="white_text"><div align="left"></div></td>
    <td class="white_text"><div align="left">S No </div></td>
    <td width="12%" class="white_text"><div align="left">User Name </div></td>
    <td width="12%" class="white_text"><div align="left">User Email </div></td>
    <td class="white_text"><div align="left">Comments</div></td>
	<td class="white_text"><div align="left">Comments By</div></td>
	<td class="white_text"><div align="left">Date</div></td>
    <td class="white_text">Edit</td>
	<td class="white_text">&nbsp;</td>
  </tr>
  <?php 
  if(!empty($count))
  {
	  for($i=0; $i<$count; $i++) 
	  { 
			if($i % 2 =="0"){
				$cls = "grey_bg";
			} else {
				$cls = "";
			} ?>
	  <tr class="<?php echo $cls; ?>">
		<td width="1%" class="black_text">&nbsp;</td>
		<td width="5%" class="black_text" style="padding:5px;"><?php echo $i+1; ?></td>
		<td class="black_text" style="padding:5px;"><?php echo  $Data[$i]["cust_fname"]." ".$Data[$i]["cust_lname"]; ?></td>
		<td class="black_text" style="padding:5px;"><?php echo $Data[$i]["cust_email"]; ?></td>
		<td width="29%" class="black_text" style="padding:5px;"><?php echo $Data[$i]["add_comment"]; ?></td>
		<td width="23%" class="black_text" style="padding:5px;"><?php echo $Data[$i]["comment_by"]; ?></td>
		<td width="15%" class="black_text" style="padding:5px;"><?php echo $Data[$i]["Added_date"]; ?></td>
		<td width="3%" class="black_text"><a href="edit-comment.php?cust_id=<?=$Data[$i]['cust_id']?>&clnicid=<?=$_SESSION["AdminInfo"]["id"]?>&comid=<?=$Data[$i]["comid"]?>&height=450&amp;width=650&amp;modal=true" class="thickbox">Edit</a></td>
			<td class="white_text">&nbsp;</td>
	  </tr>
	  <?php } 
	  } else {?>
	   <tr class="<?php echo $cls; ?>">
		<td colspan="8" class="black_text" style="color:#BF2400; font-weight:bold; padding:5px;"><div align="center">No Comments available </div></td>
		
	  </tr>
  <?php } ?>
</table>

</body>
</html>

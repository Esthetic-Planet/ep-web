<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");

$id= $_REQUEST["cust_id"];
$clid=$_REQUEST["clnicid"];

$query_clinic = "select * from esthp_tblUsers where UserId='$clid'";
$res_clinic = $sql->SqlExecuteQuery($query_clinic);
$Data_clinic = $res_clinic["Data"][0];

if($clid == "1")
{
	$clname = "Admin";
} else {
	$clname = $Data_clinic["ClinicName"];
}

$query_sel = "select * from esthp_tblCustomers where cust_id='$id'";
$res_sel = $sql->SqlExecuteQuery($query_sel);
$Data = $res_sel["Data"][0];

$name = $Data["cust_fname"]." ".$Data["cust_lname"];
$email = $Data["cust_email"];
	
if(isset($_POST['submit']) && $_POST['submit']=='Save')
{ 
	$add_comment=trim($_POST['add_comment']);
	$custid=trim($_POST['cust_id']);
	$clid=trim($_POST['clinicid']);
	$comment_by=trim($_POST['comment_by']);
	$date = date("Y-m-d",time());
	
	/*$query_sel = "select * from esthp_tblCustomers where cust_id='$id'";
	$res_sel = $sql->SqlExecuteQuery($query_sel);
	$Data = $res_sel["Data"][0];
	
	$cmt = $Data["add_comment"];
	if(empty($cmt)){
		$cmt = $add_comment;
	} else {
		$cmt = $cmt."|".$add_comment;
	}*/
		
	$query = "insert into esthp_comment (clinicid, cust_id, add_comment,comment_by,Added_date) values ('$clid', '$custid', '$add_comment','$comment_by','$date')";
	$res = $sql->SqlExecuteQuery($query);
	header("location: list-customers.php");
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Untitled Document</title>
</head>
<style type="text/css">
.bdr{
	border:1px solid #666;
	width:250px;
}
.btnbdr{
	border:1px solid #666;
	width:75px;
}
</style>
<script>
/*function checkcmt()
{
	var a = document.test.add_comment.value;
	var b = document.test.comment_by.value;
	if(a == '')
	{
		alert("Please enter the Comment");
		document.test.add_comment.focus();
		return false();
	}
	if(b == '')
	{
		alert("Please enter the Comment By");
		document.test.comment_by.focus();
		return false();
	}
}*/
</script>
<body>
<h1>Add Comment</h1><br />
<p align="right"><a href="list-customers.php">Close</a></p>
<!--<form name="test" method="post" action="add-comment.php" onsubmit="checkcmt()">-->
<form name="test" method="post" action="add-comment.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><div align="right">User Name:</div></td>
    <td>&nbsp;</td>
    <td><input type="text" name="uname" id="uname" class="bdr" readonly="" value="<?php echo $name; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" height="7"></td>
    </tr>
  <tr>
    <td valign="top"><div align="right">User Email: </div></td>
    <td>&nbsp;</td>
    <td><input type="text" name="uemail" class="bdr" id="uemail" readonly="" value="<?php echo $email; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" height="7"></td>
    </tr>
  <tr>
    <td valign="top"><div align="right">Comment:</div></td>
    <td>&nbsp;</td>
    <td><textarea name="add_comment" class="bdr" cols="40" rows="5"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" height="7"></td>
    </tr>
  <tr>
    <td valign="top"><div align="right">Comment By: </div></td>
    <td>&nbsp;</td>
    <td><input type="text" name="comment_by" class="bdr" id="comment_by" readonly="" value="<?php echo $clname; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" height="7">
      <input type="hidden" name="cust_id" value="<?php echo $id; ?>"  />
      <input type="hidden" name="clinicid" value="<?php echo $clid; ?>"  /></td>
    </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td><input  type="submit"  name="submit" class="btnbdr"  value="Save" /></td>
  </tr>
</table>
</form>
</body>
</html>

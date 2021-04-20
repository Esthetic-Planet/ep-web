<?php
include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();



$sqlError="";

$franchiseID=$_SESSION['AdminInfo']['id'];


$ord_id=$_REQUEST['ordID'];



$cond = " where ord_id='".$ord_id."' and ord_franchise_id='".$franchiseID."'";
$ord_arr = $sql->SqlSingleRecord('esthp_tblOrders',$cond);
$ord_count = $ord_arr['count'];
$order_row = $ord_arr['Data']; 




$franch_cond = " where UserId='".$franchiseID."'";
$franch_arr = $sql->SqlSingleRecord('esthp_tblUsers',$frnach_cond);
$franch_count = $franch_arr['count'];
$franch_row = $franch_arr['Data']; 



 if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['ordID']))
{	
	$content_arr = array();
	$content_arr["ord_status"] = $_POST["ord_status"] ;
	$content_arr['ord_date_modified'] = date("Y-m-d H:i:s",time());
    $condition = " where ord_id='".$ord_id."' and ord_franchise_id='".$franchiseID."'";
	$sql->SqlUpdate('esthp_tblOrders',$content_arr,$condition);
	
	
	$status_cond = " where status= '".$_POST["ord_status"]."' "; 						
	$status_arr = $sql->SqlSingleRecord('esthp_OrderStatus',$status_cond);
	$status_count = $status_arr['count'];
	$status = $status_arr['Data'];
								
	
	if(!empty($_REQUEST['notify_user']))
	{
		/////////////////////////////////// send email to customer //////////////////////////
		$to_email =$order_row['ord_cust_email'];
		$email_subject="Your order # ".$ord_id." status: "._WEBSITE_NAME;
		$email_body .=
		'
		<table width="70%" cellpadding="0" border="0">
		<tr><td colspan="2" align="left">Hi '.$order_row['	ord_cust_fname'].' '.$order_row['	ord_cust_lname'].',<br/><br/><b>Your order # '.$ord_id.'  on '._WEBSITE_NAME.' is '.$status['status_text'].' !</b><br/><br/></td></tr>
		<tr>
		<td colspan="2" align="left">Thanks</td>	
		</tr>
		</table>
		';
		$franchise_email=$franch_row['LoginEmail'];
		$from="From: ".'Admin'." <".$franchise_email.">";
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .=$from;
	
		
		mail($to_email,$email_subject,$email_body,$header);
		/////////////////////////////// send email ends /////////////////////////////////////////
	}		
	

	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-orders.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}







?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Content-Language" content="fr" />
<meta name="language" content="fr" />
<title>:: <?=$sitename?> ::</title>
<link href="script/style.css" rel="stylesheet" type="text/css">
<link href="script/admin.css" rel="stylesheet" type="text/css">

<SCRIPT language=javascript src="../js/validation_new.js"></SCRIPT>

<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>	




</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-orders.php">Manage Orders</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="update-order" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Order Details </h1></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  valign="top"><img src="images/spacer.gif" alt="" width="1" height="25" align="left">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>
         
		 <?php
		 if($sqlError!='')
		 {
		 ?>
		  </tr>
		  <tr><td valign="top"><?=$sqlError?></td>
		  </tr>
		  <?php
		  }
		  ?>
		  
		   <tr>
		  
            <td valign="top">
						
			
			
			      <table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="50%" align="left" class="link_blue"><strong>Billing Details:</strong></td>
            <td width="50%" align="left" class="link_blue"><strong>Shipping Details:</strong></td>
          </tr>
		  
          <tr>
            <td valign="top" align="left" class="normal_text_blue"><p><strong>Name:</strong> <?=$order_row['ord_cust_fname']?> <?=$order_row['ord_cust_lname']?></p>
           
            <p><strong>Address:</strong> <?=$order_row['ord_cust_address']?></p>
			<p><?=$order_row['ord_cust_state']?> <?=$order_row['ord_cust_city']?> <?=$order_row['ord_cust_zip']?> </p>
			<p><?=$order_row['ord_cust_country']?></p>
			 <p><strong>Phone:</strong> <?=$order_row['ord_cust_phone']?></p>
			  <p><strong>Email:</strong> <?=$order_row['ord_cust_email']?></p>
			  <p><strong>Franchise:</strong> # <?=$order_row['ord_franchise_id']?></p>
            <p>&nbsp;</p></td>
			
            <td valign="top" align="left" class="normal_text_blue"><p><strong>Name:</strong> <?=$order_row['ord_ship_fname']?> <?=$order_row['ord_ship_lname']?></p>
            <p><strong>Address:</strong> <?=$order_row['ord_ship_address']?></p>
			<p><?=$order_row['ord_ship_state']?> <?=$order_row['ord_ship_city']?> <?=$order_row['ord_ship_zip']?></p>
			<p><?=$order_row['ord_ship_country']?></p>
			<p><strong>Phone:</strong> <?=$order_row['ord_ship_phone']?></p>
			<p><strong>Order Date:</strong> <?=date('jS M Y H:i:s',strtotime($order_row['ord_date_added']))?></p>
            <p>&nbsp;</p></td>
        </tr>
        </table>
		

		<table width="100%" bgcolor="#ffffff" border="0" cellspacing="1" cellpadding="5">
		
		 <tr>
            <td colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" class="link_blue">Order # <strong><?=$ord_id?></strong></td>
          </tr>
		  
		  
		   <tr>
            <td colspan="5" align="left" valign="middle" bgcolor="#FFFFFF" class="link_blue">Status: <select name="ord_status" class="input_white">
				<?php
				
				
					$status_cond = " where 1=1"; 						
					$status_arr = $sql->SqlRecordMisc('esthp_OrderStatus',$status_cond);
					$status_count = $status_arr['count'];
					$status_data = $status_arr['Data'];
								
				foreach($status_data as $status)
				{
				?>
				<option value="<?=$status['status']?>" <?=($status['status']==$order_row['ord_status']?'selected':'')?>><?=$status['status_text']?></option>
				<?php
				}
				?>
				</select>	&nbsp;&nbsp;<input type="checkbox" name="notify_user" value="1"> Notify customer about order update&nbsp;&nbsp;<input type="submit" class="btn" name="Submit" value="Update"><br/>&nbsp;</td>
          </tr>
		  
		  
<?php
		$cart_cond = "where cart_order_id='".$ord_id."' and cart_franchise_id='".$franchiseID."'";				
		$cart_arr = $sql->SqlRecordMisc('esthp_tblCart',$cart_cond);
		$cart_count = $cart_arr['count'];
		$cart_records = $cart_arr['Data'];
		
		
		
		if($cart_count>0)
		{
	
	
	?>		  
  <tr class="purple_td" bgcolor="#4a2a84">
    <td width="14%" align="center" valign="middle"   class="white_text" >S.No</td>
    <td width="23%" align="left" valign="middle"  class="white_text">Product Name</td>
    <td width="18%" align="right" valign="middle"   class="white_text">Unit Price</td>
    <td width="20%" align="center" valign="middle"  class="white_text">Quantity</td>
    <td width="25%" align="right" valign="middle"  class="white_text">Total Price</td>
  </tr>
 	 <?php
						  $i=0;
						  $total_cart_price=0;
						  foreach($cart_records as $cart_record)
						  {
							$i++;
							$cart_prod_price=$cart_record['cart_prod_price'];
							$cart_prod_quantity=$cart_record['cart_prod_quantity']; 
							$sub_total=$cart_prod_price*$cart_prod_quantity;
							$total_cart_price=$total_cart_price+$sub_total;
						  ?>
							<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><?=$i?></td>
						<td align="left" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><?=$cart_record['cart_prod_name']?></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">$ <?=$cart_prod_price?></td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><?=$cart_prod_quantity?></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">$ <?=number_format($sub_total,2,'.',',')?></td>
						</tr>
						<?php
						}
						?>

						<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>Subtotal</strong></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>$ <?=number_format($total_cart_price,2,'.',',')?></strong></td>
						</tr>
						<?php
						if($order_row['ord_shipping']>0)
						{
						?>
						<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>Shipping</strong></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>$ <?=number_format($order_row['ord_shipping'],2,'.',',')?></strong></td>
						</tr>
						<?php
						}
						?>
						
						<?php
						if($order_row['ord_tax']>0)
						{
						?>
						<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue">&nbsp;</td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>Tax</strong></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>$ <?=number_format($order_row['ord_tax'],2,'.',',')?></strong></td>
						</tr>
						<?php
						}
						?>

			
						<?php
						if($order_row['ord_vat']>0)
						{
						?>
						<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>VAT</strong></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>$ <?=number_format($order_row['ord_vat'],2,'.',',')?></strong></td>
						</tr>
						<?php
						}
						?>	
						
						
						
						<tr>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="center" valign="middle" bgcolor="#e7e7e7">&nbsp;</td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>Grand Total</strong></td>
						<td align="right" valign="middle" bgcolor="#e7e7e7" class="normal_text_blue"><strong>$ <?=number_format($order_row['ord_grand_total'],2,'.',',')?></strong></td>
						</tr>
						
		  
		  
		  
		  <?php
		  }
		  ?>
      </table>
			
			</td>
          </tr>
          <tr><td valign="top">&nbsp;</td></tr>
        </table>
		</form>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td></tr>
 </table>
</body>
</html>
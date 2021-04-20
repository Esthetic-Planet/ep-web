<?php include_once("../includes/global.inc.php");

require_once(_PATH."modules/mod_admin_login.php");

include_once(_CLASS_PATH."pager.cls.php");

$AuthAdmin->ChkLogin();



$franchiseID=$_SESSION['AdminInfo']['id'];





$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

//$destId=$_REQUEST['destId'];

// single Delete start

if($_REQUEST['delid']!="")
{


	$ord_id=$_REQUEST['delid'];

	// check the existance of record


	$delete_rec_cond="where ord_id= '".$ord_id."' and ord_franchise_id='".$franchiseID."'"; 						

	$del_rec_arr= $sql->SqlSingleRecord('esthp_tblOrders',$delete_rec_cond);

	$found_records=$del_rec_arr['count'];

	$found_records_data= $del_rec_arr['Data'];

	if($found_records>0) // if record found
	{
		$update_arr=array();
		$update_arr['ord_status']=8; // update status to Deleted
	
		$update_cond="ord_id='".$ord_id."' and ord_franchise_id='".$franchiseID."'";
		
		//echo "<br/>";
		$sql->SqlUpdate('esthp_tblOrders',$update_arr,$update_cond);
		

		
		
	}	


	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-orders.php">';

	echo '<input type="hidden" name="msg" id="msg" value="deleted">';

	echo '</form>';

	echo '<script type="text/javascript">document.frmSu.submit();</script>';

	echo '</body>';		

	exit;

}

// single Delete end


$message="";

$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';

if($msg=='added')

	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";

else if($msg=='updated')

	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";

else if($msg=='deleted')

	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";

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

<link href="script/pager.css" rel="stylesheet" type="text/css">


<script type="text/javascript">
	function SingleDelete(url)
	{	
		if(confirm("Are you sure you want to delete this order?"))
		{
			window.location.href=url;
		}
	}

function checkall(state)
{
	var frm=document.prodForm;
	var n =frm.elements.length;
	for (i=0; i<n; i++)
	{
		if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;

	}
}
	
</script>

</head>

<body>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-orders.php">Manage Orders</a></div></td></tr>

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="232" valign="top" class="border_left" id="adminLeftBar"><?php include_once('include/admin_left.php');?></td>

        <td width="14" valign="top">&nbsp;</td>

        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>List Orders</h1></td>

              </tr>

            </table></td>

          </tr>
		  
		  
		  <tr><td valign="top" height='20' align="center">&nbsp;</td></tr>
		  
		  
		  
		  <?php
		  if($message!='')
		  {
		  ?>

          <tr><td valign="top" style="padding:15px;" align="center"><?=$message?></td></tr>
		  
		  <?php
		  }
		  ?>

  <?php
 
  		$records_per_page=35;				

		$offset = ($page-1) * $records_per_page;
		
		$cond="where ord_franchise_id='".$franchiseID."' and ord_status!='7'";

		$orderby="order by ord_date_added desc";

		$product_arr = $sql->SqlRecords("esthp_tblOrders",$cond,$orderby,$offset,$records_per_page);

		$count_total=$product_arr['TotalCount'];

		$count = $product_arr['count'];

		$Data = $product_arr['Data'];

		//echo $count;

	  ?>

         <tr>

          <td valign="top">

		   <form method="post" action="" name="prodForm" style="margin:0px;">

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">

             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

                   <td width="125" align="center" valign="top"></td>

                   <td width="2" align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>

                   <td width="125" align="center" valign="top"><!--<a href="add-product.php" class="add_del">Add Product</a> --></td>

					<td width="118" >	</td>

                      </tr>

                    </table></td>

                    <td align="right" valign="top"><table width="357" border="0" cellspacing="0" cellpadding="0">

                      <tr>
					  
					  
					 <!-- class="paging_bg" -->
					  
					  
                        <td align="right" valign="middle" >

						<table style="font-size:9px;">

						<tr><td>Page:</td>

						<td>

						<?php

						$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";

						foreach ($qsA as $k=>$v) $qs .= "&$k=$v";

						$url = "?page={@PAGE}&$qs";

						$pager = new pager($url, $count_total, $records_per_page, $page);

						$pager->outputlinks();

						?>

						</td></tr></table>

						</td>

                      </tr>

                    </table></td>

                  </tr>

                </table></td>

              </tr>

              <tr>

                <td valign="top" class="border">
				
				
				
				
				<table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="middle" class="left_headbg">
					
					
					
					<?php
					
					
					if($count_total>0)
					{
					?>
					
					
					<table width="100%" border="0" cellspacing="0" cellpadding="5">

                      <tr>

                        
						
						<td width="10%" align="left" class="white_text">S. No.</td>

                        <td width="20%" align="center" class="white_text">Order Date</td>
						<td width="20%" align="center" class="white_text">Last Updated</td>

                        <td width="15%" align="center" class="white_text">Status</td>

                        <td width="15%" align="center" class="white_text">Customer</td>
						
						
						

                        <td width="10%" align="center" class="white_text">Edit</td>

                        <td width="10%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{	
						
						
								$status_cond = " where status= '".$Data[$i]['ord_status']."' "; 						
								$status_arr = $sql->SqlSingleRecord('esthp_OrderStatus',$status_cond);
								$status_count = $status_arr['count'];
								$status = $status_arr['Data'];
								
								
						?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							
							
							<td align="left" height="30" class="black_text"><?=$offset+1+$i?>.</td>

							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['ord_date_added']))?></td>
							
							<td align="center" class="black_text"><?=$Data[$i]['ord_date_modified']!='0000-00-00 00:00:00'?date("jS M Y H:i:s",strtotime($Data[$i]['ord_date_modified'])):''?></td>

							<td  align="center" class="black_text"><?=$status['status_text']?></td>

							<td align="center" class="black_text"><a class="grey_text" href="view-cust-franchise.php?cust_id=<?=$Data[$i]['ord_customer_id']?>&page=<?=$page?>"><?php echo $Data[$i]['ord_cust_fname'].' '.$Data[$i]['ord_cust_lname']?></a></td>


							<td align="center" class="white_text"><a href="update-order.php?ordID=<?=$Data[$i]['ord_id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-orders.php?delid=<?=$Data[$i]['ord_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='white_text'>No orders have been placed yet.</span>";
					}
					?>
					
					
					
					</td>

                  </tr>

                </table></td>

              </tr>

              <tr>            <td valign="top">&nbsp;</td>             </tr>

            </table>

			</form>

			</td>

          </tr>

          <tr><td valign="top">&nbsp;</td></tr>

        </table></td>

      </tr>

    </table></td>

  </tr>

  <tr><td valign="top"><?php include_once('include/footer.php');?></td></tr>

</table>


</body>

</html>
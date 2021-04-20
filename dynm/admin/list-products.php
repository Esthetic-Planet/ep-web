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


	$prod_id=$_REQUEST['delid'];

	// check the existance of record
	$delete_rec_cond="where prod_id= '".$prod_id."' and prod_franchise='".$franchiseID."'"; 						
	$del_rec_arr= $sql->SqlSingleRecord('esthp_tblProducts',$delete_rec_cond);
	$found_records=$del_rec_arr['count'];
	$found_records_data= $del_rec_arr['Data'];
	
	
	if($found_records>0) // if record found
	{
		$delete_cond="prod_id='".$prod_id."' and prod_franchise='".$franchiseID."'";
		
		//echo "<br/>";
		$sql->SqlDelete('esthp_tblProducts',$delete_cond);
		
		
		
		///////////delete small and large images with thumbnails ///////////
		
		$upload_dir= _UPLOAD_FILE_PATH."products/";
		
		$small_img =$found_records_data['prod_small_img'];
		$small_img_file=$upload_dir.$small_img ;
		@unlink($small_img_file);
		
		
		$small_img_thumb_file=$upload_dir.'thumbs/'.$small_img ;
		@unlink($small_img_thumb_file);
		
		
		$large_img =$found_records_data['prod_large_img'];
		$large_img_file=$upload_dir.$large_img ;
		@unlink($large_img_file);
		
		
		$large_img_thumb_file=$upload_dir.'thumbs/'.$large_img ;
		@unlink($large_img_thumb_file);
		
		
	}	


	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-products.php">';

	echo '<input type="hidden" name="msg" id="msg" value="deleted">';

	echo '</form>';

	echo '<script type="text/javascript">document.frmSu.submit();</script>';

	echo '</body>';		

	exit;

}

// single Delete end

// multi Delete start

if($_REQUEST['task']=='deleteAll' && is_array($_REQUEST['chk']) && (count($_REQUEST['chk'])>0))
{

	//print_r($_POST);
	//die;

	$prod_ids=$_REQUEST['chk'];

	for($i=0;$i<count($prod_ids);$i++)
	{
		// check the existance of record

		$prod_id = $prod_ids[$i];

		$delete_rec_cond="where prod_id= '".$prod_id."' and prod_franchise='".$franchiseID."'"; 						

		$del_rec_arr= $sql->SqlSingleRecord('esthp_tblProducts',$delete_rec_cond);

		$found_records=$del_rec_arr['count'];

		$found_records_data= $del_rec_arr['Data'];

		if($found_records>0) // if record found
		{
			$delete_cond="prod_id='".$prod_id."' and prod_franchise='".$franchiseID."'";
			
			//echo "<br/>";
			
			$sql->SqlDelete('esthp_tblProducts',$delete_cond);
			
			
			
			///////////delete small and large images with thumbnails ///////////
		
			$upload_dir= _UPLOAD_FILE_PATH."products/";
			
			$small_img =$found_records_data['prod_small_img'];
			$small_img_file=$upload_dir.$small_img ;
			@unlink($small_img_file);
			
			
			$small_img_thumb_file=$upload_dir.'thumbs/'.$small_img ;
			@unlink($small_img_thumb_file);
			
			
			$large_img =$found_records_data['prod_large_img'];
			$large_img_file=$upload_dir.$large_img ;
			@unlink($large_img_file);
			
			
			$large_img_thumb_file=$upload_dir.'thumbs/'.$large_img ;
			@unlink($large_img_thumb_file);
			
		}	

	}



	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-products.php">';

	echo '<input type="hidden" name="msg" id="msg" value="deleted">';

	echo '</form>';

	echo '<script type="text/javascript">document.frmSu.submit();</script>';

	echo '</body>';		

	exit;


}	

// multi Delete end

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
		if(confirm("Are you sure you want to delete this product?"))
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
	
	
	function multiDelete()
	{
		//alert("called");

		var frm =document.prodForm;
		var n =frm.elements.length;
		var checkOne = false;
		for (i=0; i<n; i++)
		{
			if(frm.elements[i].checked ==true)
			{
				checkOne=true
			}
		}
		if(checkOne)
		{
			if(confirm("Are you sure you want to delete the selected product(s)?"))
			{
				frm.action='?task=deleteAll';
				frm.submit();
			}
		}
		else
		{
			alert("Please make a selection from the list.");
			return false;
		}
	}

</script>

</head>

<body>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-products.php">Manage Products</a></div></td></tr>

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

                <td><h1>List Products</h1></td>

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
		
		$cond="where prod_franchise='".$franchiseID."'";

		$orderby="order by prod_name asc";

		$product_arr = $sql->SqlRecords("esthp_tblProducts",$cond,$orderby,$offset,$records_per_page);

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

                   <td width="125" align="center" valign="top"><a href="javascript:void(0)" class="add_del" onClick="multiDelete()">Delete Selected</a></td>

                   <td width="2" align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>

                   <td width="125" align="center" valign="top"><a href="add-product.php" class="add_del">Add Product</a></td>

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

                        <td width="8%" align="center"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td>
						
						<td width="10%" align="left" class="white_text">S. No.</td>

                        <td width="30%" class="white_text">Product</td>

                        <td width="10%" align="left" class="white_text">Status</td>

                        <td width="22%" align="center" class="white_text">Last Modified</td>

                        <td width="10%" align="center" class="white_text">Edit</td>

                        <td width="10%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{	
						?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							<td  height="30" align="center" ><input type="checkbox" name="chk[]" value="<?=$Data[$i]['prod_id']?>"></td>
							
							<td align="left" class="black_text"><?=$offset+1+$i?>.</td>

							<td align="left" class="black_text"><?=$Data[$i]['prod_name']; ?></td>

							<td  align="left" class="black_text"><?=$Data[$i]['prod_status']?></td>

							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['prod_modified_date']))?></td>


							<td align="center" class="white_text"><a href="add-product.php?prodID=<?=$Data[$i]['prod_id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-products.php?delid=<?=$Data[$i]['prod_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='white_text'>No products have been added yet.</span>";
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
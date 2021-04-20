<?php include_once("../includes/global.inc.php");

require_once(_PATH."modules/mod_admin_login.php");

include_once(_CLASS_PATH."pager.cls.php");

$AuthAdmin->ChkLogin();


if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
} 

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

// single Delete start
if($_REQUEST['delid']!="")
{
	 $cat_id=$_REQUEST['delid'];
	// check the existance of record
	$delete_rec_cond="where vid_category= '".$cat_id."'"; 						
	$del_rec_arr= $sql->SqlSingleRecord('esthp_tblVideos',$delete_rec_cond);
	$found_records=$del_rec_arr['count'];
	$found_records_data= $del_rec_arr['Data'];

	if($found_records>0) // if record found, dont delete category
	{
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-categories.php">';
		echo '<input type="hidden" name="msg" id="msg" value="vid_exists">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;	
	}
	else
	{	
		$cat_rec_cond="where cat_id= '".$cat_id."'"; 						
		$cat_rec_arr= $sql->SqlSingleRecord('esthp_tblProdCat',$cat_rec_cond);
		$cat_count=$cat_rec_arr['count'];
		$cat_data= $cat_rec_arr['Data'];	
		
		if($cat_count>0)
		{
			$upload_dir= _UPLOAD_FILE_PATH."categories/";
			
			$cat_image =$cat_data['cat_image'];
			$cat_image_file=$upload_dir.$cat_image ;
			@unlink($cat_image_file);		
			
			$cat_image_thumb_file=$upload_dir.'thumbs/'.$cat_image ;
			@unlink($cat_image_thumb_file);
			
			$delete_cond="cat_id='".$cat_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblProdCat',$delete_cond);		
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-categories.php">';
			echo '<input type="hidden" name="msg" id="msg" value="deleted">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';		
			exit;		
		}		
	}
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
else if($msg=='vid_exists')
	$message="<span class=\"loginErrBox\"><span class='alert_icon'></span>".'You can not delete this category because video posts have been added under it.'."</sapn>";
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
		if(confirm("Are you sure you want to delete this category?"))
		{
			window.location.href=url;
		}
	}
</script>
</head>
<body>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-categories.php">Manage Categories</a></div></td></tr>
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
                <td><h1>List Categories</h1></td>
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
 
  		$records_per_page=10;				

		$offset = ($page-1) * $records_per_page;
		
		$cond="where 1=1";

		$orderby="order by cat_name asc";

		$cat_arr = $sql->SqlRecords("esthp_tblProdCat",$cond,$orderby,$offset,$records_per_page);

		$count_total=$cat_arr['TotalCount'];

		$count = $cat_arr['count'];

		$Data = $cat_arr['Data'];

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

             
                   <td width="125" align="center" valign="top"><a href="add-category.php" class="add_del">Add Category</a></td>

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

                    <td valign="middle" >
					
					
					
					<?php
					
					
					if($count_total>0)
					{
					?>
					
					
					<table width="100%" border="0" cellspacing="0" cellpadding="5">
                      <tr class="left_headbg">
						<td width="10%" align="left" class="white_text">S. No.</td>
                        <td width="30%" class="white_text">Category</td>
                       <!-- <td width="10%" align="left" class="white_text">Status</td> -->
                        <td width="30%" align="center" class="white_text">Last Modified</td>
                        <td width="15%" align="center" class="white_text">Edit</td>
                        <td width="15%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{	
						?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							<td height="30"  align="left" class="black_text"><?=$offset+1+$i?>.</td>
							<td align="left" class="black_text"><?=$Data[$i]['cat_name']; ?></td>
							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['cat_modified_date']))?></td>


							<td align="center" class="white_text"><a href="add-category.php?cat_id=<?=$Data[$i]['cat_id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-categories.php?delid=<?=$Data[$i]['cat_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='black_text'>No categories have been added yet.</span>";
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
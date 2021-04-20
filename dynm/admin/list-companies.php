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



if(!empty($_REQUEST['sort_feild']))
{
	$sort_feild=$_REQUEST['sort_feild'];
}
else
{
	$sort_feild='comp_date_add';
}

if(!empty($_REQUEST['sort_order']))
{
	$sort_order=$_REQUEST['sort_order'];
}
else
{
	$sort_order='desc';
}


// single Delete start

if($_REQUEST['delid']!="")
{


	 $comp_id=$_REQUEST['delid'];

	// check the existance of record

	$delete_rec_cond="where vid_company= '".$comp_id."'"; 						
	$del_rec_arr= $sql->SqlSingleRecord('esthp_tblVideos',$delete_rec_cond);
	$found_records=$del_rec_arr['count'];
	$found_records_data= $del_rec_arr['Data'];
	
	

	if($found_records>0) // if record found, dont delete category
	{
	
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-companies.php">';
			echo '<input type="hidden" name="msg" id="msg" value="vid_exists">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';		
			exit;
		
		
	}
	else
	{
	
		$comp_rec_cond="where comp_id= '".$comp_id."'"; 						
		$comp_rec_arr= $sql->SqlSingleRecord('esthp_tblCompanies',$comp_rec_cond);
		$comp_count=$comp_rec_arr['count'];
		$comp_data= $comp_rec_arr['Data'];
	
		
		if($comp_count>0)
		{
			$upload_dir= _UPLOAD_FILE_PATH."company_logos/";
			
			$comp_logo =$comp_data['comp_logo'];
			$comp_logo_file=$upload_dir.$comp_logo ;
			@unlink($comp_logo_file);
			
			
			$comp_logo_thumb_file=$upload_dir.'thumbs/'.$comp_logo ;
			@unlink($comp_logo_thumb_file);
			
			$delete_cond="comp_id='".$comp_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblCompanies',$delete_cond);
			
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-companies.php">';
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

	$message="<span class=\"loginErrBox\"><span class='alert_icon'></span>".'You can not delete this company because video posts have been added under it.'."</sapn>";

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
		if(confirm("Are you sure you want to delete this company?"))
		{
			window.location.href=url;
		}
	}

</script>

</head>

<body>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-companies.php">Manage Companies</a></div></td></tr>

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

                <td><h1>List Companies</h1></td>

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
  
   $search_text=trim($_REQUEST['search_text']);
 
  		$records_per_page=10;				

		$offset = ($page-1) * $records_per_page;
		
		$cond="where 1=1";
		
		
		if(!empty($search_text))
		{

			$cond.=" and comp_name like '%".$search_text."%'";

		}
		

		//$orderby="order by comp_name asc";
		
		$orderby=" order by ".$sort_feild." ".$sort_order;

		$cat_arr = $sql->SqlRecords("esthp_tblCompanies",$cond,$orderby,$offset,$records_per_page);

		$count_total=$cat_arr['TotalCount'];

		$count = $cat_arr['count'];

		$Data = $cat_arr['Data'];

		//echo $count;

	  ?>

         <tr>

          <td valign="top" align="center">
		  
		  
		  
		  
		  
		<form method="get" action="" name="compSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">

               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Company</td>


		</tr>
		
		
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Company Name :</td>
                <td width='10' align="left" valign="middle">&nbsp;</td>
                <td width="334" align="left" valign="middle" class="normal_text_blue">	<input name="search_text" id="search_text"  type="text" class="input_white" size="48" value="<?=$search_text?>" ></td>
              </tr>
			  

			  
              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Search">
				
				
				</td>
              </tr>
			  
		</table>
		</form>
		
		<div style="height:15px;"></div>
		
		</td>
		</tr>
		
		
		<tr>
		<td>

		   <form method="post" action="" name="prodForm" style="margin:0px;">

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		   
		   				<?php
		if(!empty($search_text))
		{

			?>
			   <tr>

                    <td valign="middle" align="left"  class="black_text" height='35'>Showing results for: <?=$search_text?></td></tr>
			<?php

		}
		?>

             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

             
                   <td width="125" align="center" valign="top"><a href="add-company.php" class="add_del">Add Company</a></td>

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
						<td width="7%" align="left" class="white_text">S. No.</td>
                        <td width="20%" align="left" class="white_text"><?php				 
						 if($sort_feild=='comp_name')
						 {
						 	if($sort_order=='asc')
								$reverse_cname='desc';
							else if($sort_order=='desc')
								$reverse_cname='asc';
						 ?>
						<a href='list-companies.php?sort_feild=comp_name&sort_order=<?=$reverse_cname?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Company</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-companies.php?sort_feild=comp_name&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Company</a> 
						 <?php
						 }
						?></td>
						<td width="10%" align="center" class="white_text">Videos</td>
						<td width="20%" align="center" class="white_text"><?php				 
						 if($sort_feild=='comp_date_add')
						 {
						 	if($sort_order=='asc')
								$reverse_cadddate='desc';
							else if($sort_order=='desc')
								$reverse_cadddate='asc';
						 ?>
						<a href='list-companies.php?sort_feild=comp_date_add&sort_order=<?=$reverse_cadddate?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-companies.php?sort_feild=comp_date_add&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						?></td>
                        <td width="20%" align="center" class="white_text"><?php				 
						 if($sort_feild=='comp_date_mod')
						 {
						 	if($sort_order=='asc')
								$reverse_cmoddate='desc';
							else if($sort_order=='desc')
								$reverse_cmoddate='asc';
						 ?>
						<a href='list-companies.php?sort_feild=comp_date_mod&sort_order=<?=$reverse_cmoddate?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Modified</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-companies.php?sort_feild=comp_date_mod&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Modified</a> 
						 <?php
						 }
						?></td>
						<td width="9%" align="center" class="white_text"><?php				 
						 if($sort_feild=='comp_status')
						 {
						 	if($sort_order=='asc')
								$reverse_cstatus='desc';
							else if($sort_order=='desc')
								$reverse_cstatus='asc';
						 ?>
						<a href='list-companies.php?sort_feild=comp_status&sort_order=<?=$reverse_cstatus?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-companies.php?sort_feild=comp_status&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						?></td>
                        <td width="7%" align="center" class="white_text">Edit</td>
                        <td width="7%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{	
						
						
							$cond = " WHERE vid_company= '".$Data[$i]['comp_id']."' "; 						
							$vid_arr = $sql->SqlRecordMisc('esthp_tblVideos',$cond);
							$video_count = $vid_arr['count'];
							$video_data = $vid_arr['Data'];			
							

						?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							<td height="30"  align="left" class="black_text"><?=$offset+1+$i?>.</td>
							
							<td align="left" class="black_text"><?=$Data[$i]['comp_name']; ?></td>
							
							<td align="center" class="black_text"><?php
							if($video_count>0)
							{
							?>
							<a href="list-videos.php?comp_id=<?=$Data[$i]['comp_id']?>" title="View Video Listing"><?=$video_count?></a>
							<?
							}
							else
							{
								echo $video_count;
							}
							?></td>
							
							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['comp_date_add']))?></td>
							
							
							<td align="center" class="black_text"><?=$Data[$i]['comp_date_mod']!='0000-00-00 00:00:00'  ? date("jS M Y H:i:s",strtotime($Data[$i]['comp_date_mod'])):' ' ?></td>
							
							<td align="center" class="black_text"><?=$Data[$i]['comp_status']; ?></td>


							<td align="center" class="white_text"><a href="add-company.php?comp_id=<?=$Data[$i]['comp_id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-companies.php?delid=<?=$Data[$i]['comp_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='black_text'>No companies have been added yet.</span>";
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
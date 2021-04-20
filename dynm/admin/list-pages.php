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
	$sort_feild='date_added';
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
	 	$page_id=$_REQUEST['delid'];


		$page_rec_cond="where id= '".$page_id."'"; 						
		$page_rec_arr= $sql->SqlSingleRecord('esthp_tblWebpage',$page_rec_cond);
		$page_count=$page_rec_arr['count'];
		$page_data= $page_rec_arr['Data'];
	
		
		if($page_count>0)
		{
			$upload_dir= _UPLOAD_FILE_PATH."webpage_images/";
			
			$page_image =$page_data['page_image'];
			$page_image_file=$upload_dir.$page_image ;
			@unlink($page_image_file);
			
			
			
			$delete_cond="id='".$page_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblWebpage',$delete_cond);
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-pages.php">';
			echo '<input type="hidden" name="msg" id="msg" value="deleted">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';		
			exit;
			
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
		if(confirm("Are you sure you want to delete this page?"))
		{
			window.location.href=url;
		}
	}

</script>

</head>

<body>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-pages.php">List Pages</a></div></td></tr>

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

                <td><h1>List Pages</h1></td>

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
		
		$cond="where 1=1 ";
		
		 if(!empty($search_text))
		{

			$cond.="and ( page_name like '%".$search_text."%' or page_url like '%".$search_text."%' ) ";

		}

		$orderby=" order by ".$sort_feild." ".$sort_order;
		
		//echo $cond.' '.$orderby;

		$cat_arr = $sql->SqlRecords("esthp_tblWebpage",$cond,$orderby,$offset,$records_per_page);

		$count_total=$cat_arr['TotalCount'];

		$count = $cat_arr['count'];

		$Data = $cat_arr['Data'];

		//echo $count;

	  ?>
	  
	  
	           <tr>

          <td valign="top" align="center">
		  
		  
		  

		<form method="get" action="" name="pageSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">

               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Page</td>


		</tr>
		
		
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Page Name/URL :</td>
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
		
		



		   <form method="post" action="" name="pageForm" style="margin:0px;">

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">

             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

             
                   <td width="125" align="center" valign="top"><a href="add-page.php" class="add_del">Add Static Page</a></td>

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
						 if($sort_feild=='page_name')
						 {
						 	if($sort_order=='asc')
								$reverse_pname='desc';
							else if($sort_order=='desc')
								$reverse_pname='asc';
						 ?>
						<a href='list-pages.php?sort_feild=page_name&sort_order=<?=$reverse_pname?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Page Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-pages.php?sort_feild=page_name&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Page Name</a> 
						 <?php
						 }
						?></td>
						<td width="10%" align="left" class="white_text"><?php				 
						 if($sort_feild=='page_url')
						 {
						 	if($sort_order=='asc')
								$reverse_purl='desc';
							else if($sort_order=='desc')
								$reverse_purl='asc';
						 ?>
						<a href='list-pages.php?sort_feild=page_url&sort_order=<?=$reverse_purl?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Page URL</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-pages.php?sort_feild=page_url&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Page URL</a> 
						 <?php
						 }
						?></td>
						<td width="20%" align="center" class="white_text"><?php				 
						 if($sort_feild=='date_added')
						 {
						 	if($sort_order=='asc')
								$reverse_adddate='desc';
							else if($sort_order=='desc')
								$reverse_adddate='asc';
						 ?>
						<a href='list-pages.php?sort_feild=date_added&sort_order=<?=$reverse_adddate?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-pages.php?sort_feild=date_added&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						?></td>
                        <td width="20%" align="center" class="white_text"><?php				 
						 if($sort_feild=='date_modified')
						 {
						 	if($sort_order=='asc')
								$reverse_moddate='desc';
							else if($sort_order=='desc')
								$reverse_moddate='asc';
						 ?>
						<a href='list-pages.php?sort_feild=date_modified&sort_order=<?=$reverse_moddate?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Modified</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-pages.php?sort_feild=date_modified&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Modified</a> 
						 <?php
						 }
						?></td>
						<td width="9%" align="center" class="white_text"><?php				 
						 if($sort_feild=='page_status')
						 {
						 	if($sort_order=='asc')
								$reverse_pstatus='desc';
							else if($sort_order=='desc')
								$reverse_pstatus='asc';
						 ?>
						<a href='list-pages.php?sort_feild=page_status&sort_order=<?=$reverse_pstatus?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-pages.php?sort_feild=page_status&sort_order=asc&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						?></td>
                        <td width="7%" align="center" class="white_text">Edit</td>
                        <td width="7%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{
						?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							<td height="30"  align="left" class="black_text"><?=$offset+1+$i?>.</td>
							
							<td align="left" class="black_text"><?=$Data[$i]['page_name']; ?></td>
							
							<td align="left" class="black_text"><?=$Data[$i]['page_url']; ?></td>
							
							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['date_added']))?></td>
							
							
							<td align="center" class="black_text"><?=$Data[$i]['date_modified']!='0000-00-00 00:00:00'  ? date("jS M Y H:i:s",strtotime($Data[$i]['date_modified'])):' ' ?></td>
							
							<td align="center" class="black_text"><?=$Data[$i]['page_status']; ?></td>


							<td align="center" class="white_text"><a href="add-page.php?page_id=<?=$Data[$i]['id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-pages.php?delid=<?=$Data[$i]['id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='black_text'>No pages have been added yet.</span>";
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
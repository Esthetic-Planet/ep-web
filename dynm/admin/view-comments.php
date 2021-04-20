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
	$sort_feild='cmt_date_add';
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


	 $cmt_id=$_REQUEST['delid'];


		$cmt_rec_cond="where cmt_id= '".$cmt_id."'"; 						
		$cmt_rec_arr= $sql->SqlSingleRecord('esthp_tblComments',$cmt_rec_cond);
		$cmt_count=$cmt_rec_arr['count'];
		$cmt_data= $cmt_rec_arr['Data'];
	
		
		if($cmt_count>0)
		{
		
		
			
			/////////////////delete comment row
			
			$delete_cond="cmt_id='".$cmt_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblComments',$delete_cond);
			
		
			
			
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'view-comments.php">';
			echo '<input type="hidden" name="vid_id" id="vid_id" value="'.$_GET['vid_id'].'">';
			echo '<input type="hidden" name="page" id="page" value="'.$_GET['page'].'">';
			echo '<input type="hidden" name="cmt_status" id="cmt_status" value="'.$_GET['cmt_status'].'">';
			echo '<input type="hidden" name="cmt_is_read" id="cmt_is_read" value="'.$_GET['cmt_is_read'].'">';
			echo '<input type="hidden" name="msg" id="msg" value="deleted">';
			echo '</form>';
			echo '<script type="text/javascript">document.frmSu.submit();</script>';
			echo '</body>';		
			exit;
		
		}





}





// single Delete end



if(!empty($_REQUEST['act']) && $_REQUEST['act']=='status')
{
	
	$content_arr = array();	
	$content_arr['cmt_status'] = $_REQUEST['value'] ;
	$content_arr['cmt_is_read'] = 1 ;
	$condition = " where cmt_id ='".$_REQUEST['cmt_id']."'";
	$sql->SqlUpdate('esthp_tblComments',$content_arr,$condition);
	header("location:view-comments.php?cmt_id=".$_REQUEST['cmt_id']."&vid_id=".$_REQUEST['vid_id']);
}


$message="";

$msg=isset($_REQUEST['msg'])? $_REQUEST['msg'] : '';

if($msg=='added')

	$message = "<span class=\"logoutMsgBox\">Record Added Successfully.</span>";

else if($msg=='updated')

	$message = "<span class=\"logoutMsgBox\">Record(s) Updated Successfully.</span>";

else if($msg=='deleted')

	$message = "<span class=\"logoutMsgBox\">Record(s) Deleted Successfully.</span>";
	
/* else if($msg=='vid_exists')

	$message="<span class=\"loginErrBox\"><span class='alert_icon'></span>".'You can not delete this video because comments have been added under it.'."</sapn>";
	*/

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
		if(confirm("Are you sure you want to delete this comment?"))
		{
			window.location.href=url;
		}
	}

</script>

</head>

<body>

<script src="../wz_tooltip/wz_tooltip.js" type="text/javascript"></script>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="view-comments.php">View Comments</a></div></td></tr>

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="232" valign="top" class="border_left" id="adminLeftBar"><?php include_once('include/admin_left.php');?></td>

        <td width="14" valign="top">&nbsp;</td>

        <td valign="top">
		
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>View Comments</h1></td>

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
  
  
 		 $vid_id=$_REQUEST['vid_id']; // if user comes from video listing page
		 
		 $search_text=trim($_REQUEST['search_text']);
		 

		 $cmt_status=$_REQUEST['cmt_status'];
		 
		
 
  		$records_per_page=75;				

		$offset = ($page-1) * $records_per_page;
		
		$cond="where 1=1";
		
		if(!empty($vid_id))
		{
			$cond.=" and cmt_vid='".$vid_id."'";

		}
		
		
		if(!empty($cmt_status))
		{
			$cond.=" and cmt_status='".$cmt_status."'";

		}
		
		if(isset($_REQUEST['cmt_is_read']) && $_REQUEST['cmt_is_read']!='')
		{
			$cmt_is_read=$_REQUEST['cmt_is_read'];
			
			$cond.=" and cmt_is_read='".$cmt_is_read."'";

		}
		
		if(!empty($search_text))
		{

			$cond.=" and (cmt_text like '%".$search_text."%' or cmt_name like '%".$search_text."%' or cmt_email like '%".$search_text."%')";

		}
		
		
		$orderby=" order by ".$sort_feild." ".$sort_order;

		$cmt_arr = $sql->SqlRecords("esthp_tblComments",$cond,$orderby,$offset,$records_per_page);

		$count_total=$cmt_arr['TotalCount'];

		$count = $cmt_arr['count'];

		$Data = $cmt_arr['Data'];

		//echo $count;

	  ?>

         <tr>

          <td valign="top" align="center">
		  
		  
		  

		<form method="get" action="" name="prodSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">

               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Comments</td>


		</tr>
		
		
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Search Text :</td>
                <td width='10' align="left" valign="middle">&nbsp;</td>
                <td width="334" align="left" valign="middle" class="normal_text_blue">	<input name="search_text" id="search_text"  type="text" class="input_white" size="48" value="<?=$search_text?>" ><input name="vid_id" id="vid_id"  type="hidden" value="<?=$vid_id?>" ><div style="height:15px;padding-top:8px;"> searches through comment, user name and email</b></td>
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
		<br/>
		&nbsp;
		</td>
		</tr>
		
		<tr>
		<td>
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				 <form method="get" action="" name="prodForm" style="margin:0px;">
				

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		   
		   <?php
		   if(!empty($vid_id))
		   {
		   
				
							$vid_arr = $sql->SqlSingleRecord('esthp_tblVideos'," where vid_id= '".$vid_id."' ");
							
							$vid_name = $vid_arr['Data']['vid_title'];	
							
		   ?>
		     <tr>

              <td height="25"  align="left" valign="middle" class="black_text">Displaying comments for video : <?=$vid_name?>
			  </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  
			  	 <?php
		   if(!empty($cmt_status))
		   {
	
							
		   ?>
		     <tr>

              <td height="25"  align="left" valign="middle" class="black_text">Displaying <b><?=$cmt_status?></b> comments
			  </td>
			  </tr>
			  <?php
			  }
			  ?>
			  
			  
			  			  
			  	 <?php
		   if(isset($_REQUEST['cmt_is_read']) && $_REQUEST['cmt_is_read']!='')
		   {
	
							
		   ?>
		     <tr>

              <td height="25"  align="left" valign="middle" class="black_text">Displaying <b>Unread</b> comments
			  </td>
			  </tr>
			  <?php
			  }
			  ?>



             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <!--<td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

             
                   <td width="125" align="center" valign="top"><a href="add-video.php" class="add_del">Add Video</a></td>

					<td width="118" >	</td>

                      </tr>

                    </table></td> -->

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
                        <td width="18%" align="left" class="white_text"><?php				 
						 if($sort_feild=='cmt_text')
						 {
						 	if($sort_order=='asc')
								$reverse_ctext='desc';
							else if($sort_order=='desc')
								$reverse_ctext='asc';
						 ?>
						<a href='view-comments.php?sort_feild=cmt_text&sort_order=<?=$reverse_ctext?>&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Comment</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='view-comments.php?sort_feild=cmt_text&sort_order=asc&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Comment</a> 
						 <?php
						 }
						?></td>
						 <td width="12%" align="left" class="white_text"><?php				 
						 if($sort_feild=='cmt_name')
						 {
						 	if($sort_order=='asc')
								$reverse_cname='desc';
							else if($sort_order=='desc')
								$reverse_cname='asc';
						 ?>
						<a href='view-comments.php?sort_feild=cmt_name&sort_order=<?=$reverse_cname?>&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>User Name</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='view-comments.php?sort_feild=cmt_name&sort_order=asc&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>User Name</a> 
						 <?php
						 }
						?></td>
						
						
						
						
						<td width="15%" align="left" class="white_text"><?php				 
						 if($sort_feild=='cmt_email')
						 {
						 	if($sort_order=='asc')
								$reverse_cemail='desc';
							else if($sort_order=='desc')
								$reverse_cemail='asc';
						 ?>
						 

						 
						<a href='view-comments.php?sort_feild=cmt_email&sort_order=<?=$reverse_cemail?>&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>User Email</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='view-comments.php?sort_feild=cmt_email&sort_order=asc&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>User Email</a> 
						 <?php
						 }
						?></td>
						
						
						<td width="12%" align="left" class="white_text">Video</td>
						
						
						<td width="21%" align="center" class="white_text"><?php				 
						 if($sort_feild=='cmt_date_add')
						 {
						 	if($sort_order=='asc')
								$reverse_cdate='desc';
							else if($sort_order=='desc')
								$reverse_cdate='asc';
						 ?>
						<a href='view-comments.php?sort_feild=cmt_date_add&sort_order=<?=$reverse_vdate?>&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='view-comments.php?sort_feild=cmt_date_add&sort_order=asc&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						?></td>
                        
						<td width="5%" align="center" class="white_text"><?php				 
						 if($sort_feild=='cmt_status')
						 {
						 	if($sort_order=='asc')
								$reverse_cstatus='desc';
							else if($sort_order=='desc')
								$reverse_cstatus='asc';
						 ?>
						<a href='view-comments.php?sort_feild=cmt_status&sort_order=<?=$reverse_cstatus?>&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='view-comments.php?sort_feild=cmt_status&sort_order=asc&vid_id=<?=$vid_id?>&search_text=<?=$search_text?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						?></td>
                        <td width="5%" align="center" class="white_text">Edit</td>
                        <td width="5%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{
							$vid_cond = " where vid_id= '".$Data[$i]['cmt_vid']."' "; 						
							$vid_arr = $sql->SqlSingleRecord('esthp_tblVideos',$vid_cond);
							$vid_count = $vid_arr['count'];
							$vid_data = $vid_arr['Data'];	
							
							
							
							$comp_cond = " where comp_id = '".$vid_data['vid_company']."' "; 						
							$comp_arr = $sql->SqlSingleRecord('esthp_tblCompanies',$cmt_cond);
							$comp_count = $comp_arr['count'];
							$comp_data = $comp_arr['Data'];		
									
						?>

							<tr <?=($i%2==0)? "class='grey_bg'":""?> 	<?php if($Data[$i]['cmt_is_read']==0) echo 'style="font-weight:bold;"';?> >

							<td height="30"  align="left" class="black_text" > <?=$offset+1+$i?> </td>
							
							<td align="left" class="black_text"><span id="tagid_<?=$i+1?>" ><?=$Data[$i]['cmt_text']?></span>
							
							
			<a href="update-comment.php?cmt_id=<?=$Data[$i]['cmt_id']?>&vid_id=<?=$vid_id?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page?>"  onmouseover="TagToTip('tagid_<?=$i+1?>')" onmouseout="UnTip()"><?php
			
			
							if(strlen($Data[$i]['cmt_text'])>15)
							{
								$cmt_text=substr($Data[$i]['cmt_text'],0,15)."...";
							}
							else
							{
								$cmt_text=$Data[$i]['cmt_text'];
							}
							
						
							
							echo $cmt_text;
							?></a></td>
							
													

							
							<td align="left" class="black_text"><?=$Data[$i]['cmt_name']?></td>
							
							<td align="left" class="black_text"><?=$Data[$i]['cmt_email']?></td>
							
							
						<td align="left" class="black_text"><span id="tag2id_<?=$i+1?>" ><?=$vid_data['vid_title']?></span>
						<a href="add-video.php?vid_id=<?=$vid_data['vid_id']?>"  onmouseover="TagToTip('tag2id_<?=$i+1?>')" onmouseout="UnTip()">				<?php
							if(strlen($vid_data['vid_title'])>18)
							{
								echo substr($vid_data['vid_title'],0,18)."...";
							}
							else
							{
								echo $vid_data['vid_title'];
							}
							?></a>
							
							</td>
							
							
							
							
	
							
							<td align="center" class="black_text"><?=date("jS M'y H:i:s",strtotime($Data[$i]['cmt_date_add']))?></td>
							
							
							
							
							<td align="center" class="black_text"><?php
							if($Data[$i]['cmt_status']=='approved')
							{
							?>
							<a href="view-comments.php?cmt_id=<?=$Data[$i]['cmt_id']?>&vid_id=<?=$vid_id?>&act=status&value=unapproved" title="Unapprove it"><img src='images/green_check_icon.gif' border="0"></a>
							<?php
							}
							else if($Data[$i]['cmt_status']=='unapproved')
							{
							?>
							<a href="view-comments.php?cmt_id=<?=$Data[$i]['cmt_id']?>&vid_id=<?=$vid_id?>&act=status&value=approved" title="Approve Now"><img src='images/b_drop.png' border="0"></a>
							<?php
							}
							?></td>


							<td align="center" class="black_text"><a href="update-comment.php?cmt_id=<?=$Data[$i]['cmt_id']?>&vid_id=<?=$vid_id?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page?>">Edit<!--<img src="images/edit_button.gif" alt="" width="59" height="19" border="0"> --></a></td>

							<td  align="center" class="black_text"><a href="javascript: void(0)" onclick="SingleDelete('view-comments.php?delid=<?=$Data[$i]['cmt_id']?>&vid_id=<?=$vid_id?>&cmt_status=<?=$cmt_status?>&cmt_is_read=<?=$cmt_is_read?>&page=<?=$page?>');">Delete<!--<img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"> --></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='white_text'>No comments have been added yet.</span>";
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
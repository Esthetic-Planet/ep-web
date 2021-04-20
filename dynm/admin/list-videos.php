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
	$sort_feild='vid_date_add';
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


	 $vid_id=$_REQUEST['delid'];


		$vid_rec_cond="where vid_id= '".$vid_id."'"; 						
		$vid_rec_arr= $sql->SqlSingleRecord('esthp_tblVideos',$vid_rec_cond);
		$vid_count=$vid_rec_arr['count'];
		$vid_data= $vid_rec_arr['Data'];
	
		
		if($vid_count>0)
		{
		
			
			///////////////delete video images (thumbnails)
			$upload_dir= _UPLOAD_FILE_PATH."video_images/thumbnails/";


			$vid_thumb_img =$vid_data['vid_thumb_img'];
			$vid_thumb_img_file=$upload_dir.$vid_thumb_img ;
			@unlink($vid_thumb_img_file);
			$vid_thumb_img_thumb_file=$upload_dir.'thumbs/'.$vid_thumb_img ;
			@unlink($vid_thumb_img_thumb_file);
			
			
			///////////////delete video images (still images)
			$upload_dir= _UPLOAD_FILE_PATH."video_images/still_images/";


			$vid_still_img =$vid_data['vid_still_img'];
			$vid_still_img_file=$upload_dir.$vid_still_img ;
			@unlink($vid_still_img_file);
			$vid_still_img_thumb_file=$upload_dir.'thumbs/'.$vid_still_img ;
			@unlink($vid_still_img_thumb_file);
			
			
			
			///////////////delete video images (home featured primary)
			$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_pri_images/";


			$vid_feat_home =$vid_data['vid_feat_home'];
			$vid_feat_home_file=$upload_dir.$vid_feat_home ;
			@unlink($vid_feat_home_file);
			$vid_feat_home_thumb_file=$upload_dir.'thumbs/'.$vid_feat_home ;
			@unlink($vid_feat_home_thumb_file);
			
			
			
			///////////////delete video images (home featured secondary)
			$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_sec_images/";


			$vid_feat_sec =$vid_data['vid_feat_sec'];
			$vid_feat_sec_file=$upload_dir.$vid_feat_sec ;
			@unlink($vid_feat_sec_file);
			$vid_feat_sec_thumb_file=$upload_dir.'thumbs/'.$vid_feat_sec ;
			@unlink($vid_feat_sec_thumb_file);
			
			
			///////////////delete videos (i phone)
			
			$upload_dir= _UPLOAD_FILE_PATH."videos/iphone/";

			$vid_iphone =$vid_data['vid_iphone'];
			$vid_iphone_file=$upload_dir.$vid_iphone ;
			@unlink($vid_iphone_file);
			
			
			///////////////delete videos (preview)
			
			$upload_dir= _UPLOAD_FILE_PATH."videos/preview/";

			$vid_preview =$vid_data['vid_preview'];
			$vid_preview_file=$upload_dir.$vid_preview ;
			@unlink($vid_preview_file);

			
			
			/////////////////delete video row
			
			$delete_cond="vid_id='".$vid_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblVideos',$delete_cond);
			
			
			/////////////////////////delete video comments on deleting videos
			
			
			
			$delete_cond="cmt_vid='".$vid_id."'";
			//echo "<br/>";
			$sql->SqlDelete('esthp_tblComments',$delete_cond);
			
			
			
			echo "<body>";
			echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-videos.php">';
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
		if(confirm("Are you sure you want to delete this video?"))
		{
			window.location.href=url;
		}
	}

</script>

</head>

<body>


<script src="../wz_tooltip/wz_tooltip.js" type="text/javascript"></script>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-videos.php">Manage Videos</a></div></td></tr>

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

                <td><h1>List Videos</h1></td>

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
  
  
 		 $comp_id=$_REQUEST['comp_id']; // if user comes from company listing page
		 
		 $search_text=trim($_REQUEST['search_text']);
 
  		$records_per_page=10;				

		$offset = ($page-1) * $records_per_page;
		
		$cond="where 1=1 ";
		
		if(!empty($comp_id))
		{
			$cond.=" and vid_company='".$comp_id."'";

		}
		
		if(!empty($search_text))
		{

			$cond.=" and vid_title like '%".$search_text."%'";

		}
		
		
		$orderby=" order by ".$sort_feild." ".$sort_order;

		$cat_arr = $sql->SqlRecords("esthp_tblVideos",$cond,$orderby,$offset,$records_per_page);

		$count_total=$cat_arr['TotalCount'];

		$count = $cat_arr['count'];

		$Data = $cat_arr['Data'];

		//echo $count;

	  ?>

         <tr>

          <td valign="top" align="center">
		  
		  
		  

		<form method="get" action="" name="prodSearch" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<tr class="left_headbg">

               <td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Video</td>


		</tr>
		
		
		              <tr>
                <td width="124" align="right" valign="middle" class="normal_text_blue">Video Title :</td>
                <td width='10' align="left" valign="middle">&nbsp;</td>
                <td width="334" align="left" valign="middle" class="normal_text_blue">	<input name="search_text" id="search_text"  type="text" class="input_white" size="48" value="<?=$search_text?>" ><input name="comp_id" id="comp_id"  type="hidden" value="<?=$comp_id?>" ></td>
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
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				 <form method="get" action="" name="prodForm" style="margin:0px;">
				

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">
		   
		   <?php
		   if(!empty($comp_id))
		   {
		   
				
							$comp_arr = $sql->SqlSingleRecord('esthp_tblCompanies'," where comp_id= '".$comp_id."' ");
							
							$comp_name = $comp_arr['Data']['comp_name'];	
							
		   ?>
		     <tr>

              <td height="25"  align="left" valign="middle" class="black_text">Displaying videos for : <?=$comp_name?>
			  </td>
			  </tr>
			  <?php
			  }
			  ?>

             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

             
                   <td width="125" align="center" valign="top"><a href="add-video.php" class="add_del">Add Video</a></td>

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
                      <tr  class="left_headbg">
						<td width="7%" align="left" class="white_text">S. No.</td>
                        <td width="15%" align="left" class="white_text"><?php				 
						 if($sort_feild=='vid_title')
						 {
						 	if($sort_order=='asc')
								$reverse_vtitle='desc';
							else if($sort_order=='desc')
								$reverse_vtitle='asc';
						 ?>
						<a href='list-videos.php?sort_feild=vid_title&sort_order=<?=$reverse_vtitle?>&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Video Title</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-videos.php?sort_feild=vid_title&sort_order=asc&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Video Title</a> 
						 <?php
						 }
						?></td>
						 <td width="12%" align="center" class="white_text">Comments</td>
						<td width="15%" align="left" class="white_text">Video Company</td>
						<td width="15%" align="center" class="white_text"><?php				 
						 if($sort_feild=='vid_date_add')
						 {
						 	if($sort_order=='asc')
								$reverse_vdate='desc';
							else if($sort_order=='desc')
								$reverse_vdate='asc';
						 ?>
						<a href='list-videos.php?sort_feild=vid_date_add&sort_order=<?=$reverse_vdate?>&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-videos.php?sort_feild=vid_date_add&sort_order=asc&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Date Added</a> 
						 <?php
						 }
						?></td>
                        <td width="15%" align="center" class="white_text">Date Modified</td>
						<td width="7%" align="center" class="white_text"><?php				 
						 if($sort_feild=='vid_status')
						 {
						 	if($sort_order=='asc')
								$reverse_vstatus='desc';
							else if($sort_order=='desc')
								$reverse_vstatus='asc';
						 ?>
						<a href='list-videos.php?sort_feild=vid_status&sort_order=<?=$reverse_vstatus?>&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						 else
						 {
						 ?>
						 <a href='list-videos.php?sort_feild=vid_status&sort_order=asc&comp_id=<?=$comp_id?>&search_text=<?=$search_text?>&page=<?=$page ?>'>Status</a> 
						 <?php
						 }
						?></td>
                        <td width="7%" align="center" class="white_text">Edit</td>
                        <td width="7%" align="center" class="white_text">Delete</td>

                      </tr>

						<?php
						for($i=0; $i<$count; $i++)
						{
							$comp_cond = " where comp_id= '".$Data[$i]['vid_company']."' "; 						
							$comp_arr = $sql->SqlSingleRecord('esthp_tblCompanies',$comp_cond);
							$comp_count = $comp_arr['count'];
							$comp_data = $comp_arr['Data'];	
							
							
							
							$cmt_cond = " where cmt_vid = '".$Data[$i]['vid_id']."' "; 						
							$cmt_arr = $sql->SqlSingleRecord('esthp_tblComments',$cmt_cond);
							$cmt_count = $cmt_arr['count'];
							$cmt_data = $cmt_arr['Data'];		
									
						?>

							<tr <?=($i%2==0)? "class='grey_bg'":""?> <?php if($Data[$i]['vid_is_main']==1) echo 'style="font-weight:bold;"';?>>

							<td height="30"  align="left" class="black_text" > <?=$offset+1+$i?> </td>
							
							<td align="left" class="black_text">
							
							
							
							<span id="tagid_<?=$i+1?>" ><?=$Data[$i]['vid_title']?></span>
							
							
					<a href="add-video.php?vid_id=<?=$Data[$i]['vid_id']?>&page=<?=$page?>" onmouseover="TagToTip('tagid_<?=$i+1?>')" onmouseout="UnTip()"><?php
							if(strlen($Data[$i]['vid_title'])>20)
							{
								echo substr($Data[$i]['vid_title'],0,20)."...";
							}
							else
							{
								echo $Data[$i]['vid_title'];
							}
							?></a></td>
							
							<td align="center" class="black_text"><?php
							if($cmt_count>0)
							{
							?>
							<a href="view-comments.php?vid_id=<?=$Data[$i]['vid_id']?>&page=<?=$page?>" title="View Comments"><?=$cmt_count?></a>
							<?php
							}
							else
							{
								echo $cmt_count;
								
							}?></td>
							
							<td align="left" class="black_text"><a href="add-company.php?comp_id=<?=$comp_data['comp_id']?>" alt="View Company Details"><?=$comp_data['comp_name']?></a></td>
							
							<td align="center" class="black_text"><?=date("jS M Y H:i:s",strtotime($Data[$i]['vid_date_add']))?></td>
							
							
							<td align="center" class="black_text"><?=$Data[$i]['vid_date_mod']!='0000-00-00 00:00:00'  ? date("jS M Y H:i:s",strtotime($Data[$i]['vid_date_mod'])):' ' ?></td>
							
							<td align="center" class="black_text"><?=$Data[$i]['vid_status']; ?></td>


							<td align="center" class="white_text"><a href="add-video.php?vid_id=<?=$Data[$i]['vid_id']?>&comp_id=<?=$comp_id?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-videos.php?delid=<?=$Data[$i]['vid_id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

					<?php
					} 
					
					?>
                    </table>
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='black_text'>No videos have been added yet.</span>";
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
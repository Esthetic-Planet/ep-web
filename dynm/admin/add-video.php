<?php include_once("../includes/global.inc.php");


require_once(_PATH."modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();

if($_SESSION['AdminInfo']['is_superadmin']!=1)
{
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'home.php">';
	echo '<input type="hidden" name="msg" id="msg" value="unauthorized">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';
	exit;
} 

include_once(_CLASS_PATH."thumbnail.php");
require_once(_PATH."includes/resize_image.php");


$vid_id=$_REQUEST['vid_id'];

if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	
	$content_arr = array();	
	$content_arr["vid_title"] = $_POST["vid_title"] ;
	$content_arr["vid_path"] = $_POST["vid_path"];
	//$content_arr["vid_desc"] = $_POST["vid_desc"];
	$content_arr["vid_tags"] = $_POST["vid_tags"];
	$content_arr["vid_description"] = $_POST["vid_description"];

	//$content_arr["vid_iphone"] = $_POST["vid_iphone"];
	//$content_arr["vid_preview"] = $_POST["vid_preview"];
	$content_arr["vid_category"] = $_POST["vid_category"];
	$content_arr["vid_company"] = $_POST["vid_company"];
	//$content_arr["vid_comments"] = ;
	//$content_arr["vid_rating"] = ;
	$content_arr["vid_duration"] = $_POST["vid_duration"];
	//$content_arr["vid_thumb_img"] = $_POST["vid_thumb_img"];
	//$content_arr["vid_still_img"] = $_POST["vid_still_img"];
	//$content_arr["vid_feat_home"] = $_POST["vid_feat_home"];
	//$content_arr["vid_feat_sec"] = $_POST["vid_feat_sec"];
	//$content_arr["vid_is_main"] = $_POST["vid_is_main"];
	
	
	
	$content_arr["vid_page_url"] =strtolower(str_replace(" ","_",$_POST["vid_page_url"] )).".html";
	$content_arr["vid_meta_title"] = $_POST["vid_meta_title"];
	$content_arr["vid_meta_key"] = $_POST["vid_meta_key"];
	$content_arr["vid_meta_des"] = $_POST["vid_meta_des"];
	$content_arr["vid_date_add"] = date("Y-m-d H:i:s",time());
	//$content_arr["vid_date_mod"] = ;


	$content_arr["vid_status"] = $_POST["vid_status"];


	$record_id = $sql->SqlInsert('esthp_tblVideos',$content_arr);
	
	//update_htaccess();
	
	if($record_id)
	{
	
		$main_video=$_REQUEST['main_video'];
		
		
		if($main_video==1 && !empty($_POST["vid_company"]))
		{
		
			$content_arr = array();	
			$content_arr['vid_is_main'] = 0 ;
			$condition = " where vid_company ='".$_POST["vid_company"]."'";
			$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			
			
			$content_arr = array();	
			$content_arr['vid_is_main'] = 1 ;
			$condition = " where vid_id ='".$record_id."'";
			$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
		}
	
	
	
		if($_FILES['vid_iphone']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."videos/iphone/";
				
				$file_name =$record_id.'_'.$_FILES['vid_iphone']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_iphone']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_iphone'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				
		}
		
		if($_FILES['vid_preview']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."videos/preview/";
				
				$file_name =$record_id.'_'.$_FILES['vid_preview']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_preview']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_preview'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				
		}
		
		
		if($_FILES['vid_thumb_img']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."video_images/thumbnails/";
				
				$file_name =$record_id.'_'.$_FILES['vid_thumb_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_thumb_img']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_thumb_img'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("102","56",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
		
		
		
		if($_FILES['vid_still_img']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."video_images/still_images/";
				
				$file_name =$record_id.'_'.$_FILES['vid_still_img']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_still_img']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_still_img'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
		
		
		
		if($_FILES['vid_feat_home']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_pri_images/";
				
				$file_name =$record_id.'_'.$_FILES['vid_feat_home']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_feat_home']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_feat_home'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("300","124",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
		
		
		
		
				
		if($_FILES['vid_feat_sec']['name']!="")
		{
				$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_sec_images/";
				
				$file_name =$record_id.'_'.$_FILES['vid_feat_sec']['name'];
				
				$upload_file=$upload_dir.$file_name ;
				
				if(move_uploaded_file($_FILES['vid_feat_sec']['tmp_name'], $upload_file))
				{
					$content_arr = array();	
					
					$content_arr['vid_feat_sec'] = $file_name ;
					
					$condition = " where vid_id ='".$record_id."'";
					
					$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
					
				}	
				$dimensions=imageresize("300","124",$upload_file); // determine proportion size for creating thumb
				@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
		}
		
		
		
			  
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-videos.php">';
		echo '<input type="hidden" name="msg" id="msg" value="added">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';
	}
	else
	{
	 	$sqlError=mysql_error();
	}
}

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['vid_id']))
{	
	$content_arr = array();	
	$content_arr["vid_title"] = $_POST["vid_title"] ;
	$content_arr["vid_path"] = $_POST["vid_path"];
	//$content_arr["vid_desc"] = $_POST["vid_desc"];
	$content_arr["vid_tags"] = $_POST["vid_tags"];
	$content_arr["vid_description"] = $_POST["vid_description"];
	//$content_arr["vid_iphone"] = $_POST["vid_iphone"];
	//$content_arr["vid_preview"] = $_POST["vid_preview"];
	$content_arr["vid_category"] = $_POST["vid_category"];
	$content_arr["vid_company"] = $_POST["vid_company"];
	//$content_arr["vid_comments"] = ;
	//$content_arr["vid_rating"] = ;
	$content_arr["vid_duration"] = $_POST["vid_duration"];
	//$content_arr["vid_thumb_img"] = $_POST["vid_thumb_img"];
	//$content_arr["vid_still_img"] = $_POST["vid_still_img"];
	//$content_arr["vid_feat_home"] = $_POST["vid_feat_home"];
	//$content_arr["vid_feat_sec"] = $_POST["vid_feat_sec"];
	//$content_arr["vid_is_main"] = $_POST["vid_is_main"];
	$content_arr["vid_page_url"] =strtolower(str_replace(" ","_",$_POST["vid_page_url"] )).".html";
	$content_arr["vid_meta_title"] = $_POST["vid_meta_title"];
	$content_arr["vid_meta_key"] = $_POST["vid_meta_key"];
	$content_arr["vid_meta_des"] = $_POST["vid_meta_des"];
	//$content_arr["vid_date_add"] = date("Y-m-d H:i:s",time());
	$content_arr["vid_date_mod"] = date("Y-m-d H:i:s",time());
	

	$content_arr["vid_status"] = $_POST["vid_status"];

    $condition = " where vid_id='".$vid_id."'";
	$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);		
	
	//update_htaccess();
	
	
	///////////update rating video
	
	$content_arr = array();	
	$content_arr['cat_id'] =  $_POST["vid_category"] ;
	$condition = " where vid_id ='".$vid_id."'";
	$sql->SqlUpdate('esthp_tblRating',$content_arr,$condition);
	
	
	
	/////////////////////////////////////
	
	
	
	$main_video=$_REQUEST['main_video'];
		
		
	if($main_video==1 && !empty($_POST["vid_company"]))
	{
	
		$content_arr = array();	
		$content_arr['vid_is_main'] = 0 ;
		$condition = " where vid_company ='".$_POST["vid_company"]."'";
		$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
		
		
		$content_arr = array();	
		$content_arr['vid_is_main'] = 1 ;
		$condition = " where vid_id ='".$vid_id."'";
		$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
	}
	
	
	
	if($_FILES['vid_iphone']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."videos/iphone/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_iphone']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_iphone']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_iphone']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_iphone'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
	}
	
	
	
	if($_FILES['vid_preview']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."videos/preview/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_preview']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_preview']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_preview']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_preview'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
	}
	
	
	
	
	
	 if($_FILES['vid_thumb_img']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."video_images/thumbnails/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_thumb_img']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_vid_thumb_img']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_thumb_img']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_thumb_img']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_thumb_img'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
			$dimensions=imageresize("102","56",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	
	
	
	if($_FILES['vid_still_img']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."video_images/still_images/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_still_img']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_vid_still_img']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_still_img']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_still_img']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_still_img'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
			$dimensions=imageresize("640","360",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	
	
	
	if($_FILES['vid_feat_home']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_pri_images/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_feat_home']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_vid_feat_home']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_feat_home']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_feat_home']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_feat_home'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
			$dimensions=imageresize("300","124",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	
	
	
	if($_FILES['vid_feat_sec']['name']!="")
	{
			
			$upload_dir= _UPLOAD_FILE_PATH."video_images/feat_sec_images/";
			
			@unlink($upload_dir.$_REQUEST['old_vid_feat_sec']);
			@unlink($upload_dir.'thumbs/'.$_REQUEST['old_vid_feat_sec']);
			
			$file_name =$vid_id.'_'.$_FILES['vid_feat_sec']['name'];
			$upload_file=$upload_dir.$file_name ;
			if(move_uploaded_file($_FILES['vid_feat_sec']['tmp_name'], $upload_file))
			{
				$content_arr = array();	
				$content_arr['vid_feat_sec'] = $file_name ;
				$condition = " where vid_id ='".$vid_id."'";
				$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
			}
			$dimensions=imageresize("300","124",$upload_file); // determine proportion size for creating thumb
			@$thumb->createThumbs($upload_dir ,$upload_dir.'thumbs/',$dimensions[0], $dimensions[1], $file_name);
	}
	
	
	
	
	
	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'list-videos.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '<input type="hidden" name="comp_id" id="comp_id" value="'.$_GET['comp_id'].'">';
	echo '<input type="hidden" name="page" id="page" value="'.$_GET['page'].'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['vid_id']))
{
	$cond = " WHERE vid_id= '$vid_id' "; 						
	$vid_arr = $sql->SqlSingleRecord('esthp_tblVideos',$cond);
	$count = $vid_arr['count'];
	$Data = $vid_arr['Data'];			
}



if(isset($_REQUEST['act']) && $_REQUEST['act']=='delimg')
{
	$type=$_REQUEST['type'];
	
	
	if($type=='vid_thumb_img')
	{
		$dir='thumbnails';
	}
	else if($type=='vid_still_img')
	{
		$dir='still_images';
	}
	else if($type=='vid_feat_home')
	{
		$dir='feat_pri_images';
	}
	else if($type=='vid_feat_sec')
	{
		$dir='feat_sec_images';
	}
	
	$content_arr=array();
	$content_arr[$type] = '' ;
	$condition = " where vid_id ='".$vid_id."'";
	$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."video_images/".$dir."/";
	
	@unlink($upload_dir.$Data[$type]);
	@unlink($upload_dir.'thumbs/'.$Data[$type]);
	
	header("location:add-video.php?vid_id=".$vid_id);
}




if(isset($_REQUEST['act']) && $_REQUEST['act']=='delvideo')
{
	$type=$_REQUEST['type'];
	
	
	if($type=='vid_iphone')
	{
		$dir='iphone';
	}
	else if($type=='vid_preview')
	{
		$dir='preview';
	}

	
	$content_arr=array();
	$content_arr[$type] = '' ;
	$condition = " where vid_id ='".$vid_id."'";
	$sql->SqlUpdate('esthp_tblVideos',$content_arr,$condition);
	
	$upload_dir= _UPLOAD_FILE_PATH."videos/".$dir."/";
	
	@unlink($upload_dir.$Data[$type]);
	
	header("location:add-video.php?vid_id=".$vid_id);
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


<script src="facefiles/jquery-1.2.2.pack.js" type="text/javascript"></script>
<link href="facefiles/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="facefiles/facebox.js" type="text/javascript"></script>
<script type="text/javascript">

    jQuery(document).ready(function($) {

      $('a[rel*=facebox]').facebox() 

    })	
</script>


<script language="javascript">
	
 
	function delete_videoImage(img_type)
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-video.php?act=delimg&type="+img_type+"&vid_id=<?=$vid_id?>"; 
		}
	}
	
	

	
	
	 
	function delete_video(vid_type)
	{
		if(confirm("Are you sure to delete video?" ))
		{
			window.location.href="add-video.php?act=delvideo&type="+vid_type+"&vid_id=<?=$vid_id?>"; 
		}
	}
	
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-videos.php">Manage Videos</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="add-video" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Video </h1></td>
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
			
			<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">


              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Video Title :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="vid_title" id="chk_vid_title" title="Please enter video title." type="text" class="input_white" size="48" value="<?=$Data['vid_title']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Video URL/Path :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="vid_path" id="chk_vid_path" title="Please enter video path." type="text" class="input_white" size="48" value="<?=$Data['vid_path']?>" ></td>
              </tr>
			  
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Video Tags: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="vid_tags" class="input_white" rows="4" cols="45"><?=$Data['vid_tags']?></textarea></td>
              </tr>
			  
			  
			  
			  
			                <tr>
                <td align="right" valign="top" class="normal_text_blue">Video Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="center" valign="top">
				<?php	
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				$sBasePath = _HTML_EDITOR_PATH."/";
				
				
				$oFCKeditor1 = new FCKeditor('vid_description') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	=$Data['vid_description'];
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="200" ;
				$oFCKeditor1->Create();	
				?>
				</td>
              </tr>
			  
			  
			  
			  
			  			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			 

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">iPhone Video (3GP, FLV, M4V, MP4):</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_iphone" value="<?=$Data['vid_iphone']?>"><input name="vid_iphone" type="file" class="input_white" size="30">
				<?php
				$vid_iphone=$Data['vid_iphone'];
				$file_ext_arr=explode(".",$vid_iphone);
				$file_ext=$file_ext_arr[count($file_ext_arr)-1];
				$file_ext=strtolower(trim($file_ext));
				if(is_file(_UPLOAD_FILE_PATH."videos/iphone/".$vid_iphone))
				{

						//if($file_ext=='flv')
						//{
						?>
						<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="300" height="200">
						<param name="movie" value="<?=_WWWROOT."flvplayer"?>/player.swf" />
						<param name="allowfullscreen" value="true" />
						<param name="allowscriptaccess" value="always" />
						<param name="flashvars" value="file=<?=_UPLOAD_FILE_URL."videos/iphone/".$vid_iphone?>" />
		<!--				<param name="flashvars" value="file=<? //=_UPLOAD_FILE_URL."videos/iphone/".$vid_iphone?>&image=<? //=_WWWROOT."flvplayer"?>/preview.jpg" /> -->
						<embed
						type="application/x-shockwave-flash"
						id="player2"
						name="player2"
						src="<?=_WWWROOT."flvplayer"?>/player.swf" 
						width="300" 
						height="200"
						allowscriptaccess="always" 
						allowfullscreen="true"
						flashvars="file=<?=_UPLOAD_FILE_URL."videos/iphone/".$vid_iphone?>" 
						/>
						<!--flashvars="file=<? //=_UPLOAD_FILE_URL."videos/iphone/".$vid_iphone?>&image=<? //=_WWWROOT."flvplayer"?>/preview.jpg"  -->
						</object>
						<?php
						// }
						?>
				
						&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_video('vid_iphone')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>
			</td>
              </tr>	
			  
			  
			  
			  
			  			  			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			 

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Preview Video (FLV):</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_preview" value="<?=$Data['vid_preview']?>"><input name="vid_preview" type="file" class="input_white" size="30">
				<?php
				$vid_preview=$Data['vid_preview'];
				$file_ext_arr=explode(".",$vid_preview);
				$file_ext=$file_ext_arr[count($file_ext_arr)-1];
				$file_ext=strtolower(trim($file_ext));
				if(is_file(_UPLOAD_FILE_PATH."videos/preview/".$vid_preview))
				{

						//if($file_ext=='flv')
						//{
						?>
						<object id="player" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" name="player" width="300" height="200">
						<param name="movie" value="<?=_WWWROOT."flvplayer"?>/player.swf" />
						<param name="allowfullscreen" value="true" />
						<param name="allowscriptaccess" value="always" />
						<param name="flashvars" value="file=<?=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>" />
		<!--				<param name="flashvars" value="file=<? //=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>&image=<? //=_WWWROOT."flvplayer"?>/preview.jpg" /> -->
						<embed
						type="application/x-shockwave-flash"
						id="player2"
						name="player2"
						src="<?=_WWWROOT."flvplayer"?>/player.swf" 
						width="300" 
						height="200"
						allowscriptaccess="always" 
						allowfullscreen="true"
						flashvars="file=<?=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>" 
						/>
						<!--flashvars="file=<? //=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>&image=<? //=_WWWROOT."flvplayer"?>/preview.jpg"  -->
						</object>
						<?php
						//}
						//else if($file_ext=='mp4' || $file_ext=='3gp' || $file_ext=='m4v')
						//{
						?>
				
					<!--	<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" 
						WIDTH="300" HEIGHT="200" 
						CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab"> 
						<PARAM name="SRC" VALUE="<? //=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>"> 
						<PARAM name="AUTOPLAY" VALUE="false"> 
						<param NAME="type" VALUE="video/quicktime">
						<PARAM name="CONTROLLER" VALUE="true"> 
						<EMBED SRC="<? //=_UPLOAD_FILE_URL."videos/preview/".$vid_preview?>" WIDTH="300" HEIGHT="200" 
						AUTOPLAY="false" CONTROLLER="true" type="video/quicktime"PLUGINSPAGE="http://www.apple.com/quicktime/download/"> 
						</EMBED> 
						</OBJECT> -->
		
						<?php
						//}
						?>
				
						&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_video('vid_preview')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>
				
				
			
			</td>
              </tr>	
			  
			  
			  
			  
			  	<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Video Category :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">
				<select name="vid_category" class="input_white" id="chksbox_vid_category" title="Please select video category.">
				<option value="">Select Category</option>
				<?php
				
				$cat_array=getProdCategoriesAdmin();
				
				
				foreach($cat_array as $cat_data)
				{
				?>
				<option value="<?=$cat_data['cat_id']?>" <?=($Data['vid_category']==$cat_data['cat_id']?'selected':'')?>><?=$cat_data['cat_name']?></option>
				<?php
				}
				?>
				</select>
				</td>
              </tr>
			  
			  
			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Video Company :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">
				<select name="vid_company" class="input_white">
				<option value="0">None</option>
				<?php
				
				$result = $sql->SqlRecordMisc("esthp_tblCompanies","where 1=1 order by comp_name");
				//$count = $result['count'];
				$comp_array = $result['Data']; 

				foreach($comp_array as $comp_data)
				{
				?>
				<option value="<?=$comp_data['comp_id']?>" <?=($Data['vid_company']==$comp_data['comp_id']?'selected':'')?>><?=$comp_data['comp_name']?></option>
				<?php
				}
				?>
				</select>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="main_video" value="1" <?=$Data['vid_is_main']==1?'checked':''?>>&nbsp;&nbsp;Mark this video as the 'Main Video' for selected company
				</td>
              </tr>
			  
			  
			  
			  			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Video Duration :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="vid_duration" id="chk_vid_duration" title="Please enter video duration." type="text" class="input_white" size="48" value="<?=$Data['vid_duration']?>" ></td>
              </tr>
			  
			  
			  
			  			  
			      <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			 

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Video Thumbnail :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_thumb_img" value="<?=$Data['vid_thumb_img']?>"><input name="vid_thumb_img" type="file" class="input_white" size="30">
				<?php
				$vid_thumb_img=$Data['vid_thumb_img'];
	
				if(is_file(_UPLOAD_FILE_PATH."video_images/thumbnails/".$vid_thumb_img))
				{

				
				?>
				<a href="<?=_UPLOAD_FILE_URL?>video_images/thumbnails/<?=$vid_thumb_img?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_videoImage('vid_thumb_img')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>

				
		</td>
              </tr>
			  
			  
			  			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			   <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Video Still Image :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_still_img" value="<?=$Data['vid_still_img']?>"><input name="vid_still_img" type="file" class="input_white" size="30">
				<?php
				$vid_still_img=$Data['vid_still_img'];
	
				if(is_file(_UPLOAD_FILE_PATH."video_images/still_images/".$vid_still_img))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>video_images/still_images/<?=$vid_still_img?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_videoImage('vid_still_img')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>
		</td>
              </tr>
			  
			  
			  
			  			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			  	<tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Video Home Featured (Primary) :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_feat_home" value="<?=$Data['vid_feat_home']?>"><input name="vid_feat_home" type="file" class="input_white" size="30">
				<?php
				$vid_feat_home=$Data['vid_feat_home'];
				if(is_file(_UPLOAD_FILE_PATH."video_images/feat_pri_images/".$vid_feat_home))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>video_images/feat_pri_images/<?=$vid_feat_home?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_videoImage('vid_feat_home')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>
		</td>
              </tr>
			  
			  
			  
			  			  <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			<tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Video Home Featured (Secondary) :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input type="hidden" name="old_vid_feat_sec" value="<?=$Data['vid_feat_sec']?>"><input name="vid_feat_sec" type="file" class="input_white" size="30">
				<?php
				$vid_feat_sec=$Data['vid_feat_sec'];
				if(is_file(_UPLOAD_FILE_PATH."video_images/feat_sec_images/".$vid_feat_sec))
				{
				?>
				<a href="<?=_UPLOAD_FILE_URL?>video_images/feat_sec_images/<?=$vid_feat_sec?>" rel="facebox"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>image_icon.gif' alt='Click to View'></a>
				&nbsp;<a href="javascript:void(0);" onclick="javascript:delete_videoImage('vid_feat_sec')"><img border='0' src='<?=_ADMIN_IMAGE_PATH?>b_drop.png' alt='Click to Delete'></a>
				<?
				}
				?>
		</td>
        </tr>
			  




              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  


				  
			  		<?
					$complete_url=explode(".html",$Data['vid_page_url']);
					?>
					
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Video Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top" class="normal_text_blue">	<input name="vid_page_url" id="chk_vid_page_url" title="Please enter video page URL." type="text" class="input_white" size="48" value="<?=$complete_url[0]?>" >.html</td>
				  </tr>
				  
				  
				  
				<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="vid_meta_title" type="text" class="input_white" size="48" value="<?=$Data['vid_meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="vid_meta_key" class="input_white" rows="4" cols="45"><?=$Data['vid_meta_key']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="vid_meta_des" class="input_white" rows="4" cols="45"><?=$Data['vid_meta_des']?></textarea></td>
              </tr>		  

			  
			  
			  
			    <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
		





             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="vid_status" type="radio" value="active" <?=($Data['vid_status']=='active' || $Data['vid_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Active</span>      <input name="vid_status" type="radio" value="inactive" <?=($Data['vid_status']=='inactive' ? 'checked' : '')?>>  <span class="normal_text_blue">Inactive</span></td>
              </tr>
			  
			  
			  
			  


			  
			  
			  

			  
			
		

			 
			 
			 
		<tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  






              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
			<?php
			
			if(isset($_REQUEST['vid_id']) && $_REQUEST['vid_id']!='')
			{
						$btnName = "Update";
			}
			else
			{
						$btnName = "Add";
			}
			?></td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-videos.php'">				
				
				</td>
              </tr>
            </table></td>
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
<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
include_once(_CLASS_PATH."/pager.cls.php");
$AuthAdmin->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$pageid =$_REQUEST['pageid'];
$path = _WWW_UPLOAD_IMAGE_PATH.'webpage_images/';	
$uploaddir = _UPLOAD_FILE_PATH.'webpage_images/';
// single Delete start
if($_REQUEST['delid']!="")
{
	$id_del = $_REQUEST['delid'];
	$ConArr_del = " WHERE imgId = '".$id_del."'"; 
	$arrFaqs_del = $sql->SqlSingleRecord('mos_tblWebpageImages',$ConArr_del);
	$count_del = $arrFaqs_del['count'];
	$Data_del = $arrFaqs_del['Data'];	 
	if($count_del>0)
	{
		if(file_exists($uploaddir.$Data_del["imageName"]))
			unlink ($uploaddir.$Data_del["imageName"]);
		$cond = " imgId = '".$id_del."'"; 
		$sql->SqlDelete('mos_tblWebpageImages',$cond);	

		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-pageImages.php?pageid='.$pageid.'">';
		echo '<input type="hidden" name="msg" id="msg" value="deleted">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;
	}
}
// single Delete end
// multi Delete start
if($_REQUEST['task']=='deleteAll' && (count($_REQUEST['chk'])>0))
{
	$webPages=$_REQUEST['chk'];
	$pageid = $_POST["pageid"];
	for($i=0;$i<count($webPages);$i++)
	{
		// check the existance of record
		$ConArr_del="";
		$id_del="";
		$count_del="";
		$Data_del="";
		$id_del = $webPages[$i];

		$ConArr_del = " WHERE imgId = '".$id_del."'"; 
		$arrFaqs_del = $sql->SqlSingleRecord('mos_tblWebpageImages',$ConArr_del);
		$count_del = $arrFaqs_del['count'];
		$Data_del = $arrFaqs_del['Data'];	 
		if($count_del>0)
		{
			if(file_exists($uploaddir.$Data_del["imageName"]))
				unlink ($uploaddir.$Data_del["imageName"]);
	
			$cond = " imgId = '".$id_del."'"; 
			$sql->SqlDelete('mos_tblWebpageImages',$cond);	
		}
	}

	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-pageImages.php?pageid='.$pageid.'">';
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
else if($msg=='update')
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
</head>
<body>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr><td valign="top"><?php include_once('include/header.php');?></td></tr>
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
        <td><h1>Manage Page Images </h1></td>
       </tr>
      </table></td>
     </tr>
     <tr><td valign="top" style="padding:15px;" align="center"><?=$message?></td></tr>
  <?	$records_per_page=30;				
		$offset = ($page-1) * $records_per_page;

		$cond="WHERE pageId = '".$pageid ."'";
		$orderby=" ORDER BY imgId DESC";
		$webPage = $sql->SqlRecords("mos_tblWebpageImages",$cond,$orderby,$offset,$records_per_page);
		$count_total=$webPage['TotalCount'];
		$count = $webPage['count'];
		$Data = $webPage['Data'];
//		echo $count;
	  ?>
     <tr>
      <td valign="top">
	   <form method="post" action="" name="frmWebPages">
	    <input type="hidden" name="pageid" value="<?=pageid?>">
		 <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">
            <tr>
             <td width="125" align="center" valign="top"><a href="javascript:void(0)" class="add_del" onClick="multiDelete()">Delete Selected</a></td>
             <td width="2" align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>
             <td width="125" align="center" valign="top"><a href="add-pageImages.php?pageid=<?=$pageid?>" class="add_del">Add Images</a></td>
			 <td width="118" class="paging_bg">	</td>
            </tr>
           </table></td>
           <td align="right" valign="top"><table width="357" border="0" cellspacing="0" cellpadding="0">
            <tr>
			 <td align="right" valign="middle" class="paging_bg"><table style="font-size:9px;">
			  <tr>
			   <td>Page:</td>
			   <td><?php 	$qsA = $_GET; unset($qsA['page'],$qsA['del']); $qs = "";
									foreach ($qsA as $k=>$v) $qs .= "&$k=$v";
									$url = "?page={@PAGE}&$qs";
									$pager = new pager($url, $count_total, $records_per_page, $page);
									$pager->outputlinks();	?>	</td
			  ></tr>
			 </table></td>
		    </tr>
		  </table></td>
	    </tr>
	   </table></td>
	  </tr>
      <tr>
		<td valign="top" class="border"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td valign="middle" class="left_headbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="4%"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td>
				<td width="52%" class="white_text">Image</td>
				<td width="11%" align="center" class="white_text"> Status</td>
				<td width="21%" align="center" class="white_text">Added On</td>
				<td width="12%" align="center" class="white_text">Delete</td>
			  </tr>
				
	<? if($count>0)
		 {
			for($i=0; $i<$count; $i++)
			{	?>
				<tr <?=($i%2==0)? 'class="grey_bg"' : ""?> height="40">
				<td width="4%" height="25"><input type="checkbox" name="chk[]" value="<?=$Data[$i]['imgId']?>"></td>
				<td width="52%" class="black_text"><img src="<?=$path.$Data[$i]["imageName"] ; ?>" width="85" border="0x"></td>
				<td width="11%" align="center" class="black_text"><?=$Data[$i]['status']?></td>
				<td align="center" class="black_text"><?=date("d/m/Y",$Data[$i]['addDate']);?>	</td>
				<td width="12%" align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-pageImages.php?delid=<?=$Data[$i]['imgId']?>&page=<?=$page?>&pageid=<?=$pageid?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>
			  </tr>
    <?  } 
	   }
	   else
	   {
			echo '<tr class="grey_bg"><td height="25" colspan="5" class="empty_record_txt">NO Record Found.</td></tr>';
	   }?>

            </table></td>
           </tr>
          </table></td>
         </tr>
         <tr>            <td valign="top">&nbsp;</td>             </tr>
        </table>
   	   </form> </td>
      </tr>
      <tr><td valign="top">&nbsp;</td></tr>
     </table></td>
    </tr>
   </table></td>
  </tr>
  <tr><td valign="top"><?php include_once('include/footer.php');?></td></tr>
</table>
<SCRIPT type=text/javascript>
	function SingleDelete(url)
	{	
		if(confirm("Are you sure you want to delete this Image ?"))
		{
			document.location=url;
		}
	}
	function checkall(state)
	{
		var frm =document.frmWebPages;
		var n =frm.elements.length;
		for (i=0; i<n; i++)
		{
			if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;
		}
	}

	function multiDelete()
	{
		var frm =document.frmWebPages;
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
			if(confirm("Are you sure you want to delete the selected Image(s)?"))
			{
				frm.action='?task=deleteAll';
				frm.submit();
			}
		}
		else
		{
			alert("please make a selection from a list");
			return false;
		}
	}
</SCRIPT>
</body>
</html>
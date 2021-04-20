<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

include_once(_CLASS_PATH."/pager.cls.php");

$AuthAdmin->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

// single Delete start

if($_REQUEST['delid']!="")

{

			

			$id_del = $_REQUEST['delid'];

			$ConArr_del = " WHERE pid= '$id_del' "; 						

			$arrPhoto_del = $sql->SqlSingleRecord('mos_tblPhoto',$ConArr_del);

			$count_del = $arrPhoto_del['count'];

			$Data_del = $arrPhoto_del['Data'];	 

		if($count_del>0)

		{

			$delid=$_REQUEST['delid'];

			$cond = " pid = ".$delid;

			$sql->SqlDelete('mos_tblPhoto',$cond);	

			@unlink(_UPLOAD_FILE_PATH."/photoGallery/thumb/".$Data_del['thumb_img']);

			@unlink(_UPLOAD_FILE_PATH."/photoGallery/".$Data_del['fullsize_img']);

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-photo.php">';

		echo '<input type="hidden" name="msg" id="msg" value="deleted">';

		echo '<input type="hidden" name="page" value="'.$page.'">';

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

	

	for($i=0;$i<count($webPages);$i++)

	{

			// check the existance of record

			$ConArr_del="";

			$id_del="";

			$count_del="";

			$Data_del="";

			

			$id_del = $webPages[$i];

			$ConArr_del = " WHERE pid= '$id_del' "; 						

			$arrPhoto_del = $sql->SqlSingleRecord('mos_tblPhoto',$ConArr_del);

			$count_del = $arrPhoto_del['count'];

			$Data_del = $arrPhoto_del['Data'];

			if($count_del>0) // if record found

			{			

				$cond = " pid = ".$webPages[$i];

				$sql->SqlDelete('mos_tblPhoto',$cond);

				unlink(_UPLOAD_FILE_PATH."/photoGallery/thumb/".$Data_del['thumb_img']);

				unlink(_UPLOAD_FILE_PATH."/photoGallery/".$Data_del['fullsize_img']);

			}	

	}

		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-photo.php">';

		echo '<input type="hidden" name="msg" id="msg" value="deleted">';

		echo '<input type="hidden" name="page" value="'.$page.'">';

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

  <tr>

    <td valign="top"><?php include_once('include/header.php');?></td>

  </tr>

  <tr>

    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

      <tr>

        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>

        <td width="14" valign="top">&nbsp;</td>

        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          

          <tr>

            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

                <td><h1>Manage Photo Gallery </h1></td>

              </tr>

            </table></td>

          </tr>

          <tr>

             <td valign="top" style="padding:15px;" align="center"><?=$message?></td>

          </tr>

		  <tr>

                <td valign="top" width="25"><img src="images/spacer.gif" alt="" width="1" height="25"></td>

               

              </tr>

		  <?php

		$records_per_page=10;			

		$offset = ($page-1) * $records_per_page;

		$cond="WHERE 1";

		$orderby=" ORDER BY pid DESC";

		$webPage = $sql->SqlRecords("mos_tblPhoto",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];		

		  ?>

          <tr>

            <td valign="top">

			<form method="post" action="" name="frmPhoto">

			<table width="100%" border="0" cellspacing="0" cellpadding="0">

              <tr>

                <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td align="center" valign="top"><a href="javascript:void(0)" class="add_del" onClick="multiDelete()" >Delete Selected</a></td>

                        <td align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>

                        <td align="center" valign="top"><a href="add-photo.php" class="add_del">Add Photo </a></td>

                      </tr>

                    </table></td>

                    <td align="right" valign="top"><table width="357" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td align="right" valign="middle" class="paging_bg">

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

                <td valign="top" class="border"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                  <tr>

                    <td valign="middle" class="left_headbg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

                      <tr>

                        <td width="7%"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td>

                        <td width="20%" class="white_text"> Image</td>                        

                        <td width="15%" align="center" class="white_text">Image Title </td>

                        <td width="17%" align="center" class="white_text">Active/Inactive</td>

                        <td width="15%" align="center" class="white_text">Last Modified</td>

                        <td width="14%" align="center" class="white_text">Edit</td>

                        <td width="12%" align="center" class="white_text">Delete</td>

                      </tr>

                    </table></td>

                  </tr>

                  

                  <tr>

                    <td valign="top">

					<table width="100%" border="0" cellspacing="0" cellpadding="0">

					<?php 

					if($count>0){

						for($i=0; $i<$count; $i++)

						{

							if($Data[$i]['thumb_img']!="" && file_exists(_UPLOAD_FILE_PATH."/photoGallery/thumb/".$Data[$i]['thumb_img']))

							{

							$img='<img src="'._WWW_UPLOAD_IMAGE_PATH.'/photoGallery/thumb/'.$Data[$i]['thumb_img'].'" border="0" width="100" height="45" />';

							}

							else

							{

							$img='<img src="'._WWW_UPLOAD_IMAGE_PATH.'/photoGallery/thumb/no_image_icon.jpg" border="0" width="100" height="45" />';

							}

					?>

                      <tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

                        <td width="5%" height="50"><input type="checkbox" name="chk[]" value="<?=$Data[$i]['pid']?>"></td>

                        <td width="20%" class="white_text"><?=$img?></td>                                 

                        <td width="15%" align="center" class="black_text"><?=$Data[$i]['title']?></td>

                        <td width="15%" align="center" class="black_text"><?=$Data[$i]['status']?></td>

                        <td width="15%" align="center" class="black_text"><?=date("d/m/Y",strtotime($Data[$i]['modifiedDate']))?></td>

                        <td width="13%" align="center" class="white_text">

						<a href="add-photo.php?mode=edit&pid=<?=$Data[$i]['pid']?>&page=<?=$page?>">

						<img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

                        <td width="11%" align="center" class="white_text">

						<a href="javascript: void(0)" onclick="SingleDelete('list-photo.php?delid=<?=$Data[$i]['pid']?>&page=<?=$page?>');">

						<img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a>						</td>

                      </tr>

                     <?php 

					 	} 

					 }

					 else

					{

						echo '<tr class="grey_bg"><td height="25" colspan="6" class="empty_record_txt">NO Record Found.</td></tr>';

					}

					 ?>

                    </table></td>

                  </tr>

                  

                </table></td>

              </tr>

              <tr>

                <td valign="top">&nbsp;</td>

              </tr>

            </table>

			</form>

			</td>

          </tr>

          <tr>

            <td valign="top">&nbsp;</td>

          </tr>

          

        </table></td>

      </tr>

    </table></td>

  </tr>

  <tr>

    <td valign="top"><?php include_once('include/footer.php');?></td>

  </tr>

</table>

<SCRIPT type=text/javascript>

	function SingleDelete(url)

	{	

		if(confirm("Are you sure you want to delete the selected Photo(s)?"))

		{

			document.location=url;

		}

	}





function checkall(state)

{

	

	var frm =document.frmPhoto;

	var n =frm.elements.length;

	for (i=0; i<n; i++)

	{

		if (frm.elements[i].name == "chk[]") frm.elements[i].checked = state;

	}

}

function multiDelete()

{

	var frm =document.frmPhoto;

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

		if(confirm("Are you sure you want to delete the selected Page(s)?"))

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


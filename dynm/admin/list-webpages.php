<?php

include_once("../includes/global.inc.php");

require_once(_PATH."/modules/mod_admin_login.php");

include_once(_CLASS_PATH."/pager.cls.php");

$AuthAdmin->ChkLogin();

$page = ($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$destId=$_REQUEST['destId'];

// single Delete start

if($_REQUEST['delid']!="")

{

	$id_del = $_REQUEST['delid'];

	$ConArr_del = " WHERE id= '$id_del' "; 

	$arrFaqs_del = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr_del);

	$count_del = $arrFaqs_del['count'];

	$Data_del = $arrFaqs_del['Data'];	 

	if($count_del>0)

	{

		$delid=$_REQUEST['delid'];

		$cond = " id = ".$delid;

		$sql->SqlDelete('mos_tblWebpage',$cond);	



		echo "<body>";

		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';

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

	for($i=0;$i<count($webPages);$i++)

	{

		// check the existance of record

		$ConArr_del="";

		$id_del="";

		$count_del="";

		$Data_del="";

		$id_del = $webPages[$i];

		$ConArr_del = " WHERE id= '$id_del' "; 						

		$arrFaqs_del = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr_del);

		$count_del = $arrFaqs_del['count'];

		$Data_del = $arrFaqs_del['Data'];

		if($count_del>0) // if record found

		{			

			$cond = " id = ".$webPages[$i];

			$sql->SqlDelete('mos_tblWebpage',$cond);				

		}	

	}



	echo "<body>";

	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';

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

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-webpages.php">List Web Pages</a></div></td></tr>

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

                <td><h1>Manage Web Pages </h1></td>

              </tr>

            </table></td>

          </tr>

          <tr><td valign="top" style="padding:15px;" align="center"><?=$message?></td></tr>

  <?	$records_per_page=30;				

		$offset = ($page-1) * $records_per_page;



		$cond="WHERE 1";

		$orderby=" ORDER BY id DESC";

		$webPage = $sql->SqlRecords("mos_tblWebpage",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];

		//echo $count;

	  ?>

         <tr>

          <td valign="top">

		   <form method="post" action="" name="frmWebPages">

		   <table width="100%" border="0" cellspacing="0" cellpadding="0">

             <tr>

              <td height="25" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">

               <tr>

                <td valign="top"><table width="0%" border="0" cellspacing="0" cellpadding="0">

                 <tr>

                   <td width="125" align="center" valign="top"><a href="javascript:void(0)" class="add_del" onClick="multiDelete()">Delete Selected</a></td>

                   <td width="2" align="center" valign="top"><img src="images/spacer.gif" alt="" width="2" height="1"></td>

                   <td width="125" align="center" valign="top"><a href="add-webpage.php" class="add_del">Add Page</a></td>

					<td width="118" class="paging_bg">	</td>

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

                        <td width="10%" align="center"><input type="checkbox" onclick="javascript:checkall(this.checked);"></td>

                        <td width="40%" class="white_text">Page Name</td>

                        <td width="10%" align="center" class="white_text">Status</td>

                        <td width="20%" align="center" class="white_text">Last Modified</td>

                        <td width="10%" align="center" class="white_text">Edit</td>

                        <td width="12%" align="center" class="white_text">Delete</td>

                      </tr>

				

			<?	if($count>0)

					{

						for($i=0; $i<$count; $i++)

						{	?>

							<tr <?=($i%2==0)? 'class="grey_bg"' : ""?>>

							<td  height="30" align="center" ><input type="checkbox" name="chk[]" value="<?=$Data[$i]['id']?>"></td>

							<td align="left" class="black_text"><?=$Data[$i]['page_name']; ?></td>

							<td  align="left" class="black_text"><?=$Data[$i]['page_status']?></td>

							<td align="center" class="black_text"><?=date("d/m/Y",strtotime($Data[$i]['date_modified']))?></td>


							<td align="center" class="white_text"><a href="add-webpage.php?mode=edit&id=<?=$Data[$i]['id']?>&page=<?=$page?>"><img src="images/edit_button.gif" alt="" width="59" height="19" border="0"></a></td>

							<td  align="center" class="white_text"><a href="javascript: void(0)" onclick="SingleDelete('list-webpages.php?delid=<?=$Data[$i]['id']?>&page=<?=$page?>');"><img src="images/delete_button.gif" alt="Delete" width="59" height="19" border="0"></a></td>

						  </tr>

				<?	} 

					}

					else

					{

						echo '<tr class="grey_bg"><td height="25" colspan="7" class="empty_record_txt">NO Record Found.</td></tr>';

					}	?>

                    </table></td>

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

<SCRIPT type=text/javascript>

	function SingleDelete(url)

	{	

		if(confirm("Are you sure you want to delete this Page ?"))

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
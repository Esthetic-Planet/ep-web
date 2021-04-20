<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();

$sqlError="";


if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{	



	$ConArr = array();	
	

	$ConArr["page_name"] = $_POST["page_name"] ;
	$ConArr["page_url"] = strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	$ConArr["meta_title"] = $_POST["meta_title"];
	$ConArr["meta_keywords"] = $_POST["meta_keywords"] ;
	$ConArr["meta_description"] = $_POST["meta_description"];
	$ConArr["page_content"] = $_POST["page_content"];
	$ConArr["page_status"] = $_POST["page_status"];
	$ConArr['date_added'] = date("Y-m-d H:i:s",time());

	$ConArr=add_slashes_arr($ConArr);

	$intResult = $sql->SqlInsert('mos_tblWebpage',$ConArr);
	update_htaccess();
	if($intResult)
	{
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && isset($_REQUEST['id']))
{	
	$ConArr = array();			

	$ConArr["page_name"] = $_POST["page_name"] ;
	//$ConArr["page_url"] = strtolower(str_replace(" ","_",$_POST["page_url"] )).".html";
	$ConArr["page_url"] = str_replace(" ","_",strtolower($_POST['page_url'])).".html";
	$ConArr["meta_title"] = $_POST["meta_title"];
	$ConArr["meta_keywords"] = $_POST["meta_keywords"] ;
	$ConArr["meta_description"] = $_POST["meta_description"];
	$ConArr["page_content"] = $_POST["page_content"];
	$ConArr["page_status"] = $_POST["page_status"];
	$ConArr['date_modified'] = date("Y-m-d H:i:s",time());

	$ConArr=add_slashes_arr($ConArr);
	
    $CondArr = " WHERE id = ".$_GET['id'];
	
	$sql->SqlUpdate('mos_tblWebpage',$ConArr,$CondArr);		
	
	update_htaccess();
	
	//echo _ADMIN_WWWROOT.'list-webpages.php';
	//die;
	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-webpages.php">';
	echo '<input type="hidden" name="msg" id="msg" value="update">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}

if(isset($_REQUEST['id']) && ($_REQUEST['mode']=='edit') && !isset($_POST['Submit']))
{
	$id = $_REQUEST['id'];
	$ConArr = " WHERE id= '$id' "; 						
	$arrArticle = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr);
	$count = $arrArticle['count'];
	$Data = $arrArticle['Data'];			
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
<SCRIPT language=javascript src="../js/validation.js"></SCRIPT>
<SCRIPT language=javascript src="../js/popupWindow.js"></SCRIPT>	
<script>
//STEP 9: prepare submit FORM function
function SubmitForm(formnm)
{
   if(!JSvalid_form(formnm))
	{
		return false;
	}
}		
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="add-webpage.php">Add/Edit Web Page</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="frmAddWebPage" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Web Page </h1></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td  valign="top"><img src="images/spacer.gif" alt="" width="1" height="25" align="left">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div></td>
          </tr>
		  <tr><td valign="top"><?=$sqlError?></td></tr>
          <tr>
            <td valign="top"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">


              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page Name :</td>
                <td  align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="page_name" type="text" class="input_white" size="48" value="<?=$Data['page_name']?>" alt="BC~DM~Page Name.~DM~"></td>
              </tr>
			  
			  		<?
					$complete_url=explode(".html",$Data['page_url']);
					?>
			  
			  
			  

				  <tr>
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				   <tr>
					<td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Page URL :</td>
					<td width="4" align="left" valign="top">&nbsp;</td>
					<td width="334" align="left" valign="top">	<input name="page_url"  type="text" class="input_white" size="48" value="<?=$complete_url[0]?>" alt="BC~DM~Page URL.~DM~">.html</td>
				  </tr>

			 


			 
              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue">Meta Title :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<input name="meta_title" type="text" class="input_white" size="48" value="<?=$Data['meta_title']?>"></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_keywords" class="input_white" rows="4" cols="45"><?=$Data['meta_keywords']?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Description: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="meta_description" class="input_white" rows="4" cols="45"><?=$Data['meta_description']?></textarea></td>
              </tr>		  

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Page Content :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="left" valign="top">
				<?php	
				
				$page_content = $Data['page_content'];	
							
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				//$oFCKeditor->BasePath = _WWWROOT. '/htmleditor/' ;	// '/FCKeditor/' is the default value.
				$sBasePath = _HTML_EDITOR_PATH."/";
				$oFCKeditor1 = new FCKeditor('page_content') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	= $page_content;
				//$oFCKeditor->ToolbarSet ="page_content";
				$oFCKeditor1->Width="90%" ;
				$oFCKeditor1->Height="400" ;
				$oFCKeditor1->Create() ;	
				?>
				</td>
              </tr>



              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="page_status" type="radio" value="active" <?php if($Data['page_status']=='active') echo " checked"?> <?php if($Data['page_status']=='') echo " checked" ?>>   <span class="normal_text_blue">Active</span>      <input name="page_status" type="radio" value="inactive" <?php if($Data['page_status']=='inactive') echo " checked"?>>  <span class="normal_text_blue">Inactive</span></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">
			<?	if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-webpages.php'">				</td>
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
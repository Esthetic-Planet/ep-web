<?php
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");
$AuthAdmin->ChkLogin();
$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";


if(isset($_POST['Submit']) && $_POST['Submit']=="Add")
{		
	$ReqArr = $_REQUEST;
	$ConArr = array();	
	
	$pageurl = "offer-".strtolower(str_replace(" ","-",$ReqArr["name"] )).".html";

	$ConArr["name"] = addslashes($_POST["name"]) ;
	$ConArr["title"] = addslashes($_POST["title"]) ;
	$ConArr["pageurl"] = addslashes($pageurl ) ;
	$ConArr["metaKeyword"] = addslashes($_POST["metaKeyword"]) ;
		
	$ConArr["metaDesc"] = addslashes($_POST["metaDesc"]) ;
	$ConArr["short_desc"] = addslashes($_POST["short_desc"]) ;
	$ConArr["long_desc"] = addslashes($_POST["long_desc"]) ;
	$ConArr["status"] = addslashes($_POST["status"]) ;
	$ConArr["link_title"] = addslashes($_POST["link_title"]) ;

	$ConArr['addedDate'] = date("Y-m-d h:i:s",time());
	$ConArr['modifiedDate'] = date("Y-m-d h:i:s",time());		
	$intResult = $sql->SqlInsert('mos_tblOffers',$ConArr);
	if($intResult)
	{
		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-offers.php">';
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

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && isset($_POST['id']))
{	
		$ConArr = array();			
		$ConArr["name"] = addslashes($_POST["name"]) ;
		$ConArr["title"] = addslashes($_POST["title"]) ;
		$ConArr["pageurl"] = addslashes($_POST["pageurl"]) ;
		$ConArr["metaKeyword"] = addslashes($_POST["metaKeyword"]) ;
		
		$ConArr["metaDesc"] = addslashes($_POST["metaDesc"]) ;
		$ConArr["short_desc"] = addslashes($_POST["short_desc"]) ;

		$ConArr["long_desc"] = addslashes($_POST["long_desc"]) ;
		$ConArr["status"] = addslashes($_POST["status"]) ;
		$ConArr["link_title"] = addslashes($_POST["link_title"]) ;

	    $CondArr = " WHERE id = ".$_POST['id'];
		$sql->SqlUpdate('mos_tblOffers',$ConArr,$CondArr);		

		echo "<body>";
		echo '<form name="frmSu" id="frmSu" method="post" action="'._ADMIN_WWWROOT.'list-offers.php">';
		echo '<input type="hidden" name="msg" id="msg" value="update">';
		echo '</form>';
		echo '<script type="text/javascript">document.frmSu.submit();</script>';
		echo '</body>';		
		exit;
}

if(isset($_REQUEST['id']) && ($_REQUEST['mode']=='edit') && !isset($_REQUEST['Submit']))
{
	$id = $_REQUEST['id'];
	$ConArr = " WHERE id= '$id' "; 						
	$arrArticle = $sql->SqlSingleRecord('mos_tblOffers',$ConArr);
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
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="add-offer.php">Add/Edit Offers</a></div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="frmAddWebPage" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?=$id?>">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Add Offer Pages </h1></td>
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
             <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Offer Name :</td>
             <td  align="left" valign="top">&nbsp;</td>
             <td width="334" align="left" valign="top">	<input name="name" type="name" class="input_white" size="48" value="<?=stripslashes($Data['name'])?>" alt="BC~DM~ Web page name~DM~"></td>
            </tr>			  
			<tr>
			  <td height="20" align="right" valign="top">&nbsp;</td>
  			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Link Caption :</td>
			  <td width="4" align="left" valign="top">&nbsp;</td>
			 <td width="334" align="left" valign="top">	<input name="link_title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['link_title'])?>" alt="BC~DM~ Link Caption~DM~"></td>
		    </tr>

	 <? if($id  !=  "" && $id  != 0)
	 	  { ?> 
			<tr>
			  <td height="20" align="right" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			  <td align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Web Page Url :</td>
			  <td width="4" align="left" valign="top">&nbsp;</td>
			  <td width="334" align="left" valign="top">	<input name="pageurl" id="title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['pageUrl'])?>" alt="BC~DM~ Web page url~DM~"></td>
			</tr>
		<? } ?>

            <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
            </tr>

		  <tr>
			<td width="124" align="right" valign="top" class="normal_text_blue">Title :</td>
			<td width="4" align="left" valign="top">&nbsp;</td>
			<td width="334" align="left" valign="top">	<input name="title" id="title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['title'])?>"></td>
		  </tr>

		  <tr>
			<td height="20" align="right" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
			<td align="left" valign="top">&nbsp;</td>
		  </tr>

              <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta KeyWords: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="metaKeyword" id="metaKeyword" class="input_white" rows="4" cols="45"><?=stripslashes($Data['metaKeyword'])?></textarea></td>
              </tr>

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

			  <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">Meta Desc.: </td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><textarea name="metaDesc" id="metaDesc" class="input_white" rows="4" cols="45"><?=stripslashes($Data['metaDesc'])?></textarea></td>
              </tr>		  

			   <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="right" valign="top" class="normal_text_blue">Short Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"></td>
              </tr>

              <tr>
                <td  colspan="3" align="left" valign="top">
	<?php	$smallDes = stripslashes($Data['short_desc']);				
				include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;
				//$oFCKeditor->BasePath = _WWWROOT. '/htmleditor/' ;	// '/FCKeditor/' is the default value.
				$sBasePath = _HTML_EDITOR_PATH."/";
				$oFCKeditor1 = new FCKeditor('short_desc') ;
				$oFCKeditor1->BasePath	= $sBasePath ;
				$oFCKeditor1->Value	= $smallDes;
				//$oFCKeditor->ToolbarSet ="Basic";
				$oFCKeditor1->Width="100%" ;
				$oFCKeditor1->Height="250" ;
				$oFCKeditor1->Create() ;	
				?>
				</td>
              </tr>

              <tr>
                <td align="right" valign="top" class="normal_text_blue">Long Description :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

              <tr>
                <td  colspan="3" align="left" valign="top">
				<?php
		
				$fullDes = stripslashes($Data['long_desc']);				
				//$oFCKeditor->BasePath = _WWWROOT. '/htmleditor/' ;	// '/FCKeditor/' is the default value.
				$sBasePath = _HTML_EDITOR_PATH."/";
				$oFCKeditor = new FCKeditor('long_desc') ;
				$oFCKeditor->BasePath	= $sBasePath ;
				$oFCKeditor->Value	= $fullDes;
				//$oFCKeditor->ToolbarSet ="Basic";
				$oFCKeditor->Width="100%" ;
				$oFCKeditor->Height="350" ;
				$oFCKeditor->Create() ;	
				?>				</td>
              </tr>
              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="status" type="radio" value="active" <?php if($Data['status']=='active') echo " checked"?> <?php if($Data['status']=='') echo " checked"?>>   <span class="normal_text_blue">Active</span>      <input name="status" type="radio" value="inactive" <?php if($Data['status']=='inactive') echo " checked"?>>  <span class="normal_text_blue">Inactive</span></td>
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
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-offers.php'">				</td>
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
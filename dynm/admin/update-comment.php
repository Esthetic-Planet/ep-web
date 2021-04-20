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



$cmt_id=$_REQUEST['cmt_id'];

 if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && !empty($_REQUEST['cmt_id']))
{	
	$content_arr = array();	
	$content_arr["cmt_text"] = trim($_POST["cmt_text"]) ;
	$content_arr["cmt_name"] = trim($_POST["cmt_name"]);
	$content_arr["cmt_email"] = trim($_POST["cmt_email"]);
	$content_arr["cmt_date_mod"] = date("Y-m-d H:i:s",time());
	$content_arr["cmt_status"] = $_POST["cmt_status"];


    $condition = " where cmt_id='".$cmt_id."'";
	$sql->SqlUpdate('esthp_tblComments',$content_arr,$condition);		
	
	//update_htaccess();
	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'view-comments.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '<input type="hidden" name="vid_id" id="vid_id" value="'.$_GET['vid_id'].'">';
	echo '<input type="hidden" name="page" id="page" value="'.$_GET['page'].'">';
	echo '<input type="hidden" name="cmt_status" id="cmt_status" value="'.$_GET['cmt_status'].'">';
	echo '<input type="hidden" name="cmt_is_read" id="cmt_is_read" value="'.$_GET['cmt_is_read'].'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>';
	echo '</body>';		
	exit;
}



if(!empty($_REQUEST['cmt_id']))
{

	$content_arr = array();	
	$content_arr['cmt_is_read'] = 1 ;
	$condition = " where cmt_id ='".$_REQUEST['cmt_id']."'";
	$sql->SqlUpdate('esthp_tblComments',$content_arr,$condition);
	
	
	$cond = " WHERE cmt_id= '$cmt_id' "; 						
	$cmt_arr = $sql->SqlSingleRecord('esthp_tblComments',$cond);
	$count = $cmt_arr['count'];
	$Data = $cmt_arr['Data'];			
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
	
 
	function delete_compImage()
	{
		if(confirm("Are you sure to delete image?" ))
		{
			window.location.href="add-company.php?act=delimg&cmt_id=<?=$cmt_id?>"; 
		}
	}
	

</script>

</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="view-comments.php">View Comments</a> &raquo; Update Comment</div></td></tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		<form name="update-comments" action="" method="post" onsubmit="return ValidateForm(this);" enctype="multipart/form-data">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
           <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
               <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
               <td><h1>Update Comment </h1></td>
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
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>User Name :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="cmt_name" id="chk_cmt_name" title="Please enter user name." type="text" class="input_white" size="48" value="<?=$Data['cmt_name']?>" ></td>
              </tr>
			  
			  
			  
			  
			  
			     <tr>
                <td height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
			  
			  
			  
			     <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>User Email :</td>
                <td width='10' align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top" class="normal_text_blue">	<input name="cmt_email" id="chkemail_cmt_email" title="Please enter a valid email ID." type="text" class="input_white" size="48" value="<?=$Data['cmt_email']?>" ></td>
              </tr>
			  

			
			  
			  
			  	<tr>
					<td height="20" align="right" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
					<td align="left" valign="top">&nbsp;</td>
				  </tr>
				  

              <tr>
                <td width="124" align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Comment Text :</td>
                <td width="4" align="left" valign="top">&nbsp;</td>
                <td width="334" align="left" valign="top">	<textarea name="cmt_text" id="chk_cmt_text" class="input_white" rows="8" cols="45" title="Please enter comment text."><?=$Data['cmt_text']?></textarea></td>
              </tr>

              <tr>
                <td height="20" align="right" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>


			


             <tr>
                <td align="right" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top"><input name="cmt_status" type="radio" value="approved" <?=($Data['cmt_status']=='approved' || $Data['cmt_status']=='' ? 'checked' : '')?>>   <span class="normal_text_blue">Approved</span>      <input name="cmt_status" type="radio" value="unapproved" <?=($Data['cmt_status']=='unapproved' ? 'checked' : '')?>>  <span class="normal_text_blue">Unapproved</span></td>
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
		$btnName = "Update";
	
			?></td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">
				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-companies.php'">				
				
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
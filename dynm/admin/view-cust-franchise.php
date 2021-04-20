<?php include_once("../includes/global.inc.php");
require_once(_PATH."modules/mod_admin_login.php");
//include_once(_CLASS_PATH."/class.upload.php");

$AuthAdmin->ChkLogin();

//print_r($_SESSION);




$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;
$sqlError="";


		
if(!empty($_REQUEST['cust_id']))
{
	$select_condition="where cust_id='".$_REQUEST['cust_id']."'";
	$cust_record_arr=$sql->SqlRecordMisc('esthp_tblCustomers', $select_condition);
	$total_customers=$cust_record_arr['count'];
	$cust_records=$cust_record_arr['Data'];
	$cust_arr=array();
	$cust_arr=$cust_records[0];
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

</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><?php include_once('include/header.php');?>
<div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="list-cust-franchise.php">Manage Customers</a></div></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>
        <td width="14" valign="top">&nbsp;</td>
        <td valign="top">
		
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          
          <tr>
            <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>
                <td><h1>View Customer Details</h1></td>
              </tr>
            </table></td>
          </tr>
		  <!-- <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="4">
			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>
			</td>
          </tr> -->
		  
		  <?php
		  if($sqlError!='')
		  {
		  ?>
		 <tr>
            <td valign="middle" height="50" align="center" style="padding:5px;"><?=$sqlError?></td>
          </tr>
		  <?php
		  }
		  ?> 
          <tr>
            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="1"></td>
          </tr>
          <tr>
            <td valign="top">
			

			
			
				  <form name="register_frm" action="" method="post" onsubmit="return ValidateForm(this)" enctype="multipart/form-data" style="margin:0px;">
			<table width="475" border="0" align="center" cellpadding="0" cellspacing="0">

              

              <tr>
                <td colspan="3" align="left" valign="top">
				
				<fieldset ><legend class="blue12">Details</legend>
				<table width="100%" border="0">
				 
				 

				 
				 <tr>
				 
				 
				 
				 
                <td width="21%" align="left" valign="top" class="normal_text_blue">First Name:</td>
                <td width="2%" align="left" valign="top">&nbsp;</td>
                <td width="77%" align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_fname']?></td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Last name:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue">
				<?=$cust_arr['cust_lname']?></td>
              </tr>
			  
			  
			                <tr>
                <td align="left" valign="top" class="normal_text_blue">Email ID:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue">
				<?=$cust_arr['cust_email']?></td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Address:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue">
			<?=$cust_arr['cust_address']?>
				</td>
              </tr>
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue">State:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_state']?>
				</td>
              </tr>
			  
			     <tr>
                <td align="left" valign="top" class="normal_text_blue">City:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_city']?>
				</td>
              </tr>
			  
			  
			  			  
			     <tr>
                <td align="left" valign="top" class="normal_text_blue">Zip:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue">
				<?=$cust_arr['cust_zip']?></td>
              </tr>
			  
			  
			  
	<tr>
	<td align="left" valign="top" class="normal_text_blue">Country:</td>
	<td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top" class="normal_text_blue">
	
	<?=$cust_arr['cust_country']?>
     </td>
    </tr>
	
			  
			  
              <tr>
                <td align="left" valign="top" class="normal_text_blue">Phone:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_phone']?>
				</td>
              </tr>
			  
			  
			  
			  

	
	
			<tr>
                <td align="left" valign="top" class="normal_text_blue">Shopping URL:</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_url']?>
				</td>
              </tr>
			  
			  
			  
			  
			  
			  

			  <tr>
                <td align="left" valign="top" class="normal_text_blue">Status :</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top" class="normal_text_blue"><?=$cust_arr['cust_status']?>
				  </td>
              </tr>
			  
			  
			 
			  
			  
			  

			  

			
			  
	
	
	
          
				
				
				
				</table>
				</fieldset></td>
                </tr>
				
				
				
				
				
				 
				 
				 
              
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
              </tr>

            </table>
			</form>
			</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
          </tr>
          
        </table>
		
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><?php include_once('include/footer.php');?></td>
  </tr>
</table>
</body>
</html>

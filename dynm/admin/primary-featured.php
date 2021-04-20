<?php include_once("../includes/global.inc.php");

require_once(_PATH."modules/mod_admin_login.php");

// include_once(_CLASS_PATH."pager.cls.php");

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



//print_r($_POST);
	
if(isset($_REQUEST['day']))
{
	$day=$_REQUEST['day'];
}
else
{
	$day=1;
}
		

if(isset($_REQUEST['submit']))
{
	$update_str="";
	
	if(is_array($_POST['home_pri']))
	{
		$update_arr=array();
		
		for($i=0;$i<count($_POST['home_pri']);$i++)
		{
			$home_comp="0";
			$home_comp_ord="";
		
			$home_comp=$_POST['home_pri'][$i];
			
			if($_POST['home_pri_ord'.$home_comp])
			{
				$home_comp_ord=$_POST['home_pri_ord'.$home_comp];
			}
			else
			{
				$home_comp_ord="1";
			}
			
			$home_comp_str=$home_comp.'|'.$home_comp_ord;
			 
			$update_arr[]=$home_comp_str;
		}
		
		if(count($update_arr)>0)
		{
			$update_str=implode(",",$update_arr);
		}
	}
	
	$content_arr = array();	
	$content_arr['comp_id_pri'] = $update_str ;
	$content_arr['pri_speed'] = $_POST['pri_speed'] ;
	$content_arr['pri_pause'] = $_POST['pri_pause'] ;
	$condition = " where id ='".$day."'";
	$sql->SqlUpdate('esthp_tblHomeFeat',$content_arr,$condition);
	
	echo "<body>";
	echo '<form name="frmSu" id="frmSu" method="get" action="'._ADMIN_WWWROOT.'primary-featured.php">';
	echo '<input type="hidden" name="msg" id="msg" value="updated">';
	echo '<input type="hidden" name="day" id="day" value="'.$day.'">';
	echo '</form>';
	echo '<script type="text/javascript">document.frmSu.submit();</script>'; 
	echo '</body>';		
	//exit;
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
	/* function SingleDelete(url)
	{	
		if(confirm("Are you sure you want to delete this comment?"))
		{
			window.location.href=url;
		}
	}
*/
</script>

</head>

<body>

<script src="../wz_tooltip/wz_tooltip.js" type="text/javascript"></script>

 <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr><td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="primary-featured.php">Primary Featured</a></div></td></tr>

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

                <td><h1>Primary Featured Content</h1></td>

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
		$feat_arr = $sql->SqlSingleRecord("esthp_tblHomeFeat","where id='".$day."'");
		$count = $feat_arr['count'];
		$Data = $feat_arr['Data'];
		
		$pri_companies=$Data['comp_id_pri'];
		$sec_companies=$Data['comp_id_sec'];
		
		$pri_arr=array();
		$pri_comp_arr=array();
		$pri_ord_arr=array();
		
		$sec_arr=array();
		
		if(trim($pri_companies)!='')
		{
			$pri_arr=explode(',',$pri_companies);
				
		}
		
		foreach($pri_arr as $pri_arr_ele)
		{
			$temp_arr1=explode('|',$pri_arr_ele);
			$pri_comp_arr[]=$temp_arr1[0];
			
			$temp_var1=$temp_arr1[0];
			$pri_ord_arr[$temp_var1]=$temp_arr1[1];
		}
		
		if(trim($sec_companies)!='')
		{
			$sec_arr=explode(',',$sec_companies);
		}
		 ?>

         <tr>
         <td valign="top" align="center">
		<form method="get" action="" name="day_form" style="margin:0px;">
		<table width="70%" class="border" cellspacing="0" cellpadding="5">
		<!--<tr class="left_headbg">
		<td valign="middle" align="left" width="100%" colspan="3" class="white_text">Search Comments</td>
		</tr> -->
		<?php
		$day_arr = $sql->SqlRecordMisc("esthp_tblHomeFeat","where 1=1 order by id");
		$day_count = $day_arr['count'];
		$day_data = $day_arr['Data'];
		?>
		<tr>
		<td width="124" align="right" valign="middle" class="normal_text_blue">Day :</td>
		<td width='10' align="left" valign="middle">&nbsp;</td>
		<td width="334" align="left" valign="middle" class="normal_text_blue">
		<select name="day" id="day" class="input_white" onchange="document.day_form.submit();">
		<?php
		foreach($day_data as $day_arr)
		{
		?>
		<option value="<?=$day_arr['id']?>" <?=$day_arr['id']==$day?'selected':''?>><?=$day_arr['day']?></option>
		<?php
		}
		?>
		</select>
		</td>
		</tr>
             <!-- <tr>
                <td align="left" valign="top">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">
				<input type="submit" class="btn" name="Submit" value="Search">
				
				
				</td>
              </tr> -->
			  
		</table>
		</form>
		<br/>
		&nbsp;
		</td>
		</tr>
		
		<tr>
		<td>
				
				
	
				
	<form method="post" action="" name="compForm" style="margin:0px;">
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>

              <td height="25" valign="middle" class="black_text" style="padding-left:20px;">Show main videos of the following companies: </td>

              </tr>

              <tr>

                <td valign="top" >

				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td valign="middle" align="center">
					<?php
					
					$comp_cond = "where 1=1 order by comp_name"; 						
					$comp_arr = $sql->SqlRecordMisc('esthp_tblCompanies',$comp_cond);
					$comp_count = $comp_arr['count'];
					$comp_data = $comp_arr['Data'];	
							
					if($comp_count>0)
					{
						//count($pri_arr)
					?>
					<table width="95%" border="0" cellspacing="0" cellpadding="5" class="border">
            
						<tr>
						<?php
						
						//print_r($pri_comp_arr);
					//	print_r($pri_ord_arr);
							
							
						$j=0;
						
						$t=0;
						foreach($comp_data as $comp_rec)
						{
							$checked="";
							$ord_val="";
							$test_var="";
							
							
							
						
							if(in_array($comp_rec['comp_id'],$pri_comp_arr))
							{
								$checked='checked';
								
								
								$ord_key_arr=array_keys($pri_ord_arr);
								
								//print_r($ord_key_arr);
								//die;
								
								if(in_array($comp_rec['comp_id'],$ord_key_arr))
								{
									$test_var=$comp_rec['comp_id'];
									$ord_val=$pri_ord_arr[$test_var];
								}
								
							}
							
							
							
								
									
							if($j>3)
							{
								echo "</tr><tr>";
								$j=0;
							}
						?>
	
	
							<td height="30"  align="left" class="black_text" valign="top"><input type="text" name="home_pri_ord<?=$comp_rec['comp_id']?>" class="input_white" style="width:15px;" value="<?=$ord_val?>"><input type="checkbox" name="home_pri[]" <?=$checked?> value="<?=$comp_rec['comp_id']?>">&nbsp;&nbsp;<?=$comp_rec['comp_name']?></td>

					<?php
					$j++;
					$t++;
					} 
					
					?>
					</tr>
					<tr ><td colspan='4' align="left" class="black_text" style="padding:20px;">Banner Speed: <input type="text" name="pri_speed" value="<?=$Data['pri_speed']?>">Milli Sec&nbsp;&nbsp;&nbsp;Pause Time: <input type="text" name="pri_pause" value="<?=$Data['pri_pause']?>">Milli Sec</td></tr>
									
					
					
                    </table>

					<br/>
					<input type="hidden" name="day" value="<?=$day?>">
					<input type="submit" class="btn" name="submit" value="Submit">
					<?php
					}
					else
					{
						echo "&nbsp;&nbsp;<span class='black_text'>No companies have been added yet.</span>";
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
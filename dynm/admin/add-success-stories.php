<?php

include_once("../includes/global.inc.php");

require_once(_PATH."modules/mod_admin_login.php");

include_once(_PATH."classes/class.upload.php");

include(_HTML_EDITOR_ABSOLUTE_PATH."/fckeditor.php") ;

$AuthAdmin->ChkLogin();





$page=($_REQUEST['page']!="")? $_REQUEST['page'] : 1;

$sqlError="";

$ID = "";



if(isset($_POST['Submit']) && $_POST['Submit']=="Add")

{		

	$ConArr = array();		

	$ConArr["title"] = addslashes($_POST["title"]);

	$ConArr["body"] = addslashes($_POST["body"]);

	$ConArr["body"] = addslashes($_POST["body"]);

	$displaypage = implode(",",$_POST["displayPage"]);

	if($_FILES["imagefile"]["name"] != "")

	{

		$filearr  = explode(".",$_FILES["imagefile"]["name"]);

		$filetype =  $filearr [1];

		if(strtoupper($filetype) == "PDF"  )

		{		

			$filename = time()."_".$_FILES["imagefile"]["name"];

			$filepath = _UPLOAD_FILE_PATH. $filename;

			if(move_uploaded_file($_FILES["imagefile"]["tmp_name"],  $filepath))

			{

				$ConArr["filename"] = 	$filename ;

			}	

		}		

	}	



	if(isset($_POST["status"] ))

	$ConArr["status"] =  $_POST["status"] ;

	$ConArr['add_Date'] =  time();

	$ConArr['modified_date'] = time();

	$intResult = $sql->SqlInsert('mos_tblSuccssStory',$ConArr);



	if($intResult)

	{

			$_SESSION["msg"]  = "added";

			header("location:"._ADMIN_WWWROOT."list-success-stories.php");

			die();

	}

	else

	{

	 	$sqlError=mysql_error();

	}

}

else if(isset($_POST['Submit']) && $_POST['Submit']=="Update" && isset($_POST['ID'])  && $_POST['ID'] != "")

{		



	$ConArr = array();		

	$ConArr["title"] = addslashes($_POST["title"]);

	$ConArr["body"] = addslashes($_POST["body"]);

        $displaypage = implode(",",$_POST["displayPage"]);

	$ConArr["displayPage"] = addslashes($displaypage);

	if($_FILES["imagefile"]["name"] != "")

	{

		$filearr  = explode(".",$_FILES["imagefile"]["name"]);

		$filetype =  $filearr [1];

		if( strtoupper($filetype) == "TXT"  || strtoupper($filetype) == "PDF"  )

		{		

		

			$filename = time()."_".$_FILES["imagefile"]["name"];

			$filepath = _UPLOAD_FILE_PATH. $filename;

			if(move_uploaded_file($_FILES["imagefile"]["tmp_name"],  $filepath))

			{

				$ConArr["filename"] = 	$filename ;

			}	

		}		

		if($_POST["preimage"] != "")

		{

			if(file_exists (_UPLOAD_FILE_PATH.stripslashes( $_POST["preimage"]) ))

			  unlink(_UPLOAD_FILE_PATH.stripslashes($_POST["preimage"]) );

		}

	}	



	if(isset($_POST["status"] ))

	$ConArr["status"] =  $_POST["status"] ;

	$ConArr['modified_date'] = time();

	$CondArr = " WHERE ID = '".$_POST['ID']."'";

	

	$intResult = $sql->SqlUpdate('mos_tblSuccssStory',$ConArr,$CondArr);

	if($intResult)

	{

			$_SESSION["msg"]  = "added";

			header("location:"._ADMIN_WWWROOT."list-success-stories.php");

			die();

	}

	else

	{

	 	$sqlError=mysql_error();

	}

}

		

	

	

	if(isset($_REQUEST['ID']) && ($_REQUEST['mode']=='edit'))

	{

		$ID = $_REQUEST['ID'];

		$ConArr = " WHERE ID= '$ID' "; 						

		$arrBrands = $sql->SqlSingleRecord('mos_tblSuccssStory',$ConArr);

		$count = $arrBrands['count'];

		$Data = $arrBrands['Data'];	
                $displaypage = explode(",",$Data['displayPage']);		 

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

  <tr>    <td valign="top"><?php include_once('include/header.php');?><div id="breadcrumbs"> <a href="home.php">Home</a> &raquo; <a href="add-success-stories.php">Add/Edit Success Story</a></div></td>  </tr>

  <tr>

   <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr>

     <td width="232" valign="top" class="border_left"><?php include_once('include/admin_left.php');?></td>

     <td width="14" valign="top">&nbsp;</td>

     <td valign="top">

	   <form name="frmAddArticle" action="" method="post" onsubmit="return SubmitForm(this);" enctype="multipart/form-data">

	   <input type="hidden" name="ID" value="<?=$ID?>">

	   <table width="100%" border="0" cellspacing="0" cellpadding="0">          

        <tr>

         <td height="25" valign="top" class="grey_bg"><table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td valign="top" width="25"><img src="images/heading_stare.gif" alt="" width="29" height="25"></td>

             <td><h1>Add Success Story </h1></td>

           </tr>

          </table></td>

         </tr>

          <tr>

            <td valign="top"><img src="images/spacer.gif" alt="" width="1" height="4">

			<div class="mandatory_txt" align="right">Fields marked with (<font color="#FF0000">*</font>) are mandatory fields</div>

			</td>

          </tr>

          <tr>

           <td valign="top"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">              

            <tr>

             <td width="136" height="20" align="right" valign="top" class="normal_text_blue">&nbsp;</td>

             <td width="5" align="left" valign="top">&nbsp;</td>

             <td width="363" align="left" valign="top"><input type="hidden" name="preimage" value="<?=$Data['filename']?>"></td>

            </tr>

            <tr>

             <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>Success Story   Title:</td>

             <td align="left" valign="top">&nbsp;</td>

             <td align="left" valign="top"><input name="title" type="text" class="input_white" size="48" value="<?=stripslashes($Data['title']);?>" alt="BC~DM~ article title~DM~">	</td>

            </tr>


<tr><td height="20" align="right" valign="top" colspan="3">&nbsp;</td></tr>



            <?php

				$records_per_page=1000;			

				$offset = ($page-1) * $records_per_page;

				$cond=" WHERE status='active' ";

				$orderby=" ORDER BY id ASC";

				$dest = $sql->SqlRecords("mos_tblWebpage",$cond,$orderby,$offset=0,$records_per_page);

				$count_dest= $dest['count'];

				$DataDest = $dest['Data'];		

			  ?>              

              <tr>

                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup> Display Pages:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<select name="displayPage[]" id="displayPage" size="10" class="input_white" style="width:360px;" multiple>
                       <option value="ALL" <?if(isset($displaypage))
 {
if(in_array("ALL",$displaypage))	
 echo " selected";
}
?> >ALL</option>

  	               <option value="index.html" <?if(isset($displaypage))
 {
if(in_array("index.html",$displaypage))	
 echo " selected";
}?>>Home</option>

               <?	for($i=0; $i<$count_dest; $i++)

			{ ?>         

       <option value="<?=$DataDest[$i]['pageUrl']?>"<?php
if(isset($displaypage))
 {
if(in_array($DataDest[$i]['pageUrl'],$displaypage))	
 echo " selected";
}

?>><? echo show_breadcrumbs($DataDest[$i]['id']); ?> </option>

               <?	} 



					$offer_result = $sql->SqlExecuteQuery("select * from mos_tblOffers WHERE status='active' order by id desc limit 0, 1000");

					$offer_count = $offer_result['count'];

					$offer_Data =  $offer_result['Data'];

					if( $offer_count > 0)

					{

						  for($i=0; $i<$offer_count; $i++)

						  {		

							  	$offer_row =  $offer_Data[$i] ;

							?>

	           		      <option value="<? echo $offer_row["pageUrl"];?>"<?php	if($Data['displayPage'] == $offer_row["pageUrl"] )	echo " selected";	?>><? echo "Crestech Offering >>". $offer_row["link_title"]?> </option>			

				<?	  }   

				    }   ?>

                </select>                

				</td>

              </tr>






            <tr><td height="20" align="right" valign="top" colspan="3">&nbsp;</td></tr>



              <tr>

                <td align="right" valign="top" class="normal_text_blue"><sup class="requried_sign">*</sup>PDF File:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top" class="normal_text_blue"><input type="file" name="imagefile" id="imagefile"> 

                (Only  PDF file)</td>

              </tr>





              <tr><td height="20" align="right" valign="top" colspan="3">&nbsp;</td>            </tr>

              <tr>

                <td align="right" valign="top" class="normal_text_blue">Success Story   Detail:</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top"></td>

              </tr>

			  <tr><td height="20" align="left" valign="top" colspan="3">

				<?php

		

				$body = stripslashes($Data['body']);				

				//$oFCKeditor->BasePath = _WWWROOT. '/htmleditor/' ;	// '/FCKeditor/' is the default value.

				$sBasePath = _HTML_EDITOR_PATH."/";

				$oFCKeditor = new FCKeditor('body') ;

				$oFCKeditor->BasePath	= $sBasePath ;

				$oFCKeditor->Value	= $body;

				//$oFCKeditor->ToolbarSet ="Basic";

				$oFCKeditor->Width="100%" ;

				$oFCKeditor->Height="350" ;

				$oFCKeditor->Create() ;	

				?>

			  </td></tr>

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

             <tr>

                <td align="right" valign="top" class="normal_text_blue">Status :</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">

				<input name="status" type="radio" value="active" <?php if($Data['status']=='active') echo " checked"?> <?php if($Data['status']=='') echo " checked"?>>

                  <span class="normal_text_blue">Active</span>

                  <input name="status" type="radio" value="inactive" <?php if($Data['status']=='inactive') echo " checked"?>>

                  <span class="normal_text_blue">Inactive</span></td>

              </tr>

              

              <tr>

                <td height="20" align="right" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

              </tr>

              <tr>

                <td align="left" valign="top">&nbsp;</td>

                <td align="left" valign="top">&nbsp;</td>

				<?php

				if(isset($_REQUEST['mode']) && $_REQUEST['mode']=='edit')

				{

					$btnName = "Update";

				}

				else

				{

					$btnName = "Add";

				}

				?>

                <td align="left" valign="top">

				<input type="submit" class="btn" name="Submit" value="<?=$btnName?>">

				<input type="button" name="cancel"  value="Cancel" class="btn" onClick="location.href='list-success-stories.php?page=<?=$page?>'">				

				</td>

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

    </table></td>

  </tr>

  <tr>

    <td valign="top"><?php include_once('include/footer.php');?></td>

  </tr>

</table>

</body>

</html>

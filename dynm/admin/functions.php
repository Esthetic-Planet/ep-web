<?php

include_once("global.inc.php");





function drawMainMenu()

{

	global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE status='active' ";

		$orderby=" ORDER BY displayOrder ASC";

		$webPage = $sql->SqlRecords("mos_tblMainMenu",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];

		

		if($count>0)

		{

			

			for($i=0; $i<$count; $i++)

			{

				echo '<a href="'.$Data[$i]['url'].'" class=>'.stripslashes($Data[$i]['mName']).'</a><span class="hr_line"><img src="images/nav-hr.gif" /></span>';

			}

		}

}



function getmainImages($imagename)

{}



function drawDestList()

{}







function getHomePageContent()

{

	global $sql;

		$id = 1;

		$ConArr = " WHERE id= '$id' "; 						

		$arrHomeContent = $sql->SqlSingleRecord('mos_tblHomepageContent',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];			

		if($count>0)

		{					

			echo stripslashes($Data['long_desc']);

		}

}



function getHomeTopImages()

{

		global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE 1";

		$orderby=" ORDER BY display_order";

		$webPage = $sql->SqlRecords("mos_homeTopImages",$cond,$orderby,$offset=0,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];		

		

		if($count>0)

		{

			for($i=0; $i<$count; $i++)

			{

				echo '<li><img src='._WWW_UPLOAD_IMAGE_PATH.'/home_img/homeTopImages/'.$Data[$i]['image_name'].' border="0"

				 height="95" width="708"  /></li>';

			}

		}

}



function getHomeSideImages()

{

		global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE 1";

		$orderby=" ORDER BY display_order";

		$webPage = $sql->SqlRecords("mos_homeSideImages",$cond,$orderby,$offset=0,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];		

		//print "<pre>";

		//print_r($Data);

		//print "</pre>";

		if($count>0)

		{

			echo '<ul>';

			for($i=0; $i<$count; $i++)

			{

				if($Data[$i]['image_name']!="")

				{

				echo '<li><img src='._WWW_UPLOAD_IMAGE_PATH.'/home_img/homeSideImages/'.$Data[$i]['image_name'].' border="0"

				width="140" /></li>';

				}

			}

			echo '</ul>';

		}

}







function getDestPageContent($id)

{}









function getDestSideImages($id)

{}





function getDestTopImages($id)

{

		global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE dest_id='$id' ";

		$orderby=" ORDER BY display_order";

		$webPage = $sql->SqlRecords("mos_destTopImages",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];		

		

		if($count>0)

		{

			for($i=0; $i<$count; $i++)

			{

				echo '<li>

				<img src='._WWW_UPLOAD_IMAGE_PATH.'/dest_img/DestTopImages/'.$Data[$i]['image_name'].' border="0" width="708"				 height="95" /></li>';

			}

		}

}



function drawDestMenu($destId)

{

		global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE dest_id='$destId' ";

		$orderby=" ORDER BY displayOrder";

		$webPage = $sql->SqlRecords("mos_tblDestMenu",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];		

		

		if($count>0)

		{

			

			for($i=0; $i<$count; $i++)

			{

			  if($Data[$i]['linkSection']==0){

				echo '<a href="'.stripslashes($Data[$i]['url']).'&destId='.$destId.'">'.stripslashes($Data[$i]['mName']).'</a><span class="hr_line"><img src="images/nav-hr.gif" /></span>';

				}else{

				echo '<a href="'.stripslashes($Data[$i]['url']).'">'.stripslashes($Data[$i]['mName']).'</a><span class="hr_line"><img src="images/nav-hr.gif" /></span>';

				  }

				

				

			}

			

		}

}



function getWebPageContent($id)

{

	global $sql;		

		$ConArr = " WHERE id= '$id' "; 						

		$arrHomeContent = $sql->SqlSingleRecord('mos_tblWebpage',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];			

		if($count>0)

		{			

			echo "<h2>".stripslashes($Data['title'])."</h2><p>&nbsp;</p>";	

			echo stripslashes($Data['long_desc']);

		}

}





function getBookingContent()

{

	global $sql;		

		$ConArr = " WHERE 1=1 "; 						

		$arrHomeContent = $sql->SqlSingleRecord('mos_tblDatesAndPrice',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];			

		if($count>0)

		{					

			echo stripslashes($Data['long_desc']);

		}

}







function getDateAndPriceContent()

{

	global $sql;

		$id = 1;

		$ConArr = " WHERE id= '$id' "; 						

		$arrHomeContent = $sql->SqlSingleRecord('mos_tblDatesAndPrice',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];			

		if($count>0)

		{					

			echo stripslashes($Data['long_desc']);

		}

}





##### getphotoGallery start #################

function getphotoGallery()

{}

##### getphotoGallery end #################





function drawFooterMenu()

{

	global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE status='active' ";

		$orderby=" ORDER BY displayOrder ";

		$webPage = $sql->SqlRecords("mos_tblFooterMenu",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

		$count = $webPage['count'];

		$Data = $webPage['Data'];

		$k=1;

		if($count>0)

		{

			

			for($i=0; $i<$count; $i++)

			{

				if($k==$count){

				echo '<a href="'.$Data[$i]['url'].'">'.stripslashes($Data[$i]['mName']).'</a>  ';

				}

				else{

				echo '<a href="'.$Data[$i]['url'].'">'.stripslashes($Data[$i]['mName']).'</a> |  ';

				}

				$k++;

			}

		}

}



##### getDestnations start #################

function getDestnations($page=1)

{}

##### getDestnations end #################





function getFooterText()

{

	global $sql;

		$id = 1;

		$ConArr = " WHERE 1"; 						

		$arrFooterText = $sql->SqlSingleRecord('mos_tblFooter',$ConArr);

		$count = $arrFooterText['count'];

		$Data = $arrFooterText['Data'];			

		if($count>0)

		{					

			echo stripslashes($Data['footerText']);

		}

}



################## Manage header & Footer content###############



function getheaderfooterContent($id)

{}







?>
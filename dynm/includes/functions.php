<?php
include_once("global.inc.php");

function getFilename()
{
	$str = $_SERVER["PHP_SELF"];
	$loc = strrpos($str, "/");
	$filename =  substr($str,$loc+1);
	return $filename;
}


function getFileURL()
{
	$str = $_SERVER["REQUEST_URI"];
	$loc = strrpos($str, "/");
	$filename =  substr($str,$loc+1);
	return $filename;
}




function createThumbs( $pathToImages, $pathToThumbs, $thumbWidth )

{

  // open the directory

  //$dir = opendir( $pathToImages );

// loop through it, looking for any/all JPG files:

//  while (false !== ($fname = readdir( $dir ))) {

    // parse path for the extension

   // $info = pathinfo($pathToImages . $fname);

    // continue only if this is a JPEG image

   // if ( strtolower($info['extension']) == 'jpg' )

    {

      echo "Creating thumbnail for {$fname} <br />";



      // load image and get image size

     echo $img = imagecreatefromjpeg( "$pathToImages" );die;

      $width = imagesx( $img );

      $height = imagesy( $img );



      // calculate thumbnail size

      $new_width = $thumbWidth;

      $new_height = floor( $height * ( $thumbWidth / $width ) );



      // create a new temporary image

      $tmp_img = imagecreatetruecolor( $new_width, $new_height );



      // copy and resize old image into new image

      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );



      // save thumbnail into a file

      imagejpeg( $tmp_img, "$pathToThumbs" );

    }

//  }

  // close the directory

  closedir( $dir );

}







function getCaseStudy( $recordCount=1)

{

	global $sql;

	$curpage = getPageURL();

	$id = 1;

	//$ConArr = "  where displayPage = '".$curpage."'  and status = 'active' "; 

        $ConArr = "  where FIND_IN_SET('".$curpage."',displayPage) or FIND_IN_SET('ALL',displayPage) and status = 'active' ";

	$webPage = $sql->SqlRecords("esthp_tblcasestudy",$ConArr, "Order by  rand() " ,$offset=0, $recordCount );

/*	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];		*/

	return  $webPage;

}





function getWhitePaper( $recordCount=1)

{

	global $sql;

	$curpage = getPageURL();

   

	$id = 1;

	//$ConArr = "  where status = 'active' "; 

         

        $ConArr = " where FIND_IN_SET('".$curpage."',displayPage) or FIND_IN_SET('ALL',displayPage) and status = 'active' ";

        $webPage = $sql->SqlRecords("esthp_tblWhitePaper",$ConArr, "Order by  rand() " ,$offset=0, $recordCount );

 	return  $webPage;

}





function drawMainMenu()

{

	global $sql;

	$records_per_page=100;			

	$offset = 0;

	$cond="WHERE status='active' ";

	$orderby=" ORDER BY displayOrder ASC";

	$webPage = $sql->SqlRecords("esthp_tblMainMenu",$cond,$orderby,$offset,$records_per_page);

	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];

	if($count>0)

	{

		for($i=0; $i<$count; $i++)

		{		

		    $htaccess = _PATH."/.htaccess";	

			if(getPageURL() ==  $Data[$i]['pageUrl'])

			  $class = 'class="active"';

			else

			  $class = '';

		    if(file_exists($htaccess))

			{			

				  if($Data[$i]['pageUrl'] !='')

				  {

						echo '<a href="'._WWWROOT.$Data[$i]['pageUrl'].'" $class>'.stripslashes($Data[$i]['mName']).'</a>';

				  }

				  else

				  {

						echo '<a href="'._WWWROOT.$Data[$i]['url'].'" $class>'.stripslashes($Data[$i]['mName']).'</a>';

				  }

			}

			else

			{

				  echo '<a href="'._WWWROOT.$Data[$i]['url'].'" $class>'.stripslashes($Data[$i]['mName']).'</a>';				

			}			

		}

	}

}



function getHomePageContent()

{

	global $sql;

	$id = 1;

	$ConArr = " WHERE id= '$id' "; 						

	$arrHomeContent = $sql->SqlSingleRecord('esthp_tblHomepageContent',$ConArr);

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

	$webPage = $sql->SqlRecords("esthp_homeTopImages",$cond,$orderby,$offset=0,$records_per_page);

	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];		

	

	if($count>0)

	{

		for($i=0; $i<$count; $i++)

		{

			echo '<img src='._WWW_UPLOAD_IMAGE_PATH.'/home_img/homeTopImages/'.$Data[$i]['image_name'].' border="0"  />';

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

	$webPage = $sql->SqlRecords("esthp_homeSideImages",$cond,$orderby,$offset=0,$records_per_page);

	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];		



	if($count>0)

	{

		for($i=0; $i<$count; $i++)

		{

			if($Data[$i]['image_name']!="")

			{

				echo '<div class="picture1"><img src='._WWW_UPLOAD_IMAGE_PATH.'/home_img/homeSideImages/'.$Data[$i]['image_name'].'	 /></div>';

			}

		}

	}

}



function getDestSideImages($id)

{}





function drawDestMenu($destId)



{



		global $sql;



		$records_per_page=100;			



		$offset = 0;



		$cond="WHERE dest_id='$destId' ";



		$orderby=" ORDER BY displayOrder";



		$webPage = $sql->SqlRecords("esthp_tblDestMenu",$cond,$orderby,$offset,$records_per_page);



		$count_total=$webPage['TotalCount'];



		$count = $webPage['count'];



		$Data = $webPage['Data'];		



		



		if($count>0)



		{



			



			for($i=0; $i<$count; $i++)



			{

			



			  if($Data[$i]['linkSection']==0){

			  	

					  $htaccess = _PATH."/.htaccess";	

					  if(file_exists($htaccess))

						{	

							if($Data[$i]['pageUrl'] !='')

									{

									echo '<a href="'. _WWWROOT.stripslashes($Data[$i]['pageUrl']).'">'.stripslashes($Data[$i]['mName']).'</a>';

							}else{

							echo '<a href="'. _WWWROOT.stripslashes($Data[$i]['url']).'&destId='.$destId.'">'.stripslashes($Data[$i]['mName']).'</a>';

									}

						}else{

									echo '<a href="'. _WWWROOT.stripslashes($Data[$i]['url']).'&destId='.$destId.'">'.stripslashes($Data[$i]['mName']).'</a>';

								}		

						

								

				}else{



				      echo '<a href="'. _WWWROOT.stripslashes($Data[$i]['url']).'">'.stripslashes($Data[$i]['mName']).'</a>';



				  }



				



				



			}



			



		}



}







function getWebPageContent($id)



{



	global $sql;		



		$ConArr = " WHERE id= '$id' "; 						



		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblWebpage',$ConArr);



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



		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblDatesAndPrice',$ConArr);



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



		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblDatesAndPrice',$ConArr);



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

	$webPage = $sql->SqlRecords("esthp_tblFooterMenu",$cond,$orderby,$offset,$records_per_page);

	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];

	$k=1;

	if($count>0)

	{

		for($i=0; $i<$count; $i++)

		{

			if($k==$count)

			{

				echo '<a href="'. _WWWROOT.$Data[$i]['url'].'">'.stripslashes($Data[$i]['mName']).'</a>  ';

		//echo '<a href="'._WWWROOT."/".stripslashes($Data[$i]['pageUrl']).'">'.stripslashes($Data[$i]['mName']).'</a>';

			}

			else

			{

				echo '<a href="'._WWWROOT.$Data[$i]['url'].'">'.stripslashes($Data[$i]['mName']).'</a>&nbsp;|&nbsp;';

			}

			$k++;

		}

	}

}







function getFooterText()

{

	global $sql;

	$id = 1;

	$ConArr = " WHERE 1"; 						

	$arrFooterText = $sql->SqlSingleRecord('esthp_tblFooter',$ConArr);

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





################## Manage home mete title###############



function getMetaHome()

{

	global $sql;

	$id = 1;

	$ConArr = " WHERE id= '$id' "; 	

	$arrHomeContent = $sql->SqlSingleRecord('esthp_tblHomepageContent',$ConArr);

	$count = $arrHomeContent['count'];

	$Data = $arrHomeContent['Data'];			

	return $Data;

}



################## Manage web page  mete title###############



function  getWebPagemetaTitle($id)

{



	global $sql;

	//	$id = 1;

	$ConArr = " WHERE id= '$id' "; 						

	$arrHomeContent = $sql->SqlSingleRecord('esthp_tblWebpage',$ConArr);

	$count = $arrHomeContent['count'];

	$Data = $arrHomeContent['Data'];			

	return $Data;

}



################## Manage web page  mete title###############



function getWebHeaderImage($webId,$destid)

{

global $sql;

		$id = 1;

		$ConArr = " WHERE id=$webId "; 						

		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblWebpage',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];	

		

		if($count>0)

		{					

		  if($Data['InnerTopImage']!=""){

				echo _WWWROOT.'/upload/web_img/'.stripslashes($Data['InnerTopImage']);

				}

				else{

				 getInnetDest($destid);

				}

		}

}



function getWebSideImage($webId,$destid)

{

global $sql;

		$id = 1;

		$ConArr = " WHERE id=$webId "; 						

		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblWebpage',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];	

		

		if($count>0)

		{

		   if($Data['InnerSideImage']!="")					

		   {

			echo _WWWROOT.'/upload/web_img/'.stripslashes($Data['InnerSideImage']);

			}

			else

			{

				getInnerSide($destid);

			}	

		}

}



function getWebMiddleImage($webId,$destid)

{

		global $sql;

		$id = 1;

		$ConArr = " WHERE id=$webId "; 						

		$arrHomeContent = $sql->SqlSingleRecord('esthp_tblWebpage',$ConArr);

		$count = $arrHomeContent['count'];

		$Data = $arrHomeContent['Data'];	

//print('<pre>');

	//print_r($Data);



		if($count>0)

		{

			for($i=0; $i<$count; $i++)

			{

			if($Data['InnerMiddleImage']!=""){

				echo '<li>

				<img src='._WWW_UPLOAD_IMAGE_PATH.'/web_img/'.$Data['InnerMiddleImage'].' border="0" width="708"				 height="95" /></li>';

			}

			else{

					 getDestTopImages($destid);

			   } 	

			}

		}

}



function getWebSideImages($id,$destId)

{

		global $sql;

		$records_per_page=100;			

		$offset = 0;

		$cond="WHERE web_id='$id' ";

		$orderby=" ORDER BY display_order";

		$webPage = $sql->SqlRecords("esthp_WebSideImages",$cond,$orderby,$offset,$records_per_page);

		$count_total=$webPage['TotalCount'];

	    $count = $webPage['count'];

		$Data = $webPage['Data'];		



		if($count>0)

		{

			for($i=0; $i<$count; $i++)

			{

				echo '<img src='._WWW_UPLOAD_IMAGE_PATH.'/WebSideImages/'.$Data[$i]['image_name'].' border="0"

				width="150" />';

			}

		}

	else

	{

		getDestSideImages($destId);

	}	



}



function  getClubeContent()

{

	global $sql;

	$ConArr = " WHERE 1"; 						

	$arrArticle = $sql->SqlSingleRecord('esthp_tblClubeSolitair',$ConArr);

	$count = $arrArticle['count'];

	$Data = $arrArticle['Data'];		 

	return $Data;

}





function show_submenues($catID)

{

	global $sql;

	$webPage = $sql->SqlExecuteQuery("select t1.*, count(t2.id) as children from esthp_tblWebpage t1 left join esthp_tblWebpage t2 on t2.parentid = t1.id and t2.status='active' WHERE t1.status='active'  and t1.parentId = '".$catID."' group by t1.id order by t1.id");



	$count_total=$webPage['TotalCount'];

	$count = $webPage['count'];

	$Data = $webPage['Data'];

	if($count>0)

	{

		echo '<ul>';

		for($i=0; $i<$count; $i++)

		{		

		  	$row =  $Data[$i] ;

			if( $row["children"] > 0)

			{

				echo '<li><a href="'.$row["pageUrl"].'"  class="sub">'.$row["link_title"].'</a>';

				show_submenues($row["id"]);

				echo '</li>';

			}

			else

			{

				echo '<li><a href="'.$row["pageUrl"].'">'.$row["link_title"].'</a></li>';

			}	

		}

		echo '</ul>';

	}

}



function show_breadcrumbs($cat_id, $showlink =0)

{

	global $sql;

	$str = "";

	$Page = $sql->SqlExecuteQuery("select parentId, id, link_title, pageUrl from esthp_tblWebpage  WHERE id = '".$cat_id."'");

	$count_total=$Page['TotalCount'];

	$Data = $Page['Data'];

  	$row =  $Data[0] ;

	if( $row["parentId"] == 0)

	{

		if($showlink == 1)

			return '<a href="'.$row["pageUrl"].'">'.stripslashes($row["link_title"]) .'</a>';

		else

			return stripslashes($row["link_title"]);

	}

	else

	{

		if($showlink == 1)

			$str .= show_breadcrumbs($row["parentId"],1) ." &raquo; ". '<a href="'.$row["pageUrl"].'">'.stripslashes($row["link_title"]) .'</a>';

		else

			$str .= show_breadcrumbs($row["parentId"]) ." &raquo; ".stripslashes($row["link_title"]);

	}

	return $str;	

}



function getSubLinks($catID ,  $parentId )

{

  global $sql;

  $selectCat = $catID ;

  $result = $sql->SqlExecuteQuery("select link_title, pageUrl from esthp_tblWebpage WHERE status='active'  and parentId = '".$catID."' order by id");



  $count_total=$result['TotalCount'];

  $count = $result['count'];

  $Data = $result['Data'];



	if($count == 0)

	{

		$result = $sql->SqlExecuteQuery("select link_title, id,  pageUrl from esthp_tblWebpage WHERE status='active'  and parentId = '".$parentId."' order by id");



		$count_total=$result['TotalCount'];

		$count = $result['count'];

		$Data = $result['Data'];

		$selectCat = $parentId ;

	}



	if($count > 0)

	{

	echo '<div class="dark_gray">';

	echo '<div class="heading1">Sub Links</div>';

	echo '<div class="sub_links">';

	  for($i=0; $i<$count; $i++)

	  {		

		$row =  $Data[$i] ;

		echo '<a href="'.$row["pageUrl"].'">'.$row["link_title"].'</a>';

	  }	

	 echo '</div></div>';

	}

}



function getShortDesc($parentId )

{

	global $sql;

	$result = $sql->SqlExecuteQuery("select short_desc, parentId from esthp_tblWebpage WHERE status='active'  and id = '".$parentId."' ");

	$count_total=$result['TotalCount'];

	$count = $result['count'];

	$Data = $result['Data'];

	if($count > 0)

	{

		if($Data[0]["short_desc"] != "")

			echo  stripslashes($Data[0]["short_desc"]);

		else if($Data[0]["parentId"] >0)

			getShortDesc($Data[0]["parentId"] );

	}	

}



function getPageImage($catID)

{

	global $sql;

	global $thumb;

	$path = _WWW_UPLOAD_IMAGE_PATH.'webpage_images/';

	$result = $sql->SqlExecuteQuery("select * from esthp_tblWebpageImages WHERE status='active'  and pageId = '".$catID."' order by rand() limit 0,1");



	$count_total=$result['TotalCount'];

	$count = $result['count'];

	$Data = $result['Data'];

	if($count > 0)

	{

		//$thumb->createThumbs(_UPLOAD_FILE_PATH.'webpage_images/' , _UPLOAD_FILE_PATH.'webpage_images/',425,160, $Data[0]["imageName"]);

		echo '<img src="'.$path.$Data[0]["imageName"].'" alt="" width="425" height="160" />';

	}

	else

	{

		$row = getWebPagemetaTitle($catID);

		if( $row["parentId"] != 0)

		{

			getPageImage($row["parentId"]);

		}

		else

		{

			echo '<img src="images/inside-banner.jpg" alt="" />';

		}

	}

}		

######################################  OFFERING FUNCTION ##################################

function showOffers($is_index = 1, $total_records=1000 )

{

	global $sql;

	$result = $sql->SqlExecuteQuery("select link_title, pageUrl, id from esthp_tblOffers WHERE status='active' order by id desc limit 0,".$total_records);

	$count_total=$result['TotalCount'];

	$count = $result['count'];

	$Data = $result['Data'];

	if($count > 0)

	{

		echo '<div class="dark_gray">';

		if($is_index == 0)

			echo '<div class="heading1">Crestech Offering</div>';

	

		echo '<div class="sub_links">';	

		  for($i=0; $i<$count; $i++)

		  {		

		  	$row =  $Data[$i] ;

			  $class = "";

			echo '<a href="'.$row["pageUrl"].'" '.$class.'>'.$row["link_title"].'</a>';

		  }	

		 echo '</div></div>';	

	}

}





function  getoffermetaTitle($id)

{

	global $sql;

	//	$id = 1;

	$ConArr = " WHERE id= '$id' "; 						

	$arrHomeContent = $sql->SqlSingleRecord('esthp_tblOffers',$ConArr);

	$count = $arrHomeContent['count'];

	$Data = $arrHomeContent['Data'];			

	return $Data;

}

/*

 function update_htaccess()

 {

 	global $sql;

	$myFile = "../.htaccess";

	$fh = fopen(	$myFile, 'r') or die("can't open file");

	$theData = fread($fh,filesize($myFile));

	fclose($fh);

	$theData=explode("#dynamic_rewrite_rule",$theData);

	$theData=trim($theData[0]);

	

    $main_cond="WHERE status='active' ";

	$main_orderby=" ORDER BY id ASC";

	$main_menu = $sql->SqlRecords("esthp_tblWebpage",$main_cond,$main_orderby);



	$main_count_total=$main_menu['TotalCount'];

	$main_count = $main_menu['count'];

	$mainData = $main_menu['Data'];

	$mainpageUrls .= "rewriterule ^index.html$  index.php [T=application/x-httpd-shtml] [R=301,L]";



	for($j=0;$j < $main_count;$j++)

	{		 	

		if($mainData[$j]['pageUrl'] !='')

		{						

			 $mainpageUrls .= "

rewriterule ^".trim($mainData[$j]['pageUrl'])."$  webpage.php?page=".$mainData[$j]['id']." [T=application/x-httpd-shtml] [R=301,L]";

		}

 	}



	$offerpageUrls = "";



    $offer_cond="WHERE status='active' ";

	$offer_orderby=" ORDER BY id ASC";

	$offer_menu = $sql->SqlRecords("esthp_tblOffers",$main_cond,$main_orderby);



	$offer_count_total = $offer_menu['TotalCount'];

	$offer_count = $offer_menu['count'];

	$offerData = $offer_menu['Data'];



	for($j=0;$j < $offer_count;$j++)

	{		 	

		if($offerData[$j]['pageUrl'] !='')

		{						

			 $offerpageUrls .= "

rewriterule ^".trim($offerData[$j]['pageUrl'])."$  offers.php?offer_id=".$offerData[$j]['id']." [T=application/x-httpd-shtml] [R=301,L]";

		}

 	}



//echo $strEbookUrls; exit;

$theData .="

#dynamic_rewrite_rule

RewriteEngine on

#webpage page Urls

".$webpageUrls."

#main page Urls

".$mainpageUrls."

#offer page Urls 

".$offerpageUrls."

#footer page Urls

".$footerpageUrls."

#article page Urls

".$articlepageUrls."";

	

	$fh = fopen($myFile, 'w') or die("can't open file");

	if(fwrite($fh, $theData))

	$msg="<span style=\"color:#009933\">Links Updated</span>";

	else

	$msg="<span style=\"color: #FF6600\">Links Not Updated</span>";

 }


*/


 function update_htaccess()
 {
 	global $sql;
	$myFile = "../.htaccess";
	$fh = fopen(	$myFile, 'r') or die("can't open file");
	$theData = fread($fh,filesize($myFile));
	fclose($fh);
	
	$theData = explode("#dynamic_rewrite_rule",$theData);
	
	$theData = trim($theData[0]); // keep all the text before tag '#dynamic_rewrite_rule' as it is
	
	
	//////////// create url strings for various sections /////////////////////

	$categoryUrls = "";
	
    $cat_cond="where cat_status='active' order by cat_id asc";
	$cat_arr = $sql->SqlRecordMisc("esthp_tblProdCat",$cat_cond);
	$cat_count = $cat_arr['count'];
	$cat_data = $cat_arr['Data'];

	foreach($cat_data as $cat_record)
	{		 	
		if(trim($cat_record['cat_page_url']) !='')
		{						
			 $categoryUrls .= "\nrewriterule ^".trim($cat_record['cat_page_url'])."$  category.php?cat_id=".$cat_record['cat_id']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}
	
	
	
	$categoryUserUrls = "";
	
    $cat_cond="where cat_status='active' order by cat_id asc";
	$cat_arr = $sql->SqlRecordMisc("esthp_tblUserCat",$cat_cond);
	$cat_count = $cat_arr['count'];
	$cat_data = $cat_arr['Data'];

	foreach($cat_data as $cat_record)
	{		 	
		if(trim($cat_record['cat_page_url']) !='')
		{						
			 $categoryUserUrls .= "\nrewriterule ^".trim($cat_record['cat_page_url'])."$  user_category.php?cat_id=".$cat_record['cat_id']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}
	
	
	
	$clinicUrls = "";
	
    $cat_cond="where IsActive='t' order by UserId";
	$cat_arr = $sql->SqlRecordMisc("esthp_tblUsers",$cat_cond);
	$cat_count = $cat_arr['count'];
	$cat_data = $cat_arr['Data'];

	foreach($cat_data as $cat_record)
	{		 	
		if(trim($cat_record['user_page_url']) !='')
		{						
			 $clinicUrls .= "\nrewriterule ^".trim($cat_record['user_page_url'])."$  clinic.php?cat_id=".$cat_record['UserId']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}
	
	
	
	
	$videoUrls = "";
	
    $vid_cond="where vid_status='active' order by vid_id asc";
	$vid_arr = $sql->SqlRecordMisc("esthp_tblVideos",$vid_cond);
	$vid_count = $vid_arr['count'];
	$vid_data = $vid_arr['Data'];

	foreach($vid_data as $vid_record)
	{		 	
		if(trim($vid_record['vid_page_url']) !='')
		{						
			 $videoUrls .= "\nrewriterule ^".trim($vid_record['vid_page_url'])."$  video.php?vid_id=".$vid_record['vid_id']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}
	
	
	$pageUrls="";
	
	$page_cond = "where page_status='active' order by id asc";
	$page_arr = $sql->SqlRecordMisc("esthp_tblWebpage",$page_cond);
	$page_count = $page_arr['count'];
	$page_data = $page_arr['Data'];
	
	$pageUrls .= "\nrewriterule ^index.html$  index.php [T=application/x-httpd-shtml] [R=301,L]";

	foreach($page_data as $page_record)
	{		 	
		if(trim($page_record['page_url'])!='')
		{						
			 $pageUrls .= "\nrewriterule ^".trim($page_record['page_url'])."$  webpage.php?page_id=".$page_record['id']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}
	
	
	////////////// url string creation ends /////////////////
	
	$theData .="\n#dynamic_rewrite_rule";
	$theData .="\nRewriteEngine on";
	
	$theData .="\n\n#User Category Urls\n";
	$theData .="\n$categoryUserUrls";
	
	$theData .="\n\n#Clinic Urls\n";
	$theData .="\n$clinicUrls";
	
	$theData .="\n\n#Product Category Urls\n";
	$theData .="\n$categoryUrls";
	
	$theData .="\n\n#Video Urls\n";
	$theData .="\n$videoUrls";
	
	$theData .="\n\n#Page Urls\n";
	$theData .="\n$pageUrls";
	

	
	//echo $theData;
	//die;
	
	
	
	$fh = fopen($myFile, 'w') or die("can't open file");
	if(fwrite($fh, $theData))
	$msg="<span style=\"color:#009933\">Links Updated</span>";
	else
	$msg="<span style=\"color: #FF6600\">Links Not Updated</span>";
	
 }
 
 

 function shorten_Strng_by_words($str, $wordsreturned)
{
	$array = explode(" ", $str);
	if (count($array)<=$wordsreturned)
	{
		$retval = $str;
	}
	else
	{
		array_splice($array, $wordsreturned);
		$retval = implode(" ", $array)." ...";
	}
	return $retval;
}


 function ShortenText($text,$chars)  // shorten text by chars but show complete word in last
 {
       if(strlen($text)>$chars)
	   {
	    $text = $text." ";
        $text = substr($text,0,($chars+1));
        $text = substr($text,0,strrpos($text,' '));
        $text = $text."...";
        
		}
		return $text;
 }

//echo ShortenText("This is a great site for watching videos online",14); 


 

 function getIndexPageImage($catID)

{

	global $sql;

	$path = _WWW_UPLOAD_IMAGE_PATH.'webpage_images/';

	$result = $sql->SqlExecuteQuery("select * from esthp_tblWebpageImages WHERE status='active'  and pageId = '".$catID."' order by rand() limit 0,1");



	$count_total=$result['TotalCount'];

	$count = $result['count'];

	$Data = $result['Data'];

	if($count > 0)

	{

		echo $path.$Data[0]["imageName"];

	}

	else

	{

		echo "images/sercurity-icon.gif";

	}

}



   function  getBanner( $is_index = 0 )

   {

	    global $sql;

		

		$curpage = getPageURL();

 		$query = "select * from esthp_tblbanners where displayPage = '".$curpage."'  and status='active'  order by modified_date desc";

		$query_news = $sql->SqlExecuteQuery($query , 0 ,1);

		$count = $query_news['count'];

		$Data = $query_news['Data'];

		if($count > 0) 

		{

			$row =  $Data[0];

			  list($img_width, $img_height, $img_type, $img_attr) = @getimagesize("upload/banner_images/".$row['filename']); 

		       

                                   if( $img_width > 214 )

                                               $width_str =  "width='214' ";

                                       else        

                                               $width_str =  "";


 									if( $img_width > 342 )

                                               $width_str1 =  "width='342' height='136' ";

                                       else        

                                               $width_str1 =  "";

			if( $is_index  == 1)

			{

			

			

		

		

										

			

			

			

			

			?>

				<div id="banner_area"><a href="<?=$row["linkurl"]?>" target="_blank"><img src="upload/banner_images/<?=$row["filename"]?>" alt=""  border="0"  <?=$width_str1;?>/></a></div>				

	<?	} 

			else

			{?>

			<div id="right_banner"><a href="<?=$row["linkurl"]?>" target="_blank"><img src="upload/banner_images/<?=$row["filename"]?>" alt=""  border="0" <?=$width_str;?>/></a></div>	

  <?		}

		} 

	    else

 	    { 

			if( $is_index  == 1)

			{

				echo '<div id="banner_area"><img src="upload//banner-area.gif" alt="" /></div>';

			}

			else

			{

				echo '<div id="right_banner"><img src="images/banner-box.gif" alt=""   border="0"/></div>';

			}

  	    }

	}
	
	
	


function getProdCategoriesAdmin()
{
	global $sql;
	$result = $sql->SqlExecuteQuery("select * from esthp_tblProdCat order by cat_name");
	$count = $result['count'];
	$Data = $result['Data']; 
	return $Data;
}


	
function add_slashes_arr($content_arr)
	{
		if(is_array($content_arr))
		{
			if(get_magic_quotes_gpc()==0)
			{
				foreach($content_arr as $key=>$value)
				{
					$content_arr[$key]=addslashes($value);
				}
			}
			return $content_arr;
		}
	}
	

function escape_XMLstring($text_string)
{
	$text_string=str_replace('&','&amp;',$text_string);
	$text_string=str_replace('<','&lt;',$text_string);
	$text_string=str_replace('>','&gt;',$text_string);
	$text_string=str_replace('"','&quot;',$text_string);
	$text_string=str_replace("'",'&apos;',$text_string);
	return $text_string;
}

function createRSS()
{
	global $sql;
	// read article at http://www.downes.ca/cgi-bin/page.cgi?post=56
	// http://support.microsoft.com/kb/308060
	//http://cyber.law.harvard.edu/rss/rss.html
	
	/*
	
	Character Name 	Entity Reference 	Character Reference 	Numeric Reference
	Ampersand 	&amp; 	& 	&#38;#38;
	Left angle bracket 	&lt; 	< 	&#38;#60;
	Right angle bracket 	&gt; 	> 	&#62;
	Straight quotation mark 	&quot; 	" 	&#39;
	Apostrophe 	&apos; 	' 	&#34;
	
	*/



	$vid_arr=$sql->SqlRecordMisc('esthp_tblVideos',"where vid_status='active' order by vid_date_add desc limit 15");
	$vid_count=$vid_arr['count'];
	$vid_data=$vid_arr['Data'];
	
	$str='<?xml version="1.0" encoding="UTF-8"?>
	<rss version="2.0"
		xmlns:content="http://purl.org/rss/1.0/modules/content/"
		xmlns:wfw="http://wellformedweb.org/CommentAPI/"
		xmlns:dc="http://purl.org/dc/elements/1.1/"
		xmlns:atom="http://www.w3.org/2005/Atom"
		xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
		xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
		>
		<channel>
		<title>City Life TV</title>
		<atom:link href="http://www.esthp.ca/esthp.rss" rel="self" type="application/rss+xml" />
		<link>http://www.esthp.ca</link>
		<description>Broadcasting your city in HD</description>
		<language>en</language>
		';


	
	foreach($vid_data as $vid_rec)
	{
	
		$cat_arr=$sql->SqlSingleRecord('esthp_tblProdCat',"where cat_id='".$vid_rec['vid_category']."'");
		$cat_count=$cat_arr['count'];
		$cat_data=$cat_arr['Data'];
		
		$str.='<item>
		';
		$str.='<title>';
		$str.=escape_XMLstring($vid_rec['vid_title']); // htmlentities($vid_data['vid_title'],ENT_QUOTES); will not work coz it replaces ' by  &#039;
		$str.='</title>
		';
		$str.='<link>';
		$str.=escape_XMLstring(_WWWROOT.$vid_rec['vid_page_url']); // htmlentities($vid_data['vid_title'],ENT_QUOTES); will not work coz it replaces ' by  &#039;
		$str.='</link>
		';

		$str.='<pubDate>';
		$str.=escape_XMLstring(date('D, d M Y H:i:s O', strtotime($vid_rec['vid_date_add']))); 
		$str.='</pubDate>
		';
		
		$str.='<category>';
		$str.=escape_XMLstring($cat_data['cat_name']);
		$str.='</category>
		';
		$str.='<description>';
		$str.=escape_XMLstring($vid_rec['vid_description']);
		$str.='</description>
		';
		$str.='</item>
	';
	
	}
	
	$str.='</channel>
	</rss>';
	
	return $str;
}



 

?>


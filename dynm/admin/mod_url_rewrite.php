<?
include_once("../includes/global.inc.php");
require_once(_PATH."/modules/mod_admin_login.php");

if($_REQUEST['Submit']=="Submit")
{
	$myFile = "../.htaccess";
	$fh = fopen(	$myFile, 'r') or die("can't open file");
	$theData = fread($fh,filesize($myFile));
	fclose($fh);
	$theData=explode("#dynamic_rewrite_rule",$theData);
	$theData=trim($theData[0]);
	
    $main_cond = " WHERE status='active' and pageUrl not like 'http://%'  ";
	$main_orderby=" ORDER BY id ASC";
	$main_menu = $sql->SqlRecords("mos_tblWebpage",$main_cond,$main_orderby,0,10000);

	$main_count_total=$main_menu['TotalCount'];
	$main_count = $main_menu['count'];
	$mainData = $main_menu['Data'];

	$mainpageUrls .= "rewriterule ^index.html$  index.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
rewriterule ^testimonial.html$  testimonial.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
 rewriterule ^case-study.html$  case-study.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
 rewriterule ^news-letter.html$  news-letter.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
 rewriterule ^white-paper.html$  white-paper.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
 rewriterule ^success-story.html$  success-story.php [T=application/x-httpd-shtml] [R=301,L]";
	$mainpageUrls .= "
 rewriterule ^news.html$  news.php [T=application/x-httpd-shtml] [R=301,L]";

	for($j=0;$j < $main_count;$j++)
	{		 	
		if($mainData[$j]['pageUrl'] !='')
		{						
			 $mainpageUrls .= "
rewriterule ^".trim($mainData[$j]['pageUrl'])."$  webpage.php?page=".$mainData[$j]['id']." [T=application/x-httpd-shtml] [R=301,L]";
		}
 	}

	$offerpageUrls = "";
    $offer_cond= " WHERE status='active' and pageUrl not like 'http://%'  ";
	$offer_orderby=" ORDER BY id ASC";
	$offer_menu = $sql->SqlRecords("mos_tblOffers",$main_cond,$main_orderby,0,10000);
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


	$caseStudyUrls = "";
    $case_cond = " WHERE status='active' ";
	$case_orderby=" ORDER BY ID ASC";
	$case_menu = $sql->SqlRecords("mos_tblcasestudy",$case_cond,$case_orderby,0,10000);
	$case_count_total = $case_menu['TotalCount'];
	$case_count = $case_menu['count'];
	$caseData = $case_menu['Data'];
	for($j=0;$j < $case_count;$j++)
	{		 	
		 $caseStudyUrls .= "
rewriterule ^case-study".trim($caseData[$j]['ID']).".html$  case-studies.php?caseid=".$caseData[$j]['ID']." [T=application/x-httpd-shtml] [R=301,L]";
 	}
	

	$newsLetterUrls = "";
    $case_cond=" WHERE status='active' ";
	$case_orderby=" ORDER BY ID ASC";
	$case_menu = $sql->SqlRecords("mos_tblnewsLetter",$case_cond,$case_orderby,0,10000);
	$case_count_total = $case_menu['TotalCount'];
	$case_count = $case_menu['count'];
	$caseData = $case_menu['Data'];
	for($j=0;$j < $case_count;$j++)
	{		 	
		 $newsLetterUrls .= "
rewriterule ^news-letter".trim($caseData[$j]['ID']).".html$  news-letters.php?caseid=".$caseData[$j]['ID']." [T=application/x-httpd-shtml] [R=301,L]";
 	}
	

	$whitePaperUrls = "";
    $case_cond=" WHERE status='active' ";
	$case_orderby=" ORDER BY ID ASC";
	$case_menu = $sql->SqlRecords("mos_tblWhitePaper",$case_cond,$case_orderby,0,10000);
	$case_count_total = $case_menu['TotalCount'];
	$case_count = $case_menu['count'];
	$caseData = $case_menu['Data'];
	for($j=0;$j < $case_count;$j++)
	{		 	
		 $whitePaperUrls .= "
rewriterule ^white-paper".trim($caseData[$j]['ID']).".html$  white-papers.php?caseid=".$caseData[$j]['ID']." [T=application/x-httpd-shtml] [R=301,L]";
 	}
	

	$sucessStoryUrls = "";
    $case_cond=" WHERE status='active' ";
	$case_orderby=" ORDER BY ID ASC";
	$case_menu = $sql->SqlRecords("mos_tblSuccssStory",$case_cond,$case_orderby,0,10000);
	$case_count_total = $case_menu['TotalCount'];
	$case_count = $case_menu['count'];
	$caseData = $case_menu['Data'];
	for($j=0;$j < $case_count;$j++)
	{		 	
		 $sucessStoryUrls .= "
rewriterule ^success-story".trim($caseData[$j]['ID']).".html$  success-stories.php?caseid=".$caseData[$j]['ID']." [T=application/x-httpd-shtml] [R=301,L]";
 	}
	

/////////////////////////// Merging  all Urls //////////////////////////////////////////////////////////
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
#caseStudy Urls
".$caseStudyUrls."
#news Letter Urls
".$newsLetterUrls ."
#white Paper Urls".
$whitePaperUrls ."
#sucess Story Urls".
$sucessStoryUrls."
#article page Urls
".$articlepageUrls."";


	
	$fh = fopen($myFile, 'w') or die("can't open file");
	if(fwrite($fh, $theData))
	$msg="<span style=\"color:#009933\">Links Updated</span>";
	else
	$msg="<span style=\"color: #FF6600\">Links Not Updated</span>";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<?
$myFile = "../.htaccess";
$fh = fopen($myFile, 'r');
$newData = fread($fh, filesize($myFile));
fclose($fh);
@chmod($myFile,0777);
//echo $theData;
?>
<form name="form1" action="" method="post">
  <table>
    <tr>
      <td colspan="3" align="center"><?=$msg?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><textarea name="file_text" id="file_text" rows="30" cols="100" readonly="readonly" style="border:1px solid #999999; font-family:Arial, Helvetica, sans-serif; font-size:10px; color:#666666;"><?=$newData?>
</textarea></td>
    </tr>
    <tr>
      <td colspan="3"><input type="submit" name="Submit" value="Submit" /></td>
    </tr>
  </table>
</form>
</body>
</html>

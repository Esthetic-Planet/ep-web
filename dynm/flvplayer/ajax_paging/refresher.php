<? /*
This file is to be included from the main index file for ajax call.
-When you want to use ajax instead of a simple HREF Tag, please comment linkAsAjax() line */


if(is_file( '../includes/global.inc.php'))
{
	require_once( '../includes/global.inc.php');
}


$id=$_REQUEST['id'];
$member_arr=$sql->SqlSingleRecord("esthp_tblAjaxPaging","where id='".$id."'");
$member_count=$member_arr['count'];
$vmember_data=$member_arr['Data'];



require_once _PATH.'ajax_paging/config_paging.php';
require_once _PATH.'ajax_paging/CLS_DB.php';





/* Link Controllers */
$pagespergroup = 5;
$limitpp = 2; 
$spacer = ' | ';

//no need to edit anything beyond this line except for all query variables:
//change $query, $orderby to reflect your own; change $fetchnow->DESCRIPTION to suite your own column name from you own database

$startat = 0;
$mul=0;

foreach($_REQUEST as $key=>$val)
{
	$$key=$val;
}


$query = "select * from esthp_tblAjaxPaging";


$where="";

if(!empty($_REQUEST['id']))
{
	$where=" where id='".$_REQUEST['id']."'";
}
else
{
	$where=" where id>0";
}

$query.=$where;


$orderby=" order by name";






////////// code for href paging starts ///////////////////////////////

/*

echo "code for href paging<br/><br/>"; 

$newPaging = new CLS_PAGING($query, $orderby, $limitpp, '?testkey=testvalue'); // for href type of paging


$res = $newPaging->showPageRecs($startat);
echo $newPaging->showFirst('&laquo;')."&nbsp;".
	 $newPaging->showPrev('prev', $mul)."&nbsp;".
	 $newPaging->showPages($spacer, $pagespergroup, $mul)."&nbsp;".
	 $newPaging->showNext('next', $mul)."&nbsp;".
	 $newPaging->showLast('&raquo;');


echo "<BR><BR>";

while ($fetchnow = mysql_fetch_object($res)) {
	echo $newPaging->getRecNum($ctr, $mul).".) ".$fetchnow->name."<br>";
	$ctr++;
}

echo "<BR><BR>";

//showFirst, showPrev, showNext, showLast, showPages are optional functions
echo $newPaging->showFirst('&laquo;')."&nbsp;".
	 $newPaging->showPrev('prev', $mul)."&nbsp;".
	 $newPaging->showPages($spacer, $pagespergroup, $mul)."&nbsp;".
	 $newPaging->showNext('next', $mul)."&nbsp;".
	 $newPaging->showLast('&raquo;');
	 
////////// code for href paging ends ///////////////////////////////
	 
	 
	 
	echo "<br/><br/>code for ajax paging<br/><br/>"; 
	 
	 */


////////// code for ajax paging starts ///////////////////////////////








$newPaging = new CLS_PAGING($query, $orderby, $limitpp, ""); // for href type of paging


$newPaging->linkAsAjax('post', 'container', _WWWROOT.'ajax_paging/refresher.php', "id=".$_REQUEST['id'].'&name='.$_REQUEST['name']); // for ajax type paging


$res = $newPaging->showPageRecs($startat);



echo $newPaging->showFirst('&laquo;')."&nbsp;".
	 $newPaging->showPrev('prev', $mul)."&nbsp;".
	 $newPaging->showPages($spacer, $pagespergroup, $mul)."&nbsp;".
	 $newPaging->showNext('next', $mul)."&nbsp;".
	 $newPaging->showLast('&raquo;');


?>

		  		  
		  <?php
		  $t=0;
		  
		  
		 while ($fetchnow = mysql_fetch_array($res)) 
		  {
		  
		  ?>
		  <div ><?php echo $newPaging->getRecNum($t, $mul) ?>. <?php echo ShortenText($fetchnow['name'],25);?></div>
		  <?php
		  
		  $t++;

		  }

		  ?>


<?php

//echo "<BR><BR>";

//showFirst, showPrev, showNext, showLast, showPages are optional functions
	
	 

	 
	 


?>


<?php

echo $newPaging->showFirst('&laquo;')."&nbsp;".
	 $newPaging->showPrev('prev', $mul)."&nbsp;".
	 $newPaging->showPages($spacer, $pagespergroup, $mul)."&nbsp;".
	 $newPaging->showNext('next', $mul)."&nbsp;".
	 $newPaging->showLast('&raquo;');
	 
	 
	 ////////// code for ajax paging ends ///////////////////////////////
	 ?>

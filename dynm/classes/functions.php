<?php

die("not in use");

//include($DOCUMENT_ROOT."/classes/config.php");

include($_SERVER['DOCUMENT_ROOT']."/community/classes/config.php");

include($root_dir."/classes/classdb.php");

global $dbcon;

$dbcon = new DatabaseConnection($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['dbname'] );

if ( ! $dbcon->connectDB() )

{

     echo $dbcon->show_error();

     exit;

}

##################JAVASCRIPT FUNCTIONS#################3

function showJavaScriptMessage($mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

           </script>";

};

function MessageNClose($mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

             window.close();

           </script>";

};

function showJavaScriptURL($url)

{

     echo "<script>

           document.location = \"$url\";

           </script>";

};

function AlertJavaScript($mesg)

{

     echo "<script>

           alert(\"".$mesg."\");

           </script>";

};

function showJavaScriptURLMessage($url,$mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

             document.location = \"$url\";

           </script>";

};

function showJavaScriptURLMesg($url,$mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

             top.location = \"$url\";

           </script>";

};

function showJavaScriptMSgParent()

{

     echo "<script>

             opener.window.history.go(0);

             window.close();

           </script>";

};

function showJavaScriptAlertMSgParent($mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

             opener.window.history.go(0);

             window.close();

           </script>";

};

function showJavaScriptNavigateMessage($pg,$mesg)

{

     echo "<script>

             alert(\"".$mesg."\");

             window.history.go($pg);

           </script>";

};



### Create drop down list ##



function CreateCombo($arr,$name,$default="",$arrval="",$others="class='listBox'",$size=1)

{

    if(empty($arrval))

    	$arrval=$arr;



    if($size>1)

    	$multiple=" multiple ";

    $str="<select name=\"$name\" size=\"$size\" $multiple $others>";

    for($i=0;$i<count($arr);$i++)

    {

     if($arrval[$i]=="$default")

     	$selected="selected";

     else

     	$selected="";

     $str.="<option value=\"$arrval[$i]\" $selected>$arr[$i]</option>";

    }



    $str.="</select>";

    echo $str;

}



function CreateCombo1($arr,$dis,$val,$name,$default,$size=1,$others="class='listBox'")

{



    $str="<select name=\"$name\" size=\"$size\" $others>";

    for($i=0;$i<count($arr);$i++)

    {

     if($arr[$i][$val]=="$default")

     	$selected="selected";

     else

     	$selected="";

     $str.="<option value=\"".$arr[$i][$val]."\" $selected>".stripslashes($arr[$i][$dis])."</option>";

    }



    $str.="</select>";

    echo $str;

}







########### MASTER ADMIN SECTION ################

function verifyMasterAdmin($username,$password)

{

global $dbcon;

$retval=false;

$query="select * from community_admin where username='$username' and password=('$password')";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getbanner()

{

global $dbcon;

$retval=false;

$query="select * from community_banner";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getlink()

{

global $dbcon;

$retval=false;

$query="select * from community_link order by lname";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getlinkbypage($start,$records_per_page)

{

global $dbcon;

$retval=false;

$query="select * from community_link order by lname limit $start,$records_per_page";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getbannerbyid($id)

{

global $dbcon;

$retval=false;

$query="select * from community_banner where bid='$id'";

if($dbcon->execute_query($query))

 $retval=$dbcon->fetch_one_record();

else

 $dbcon->show_error();

return $retval;



}



function getlinksbysectionId($sid)

{

global $dbcon;

$retval=false;

$query="select * from community_link where section_id='$sid' order by lname";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getwebpages()

{

global $dbcon;

$retval=false;

$query="select * from community_webpage order by pname";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getbizcardsbyid($id)

{

	  global $dbcon;

	  $retval=false;

	  $query="select * from community_businesscard where category='$id' and valid=1 order by date desc";

		 if($dbcon->execute_query($query))

			  $retval=$dbcon->fetch_records();

		 else

			  $dbcon->show_error();

			   return $retval;

}



function getpersonalbyid1($id)

{

global $dbcon;

$retval=false;

$query="select * from community_personal where pcategory='$id' and valid=1";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getpersonalbypid($id)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`date`,'%W, %M %d, %Y') as date from community_personal where pid='$id'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getallpersonals()

{

global $dbcon;

$retval=false;

$query="select * from community_personal";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getallpersonalsbypage($start,$records_per_page)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`date`,'%W, %M %d, %Y') as date from community_personal limit $start,$records_per_page";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getpersonalbypage($id,$start,$records_per_page,$order,$way)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`date`,'%W, %M %d, %Y') as date from community_personal where pcategory='$id' and valid=1 order by '$order' $way limit $start,$records_per_page";



 if($dbcon->execute_query($query))

	 $retval=$dbcon->fetch_records();

   else

	 $dbcon->show_error();

return $retval;

}



function getbizcardbypage($id,$start,$records_per_page)

{

global $dbcon;

$retval=false;

$query="select * from community_businesscard where category='$id' and valid=1 order by date desc limit $start,$records_per_page";

 if($dbcon->execute_query($query))

   $retval=$dbcon->fetch_records();

 else

   $dbcon->show_error();

return $retval;

}

function getallwebpagesbyid($id)

{

	   global $dbcon;

	   $retval=false;

	   $query="select * from community_webpage where wid='$id'";

		if($dbcon->execute_query($query))

	   $retval=$dbcon->fetch_one_record();

	   else

	   $dbcon->show_error();

	   return $retval;

}

function getwebpagesbyfile($filename)

{

	   global $dbcon;

	   $retval=false;

	   $query="select * from community_webpage where pfile='$filename'";

	   if($dbcon->execute_query($query))

	   $retval=$dbcon->fetch_one_record();

	   else

	   $dbcon->show_error();

	   return $retval;

}

function getlinkbyid($id)

{

	 global $dbcon;

	 $retval=false;

	 $query="select * from community_link where lid='$id'";

	 if($dbcon->execute_query($query))

	 $retval=$dbcon->fetch_one_record();

	 else

	 $dbcon->show_error();

	 return $retval;

}

function getsectionname($id){

switch($id){

case "1":

	echo "Sponsor";

	break;



case "2":

	echo "Information";

	break;



case "3":

	echo "Business Directory";

	break;



case "4":

	echo "Bergenlist Search";

	break;



case "5":

	echo "Bergen Info";

	break;



case "6":

	echo "Fun in Bergen";

	break;



case "7":

	echo "Bergenlist.com";

	break;



case "8":

	echo "About Us";

	break;

case "9":

	echo "terms of use";

	break;

}

}

function getpersonalcatname($id){

switch($id){

case "1":

	echo "men seeking women";

	break;



case "2":

	echo "women seeking men";

	break;



case "3":

	echo "seeking friends";

	break;



case "4":

	echo "alternative life style";

	break;



}

}



function getadmin()

{

global $dbcon;

$retval=false;

$query="select * from community_admin";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getpaypalsetting()

{

global $dbcon;

$retval=false;

$query="select * from community_paypal";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



############################FORUM############################

function getallorder()

{

global $dbcon,$PHP_SELF;

$query="select * from forum_forums order by  fororder desc";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getallforumcategories()

{

global $dbcon,$PHP_SELF;

$query="select * from forum_categories order by catname";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getallforum()

{



global $dbcon,$PHP_SELF;

$query="select * from forum_forums order by forumname";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getallforumbypage($start,$records_per_page)

{



global $dbcon,$PHP_SELF;

$query="select * from forum_forums order by fororder limit $start,$records_per_page";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function getforumbyforumno($num)

{



global $dbcon,$PHP_SELF;

$query="select * from forum_forums where forumno='$num'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function Modulegetuserbyid($tablename,$catid)

{

  global $dbcon;

  $query="select * from $tablename where userid='$userid'";

  if($dbcon->execute_query($query))

  	$retval=$dbcon->fetch_one_record();

  else

  	$dbcon->show_error();

  	return $retval;

}



function getallforumuserbypage($start,$records_per_page)

{

  global $dbcon;

  $retval=false;

  $query="select *,DATE_FORMAT(`userdob`,'%M %d %Y') as userdob from forum_users  order by userid desc limit $start,$records_per_page";

	if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}

function getallforumcategoriesbyorderid($id)

{

global $dbcon,$PHP_SELF;

$query="select * from forum_categories where catorder='$id'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function getforumsnewsletterbyid($id)

{

global $dbcon,$PHP_SELF;

$query="select * from forum_newsletter_messages where msg_id='$id'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function getforumuser()

 {



   global $dbcon;

   $retval=false;

   $query="select * from forum_users ";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;

}



function getforumdetailsbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select *,DATE_FORMAT(`registerdate`,'%W, %M %d, %Y') as registerdate  from forum_users where userid='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}



function getallforumuserbyid($id)

{



  global $dbcon;

     $retval=false;

     $query="select *,UNIX_TIMESTAMP(lastaccesstime) as lastaccesstime,DATE_FORMAT(`registerdate`,'%W, %M %d, %Y') as registerdate ,DATE_FORMAT(`userdob`,'%W, %M %d, %Y') as userdob from forum_users where usernumber='$id'";



       if($dbcon->execute_query($query))

              $retval=$dbcon->fetch_one_record();

  	else

  	        $dbcon->show_error();

            return $retval;

}

function getnoofpost($userid)

{

   global $dbcon;

   $retval=false;

   $query="SELECT * FROM forum_public WHERE userfrom='$userid'";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;



}



function getallforumbycat($cat)

{



global $dbcon,$PHP_SELF;

$query="select * from forum_forums where cat='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getuserright($userid)

 {

 global $dbcon,$PHP_SELF;

 $query="select * from forum_userrights where userid='$userid'";

 if($dbcon->execute_query($query))

 $retval=$dbcon->fetch_one_record();

 else

 $dbcon->show_error();

 return $retval;



 }



###### UPDATE CATEGORIES #############

function getallcategory($catTable)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getallcategory1($catTable)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where maincat=0 order by cat";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}









function getallcategorybymaincat($catTable,$cat)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where maincat='$cat' order by cat";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getallcategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_classified_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getalleventscategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_events_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getbusinesscardsbycatid($catTable,$catid)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where category='$catid' and valid=1";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getpersonalbyid($catTable,$id)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where pcategory='$id' and valid=1";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}

function Moduleupdatecat($editcatid,$cat,$payment,$maincat,$catTable,$restrict,$txtamount)

{

global $dbcon,$PHP_SELF;

$regulardate=convertdate($lifespan);

$query="update $catTable set cat='$cat',maincat='$maincat',payment_required='$payment',`restrict`='$restrict',amount='$txtamount' where catid='$editcatid'";

return $dbcon->execute_query($query) or die(mysql_error());

}



function Moduleupdatecat1($editcatid,$cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$regulardate=convertdate($lifespan);

$query="update $catTable set cat='$cat',maincat='$maincat',`restrict`='$restrict' where catid='$editcatid'";

return $dbcon->execute_query($query) or die(mysql_error());

}

function Moduleupdatebizcat($editcatid,$cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$query="update $catTable set cat='$cat',maincat='$maincat',`restrict`='$restrict' where catid='$editcatid'";

return $dbcon->execute_query($query) or die(mysql_error());

}





function Moduleupdatebizsite($editcatid,$cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$regulardate=convertdate($lifespan);

$query="update $catTable set cat='$cat',maincat='$maincat',`restrict`='$restrict' where catid='$editcatid'";

return $dbcon->execute_query($query) or die(mysql_error());

}



function Moduleaddcat($cat,$payment,$maincat,$catTable,$restrict,$txtamount)

{

global $dbcon,$PHP_SELF;

$query="insert into $catTable (`restrict`,cat,payment_required,maincat,amount) values ( '$restrict','$cat','$payment','$maincat','$txtamount')";

return $dbcon->execute_query($query) or die(mysql_error());

}

function Moduleaddcat1($cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$query="insert into $catTable(cat,maincat,`restrict`) values('$cat','$maincat','$restrict')";

return $dbcon->execute_query($query) or die(mysql_error());

}

function Moduleaddbizcat($cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$query="insert into $catTable(cat,maincat,`restrict`) values('$cat','$maincat','$restrict')";

return $dbcon->execute_query($query) or die(mysql_error());

}





function Moduleaddbizsite($cat,$maincat,$catTable,$restrict)

{

global $dbcon,$PHP_SELF;

$regulardate=convertdate($lifespan);

$query="insert into $catTable(cat,maincat,`restrict`) values('$cat','$maincat','$restrict')";

return $dbcon->execute_query($query) or die(mysql_error());

}









function Moduledeletecat($editcatid, $catTable)

{

global $dbcon,$PHP_SELF;

$query="delete from $catTable where catid='$editcatid'";

return $dbcon->execute_query($query) or die(mysql_error());

}

function Moduledeletesubcat($catid, $catTable)

{

global $dbcon,$PHP_SELF;

$query="delete from $catTable where maincat='$catid'";

return $dbcon->execute_query($query) or die(mysql_error());

}



function Moduleshowoptionlinks($tablename,$maincat=0,$spacer)

{

	global $dbcon,$PHP_SELF;

	$query="select * from $tablename where maincat='$maincat' order by cat";



	$dbcon->execute_query($query) or die(mysql_error());

	$CAT=$dbcon->fetch_records();

	if($CAT)

	{

        if(!isset($spacer))

        $spacer="<br>";

        else

        $spacer.="|--";

	    for($i=0;$i<count($CAT);$i++)

		{

		  echo "$spacer <a href=\"$PHP_SELF?page=categories&editcatid=".$CAT[$i][catid]."\">".stripslashes($CAT[$i][cat])."</a>";

		  Moduleshowoptionlinks($tablename,$CAT[$i][catid],$spacer);

	    }



   }



}

function showoption($tablename,$default,$maincat=0,$spacer="")

{

	global $dbcon;

	$query="select * from $tablename where maincat='$maincat' order by cat";

	$dbcon->execute_query($query) or die(mysql_error());

	$CAT=$dbcon->fetch_records();

	if($CAT)

	{

        if(!isset($spacer))

        	$spacer="";

        else

        	$spacer.="|--";



	    for($i=0;$i<count($CAT);$i++)

		{



				if($CAT[$i][catid]==$default)

				$selected="selected";

				else

				$selected="";



				echo "<option value=\"".$CAT[$i][catid]."\" $selected>".$spacer.stripslashes($CAT[$i][cat])."</option>";

				showoption($tablename,$default,$CAT[$i][catid],$spacer);





	    }



   }



}



function Moduleshowoption($tablename,$default,$maincat=0,$spacer="")

{

	global $dbcon;

	$query="select * from $tablename where maincat='$maincat' order by cat";

	$dbcon->execute_query($query) or die(mysql_error());

	$CAT=$dbcon->fetch_records();

	if($CAT)

	{

        if(!isset($spacer))

        	$spacer="";

        else

        	$spacer.="|--";



	    for($i=0;$i<count($CAT);$i++)

		{

		  if($CAT[$i][catid]==$default)

		  	$selected="selected";

		  else

		  	$selected="";



          echo "<option value=\"".$CAT[$i][catid]."\" $selected>".$spacer.stripslashes($CAT[$i][cat])."</option>";

		  showoption($tablename,$default,$CAT[$i][catid],$spacer);

	    }



   }



}

function Modulegetcatbyid($tablename,$catid)

{

  global $dbcon;

  $query="select * from $tablename where catid='$catid'";

  if($dbcon->execute_query($query))

  	$retval=$dbcon->fetch_one_record();

  else

  	$dbcon->show_error();

  	return $retval;

}

function Modulegetcatbyid1($tablename,$catid)

{

  global $dbcon;

  $query="select * from $tablename where catorder='$catid'";

  if($dbcon->execute_query($query))

  	$retval=$dbcon->fetch_one_record();

  else

  	$dbcon->show_error();

  	return $retval;

}

function Moduledisplaycategory($tablename,$listname,$selected=0,$others="",$no_top=0)

{

   echo "<select name=\"$listname\" $others>";

   if($no_top==0){

   echo "<option value=\"0\">-----------  TOP LEVEL -------------</option>";

   }

   Moduleshowoption($tablename,$selected,$maincat=0,$spacer="");

   echo "</select>";



}

function RegularDisplaycategory($tablename,$listname,$selected=0,$others="")

{

   echo "<select name=\"$listname\" $others>";

   Moduleshowoption($tablename,$selected,$maincat=0,$spacer="");

   echo "</select>";



}





function getParentCat($tablename,$catid,$ARR=array()){

	global $dbcon,$PHP_SELF;

	$query="select * from $tablename where catid='$catid'";

	//echo $query;

	$dbcon->execute_query($query);

	$retval=$dbcon->fetch_one_record();

	if($retval){

			$ARR[]="<a href='$PHP_SELF?id=".$retval[catid]."'><b>".$retval[cat].'</b></a> &raquo;';

			getParentCat($tablename,$retval[maincat],$ARR);

	}

	else

	{

	    $ARR=array_reverse($ARR);

	    echo "<a href='classified.php'><b>Classified Home</b></a> &raquo;";

		for($i=0;$i<count($ARR);$i++){

			echo $ARR[$i];

		}

	}

}





function getParentCatevents($tablename,$catid,$ARR1=array()){

	global $dbcon,$PHP_SELF;

	$query="select * from $tablename where catid='$catid'";



	$dbcon->execute_query($query);

	$result=$dbcon->fetch_one_record();

	if($result){

			$ARR1[]="<a href='$PHP_SELF?catid=".$result[catid]."'><b>".$result[cat].'</b></a> &raquo;';

			getParentCatevents($tablename,$result[maincat],$ARR1);

	}

	else

	{

	    $ARR1=array_reverse($ARR1);

	    echo "<a href='show_events.php'><b>Events Home</b></a> &raquo;";

		for($i=0;$i<count($ARR1);$i++){

			echo $ARR1[$i];

		}

	}

}





function getParentCatbiz($tablename,$catid,$ARR1=array()){

	global $dbcon,$PHP_SELF;

	$query="select * from $tablename where catid='$catid'";



	$dbcon->execute_query($query);

	$result=$dbcon->fetch_one_record();

	if($result){

			$ARR1[]="<a href='$PHP_SELF?catid=".$result[catid]."'><b>".$result[cat].'</b></a> &raquo;';

			getParentCatbiz($tablename,$result[maincat],$ARR1);

	}

	else

	{

	    $ARR1=array_reverse($ARR1);

	    echo "<a href='bizsite.php'><b>Business sites Home</b></a> &raquo;";

		for($i=0;$i<count($ARR1);$i++){

			echo $ARR1[$i];

		}

	}

}







function getParentCatbizcard($tablename,$catid,$ARR1=array()){

	global $dbcon,$PHP_SELF;

	$query="select * from $tablename where catid='$catid'";



	$dbcon->execute_query($query);

	$result=$dbcon->fetch_one_record();

	if($result){

			$ARR1[]="<a href='$PHP_SELF?id=".$result[catid]."'><b>".$result[cat].'</b></a> &raquo;';

			getParentCatbizcard($tablename,$result[maincat],$ARR1);

	}

	else

	{

	    $ARR1=array_reverse($ARR1);

	    echo "<a href='bizcards.php'><b>Business cards Home</b></a> &raquo;";

		for($i=0;$i<count($ARR1);$i++){

			echo $ARR1[$i];

		}

	}

}



function getFeaturedList()

{

 global $dbcon;

  $query="select * from community_classified where valid=1 and featured=1";

	if($dbcon->execute_query($query))

	$retval=$dbcon->fetch_records();

	else

	$dbcon->show_error();

  return $retval;

}

########### GET DATE IN REGULAR FORMAT ######

############ CONVERTS INTO YYYY-MM-DD #######



function convertdate($date)

{

	$tmpvar=split('/',$date);

	if(!empty($tmpvar[2]) && ($tmpvar[0]) && ($tmpvar[1]))

	{

		$regular_date=$tmpvar[2]."-".$tmpvar[1]."-".$tmpvar[0];



	}

	return $regular_date;

}





function convertdateRev($date)

{

	$tmpvar=split('-',$date);

	if(!empty($tmpvar[2]) && ($tmpvar[0]) && ($tmpvar[1]))

	{

		$regular_date=$tmpvar[1].'/'.$tmpvar[2].'/'.$tmpvar[0];



	}

	return $regular_date;

}

##############USER MANAGEMENT ##########

function verifyUser($email,$password)

{

global $dbcon;

$retval=false;

$query="select * from community_user_register where valid=1 and email='$email' and password=md5('$password') ";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function verifyUserinvalid($email,$password)

{

global $dbcon;

$retval=false;

$query="select * from community_user_register where  email='$email' and password=md5('$password') and valid=0";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

function getuserbyemail($email)

  {

      global $dbcon;

	  $retval=false;

	  $query="select * from community_user_register where email='$email'";

	  	   if($dbcon->execute_query($query))

	     $retval=$dbcon->fetch_one_record();

	   else

	     $dbcon->show_error();

   return $retval;

   }

###################################user management admin####################

function getalluserbyid($id)

 {



  global $dbcon;

 	  $retval=false;

 	  $query="select * from community_user_register where uid='$id'";

  	  	   if($dbcon->execute_query($query))

 	     $retval=$dbcon->fetch_one_record();

 	   else

 	     $dbcon->show_error();

   return $retval;



 }





 function getalluserby()

  {



   global $dbcon;

  	  $retval=false;

  	  $query="select * from community_user_register";

   	  	   if($dbcon->execute_query($query))

  	     $retval=$dbcon->fetch_records();

  	   else

  	     $dbcon->show_error();

    return $retval;



 }





 function getalluserbypage($start,$records_per_page)

 {

   global $dbcon;

   $retval=false;

   $query="select * from community_user_register order by uid desc limit $start,$records_per_page";

 	if($dbcon->execute_query($query))

      $retval=$dbcon->fetch_records();

    else

      $dbcon->show_error();

    return $retval;

}





##############CLASSIFIED AND BIZZCARDS MANAGEMENT ##########



function getbusinesscarduser()

 {



   global $dbcon;

   $retval=false;

   $query="select * from community_businesscard";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;

}

function getallbusinesscarduserbypage($start,$records_per_page)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_businesscard order by id desc limit $start,$records_per_page";

	if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}

function getbusinesscarduserdetailsbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_businesscard where id='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}





 function getuserclassifiedbyid($id)

  {

      global $dbcon;

	  $retval=false;

	  $query="select *,DATE_FORMAT(`submitdate`,'%W %d %M %Y') as submitdate from community_classified where id='$id'";



	  	   if($dbcon->execute_query($query))

	     $retval=$dbcon->fetch_one_record();

	   else

	     $dbcon->show_error();

   return $retval;

   }







function getclassifieduser()

 {



   global $dbcon;

   $retval=false;

   $query="select * from community_classified ";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;

}



function getclassifiedbypage($id,$start,$records_per_page,$order,$way)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`submitdate`,'%W, %M %d, %Y') as submitdate from community_classified where category='$id'  and valid=1 order by $order $way limit $start,$records_per_page";

 if($dbcon->execute_query($query))

	 $retval=$dbcon->fetch_records();

   else

	 $dbcon->show_error();

return $retval;

}







function getclassifiedbypagefeatuer($start,$records_per_page)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`submitdate`,'%W %M %d %Y') AS submitdate from community_classified where featured=1 and valid=1 order by submitdate desc limit $start,$records_per_page";

 if($dbcon->execute_query($query))

	 $retval=$dbcon->fetch_records();

   else

	 $dbcon->show_error();

return $retval;

}



function getallclassifieduserbypage($start,$records_per_page)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_classified  order by id desc limit $start,$records_per_page";

	if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}





function getclassifieduserdetailsbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_classified where category='$id' and valid=1";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}

function getclassifieddetailsbyIdadmin($id)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_classified where id='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}

function getclassifieddetailsbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select *,DATE_FORMAT(`submitdate`,'%W, %M %d, %Y') as submitdate from community_classified where id='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}

function getallcategoryclassfi()

{

global $dbcon,$PHP_SELF;

$query="select * from community_classified_category where maincat=0 order by cat";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}







function getallclassifiedcategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_classified_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function getallclassifiedbymaincat($catid)

       {

        global $dbcon,$PHP_SELF;

		$query="select * from community_classified_category where maincat='$catid'";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_records();

		else

		$dbcon->show_error();

        return $retval;



       }



       function geteventssbycatid($catTable,$catid)

	   {

	   global $dbcon,$PHP_SELF;

	   $query="select * from $catTable where catid='$catid' and valid=1";

	   if($dbcon->execute_query($query))

	   $retval=$dbcon->fetch_records();

	   else

	   $dbcon->show_error();

	   return $retval;

}



function getallfeaturedclassified()

    {

        global $dbcon,$PHP_SELF;

		$query="select *,DATE_FORMAT(`submitdate`,'%W %M %d %Y') AS submitdate from community_classified where featured=1 and valid=1 order by submitdate desc";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_records();

		else

		$dbcon->show_error();

        return $retval;



       }

function getallfeaturedclassifiedbyid($id)

    {

        global $dbcon,$PHP_SELF;

		$query="select *,DATE_FORMAT(`submitdate`,'%W %M %d %Y') AS submitdate from community_classified where id='$id' and featured=1 and valid=1 order by submitdate desc ";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_one_record();

		else

		$dbcon->show_error();

        return $retval;



       }



#############################EVENT MANAGEMENT ADMIN###################################

function geteventdetailsbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select *,DATE_FORMAT(`date_of_event`,'%W, %M %d, %Y') as date_of_event from community_event where id='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}



function getalleventuserbypage($start,$records_per_page)

{

  global $dbcon;

  $retval=false;

  $query="select *,DATE_FORMAT(`date_of_event`,'%W %M %d %Y') as date_of_event from community_event order by id desc limit $start,$records_per_page";

	if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}



function geteventuser()

 {



   global $dbcon;

   $retval=false;

   $query="select * from community_event ";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;

}





function geteventdetailsbyIdadmin($id)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_event where id='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}





function getallfromclassbyemail($email)

  {

       global $dbcon;

	   $retval=false;

	   $query="select *,DATE_FORMAT(`submitdate`,'%W %M %d %Y') as submitdate from community_classified where email='$email' and valid=1";



	   if($dbcon->execute_query($query))

	            $retval=$dbcon->fetch_records();

		else

		        $dbcon->show_error();

	            return $retval;

 }



function getallfrompersonalbyemail($email)





  {

         global $dbcon;

  	   $retval=false;

  	   $query="select *,DATE_FORMAT(`date`,'%W %M %d %Y') as date from community_personal where email='$email' and valid=1";

  	   if($dbcon->execute_query($query))

  	            $retval=$dbcon->fetch_records();

  		else

  		        $dbcon->show_error();

  	            return $retval;

  }





  function getallcategoryevent()

  {

  global $dbcon,$PHP_SELF;

  $query="select * from community_events_category where maincat=0";

  if($dbcon->execute_query($query))

  $retval=$dbcon->fetch_records();

  else

  $dbcon->show_error();

  return $retval;

  }

#######################################BUSINESS CARDS################################

function getallbusinesscardcategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_business_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}





function getallbusinesscardbymaincat($catid)

       {

        global $dbcon,$PHP_SELF;

		$query="select * from community_business_category where maincat='$catid'";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_records();

		else

		$dbcon->show_error();

        return $retval;



       }



######################################BUSINESS SITES MANAGEMENT############################

function getbusinesssites()

 {



   global $dbcon;

   $retval=false;

   $query="select * from community_url";

     if($dbcon->execute_query($query))

            $retval=$dbcon->fetch_records();

	else

	        $dbcon->show_error();

            return $retval;

}





function getallbusinesssitesuserbypage($start,$records_per_page)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_url order by uid desc limit $start,$records_per_page";

	if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_records();

   else

     $dbcon->show_error();

   return $retval;

}



function getbusinesssitesbyId($id)

{

  global $dbcon;

  $retval=false;

  $query="select * from community_url where uid='$id'";

 if($dbcon->execute_query($query))

     $retval=$dbcon->fetch_one_record();

   else

     $dbcon->show_error();

   return $retval;

}

function getbusinesssitesbycatid($catTable,$catid)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where catid='$catid' and valid=1";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}



function getallbizsitebymaincat($catid)

       {

        global $dbcon,$PHP_SELF;

		$query="select * from community_business_site_category where maincat='$catid'";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_records();

		else

		$dbcon->show_error();

        return $retval;



       }

function getallbusinesssitescategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_business_site_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}



function getbusinesssitebypage($catid,$start,$records_per_page)

	   {

	   global $dbcon;

	   $retval=false;

	   $query="select * from community_url where catid='$catid' and valid=1 limit $start,$records_per_page";

	    if($dbcon->execute_query($query))

	   	 $retval=$dbcon->fetch_records();

	      else

	   	 $dbcon->show_error();

	   return $retval;

}

function getallbizcategory($catTable)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where maincat=0 order by cat";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}





#############################EVENT MANAGEMENT###################################



 function getevents($catid)



    {

        global $dbcon;

	    $retval=false;

	    $query="select *,DATE_FORMAT(`date_of_event`,'%W %M %d %Y') as date_of_event  from community_event where catid='$catid'";

	    if($dbcon->execute_query($query))

	          $retval=$dbcon->fetch_records();

	    else

	         $dbcon->show_error();

  	    return $retval;





    }







  /*  function getalleventbyemail($email,$pass)

	  {

	      global $dbcon;

	      $retval=false;

		  	    $query="select * from community_event where email='$email' and password='$pass'";

		  	    if($dbcon->execute_query($query))

		  	          $retval=$dbcon->fetch_records();

		  	    else

		  	         $dbcon->show_error();

	  	    return $retval;



   } */



   function getalleventsbymaincat($catid)

       {

        global $dbcon,$PHP_SELF;

		$query="select * from community_events_category where maincat='$catid'";

		if($dbcon->execute_query($query))

		$retval=$dbcon->fetch_records();

		else

		$dbcon->show_error();

        return $retval;



       }



       function geteventsbypage($catid,$start,$records_per_page)

	   {

	   global $dbcon;

	   $retval=false;

	   $query="select *,DATE_FORMAT(`date_of_event`,'%W, %M %d, %Y') as date_of_event from community_event where catid='$catid' and valid=1 limit $start,$records_per_page";

	    if($dbcon->execute_query($query))

	   	 $retval=$dbcon->fetch_records();

	      else

	   	 $dbcon->show_error();

	   return $retval;

}



function geteventsbyid($catTable,$catid)

{

global $dbcon,$PHP_SELF;

$query="select * from $catTable where catid='$catid' and valid=1";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}







function geteventscategorybyid($cat)

{

global $dbcon,$PHP_SELF;

$query="select * from community_events_category where catid='$cat'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_one_record();

else

$dbcon->show_error();

return $retval;

}

###################PERSONAL MANAGEMENT##############################





function getpersonalbyemailpass($email)

  {

      global $dbcon;

      $retval=false;

	  	    $query="select * from community_personal where email='$email'";

	  	    if($dbcon->execute_query($query))

	  	          $retval=$dbcon->fetch_records();

	  	    else

	  	         $dbcon->show_error();

  	    return $retval;



   }



############BANNER SECTION#############

function GetBannersback($position)

 {

 	 global $dbcon, $_SESSION,$wwwroot;

     $strsession="start_banner".$position;

     if(!session_is_registered($strsession))

     {

     	$$strsession=0;

     	session_register($strsession);

     	$_SESSION[$strsession]=0;

     }

     else

     {

     	++$_SESSION[$strsession];

     }



	 $query="SELECT COUNT(*) AS rand_row FROM supermart_ads  where position='$position'";

	 $dbcon->execute_query($query);

	 $TOTAL=$dbcon->fetch_one_record();

	 if($_SESSION[$strsession] >=$TOTAL[rand_row])

	 {

	 	$_SESSION[$strsession]=0;

	 }





	 $query="SELECT * FROM supermart_ads  where position='$position' LIMIT $_SESSION[$strsession], 1";



	 $dbcon->execute_query($query);

	 $IMAGE=$dbcon->fetch_one_record();

	 if($IMAGE)

	 {

	 if($IMAGE[position]=="top")

		  $retval="<a target=\"_blank\" href=\"$IMAGE[link]\"><img src=\"$wwwroot/banner/$IMAGE[image]\" border=0 alt=\"\" width=\"438\" height=\"60\"></a>";

	 else

		  $retval="<a href=\"$IMAGE[link]\"><img src=\"$wwwroot/banner/$IMAGE[image]\" border=0 alt=\"\" width=\"88\" height=\"31\"></a>";

	 }



    return $retval;





 }





########## BANNER SECTION ##########



function getbanners()

{

   global $dbcon;

   $retval="false";

   $query="select *  from community_ads";

   if($dbcon->execute_query($query))

      	$retval=$dbcon->fetch_records();

   else

   		$dbcon->show_error();



   return $retval;

}



function getbannersbypage($start,$records_per_page)

{

   global $dbcon;

   $retval="false";

   $query="select *  from community_ads limit $start,$records_per_page";

   if($dbcon->execute_query($query))

      	$retval=$dbcon->fetch_records();

   else

   		$dbcon->show_error();



   return $retval;

}

function getbannersbyid($id)

{

   global $dbcon;

   $retval="false";

   $query="select *  from community_ads where id='$id'";

   if($dbcon->execute_query($query))

      	$retval=$dbcon->fetch_one_record();

   else

   		$dbcon->show_error();



   return $retval;

}



function GetBannersbyPosition($position)

 {

     global $dbcon, $_SESSION,$wwwroot;

     $strsession="start_banner".$position;

     if(!session_is_registered($strsession))

     {

     	$$strsession=0;

     	session_register($strsession);

     	$_SESSION[$strsession]=0;

     }

     else

     {

     	++$_SESSION[$strsession];

     }



	 $query="SELECT COUNT(*) AS rand_row FROM community_ads where position='$position' and start_dt <=now() and end_dt >now()";

	 $dbcon->execute_query($query) or die(mysql_error());

	 $TOTAL=$dbcon->fetch_one_record();

	 if($_SESSION[$strsession] >=$TOTAL[rand_row])

	 {

	 	$_SESSION[$strsession]=0;

	 }





	 $query="SELECT * FROM community_ads where position='$position' and start_dt <=now() and end_dt >now() LIMIT $_SESSION[$strsession], 1";

	  $dbcon->execute_query($query) or die(mysql_error());

	 $IMAGE=$dbcon->fetch_one_record();



	 $update_imp="update community_ads set no_of_imp=no_of_imp+1  where id='$IMAGE[id]'";

	 $dbcon->execute_query($update_imp);



	 if($IMAGE)

	 {

	  $target=$IMAGE[target];

	 if(!empty($IMAGE[aff_code]))

	 	 	$retval=$IMAGE[aff_code];

	 else

	 {

		 if($IMAGE[position]=="top")

			  $retval="<a target=\"$target\" href=\"$wwwroot/hits.php?url=".urlencode($IMAGE[link])."&imgid=$IMAGE[id]\"><img src=\"$wwwroot/banner/$IMAGE[banner_image]\" border=0 alt=\"\" width=\"438\" height=\"60\"></a>";

		 else if($IMAGE[position]=="middle")

		 	  $retval="<a target=\"$target\" href=\"$wwwroot/hits.php?url=".urlencode($IMAGE[link])."&imgid=$IMAGE[id]\"><img src=\"$wwwroot/banner/$IMAGE[banner_image]\" border=0 alt=\"\" width=\"200\" height=\"60\"></a>";

		 else

		 	  $retval="<a target=\"$target\" href=\"$wwwroot/hits.php?url=".urlencode($IMAGE[link])."&imgid=$IMAGE[id]\"><img src=\"$wwwroot/banner/$IMAGE[banner_image]\" border=0 alt=\"\" width=\"88\" height=\"31\"></a>";



		}



	 }









   return $retval;







 }



function counthits($imgid)

{

   global $dbcon;

   $retval="false";

   $query="update community_ads set no_of_hits=no_of_hits+1 where id='$imgid'";

   if($dbcon->execute_query($query))

   {

   }

   else

   		$dbcon->show_error();



}





























############ SEND MAIL ###################

function sendMail($to,$subject,$message,$from,$file,$type)

{



// $type = 4 = send message as (html) with attachment

// $type = 3 = send message as (html) with (no) attachment

// $type = 2 = send message as (text) with attachment

// $type = 1 = send message as (text) with (no) attachment

// $to = who the mail is going to

// $subject = this message subject

// $message = the mail message to send

// $from = who is sending this message (also = Reply-To)

// $file = path to a file to attach to this message



        if(($type==2)||($type==4))

        {

        $content=fread(fopen($file,"r"),filesize($file));

        $content=chunk_split(base64_encode($content));

        $uid=strtoupper(md5(uniqid(time())));

        $name=basename($file);

        }

        $header="From:$from\n";

        $header.="Reply-To:$from\n";

        $header.="X-Priority: 3 (low)\n";

        $header.="X-Mailer: <Ya-Right Mail Server>\n";

        $header.="MIME-Version: 1.0\n";



        if(($type==2)||($type==4))

        {

        $header.="Content-Type:multipart/mixed;boundary=$uid\n\n";

        $header.="This is a mulipart message in mime format\n\n";

        $header.="--$uid\n";

        }



        if(($type==1)||($type==2)){

        $header.="Content-Type: text/plain; charset=\"ISO-8859-1\"\n";

        }



        if(($type==3)||($type==4))

        {

        $header.="Content-Type: text/html; charset=\"ISO-8859-1\"\n";

        }

        $header.="Content-Transfer-Encoding: 8bit\n\n";

        $header.="$message\n\n";

        if(($type==2)||($type==4))

        {

        $header.="--$uid\n";

        $header.="Content-Type:application/octet-streamname=\"$name\"\n";

        $header.="Content-Transfer-Encoding: base64\n";

        $header.="Content-Disposition:attachment;filename=\"$name\"\n\n";

        $header.="$content\n\n";

        $header.="--$uid--\n";

        }

        @mail($to,$subject,"",$header);

        return true;

}







###################################SEARCH##############################

function searchpersonal($txtsearch,$txtinsearch)

{

global $dbcon;

$retval=false;

$query="select *,DATE_FORMAT(`date`,'%W, %M %d, %Y') as date from community_personal where pcategory='$txtinsearch' and valid=1 and title LIKE '%$txtsearch%' or pinfo LIKE '%$txtsearch%'";

if($dbcon->execute_query($query))

$retval=$dbcon->fetch_records();

else

$dbcon->show_error();

return $retval;

}





##################################################





function traverse2($root, $depth, $sql,$selected_val) 

{ 



     $row=0; 



     while ($acat = mysql_fetch_array($sql)) 

     { 

	



          if ($acat['parentCatId'] == $root) 

          { 

			//print_r($acat);

               print "<option value='" . $acat['pageCatId'] . "'";

			if($selected_val==$acat['pageCatId'] )

				print " selected";

			print ">"; 



               $j=0; 



               while ($j<$depth) 



               {     



                     print "&nbsp;&nbsp;";



                    $j++; 



               } 



               if($depth>0)



               {



                 print "|- ->";



               }



               print $acat['pageCat_title'] . "</option>"; 



               @mysql_data_seek($sql,0); 



               traverse2($acat['pageCatId'], $depth+1,$sql,$selected_val); 



                



          } 



          $row++; 



          @mysql_data_seek($sql,$row); 



           



     } 



} 





?>
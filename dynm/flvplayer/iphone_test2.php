<?php include_once("mobile_detect/mdetect.php");

//Instantiate the object to do our testing with.
$uagent_obj = new uagent_info();

//Let's detect an iPhone.
//This will return a 1 for true or 0 for false.
$iPhone = $uagent_obj->DetectIphone();


echo $iPhone;

echo "<br/>";

echo   $user_agent= $_SERVER['HTTP_USER_AGENT'];


if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))
{
	// yes
}

?>

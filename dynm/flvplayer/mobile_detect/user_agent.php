<?php
include_once("mdetect.php");

//Instantiate the object to do our testing with.
$uagent_obj = new uagent_info();

//Let's detect an iPhone.
//This will return a 1 for true or 0 for false.
$iPhone = $uagent_obj->DetectIphone();

//Do some logic with it now, such as print it.
print("<p>You're using an iPhone: ".$iPhone."</p>");

//You might also want to print out the user agent string.
$agent = $uagent_obj->Get_Uagent();
print("<p>Your user agent string: <br /> ".$agent."</p>");


// Detects if the current device is an iPhone.
$uagent_obj->DetectIphone();

// Detects if the current device is an iPod Touch.
$uagent_obj->DetectIpod();

// Detects if the current device is an iPhone or iPod Touch.
$uagent_obj->DetectIphoneOrIpod());





// Detects if the current browser is on an Android-powered device.
$uagent_obj->DetectAndroid();

// Detects if the current browser is WebKit-based on 
//   an Android-powered device.
$uagent_obj->DetectAndroidWebKit();


// Detects if the current browser is the Nokia S60 Open Source Browser.
$uagent_obj->DetectS60OssBrowser();

// Detects if the current device is any Symbian OS-based device,
//   including older S60, Series 70, Series 80, Series 90, and UIQ, 
//   or other browsers running on these devices.
$uagent_obj->DetectSymbianOS();


// Detects if the current browser is a Windows Mobile device.
$uagent_obj->DetectWindowsMobile();


// Detects if the device is a BlackBerry.
$uagent_obj->DetectBlackBerry();

// Detects if the device is specifically a BlackBerry Touch
// device, such as the Storm 1 or 2.
$uagent_obj->DetectBlackBerryTouch();


// Detects if the current browser is on a Palm WebOS device.
$uagent_obj->DetectPalmWebOS();

// Detects if the current browser is on a PalmOS device.
$uagent_obj->DetectPalmOS();


/* 
if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod'))
{
	// yes
}

*/

?>

<?php

ob_start();
session_start();
global $Config ;

// SECURITY: You must explicitelly enable this "connector". (Set it to "true").
$Config['Enabled'] = true ;

//$Config['UserFilesPath'] = 'http://dnd.com/esthetic_planet/upload';
//$Config['UserFilesAbsolutePath'] = '/opt/lampp/htdocs/esthetic_planet/upload';

$Config['UserFilesPath'] = 'http://www.mosaic-service-demo.com/esthetic_planet/upload';
$Config['UserFilesAbsolutePath'] = '/home/mosaicse/public_html/esthetic_planet/upload';

//$Config['UserFilesPath'] = 'http://localhost/esthetic_planet/upload';
//$Config['UserFilesAbsolutePath'] = '/opt/lampp/htdocs/esthetic_planet/upload';


$Config['AllowedExtensions']['File']	= array() ;
$Config['DeniedExtensions']['File']		= array('php','php3','php5','phtml','asp','aspx','ascx','jsp','cfm','cfc','pl','bat','exe','dll','reg','cgi') ;

$Config['AllowedExtensions']['Image']	= array('jpg','gif','jpeg','png') ;
$Config['DeniedExtensions']['Image']	= array() ;

$Config['AllowedExtensions']['Flash']	= array('swf','fla') ;
$Config['DeniedExtensions']['Flash']	= array() ;

?>
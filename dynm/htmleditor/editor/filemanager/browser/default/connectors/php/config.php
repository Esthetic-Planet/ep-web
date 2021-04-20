<?php
/*
 * FCKeditor - The text editor for internet
 * Copyright (C) 2003-2005 Frederico Caldeira Knabben
 *
 * Licensed under the terms of the GNU Lesser General Public License:
 * 		http://www.opensource.org/licenses/lgpl-license.php
 *
 * For further information visit:
 * 		http://www.fckeditor.net/
 *
 * "Support Open Source software. What about a donation today?"
 *
 * File Name: config.php
 * 	Configuration file for the File Manager Connector for PHP.
 *
 * File Authors:
 * 		Frederico Caldeira Knabben (fredck@fckeditor.net)
 */
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

$Config['AllowedExtensions']['Media']	= array('swf','fla','jpg','gif','jpeg','png','avi','mpg','mpeg') ;
$Config['DeniedExtensions']['Media']	= array() ;

?>
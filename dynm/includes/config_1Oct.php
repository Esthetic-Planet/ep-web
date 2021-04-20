<?php
$sitename="Esthetic Planet";
$metadata="";
$metadescription="";



//echo $_SERVER['SERVER_NAME'];

// ROOT DIRECTORY
############ General ############################

	//if(!defined(_WEBSITE_NAME))	
	//	define("_WEBSITE_NAME","http://localhost/esthetic_planet");
		
		if(!defined(_WEBSITE_NAME))	
		define("_WEBSITE_NAME","http://192.168.5.29/pierre/esthetic_planet/development/");
		
		
	if(!defined(_PATH))	
		define("_PATH",$_SERVER['DOCUMENT_ROOT']."/pierre/esthetic_planet/development/");		
		
	if(!defined(_CURRENTDIR)	)
		define("_CURRENTDIR", "/");		
		
	if(!defined(_CLASS_PATH))	
		define("_CLASS_PATH",$_SERVER['DOCUMENT_ROOT']."/pierre/esthetic_planet/development/classes/");		
	
	if(!defined(_WWWROOT))	
		define("_WWWROOT","http://".$_SERVER['HTTP_HOST']."/pierre/esthetic_planet/development/");
		
	if(!defined(_IMAGE_PATH))
	define("_IMAGE_PATH",_WWWROOT."/images/");
		
	if(!defined(_CSS_PATH))
		define("_CSS_PATH",_WWWROOT."/style/");	
			
############  Site Back  End ############################					
	if(!defined(_ADMIN_WWWROOT))	
		define("_ADMIN_WWWROOT",_WWWROOT."admin/");
		
	if(!defined(_ADMIN_PATH))	
		define("_ADMIN_PATH",_PATH."admin/");
			
	if(!defined(_ADMIN_IMAGE_PATH))
		define("_ADMIN_IMAGE_PATH",_WWWROOT."admin/images/");
	
	if(!defined(_ADMIN_CSS_PATH))
		define("_ADMIN_CSS_PATH",_WWWROOT."admin/style/");	


############  File System Setting ############################	
	
	if(!defined(_UPLOAD_FILE_PATH))
		define("_UPLOAD_FILE_PATH",_PATH."upload/");	
		
	if(!defined(_UPLOAD_FILE_URL))
		define("_UPLOAD_FILE_URL",_WWWROOT."upload/");
			
	if(!defined(_WWW_UPLOAD_IMAGE_PATH))
		define("_WWW_UPLOAD_IMAGE_PATH",_WWWROOT."upload/");	
		
############# html editor path ############################
if(!defined(_HTML_EDITOR_ABSOLUTE_PATH))	
		define("_HTML_EDITOR_ABSOLUTE_PATH",$_SERVER['DOCUMENT_ROOT']."/pierre/esthetic_planet/development/htmleditor");
if(!defined(_HTML_EDITOR_PATH))	
		define("_HTML_EDITOR_PATH","http://".$_SERVER['HTTP_HOST']."/pierre/esthetic_planet/development/htmleditor");			

############  Javascript  path setting ############################	

	if(!defined(_JS_PATH))
		define("_JS_PATH",_WWWROOT."js/");
		
############  DataBase   setting ############################	


 if(!defined(_HOST))
		define("_HOST","localhost");
	
	if(!defined(_USER))
		//define("_USER","mosaicse_mosuser");
		define("_USER","root");
	
	if(!defined(_PASS))
		//define("_PASS","QVuL%xT-AAPU");			
		define("_PASS","");	
		
	if(!defined(_DB))
		//define("_DB","mosaicse_maindb");
		define("_DB","esthetic_planet");
?>


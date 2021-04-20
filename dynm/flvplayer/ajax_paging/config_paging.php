<?

/*
THIS CLASS USES PEAR DB 
PLEASE CUSTOMIZE DSN ARRAY TO SUIT YOUR NEEDS
*/



if($_SERVER['HTTP_HOST']=='localhost') {
	
	define(PHP_TYPE, 'mysql');
	define(HOST_SPEC, 'localhost');
	define(DB, 'esthetic_planet');
	define(USER, 'root');
	define(PWD, '');
	
} else {
	
	define(PHP_TYPE, 'mysql');
	define(HOST_SPEC, 'localhost');
	define(DB, 'esthetic_planet');
	define(USER, 'root');
	define(PWD, '');
}



/*
define(PHP_TYPE, 'mysql');
define(HOST_SPEC, 'localhost');
define(DB, 'mosaicse_maindb');
define(USER, 'mosaicse_mosuser');
define(PWD, 'QVuL%xT-AAPU');



	define(PHP_TYPE, 'mysql');
	define(HOST_SPEC, 'localhost');
	define(DB, 'citylife_cltv');
	define(USER, 'citylife_cltv');
	define(PWD, '^tkWgSnFrg1-');

*/


 
require_once 'class.database.php'; 


		 
					
					
 
	$db = new Database();
 

?>
<?php
ob_start();
@session_start();

require_once($_SERVER['DOCUMENT_ROOT']."/dynm/includes/config.php");	



require_once(_PATH."includes/common.inc.php");		
require_once(_PATH."includes/functions.php");		

require_once(_PATH."classes/class.db.php");
require_once(_PATH."classes/sql.php");
require_once(_PATH."classes/class.javascript.php");	

	
$Check_db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
$Check_db->checkDB();
$Check_db->disconnectDB();
?>
<?php
ob_start();

class admLogin
{
	function admLogin()
	{
	}
	function ChkLogin()
	{
		if(isset($_SESSION['AdminInfo']['id']) && $_SESSION['AdminInfo']['id']!="")
		{
		}
		else
		{
			$url = _ADMIN_WWWROOT."index.php?msg=noSess";
			header("Location: $url");
			exit;
		}
	}
	function RedirctAdm()
	{
		if(isset($_SESSION['AdminInfo']['id']) && $_SESSION['AdminInfo']['id']!="")
		{
			$url = _ADMIN_WWWROOT."home.php";
			header("Location: $url");
			exit;
		}
	}

}

$AuthAdmin = new admLogin();

?>
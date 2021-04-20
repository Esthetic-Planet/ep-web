<?php
ob_start();

class userLogin
{
	function userLogin()
	{
	}
	function ChkLogin()
	{
		if(isset($_SESSION['UserInfo']['id']) && $_SESSION['UserInfo']['id']!="")
		{
		}
		else
		{
			$url = _WWWROOT."index.php?msg=noSess";
			header("Location: $url");
			exit;
		}
	}
	function RedirctUser()
	{
		if(isset($_SESSION['UserInfo']['id']) && $_SESSION['UserInfo']['id']!="")
		{
			$url = _WWWROOT."service.php";
			header("Location: $url");
			exit;
		}
	}

}

$AuthUser = new userLogin();

?>
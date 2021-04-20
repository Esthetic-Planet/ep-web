<?php
if ( class_exists('JavaScript') )
{
   return;
} else {

     class JavaScript
     {

     	function showJavaScriptMessage($mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		           </script>";
		}

		function MessageNClose($mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		             window.close();
		           </script>";
		}

		function showJavaScriptURL($url)
		{
		     echo "<script>
		           document.location = \"$url\";
		           </script>";
		}

		function AlertJavaScript($mesg)
		{
		     echo "<script>
		           alert(\"".$mesg."\");
		           </script>";
		}

		function showJavaScriptURLMessage($url,$mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		             document.location = \"$url\";
		           </script>";
		}

		function showJavaScriptURLMesg($url,$mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		             top.location = \"$url\";
		           </script>";
		}

		function showJavaScriptMSgParent()
		{
		     echo "<script>
		             opener.window.history.go(0);
		             window.close();
		           </script>";
		}

		function showJavaScriptAlertMSgParent($mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		             opener.window.history.go(0);
		             window.close();
		           </script>";
		}

		function showJavaScriptNavigateMessage($pg,$mesg)
		{
		     echo "<script>
		             alert(\"".$mesg."\");
		             window.history.go($pg);
		           </script>";
		}

		function showJavaScriptBackHistory($pg)
		{
				     echo "<script>
				             window.history.go($pg);
				           </script>";
		}


     }
	 }

?>

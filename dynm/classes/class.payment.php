<?
CLASS  PGateway{

	 var $transaction;
	 var $response;
	 var $pValues;


	function initiate($_CNF){

		global $_POST, $_SESSION;
		if(empty($_POST)){
			die("Inavlid access of this page");
		}

		if(empty($_SESSION)){
			die("Inavlid access of this page");
		}

		$this->pValues = $_POST;

		$USER = $_SESSION["USER"];


		$this->transaction["target_app"] = "WebCharge_v5.06";
		$this->transaction["response_mode"] = "simple";
		$this->transaction["response_fmt"] = "delimited";
		$this->transaction["upg_auth"] = $_CNF['merchant_id'];
		$this->transaction["delimited_fmt_field_delimiter"] = "=";
		$this->transaction["delimited_fmt_include_fields"] = "true";
		$this->transaction["delimited_fmt_value_delimiter"] = "|";

		$this->transaction["username"] = $_CNF['username'];
		$this->transaction["pw"] = $_CNF['pw'];

		$this->transaction["trantype"] = "sale";
		// Allowable Transaction Types:
		// Options:  preauth, postauth, sale, credit, void

		$this->transaction["reference"] = "";  // Blank for new sales...
		// required for VOID, POSTAUTH, and CREDITS.
		// Will be original Approval value.

		$this->transaction["trans_id"] = "";   // Blank for new sales...
		// required for VOID, POSTAUTH, and CREDITS.
		// Will be original ANATRANSID value.

		$this->transaction["authamount"] = ""; // Only valid for POSTAUTH and
		// is equal to the original
		// preauth amount.



		switch($_POST[cctype]){

			case 'V':
					$this->transaction["cardtype"] = "visa";
					break;

			case 'M':
					$this->transaction["cardtype"] = "mc";
					break;

			case 'A':
					$this->transaction["cardtype"] = "amax";
					break;

			case 'D':
					$this->transaction["cardtype"] = "discover";
					break;
			default:
					die("Invalid card number - try again or call GHV at 800-688-2254 for immediate service");
					break;
		}


		// Credit Card information
		$this->transaction["ccnumber"] = $_POST[cardnumber];

		// CC# may include spaces or dashes.

		$this->transaction["month"] = $_POST[expmonth]; // Must be TWO DIGIT month.
		$this->transaction["year"] =  $_POST[expyear]; // Must be TWO or FOUR DIGIT year.

		$total=round($_POST[payment_charged]*100)/100;
		$this->transaction["fulltotal"] = $total; // Total amount WITHOUT dollar sign.

		$this->transaction["ccname"] = $_POST[bname];
		$this->transaction["baddress"] = $_POST[invadd1];
		$this->transaction["baddress1"] = $_POST[invadd2];
		$this->transaction["bcity"] = $_POST[invtown];
		$this->transaction["bstate"] = $_POST[invcounty];
		$this->transaction["bzip"] = $_POST[invpostcode];
		$this->transaction["bcountry"] = $_POST[invcountry]; // TWO DIGIT COUNTRY (United States = "US")
		$this->transaction["bphone"] = $_POST[txtphone];
		$this->transaction["email"] = $USER[email];

		//echo "<PRE>";
		//print_r($this->transaction);
		//echo "</PRE><HR>";


  }


  function processPayment()
  {


  	 $this->response = $this->PostTransaction();
  	 //print_r($this->response);

	  if ($response["approved"] != "")
		{
			return $this->successPayment();
		} else {
			return $this->failurePayment();
	 }

  }

  function successPayment()
  {
  			return true;

  }

  function failurePayment()
  {

           return false;
  }





 function PostTransaction () {

 		$transaction=$this->transaction;

		$url = "https://transactions.innovativegateway.com/servlet/com.gateway.aai.Aai";
		$user_agent = "Mozilla/4.0";
		$proxy = ""; // If you use a proxy server to connect
			     // your server to the Internet then put
			     // in its address here.

		// Create the POST form to send to the gateway using
		// the incoming array.
		$data = "";
		foreach ($transaction as $name => $value) {
		    $data .= "&" . $name . "=" . urlencode($value);
		}

		$data = substr($data,1);


		// Create the connection through the cURL extension
	        $ch = curl_init();
	        curl_setopt ($ch, CURLOPT_URL, $url);

		if ($proxy != "")
			curl_setopt ($ch, CURLOPT_PROXY, $proxy);

	        curl_setopt ($ch, CURLOPT_USERAGENT, $user_agent);
			curl_setopt ($ch, CURLOPT_POST, 1);
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
	        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt ($ch, CURLOPT_TIMEOUT, 120);
	        $result = curl_exec ($ch);
	        curl_close($ch);

		// Now we've got the results back in a big string.

		// Parse the string into an array to return
		$rArr = explode("|",$result);



		$returnArr="";
		for($i=0;$i<count($rArr);$i++)
		{
			$tmp2 = explode("=", $rArr[$i]);

			// YES, we put all returned field names in lowercase
			$tmp2[0] = strtolower($tmp2[0]);

			// YES, we strip out HTML tags.
			$returnArr[$tmp2[0]] = strip_tags($tmp2[1]);
		}

		// Return the array.
		return $returnArr;
	}




}
?>

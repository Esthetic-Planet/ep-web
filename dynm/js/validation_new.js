//This file contains the functions for input data validation
//at client side with the help of java script.

//  this function checks the email format is correct or not
//  and return true or false accordingly.
	function is_email(email)
	{
		if(!email.match(/^[A-Za-z0-9\._\-+]+@[A-Za-z0-9_\-+]+(\.[A-Za-z0-9_\-+]+)+$/))
			return false;
		return true;
	}
	
	function disallow_spaces(fieldvalue,fieldid)
	{
		//alert("called");
		
			var m_strOut = new String(fieldvalue); 
			document.getElementById(fieldid).value = m_strOut.replace(/\s*/g, ''); // g means globally: replace all occurences of spaces
	}
	
	function is_integer_float(number) // allow float and integer number only (decimal representation)
	{
		//alert(number);
		//alert("dddd");
		//[0-9]+(\.[0-9]+)?
		if(!number.match(/^[0-9]+(\.[0-9]+)?$/))
			return false;
		return true;
	}
	
	function allow_integer_float(number,id) // allow float and integer number only (decimal representation)
	{
		//alert(id);
		//alert("dddd");
		//[0-9]+(\.[0-9]+)?
		if(!number.match(/^[0-9]+(\.[0-9]+)?$/))
		{
			//return false;
			document.getElementById(id).value=number.replace(/[^0-9.]/g, ''); // allow numers and . only
			return true;
		} 
		return true;
	}
	
			
	function allow_integer(number,id) // allow float and integer number only (decimal representation)
	{
		//alert(id);
		//alert("dddd");
		//[0-9]+(\.[0-9]+)?
		if(!number.match(/^[\+0-9]+?$/))
		{
			//return false;
			document.getElementById(id).value=number.replace(/[^0-9]/g, ''); // allow numers and . only
			return true;
		} 
		return true;
	}
	
	function stripAlphaChars(pstrSource) // strips alphanumeric characters from a string
	{ 
		var m_strOut = new String(pstrSource); 
		m_strOut = m_strOut.replace(/[^0-9]/g, ''); 
	
		return m_sOut; 
	}
	
	
// End of is_email Function

//  this function checks the given number is signed/unsigned number
//  and return true or false accordingly.
	function is_number(number)
	{
		if(!number.match(/^[\-\+0-9e1-9]+$/))
			return false;
		return true;
	}
// End of is_number Function

//  this function checks the given number is unsigned number
//  and return true or false accordingly.
	function is_unsign_number(number)
	{
		if(!number.match(/^[\+0-9]+$/))
			return false;
		return true;
	}
	function is_double(number)
	{
		if(!number.match(/^[0-9]*\.?[0-9]*$/))
			return false;
		return true;
	}
// End of is_unsign_number Function
	
//  this function checks the given string is alphanumeric word or not
//  and return true or false accordingly.
	function is_alpha_numeric(str)
	{
		if(!str.match(/^[A-Za-z0-9 ]+$/))
			return false;
		return true;
	}
// End of is_alpha_numeric Function

//  this function checks the given string is empty or not
//  and return true or false accordingly.
	function is_empty(str)
	{
  		 str=trim(str);
		 if ((str.length==0)||(str==null))
			return true;
		 return false;
	}
// End of is_empty Function
	
	function trim(inputString) 
	{
	   inputString=inputString.replace(/^\s+/g,"");
	   inputString=inputString.replace(/\s+$/g,"");
	   return inputString;
	} // Ends the "trim" function

	function convertDate(d,dateformat)
	{
		if(dateformat==null)
			dateformat='dd-mm-yyyy';

		if(dateformat.match(/^dd[-\/]{1}mm[-\/]{1}yyyy$/i))
		{
			var T = d.split(/[-\/]/);
			var M = T[1];
			var D = T[0];
			var	Y = T[2];
		}
		else if(dateformat.match(/^yyyy[-\/]{1}mm[-\/]{1}dd$/i))
		{
			var T = d.split(/[-\/]/);
			var M = T[1];
			var D = T[2];
			var	Y = T[0];
		}
		else
			return d;

		return (M+"-"+D+"-"+Y);
	}

	function is_date(d,dateformat)
	{
		if(dateformat==null)
			dateformat='dd-mm-yyyy';

		if(!dateformat.match(/^mm[-\/]{1}dd[-\/]{1}yyyy$/i))
			d=convertDate(d,dateformat);

		if(d.search(/^(\d){1,2}[-\/\\](\d){1,2}[-\/\\]\d{4}$/)!=0)
			return -1;//Bad Date Format
		
		var T = d.split(/[-\/]/);
		var M = eval(T[0]);
		var D = T[1];
		var	Y = T[2];
	
		return D>0 && (D<=[,31,28,31,30,31,30,31,31,30,31,30,31][M] ||	D==29 && Y%4==0 && (Y%100!=0 || Y%400==0) ) 
	}

	/// Usage : daetDiif(FirstDate,SecondDate,dateformat,returnas)
	/// returnas=null or 0 //Difrence will return in days
	/// returnas=null or 1 //Difrence will return in hours;
	/// returnas=null or 2 //Difrence will return in mins;
	/// returnas=null or 3 //Difrence will return in secs;
	/// returnas=null or 4 //Difrence will return in weeks;
	/// returnas=null or 5 //An array will return;


	function dateDiff(firstdate,secondate,dateformat,returnas)
	{
		date1 = new Date();
		date2 = new Date();
		diff  = new Date();
		
		firstdate=convertDate(firstdate,dateformat);
		secondate=convertDate(secondate,dateformat);

		if(is_date(firstdate,'mm-dd-yyyy')) 
		{ // Validates first date 
			date1temp = new Date(firstdate);
			date1.setTime(date1temp.getTime());
		}
		else
			return false; // otherwise exits

		if(is_date(secondate,'mm-dd-yyyy')) 
		{ // Validates second date 
			date2temp = new Date(secondate);
			date2.setTime(date2temp.getTime());
		}
		else
			return false; // otherwise exits

		// sets difference date to difference of first date and second date

		diff.setTime(date1.getTime() - date2.getTime());

		timediff = diff.getTime();
		
		if(returnas==null || returnas==0)
			return Math.floor(timediff / (1000 * 60 * 60 * 24)); 
		else if(returnas==1)
			return Math.floor(timediff / (1000 * 60 * 60)); 
		else if(returnas==2)
			return Math.floor(timediff / (1000 * 60)); 
		else if(returnas==3)
			return Math.floor(timediff / 1000); 
		else if(returnas==4)
			return Math.floor(timediff / (1000 * 60 * 60 * 24 * 7));
		else if(returnas==5)
		{
			weeks = Math.floor(timediff / (1000 * 60 * 60 * 24 * 7));
			timediff -= weeks * (1000 * 60 * 60 * 24 * 7);

			days = Math.floor(timediff / (1000 * 60 * 60 * 24)); 
			timediff -= days * (1000 * 60 * 60 * 24);

			hours = Math.floor(timediff / (1000 * 60 * 60)); 
			timediff -= hours * (1000 * 60 * 60);

			mins = Math.floor(timediff / (1000 * 60)); 
			timediff -= mins * (1000 * 60);

			secs = Math.floor(timediff / 1000); 
			timediff -= secs * 1000;

			retval=new Array(weeks,days,hours,mins,secs);

			return retval; // form should never submit, returns false
		}
	}

	function isPastDate(firstdate,secondate,dateformat)
	{

		diff=dateDiff(firstdate,secondate);
		
		if(diff<0)
			return true;
		return false;
	}

	function isValidCreditCard(type, ccnum) 
	{
	   if (type == "Visa" || type == "VI") {
		  // Visa: length 16, prefix 4, dashes optional.
		  var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
	   } else if (type == "MasterCard" || type == "MC") {
		  // Mastercard: length 16, prefix 51-55, dashes optional.
		  var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
	   } else if (type == "Discover"  || type == "NO") {
		  // Discover: length 16, prefix 6011, dashes optional.
		  var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
	   } else if (type == "AmEx" || type == "AX") {
		  // American Express: length 15, prefix 34 or 37.
		  var re = /^3[4,7]\d{13}$/;
	   } else if (type == "Diners") {
		  // Diners: length 14, prefix 30, 36, or 38.
		  var re = /^3[0,6,8]\d{12}$/;
	   } else if (type == "Bankcard") {
		  // Bankcard: length 16, prefix 5610 dashes optional.
		  var re = /^5610-?\d{4}-?\d{4}-?\d{4}$/;
	   } else if (type == "JCB") {
		  // Bankcard: length 16, prefix 5610 dashes optional.
		  var re = /^[3088|3096|3112|3158|3337|3528]\d{12}$/;
	   } else if (type == "EnRoute") {
		  // Bankcard: length 15, prefix 5610 dashes optional.
		  var re = /^[2014|2149]\d{11}$/;
	   } else if (type == "Switch") {
		  // Bankcard: length 16, prefix 5610 dashes optional.
		  var re = /^[4903|4911|4936|5641|6333|6759|6334|6767]\d{12}$/;
	   }

	   if (!re.test(ccnum)) return false;
	   // Checksum ("Mod 10")
	   // Add even digits in even length strings or odd digits in odd length strings.
	   var checksum = 0;
	   for (var i=(2-(ccnum.length % 2)); i<=ccnum.length; i+=2) {
		  checksum += parseInt(ccnum.charAt(i-1));
	   }
	   // Analyze odd digits in even length strings or even digits in odd length strings.
	   for (var i=(ccnum.length % 2) + 1; i<ccnum.length; i+=2) {
		  var digit = parseInt(ccnum.charAt(i-1)) * 2;
		  if (digit < 10) { checksum += digit; } else { checksum += (digit-9); }
	   }
	   if ((checksum % 10) == 0) return true; else return false;
	}

	//Checks the phone number like (001)-330-330 OR 9992592892
	///Start Function
	function is_phone(varphone)
	{
		if(!varphone.match(/^(\(?[0-9]*[-#\*\s]*[0-9]+\)?)+$/))
			return false;
		return true
	}
	//End Function



	//Form validation

	function ValidateForm(theForm)
	{
		//alert(theForm);
		//return false;
		
		
		
		for(i=0;i<theForm.elements.length;i++)
		{
				field = theForm.elements[i];
				if(field.id.match(/^chkemail_/)) // textfield email
				{
						/*fieldname = field.id.replace(/^chkemail_/,'');
						fieldobj = field.getElementById(fieldname);*/
						if(!is_email(field.value))
						{
							alert(field.title)
							field.focus();
							return false;
						}
						/*if(document.getElementById('chkemail_email').value != document.getElementById('chkemail_confrmemail').value)
						{
							alert("Email Ids do not match.")
							field.focus();
							return false;
						} */
				}
				else if(field.id.match(/^chkphone_/)) // textfield phone
				{
						/*fieldname = field.id.replace(/^chkphone_/,'');
						fieldobj = field.getElementById(fieldname);*/
						if(!is_phone(field.value))
						{
							alert(field.title)
							field.focus();
							return false;
						}
				}
				else if(field.id.match(/^chknum_/)) // textfield number
				{
						if(!is_number(field.value))
						{
							alert(field.title)
							field.focus();
							return false;
						}
				}
				else if(field.id.match(/^chkintf_/)) // textfield number
				{
						if(is_empty(field.value))
						{
							alert(field.title);
							field.focus();
							return false;
						}
						else if(!is_integer_float(field.value))
						{
							alert('Please enter a valid price. Numeric values are allowed.');
							field.focus();
							return false;
						}
						//alert("called2");
						//return false;
				}
				else if(field.id.match(/^chksbox_/)) // selectbox 
				{
						if(field.selectedIndex==0)
						{
							alert(field.title)
							field.focus();
							return false;
						}
				}
				else if(field.id.match(/^chkchkbox_/)) // checkbox single
				{
						if(!field.checked)
						{
							alert(field.title)
							field.focus();
							return false;
						}
				}
				else if(field.id.match(/chkchkmbox_/)) // checkbox multiple
				{
					if(theForm.elements[field.name].length >0)
					{
						checked = false;
						for(j=0;j<theForm.elements[field.name].length;j++)
						{
							if(theForm.elements[field.name][j].checked)
							{
								checked = true;
								break
							}
						}
						if(!checked)
						{
							alert(field.title)
							field.focus();
							return false;
						}
		
					}
					else if(!field.checked)
					{
							alert(field.title)
							field.focus();
							return false;
					}
				}
				else if(field.id.match(/^chkradio_/)) // radio button
				{
					if(theForm.elements[field.name].length >0)
					{
						checked = false;
						for(j=0;j<theForm.elements[field.name].length;j++)
						{
							if(theForm.elements[field.name][j].checked)
							{
								checked = true;
								break
							}
						}
						if(!checked)
						{
							alert(field.title)
							field.focus();
							return false;
						}
		
					}
					else if(!field.checked)
					{
							alert(field.title)
							field.focus();
							return false;
					}
				}
				else if(field.id.match(/^chk_/) || (field.value==field.title && !is_empty(field.value))) // textfield simple
				{
						if(is_empty(field.value))
						{
							alert(field.title)
							field.focus();
							return false;
						}
				}
				else if(field.id.match(/^chkpass_/)) // checkbox single
				{
						if(is_empty(field.value))
						{
							alert(field.title)
							field.focus();
							return false;
						}
						
						if(document.getElementById('chk_password').value != document.getElementById('chkpass_repassword').value)
						{
							alert("Les mots de passe ne correspondent pas.")
							field.focus();
							return false;
						}
				}
		}
		
		///////////////////////////////////////////////////////////////
		var total_cost;
		var percent_cost;
		
		total_cost = eval(parseFloat(document.getElementById("chkintf_Rent").value)  + parseFloat(document.getElementById("chkintf_Mortgage").value)+ parseFloat(document.getElementById("chkintf_Internet" ).value)+ parseFloat(document.getElementById("chkintf_Mobile").value)+ parseFloat(document.getElementById("chkintf_Electricity").value)+ parseFloat(document.getElementById("chkintf_Gas").value)+ parseFloat(document.getElementById("chkintf_Food").value)+ parseFloat(document.getElementById("chkintf_Clothes").value)+ parseFloat(document.getElementById("chkintf_Insurance").value)+ parseFloat(document.getElementById("chkintf_Petrol").value)+ parseFloat(document.getElementById("chkintf_Registration").value)+ parseFloat(document.getElementById("chkintf_contents").value)+ parseFloat(document.getElementById("chkintf_Health").value)+ parseFloat(document.getElementById("chkintf_Fees").value));
		
		total_cost=total_cost*12;
		
		percent_cost=eval((3*total_cost)/100);
		
		document.getElementById("total_cost_text").innerHTML="<b>Total Cost x 12 = </b>";
		
		document.getElementById("total_cost").innerHTML="<b>$ "+total_cost.toFixed(2)+"</b>";
		
		document.getElementById("percent_cost_text").innerHTML="<b>Percent Cost 3% = </b>";
		
		document.getElementById("percent_cost").innerHTML="<b>$ "+percent_cost.toFixed(2)+"</b>";
		
		
		//////////////////////////////////////////////////////////////
		return true; 
	
	}

// validation for e-mail
function isEmailAddr(email)
{
  var result = false
  var theStr = new String(email)
  var index = theStr.indexOf("@");
  if (index > 0)
  {
    var pindex = theStr.indexOf(".",index);
    if ((pindex > index+1) && (theStr.length > pindex+1))
	result = true;
  }
  return result;
}

// this function used to check valid chars
function check_validchar(pattern,str)
{
  var re = new RegExp(pattern,"g");
  var arr = re.test(str);
   return arr;
}  

// get element value after removing leading and trailing spaces
function RemoveLTSpace(elemval)
{
	var val=elemval.replace(/\s*/,"")
	var val=val.replace(/\s*$/,"")
	return val;
}
function JSvalid_form(formnm)
{
formnm=eval(formnm);
for(var i=0;i<formnm.elements.length;i++)
	{
		//alert(formnm.elements[i].name);
		//alert(formnm.elements[i].value);
if(formnm.elements[i].alt){
// START CHECK FOR BLANK
var altval=formnm.elements[i].alt;
var altval1=altval.split("~DM~");
if(altval1[0]=="BC" && RemoveLTSpace(formnm.elements[i].value)=="")
		{
		formnm.elements[i].value=RemoveLTSpace(formnm.elements[i].value);
		alert("Please enter "+altval1[1]);
		formnm.elements[i].focus();
		
		return false;
		}
if(altval1[0]=="BS" && RemoveLTSpace(formnm.elements[i].value)=="")
		{
		formnm.elements[i].value=RemoveLTSpace(formnm.elements[i].value);
		alert("Please select "+altval1[1]);
		formnm.elements[i].focus();
		
		return false;
		}
// END CHECK FOR BLANK
// VALID CHAR CHECK
if(altval1[2]!="" && formnm.elements[i].value!="")
	{
var re1 = new RegExp ('&q', 'g') ;
var pattern_val = altval1[2].replace(re1,'"') ;
var pattern="["+pattern_val+"]";
var re = new RegExp(pattern,"g");
if(re.test(formnm.elements[i].value)==true)
		{
		alert("Please avoid to enter \""+pattern_val+"\" in "+altval1[1]);
		formnm.elements[i].focus();
		formnm.elements[i].select();
		return false;
		}
	}




//START EMAIL CHECK
if(altval1[0]=="EMC")
{
  if (formnm.elements[i].value == "")
  {
    alert("Please enter a value for the \"email\" field.");
    formnm.elements[i].focus();
    return (false);
  }
  if (!isEmailAddr(formnm.elements[i].value))
  {
    alert("Please enter a complete email address in the form: yourname@yourdomain.com");
    formnm.elements[i].focus();
	formnm.elements[i].select();
    return (false);
  }
  if (formnm.elements[i].value.length < 3)
  {
    alert("Please enter at least 3 characters in the \"email\" field.");
    formnm.elements[i].focus();
	formnm.elements[i].select();
    return (false);
  }
}
// END EMAIL CHECK
	}
}
return true;
}

// function for password match
function password_match(pass1,pass2)
{
pass1=eval(pass1);
pass2=eval(pass2);
	if(pass1.value!=pass2.value)
	{
		return false;
	}
return true;
}

function isInteger(s)
{  
	
	if(!isNaN(s))
	{
		return false;
	}
  	  // All characters are numbers.
    return true;
}



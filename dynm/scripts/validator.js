/*
	presenceOf(field)								-	this function checks to see whether the filled is empty or not
	numericalityOf(field)						-	this function checks to see whether the value entered in the field is a number or not
	sizeOf(field, minimum, maximum)	-	this function checks to see whether the value i.e. number entered in the field is between minimum and maximum limits specified
	minimumOf(field, minimum)			-	this function checks to see whether the value i.e. number entered in the field is at least the minimum limit specified
	maximumOf(field, maximum)			-	this function checks to see whether the value i.e. number entered in the field is not more than the maximum limit specified
	lengthOf(field, minimum, maximum) - this function checks to see whether the length of the string entered in the field is between minimum and maximum limits specified
	formatOf(field, regexp, errorMesg)	-	this function checks to see whether the string entered in the field conforms to the format specified by the regular expression supplied. The error message supplied is used to report errors.
	emailOf(field)									-	this function checks to see whether the string entered in the field conforms to the format of an email address

*/
	
	String.prototype.trim = function() {
		return this.replace(/^\s*|\s*$/g, "")
	}
	

	function validator(form) {
		// instance variables
		this.errorString = new String();
		this.firstErrorField = null;

		// ctor
		for (var i = 0; i < form.elements.length; i++) {
			form.elements[i].style.backgroundColor = "white";
		}

		// instance methods follow...
		
		this.presenceOf = function() {
			var errorFlag = false;

			for (var i = 0; i < arguments.length; i++) {
				value = arguments[i].value.trim();
				if (value=="") {
					if (errorFlag == false) 
						this.errorString += arguments[i].alt;
					else
						this.errorString += ", " + arguments[i].alt;
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];
				}
			}

			if (errorFlag == true) {
				this.errorString = this.errorString.replace(/, ([A-Za-z\s]+)$/, " and $1");
				this.errorString += " can't be blank\n";
				return false;
			}
			return true;			
		}
		
		this.numericalityOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i++) {
				value = arguments[i].value.trim();
				if (value.trim() == "") value = "###";
				if (isNaN(value)) {
					if (errorFlag == false) 
						this.errorString += arguments[i].alt;
					else
						this.errorString += ", " + arguments[i].alt;
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];				
				}
			}

			if (errorFlag == true) {
				this.errorString = this.errorString.replace(/, ([A-Za-z\s]+)$/, " and $1");
				this.errorString += " should be a number\n";
				return false;
			}
			return true;			
		}
		
		this.sizeOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i=i+3) {
				value = parseInt(arguments[i].value.trim());
				if (isNaN(value)) value = -2147483000;	// useful when someone enters only text in this field
				min = parseInt(arguments[i+1]);
				max = parseInt(arguments[i+2]);
				if (value <  min || value > max) {
					this.errorString += arguments[i].alt + " should be between " + min + " and " + max + "\n";
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];				
				}
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.minimumOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i=i+2) {
				value = parseInt(arguments[i].value.trim());
				if (isNaN(value)) value = -2147483000;	// useful when someone enters only text in this field
				min = parseInt(arguments[i+1]);
				if (value <  min) {
					this.errorString += arguments[i].alt + " should be at least " + min + "\n";
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];				
				}
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.maximumOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i=i+2) {
				value = parseInt(arguments[i].value.trim());
				if (isNaN(value)) value = 2147482999;	// useful when someone enters only text in this field
				max = parseInt(arguments[i+1]);
				if (value >  max) {
					this.errorString += arguments[i].alt + " should be less than or equal to " + max + "\n";
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];				
				}
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.lengthOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i=i+3) {
				value = arguments[i].value.trim();
				min = parseInt(arguments[i+1]);
				max = parseInt(arguments[i+2]);
				if (max == 0) max = 2147482999;
				if (value.length <  min || value.length > max) {
					if (min > 0 && max != 2147482999) {
						this.errorString += arguments[i].alt + " should be minimum " + min + " characters and maximum " + max + " characters\n";
					}
					else if (min > 0) {
						this.errorString += arguments[i].alt + " should be minimum " + min + " characters\n";
					}
					else {
						this.errorString += arguments[i].alt + " should be maximum " + max + " characters\n";
					}
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];				
				}
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.formatOf = function() {
			var errorFlag = false;
		
			for (var i = 0; i < arguments.length; i=i+3) {
				value = arguments[i].value.trim();
				pattern = arguments[i+1];
				errorMsg = arguments[i+2];
				if (value.search(pattern) == -1) {
					this.errorString += errorMsg + "\n";
					arguments[i].style.backgroundColor = "pink";
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];
				}
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.emailOf = function() {
			var errorFlag = false;
			
			for (var i = 0; i < arguments.length; i++) {
				if (this.formatOf(arguments[i],/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/, arguments[i].alt + " must be a valid email address")  == false)
					errorFlag = true;
					if (this.firstErrorField == null) this.firstErrorField = arguments[i];
			}
			
			if (errorFlag) return false;
			return true;
		}
		
		this.validate = function() {
			if (this.errorString != "") {
				this.firstErrorField.select();
				this.firstErrorField.focus();
				return false;
			}
			return true;			
		}
		
	}
	
	
	
	function validate_me(formobj)

{

    if ( (formobj.Firstname.value == "") ||  (formobj.Add1.value == "")  ||  (formobj.Add2.value == "")  || (formobj.Town.value == "")  || (formobj.County.value == "")  || (formobj.Country.value == "")  || (formobj.Postcode.value == "")  || (formobj.Email.value == ""))

    {

            alert("Please complete the fields marked with *");

            return false;

    }

    if ( (formobj.Email.value.indexOf("@") == -1) || (formobj.Email.value.indexOf(".") == -1) )

    {

        alert("Please enter a valid email address.");

        formobj.Email.select( );

        formobj.Email.focus( );

        return false;

    }

    return true;

}
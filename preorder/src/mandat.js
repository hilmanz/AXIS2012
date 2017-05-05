function isEmailAddr(emailaddress)
{
  var result = false;
  var theStr = new String(emailaddress);
  var index = theStr.indexOf("@");
  if (index > 0)
  {
    var pindex = theStr.indexOf(".",index);
    if ((pindex > index+1) && (theStr.length > pindex+1))
	result = true;
  }
  return result;
}

function validRequired(formField,fieldLabel)
{
	var result = true;
	
	if (formField.value == "")
	{
		alert('"' + fieldLabel +'" mandatory');
		formField.focus();
		result = false;
	}
	
	return result;
}

function allDigits(str)
{
	return inValidCharSet(str,"0123456789");
}

function inValidCharSet(str,charset)
{
	var result = true;

	// Note: doesn't use regular expressions to avoid early Mac browser bugs	
	for (var i=0;i<str.length;i++)
		if (charset.indexOf(str.substr(i,1))<0)
		{
			result = false;
			break;
		}
	
	return result;
}

function validEmail(formField,fieldLabel,required)
{
	var result = true;
	
	if (required && !validRequired(formField,fieldLabel))
		result = false;

	if (result && ((formField.value.length < 8) || !isEmailAddr(formField.value)) )
	{
		alert("Invalid Email Address");
		formField.focus();
		result = false;
	}
   
  return result;

}

function validNum(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result && ((formField.value.length < 5) ))
 	{
 		if (!allDigits(formField.value))
 		{
 			alert('Please enter number for the  "' + fieldLabel +'"');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validInt(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var num = parseInt(formField.value,10);
 		if (isNaN(num))
 		{
 			alert('Please enter a number for the "' + fieldLabel +'".');
			formField.focus();		
			result = false;
		}
	} 
	
	return result;
}


function validDate(formField,fieldLabel,required)
{
	var result = true;

	if (required && !validRequired(formField,fieldLabel))
		result = false;
  
 	if (result)
 	{
 		var elems = formField.value.split("/");
 		
 		result = (elems.length == 3); // should be three components
 		
 		if (result)
 		{
 			var month = parseInt(elems[0],10);
  			var day = parseInt(elems[1],10);
 			var year = parseInt(elems[2],10);
			result = allDigits(elems[0]) && (month > 0) && (month < 13) &&
					 allDigits(elems[1]) && (day > 0) && (day < 32) &&
					 allDigits(elems[2]) && ((elems[2].length == 2) || (elems[2].length == 4));
 		}
 		
  		if (!result)
 		{
 			alert('Please enter a date in the format MM/DD/YYYY for the "' + fieldLabel +'" field.');
			formField.focus();		
		}
	} 
	
	return result;
}


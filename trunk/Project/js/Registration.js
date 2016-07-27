$(function(){
	$('#pwd').keypress(function(event){
		return nospaceallowed(event);
	});
	$('#conf_pwd').keypress(function(event){
		return nospaceallowed(event);
	});
/*	$('#offPhone').keypress(function(event){
		return numbersonly(event);
	});
	$('#persPhone').keypress(function(event){
		return numbersonly(event);
	}); */

	$('#email').jqxInput({disabled: true});	//The input dows not exist. it is a span converted to jqx widget
	$('form').find('input')[0].focus();
});

function Register(){
	
	var usrStatus		= $('#usrStatus').val();
	var passwordField		=	$('#pwd');
	var passwordFieldValue	=	passwordField.val();
	var confirmPasswordField=	$('#conf_pwd');
	var confirmPasswordFieldValue=	confirmPasswordField.val();
    if(passwordFieldValue == '' || passwordFieldValue == undefined ){
		AlertMessage({msg:ErrorMessages[10]});
		return false;
	}
	else if(passwordFieldValue.length <= 6 || passwordFieldValue.length >= 20) {
		AlertMessage({msg:ErrorMessages[11]});
		return false;
	}
	
	if(passwordFieldValue != confirmPasswordFieldValue){
		AlertMessage({msg:ErrorMessages[12]});
		return false;
	}
	
	var firstNameField		=	$('#fname');
	var firstNameFieldValue	=	firstNameField.val();
	firstNameFieldValue	= disallowSpacesBetweenNames(firstNameFieldValue);
	$('#fname').val(firstNameFieldValue);
	
	if(firstNameFieldValue == '' || firstNameFieldValue == undefined ){
		AlertMessage({msg:RegistrationErrorMessages[0]});
		return false;
	}
	
	var lastNameField		=	$('#lname');
	var lastNameFieldValue	=	lastNameField.val();
	lastNameFieldValue	= disallowSpacesBetweenNames(lastNameFieldValue);
	$('#lname').val(lastNameFieldValue);
	
	var organizationNameField		=	$('#org');
	var organizationNameFieldValue	=	organizationNameField.val();
	organizationNameFieldValue		= disallowSpacesBetweenNames(organizationNameFieldValue);
	$('#org').val(organizationNameFieldValue);

	if(organizationNameFieldValue == '' || organizationNameFieldValue == undefined ){
		AlertMessage({msg:RegistrationErrorMessages[2]});
		return false;
	}
	
	var websiteField		=	$('#csite');
	var websiteFieldValue	=	websiteField.val();
	//websiteFieldValue		= disallowSpacesBetweenNames(websiteFieldValue);
	//$('#csite').val(websiteFieldValue);
	
	var addressField		=	$('#add');
	var addressFieldValue	=	addressField.val();
	addressFieldValue		= disallowSpacesBetweenNames(addressFieldValue);
	$('#add').val(addressFieldValue);
	
	var cityField		=	$('#city');
	var cityFieldValue	=	cityField.val();
	cityFieldValue		= disallowSpacesBetweenNames(cityFieldValue);
	$('#city').val(cityFieldValue);
	
	var pincodeField		=	$('#pin');
	var pincodeFieldValue	=	pincodeField.val();
	$('#pin').val(pincodeFieldValue);
	
	var pincodeField		=	$('#pin');
	var pincodeFieldValue	=	pincodeField.val();
	$('#pin').val(pincodeFieldValue);
	
	var countryField		=	$('#country');
	var countryFieldValue	=	countryField.val();
	$('#country').val(countryFieldValue);
	
	var offPhoneField		=	$('#offPhone');
	var offPhoneFieldValue	=	offPhoneField.val();
	$('#offPhone').val(offPhoneFieldValue);
	
	var persPhoneField		=	$('#persPhone');
	var persPhoneFieldValue	=	persPhoneField.val();
	$('#persPhone').val(persPhoneFieldValue);
	
	var offPhoneField		=	$('#offPhone');
	var offPhoneFieldValue	=	offPhoneField.val();
	$('#offPhone').val(offPhoneFieldValue);
	
	var email    		= $('#email').val();
	var userID    		= $('#usrId').val();
	var usrStatus		= $('#usrStatus').val();

	if(passwordFieldValue	== '*ENCRYPTED*') {
		passwordFieldValue	=	'';
	}
	
	var Data_random 	= randomize_Data('fname='+firstNameFieldValue+'&lname='+lastNameFieldValue+'&org='+organizationNameFieldValue+'&csite='+websiteFieldValue+'&city='+cityFieldValue+'&pin='+pincodeFieldValue+'&country='+countryFieldValue+'&offPhone='+offPhoneFieldValue+'&persPhone='+persPhoneFieldValue+'&add='+addressFieldValue+'&email='+email+'&pwd='+passwordFieldValue+'&userID='+userID+'&usrStatus='+usrStatus);
	var Data_encoded 	= EncodeData(Data_random);
	$('input').each(function(){$(this).val("");});
	$('#RegisterValues').val(Data_encoded);
	return true;
}

var backToHome = function(){
	var date = new Date();
	date.setTime(date.getTime()+(5*1000));
	var expires = "; expires="+date.toGMTString();
	document.cookie = "tab=personalInfoDiv"+expires;
	window.location = 'UserPage.php';
};
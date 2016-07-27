/*
* Author: Ankit
* date: 21-Feb-2015
* Description: This defines Alert messages for user interface
*/

var AlertMessageArrVar = new Array();	// This variable collects the arguments and pass it to alert.getmessages
function AlertDynamicMessage(ArrayStrings)
{
	//Assumption: Message will always start with string. Variables will always be Arrays. Variables and strings will alternate as -- string+variable+string+variable+string+....
	this.getMessages = function getMessages(Variable)
	{
		var messageReturn = "";
		for(var ijk = 0; ijk < ArrayStrings.length; ijk++)
		{
			if(ArrayStrings[ijk] != "" && ArrayStrings[ijk] != undefined)
			{
				messageReturn += ArrayStrings[ijk];
			}
			if(Variable[ijk] != "" && Variable[ijk] != undefined)
			{
				messageReturn += Variable[ijk];
			}
		}
		return messageReturn;
	};
}

var SuccessMessages = new Array();
SuccessMessages[0]	= '';
SuccessMessages[1]	= 'User details updated successfully';
SuccessMessages[2]	= 'User deleted successfully';
SuccessMessages[3]	= 'The user has been registered successfully and a verification email has been sent to the registered user. The user needs to complete the registration process by clicking the verification link in the email';
SuccessMessages[4]	= 'Voucher code has been generated successfully. Please check your email for the voucher details';
SuccessMessages[5]	= 'Your credit amount has been updated successfully';
SuccessMessages[6]	= 'Voucher has been cancelled';
SuccessMessages[7]	= 'Voucher has been assigned successfully';
SuccessMessages[8]	= 'SMTP settings saved successfully';
SuccessMessages[9]	= 'Invoice details have been sent to registered email address.';
SuccessMessages[10]	= 'Support email address have been saved successfully';
SuccessMessages[11]	= 'SUID has been reset successfully';
SuccessMessages[12]	= 'Mail sent successfully';

var ErrorMessages = new Array();
ErrorMessages[0]	= 'Incorrect password. Please re-enter your credentials';
ErrorMessages[1]	= 'All requests have been completed successfully';
ErrorMessages[2]	= 'Sufficient credits are not available for completing this action';
ErrorMessages[3]	= 'The user doesn\'t exist';
ErrorMessages[4]	= 'The user is currently under unlimited plan. The subscription can only be modified after expiry of the plan';
ErrorMessages[5]	= 'The user has been logged out';
ErrorMessages[6]	= 'The user has not set the password';
ErrorMessages[7]	= 'Incorrect password. Please re-enter your credentials';
ErrorMessages[8]	= 'Username can not be left empty';
ErrorMessages[9]	= 'Invalid username';
ErrorMessages[10]	= 'Password can not be left empty';
ErrorMessages[11]	= 'Password should be greater than 6 and less than 20';
ErrorMessages[12]	= 'Passwords do not match';
ErrorMessages[13]	= 'Error in cancelling the voucher';
ErrorMessages[14]	= 'Please enter a valid customer email address';
ErrorMessages[15]	= 'Error in assigning voucher';
ErrorMessages[16]	= 'Enter a valid Reset Code';
ErrorMessages[17]	= 'Failed to save SMTP settings';
ErrorMessages[18]	= 'Please fill the support form correctly';
ErrorMessages[19]	= 'Error in processing your support request';
ErrorMessages[20]	= 'Please enter a valid contact number';
ErrorMessages[21]	= 'Unable to Generate Invoice for this transaction';
ErrorMessages[22]	= 'Failed to create database backup';
ErrorMessages[23]	= 'Amount must be greater than 100 USD';
ErrorMessages[24]	= 'Your account validity has expired';
ErrorMessages[25]	= 'Failed to save support email address';
ErrorMessages[26]	= 'Failed to reset SUID because of invalid user';	//Bad request/ UserID not sent
ErrorMessages[27]	= 'Failed to reset SUID because of invalid user';	//Bad request/ User is not a customer/Operator
ErrorMessages[28]	= 'Failed to reset SUID';	//probably a db error
ErrorMessages[29]	= 'Please enter all input for sending mail';	//Bad request All inputs not provided
ErrorMessages[30]	= 'Failed to send Mail';	//probably a db error
ErrorMessages[31]	= 'Unauthorized access';	

var CreditErrorMessages = new Array();
CreditErrorMessages[2]	= '';

var UserAddEditDelete = new Array();
UserAddEditDelete[1]	= 'Failed to delete user';
UserAddEditDelete[2]	= 'Failed to add new user';
UserAddEditDelete[3]	= 'User is already registered';

var RegistrationErrorMessages	= new Array();
RegistrationErrorMessages[0]	= "Name cannot be left empty";
RegistrationErrorMessages[1]	= "Name cannot contain any numeric value";
RegistrationErrorMessages[2]	= "Enter the organization name";
RegistrationErrorMessages[3]	= "Name cannot contain any special characters";

var SMTPErrorMessages	= new Array();
SMTPErrorMessages[0]	= 'HostName cannot be left empty';
SMTPErrorMessages[1]	= 'SMTP port number cannot be left empty';
SMTPErrorMessages[2]	= 'Sender name cannot be left empty';

var AddUserErrorMessages	=	new Array();
AddUserErrorMessages[0]	=	'User type must be specified';
AddUserErrorMessages[1]	=	'Email address must be specified';
AddUserErrorMessages[2]	=	'Enter a valid email address';

var RefreshMessages	=	new Array();
RefreshMessages[0]	=	'Node updated successfully';
RefreshMessages[1]	=	'Node deleted successfully';
RefreshMessages[2]	=	'User deleted successfully';
RefreshMessages[3]	=	'User added successfully';
RefreshMessages[4]	=	'Source added successfully';
RefreshMessages[5]	=	'Node added successfully';
RefreshMessages[6]	=	'Source deleted successfully';
RefreshMessages[7]	=	'Source updated successfully';
RefreshMessages[8]	=	'Group deleted successfully';
RefreshMessages[9]	=	'Group added successfully';
RefreshMessages[10]	=	'Group updated successfully';
RefreshMessages[11]	=	'Profile updated successfully';
RefreshMessages[12]	=	'Template deleted successfully';
RefreshMessages[13]	=	'Template added successfully';
RefreshMessages[14]	=	'Template updated successfully';
RefreshMessages[15]	=	'Report settings saved successfully';
RefreshMessages[16]	=	'Source profiles updated successfully';
RefreshMessages[17]	=	'Monitor Settings updated successfully';
RefreshMessages[18]	=	'Payment added successfully';
RefreshMessages[19]	=	'Customer added successfully';
RefreshMessages[20]	=	'Customer deleted successfully';
RefreshMessages[21]	=	'Timezone settings saved successfully';
RefreshMessages[22]	=	'Account status changed successfully';
RefreshMessages[23]	=	'Alert settings saved successfully';

var SoapErrorMessages	=	new Array();
SoapErrorMessages[1]	=	'Template configuration failed';
SoapErrorMessages[2]	=	'Duplicate Source Url Detected';
SoapErrorMessages[3]	=	'There is no file for verification of Url';
SoapErrorMessages[4]	=	'No media file found';
SoapErrorMessages[5]	=	'Network Error';
SoapErrorMessages[6]	=	'Media file is not valid';
SoapErrorMessages[7]	=	'No data in database';
SoapErrorMessages[8]	=	'No agent available for monitoring task';
SoapErrorMessages[9]	=	'Invalid Report Path';
SoapErrorMessages[10]	=	'Invalid template XML';
SoapErrorMessages[11]	=	'Web Notification type is undefined';
SoapErrorMessages[24]	=	'Database disconnected';
SoapErrorMessages[25]	=	'Database error query fail';
SoapErrorMessages[31]	=	'Database error duplicate entry';
SoapErrorMessages[51]	=	'Automated report settings not configured for the user';
SoapErrorMessages[52]	=	'User deleted successfully but report settings failed to update';



var TemplateErrorMessages	=	new Array();
TemplateErrorMessages[0]	=	'Template Name or Description cannot be left empty';
TemplateErrorMessages[1]	=	'Black frame duration value must be greater than 1';
TemplateErrorMessages[2]	=	'Freeze frame duration value must be greater than 1';
TemplateErrorMessages[3]	=	'Solid color duration value must be greater than 1';
TemplateErrorMessages[4]	=	'Mute duration value must be greater than 1';
TemplateErrorMessages[5]	=	'Silence duration value must be greater than 1';
TemplateErrorMessages[6]	=	'Failed to add template';
TemplateErrorMessages[7]	=	'Maximum Loudness level for EBU not set';
TemplateErrorMessages[8]	=	'Maximum Loudness tolerance for EBU not set';
TemplateErrorMessages[9]	=	'Minimum Loudness level for EBU not set';
TemplateErrorMessages[10]	=	'Minimum Loudness tolerance for EBU not set';
TemplateErrorMessages[11]	=	'Maximum Loudness level for ATSC not set';
TemplateErrorMessages[12]	=	'Minimum Loudness tolerance for ATSC not set';
TemplateErrorMessages[13]	=	'Maximum Loudness level for ATSC not set';
TemplateErrorMessages[14]	=	'Minimum Loudness tolerance for ATSC not set';
TemplateErrorMessages[15]	=	'Failed to add template';
TemplateErrorMessages[16]	=	'Failed to add template';
TemplateErrorMessages[17]	=	'A/V signal drop duration value must be greater than 1';
TemplateErrorMessages[18]	=	'Closed caption missing duaration must be greater than 1';

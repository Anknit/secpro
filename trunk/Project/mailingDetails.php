<?php
/*
* Author: Aditya
* date: 16-Sep-2014
* Description: This defines functions required for getting mail subjects and bodies
*
*/
require_once __DIR__.'./../Common/php/commonfunctions.php';

class mail_Details{
	public function getEmailBody($Context, $EmailBodyVariables){
		$EmailBody	=	'';
		switch($Context) {
			case 'NewVoucher':
				$EmailBody	.=	'Dear '.$EmailBodyVariables['RecipientsName'].', <br /><br />';
				$EmailBody	.=	'You have generated a new voucher with the following details:<br /><br />'; 
				$EmailBody	.=	'<b>Voucher code</b>: '.$EmailBodyVariables['VoucherCodeNumber'].'<br />'; 
				$EmailBody	.=	'<b>Amount (USD)</b>: '.$EmailBodyVariables['VoucherAmount'].'<br />'; 
				$EmailBody	.=	'<b>Voucher validity</b>: '.$EmailBodyVariables['VoucherValidity'].'<br />'; 
				$EmailBody	.=	'<b>Type</b>: '.$EmailBodyVariables['VoucherType'].'<br />';
				if($EmailBodyVariables['VoucherTypeValue']	!=	Demo)
					$EmailBody	.=	'<b>Subscription validity</b>: 1 year from the date of voucher activation<br />'; 
				else
					$EmailBody	.=	'<b>Subscription validity</b>: 30 days from the date of voucher activation<br />'; 
				
				if($EmailBodyVariables['Notes'] != "" && $EmailBodyVariables['Notes'] != NULL) {
					$EmailBody	.=	'<b>Notes</b> : '.$EmailBodyVariables['Notes'].'<br /><br />'; 
				}
			break;
			case 'VoucherAssigned':
				$EmailBody	.=	'Dear '.$EmailBodyVariables['RecipientsName'].', <br /><br />';
				$EmailBody	.=	'You have been assigned a new voucher with the following details:<br /><br />'; 
				$EmailBody	.=	'<b>Voucher code</b>: '.$EmailBodyVariables['VoucherCodeNumber'].'<br />';
				$EmailBody	.=	'<b>Amount (USD)</b> : '.$EmailBodyVariables['VoucherAmount'].'<br />'; 
				$EmailBody	.=	'<b>Voucher validity</b> : '.$EmailBodyVariables['VoucherValidity'].'<br />'; 
/*				$EmailBody	.=	'<b>Type</b>: '.$EmailBodyVariables['VoucherType'].'<br />';
				if($EmailBodyVariables['VoucherTypeValue']	!=	Demo)
					$EmailBody	.=	'<b>Subscription validity</b>: 1 year from the date of voucher activation<br />'; 
				else
					$EmailBody	.=	'<b>Subscription validity</b>: 30 days from the date of voucher activation<br />'; 
				
				if($EmailBodyVariables['Notes'] != "" && $EmailBodyVariables['Notes'] != NULL) {
					$EmailBody	.=	'<b>Notes</b> : '.$EmailBodyVariables['Notes'].'<br />'; 
				}
*/
			break;
			case 'NewUser':
				$EmailBody	.=	'Dear user, <br />';
				$EmailBody	.= 'You have been added to the NOVA service. Please complete the registration by clicking '.$EmailBodyVariables['RegistrationLink'].'  to start using the service.<br /><br />';//<br /> As an alternative you can copy paste the following address in browser\'s address bar :- '.$EmailBodyVariables['RegistrationPageAddress'];
/*				if($EmailBodyVariables['Notes'] != "" && $EmailBodyVariables['Notes'] != NULL) {
					$EmailBody	.=	' &nbsp;&nbsp;&nbsp;&nbsp;<b>Notes</b> : '.$EmailBodyVariables['Notes'].'<br />'; 
				}
*/			break;
			case 'NewSupportRequest':
				$EmailBody	.=	'Support Team, <br />';
				$EmailBody	.= 'A new support request is registered for NOVA service. Following are the details. <br />';
				$EmailBody	.= '<br /><b>Request Ticket ID: </b>'.$EmailBodyVariables['NewRequestTicket'];
				$EmailBody	.= '<br /><b>Request Generator: </b>'.$_SESSION['Username'];
				$EmailBody	.= '<br /><b>Request generator Organization: </b>'.$EmailBodyVariables['NewRequestOrganisation'];
				$EmailBody	.= '<br /><b>Request Category: </b>'.$EmailBodyVariables['NewRequestSubject'];
				$EmailBody	.= '<br /><b>Request Summary: </b>'.$EmailBodyVariables['NewRequestSummary'];
				$EmailBody	.= '<br /><b>Request Description: </b>'.$EmailBodyVariables['NewRequestDescription'];
			break;
			case 'NewInvoice':
				$EmailBody	.=	'Dear Customer, <br />';
				$EmailBody	.= 'Invoice detail for your transaction ID <b>'.$EmailBodyVariables['NewInvoiceID'].'</b>. <br />';
				$EmailBody	.= '<br /><b>Transaction ID: </b>'.$EmailBodyVariables['NewInvoiceID'];
				$EmailBody	.= '<br /><b>Payment Amount (USD): </b>'.$EmailBodyVariables['NewInvoiceAmount'];
			break;
		}
		
		if($EmailBody != "") {
			
			$EmailBody	=	'<html>
								<head>
									<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
										<style type="text/css"> .internalTextNormal{
										font-family: Arial, Helvetica, sans-serif;
										font-size: 11px;
										color: #000000;
										font-weight: normal;	 
									}</style>
								</head>
								<body>	
								<table class="internalTextNormal" border="0" cellpadding="2" cellspacing="2" width="100%" style="background-color:#FFFFFF">
									<tr><td align="left">'.$EmailBody.'</td></tr>
									<tr>
										<td style="height: 20px;" align="left">
											Thanks,<br />
											NOVA Administrator
										</td>
									</tr> 			 		 
								</table></body></html>';
		}
		
		return $EmailBody;
	}
	
	public function getEmailSubject($Context, $EmailSubjectVariables){
		$EmailSubject	=	'';
		switch($Context) {
			case 'NewVoucher':
				$EmailSubject	.=	'New voucher, code - '.$EmailSubjectVariables['VoucherCodeNumber'];
			break;
			case 'NewUser':
				$EmailSubject	.=	'NOVA verification email';
			break;
			case 'VoucherAssigned':
				$EmailSubject	.=	'NOVA voucher';
			break;
			case 'NewSupportRequest':
				$EmailSubject	.=	'Support Request - '.$EmailSubjectVariables['NewRequestTicket'].', '.$EmailSubjectVariables['NewRequestSummary'];
			break;
			case 'NewInvoice':
				$EmailSubject	.=	'Transaction Invoice, ID -  '.$EmailSubjectVariables['NewInvoiceID'];
			break;
		}
		return $EmailSubject;
	}
};

function getEmailBody($Context, $EmailBodyVariables){
	$mail_Details	=	 getclassObject('mail_Details');
	return $mail_Details -> getEmailBody($Context, $EmailBodyVariables);
}

function getEmailSubject($Context, $EmailSubjectVariables){
	$mail_Details	=	 getclassObject('mail_Details');
	return $mail_Details -> getEmailSubject($Context, $EmailSubjectVariables);
}
?>
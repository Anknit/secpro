<?php
/*
* Author: Aditya
* date: 08-Aug-2014
* Description: This defines some common functions required throughout the project
*
*/
require_once __DIR__.'/PageId.php';

class EncDecQueryStrings {
	public $randomStringsArray	=	array('vW2p4U2l','Fe5Vn7sR','hw9Nu8Mz','Tm4P1aD4','xo9Rb3yT','i9QsLn7g','o5jQv8eN','Szl78hCj','iIHs2dk4','Zu6wYs8b');
	
	public function encodeQueryString($cleanData){
		$dirtydataArray = $this->randomStringsArray;
		$randomized_Data = "";
		$RandomCount	= 0;
		$fieldPairs 	= explode("&",$cleanData);
		for($i = 0; $i<count($fieldPairs); $i++){
			if($RandomCount	>= 9)	$RandomCount = 0;
			$keyPairs 			= explode("=",$fieldPairs[$i]);
			$keyPairs[0]		= $dirtydataArray[$RandomCount].$keyPairs[0].$dirtydataArray[$RandomCount+1];
			$RandomCount+=2;
			if($RandomCount	>= 9)	$RandomCount = 0;
			$keyPairs[1]		= $dirtydataArray[$RandomCount].$keyPairs[1].$dirtydataArray[$RandomCount+1];
			$RandomCount+=2;
			$randomized_Data 	= implode("=",$keyPairs);
			$fieldPairs[$i]		= $randomized_Data;
			$randomized_Data	=	"";
		}
		$randomized_Data = implode("&",$fieldPairs);
		$randomized_Data 	= base64_encode($randomized_Data);
		return $randomized_Data;
	}
	
	public function decodeQueryString($encodedData){
		$data_Dirty 	= base64_decode($encodedData);
		$data_Dirty		= urldecode($data_Dirty);
		$data_Clean		= str_replace($this->randomStringsArray, '', $data_Dirty);
		return $data_Clean;
	}
};

function Random_encode($cleanData)
{
	$EncDecQueryStrings	=	getclassObject('EncDecQueryStrings');
	return $EncDecQueryStrings->encodeQueryString($cleanData);
}

function Random_decode($encodedData)
{
	$EncDecQueryStrings	=	getclassObject('EncDecQueryStrings');
	return $EncDecQueryStrings->decodeQueryString($encodedData);
}

function RedirectTo($PAGEID, $QueryString = "")
{
	global $pages_id;
	$page	=	$pages_id[$PAGEID];
	if($QueryString != ""){$page .= '?'.$QueryString;}
	header('Location: '.$_SESSION['HTTP_ROOT'].$page);
	exit();
}

function SetUserLoginSessionVars ($uid, $utype, $uname, $accountID) {
    $_SESSION['userID']		=	$uid;
    $_SESSION['userTYPE']	=	$utype;
    $_SESSION['Username']	=	$uname;
    $_SESSION['accountID']	=	$accountID;
} 
										
function GetArrayOfSelectedFieldsInDecimalFormat($bitsAsInteger)
{
	$BinaryFormat = decbin($bitsAsInteger);
	$BinaryFormatArray = str_split($BinaryFormat);
	$i = 0;
	$Selected	=	array();
	$valueActuallySelected = 0;
	$arraylength = count($BinaryFormatArray);
	for($j = ($arraylength-1); $j >= 0; $j--)
	{
		$valueActuallySelected++;	
		if(intval($BinaryFormatArray[$j]) == 1)
		{
			$Selected[$i] = $valueActuallySelected;
			$i++;
		}
	}
	return $Selected;
}

function GetCommaSeparatedApplicationFeatures($FeaturesFromDatabase)
{
	$features	=	"";
	$FeaturesListCommaSeparated	=	"";
	if($FeaturesFromDatabase	==	"")	{	//Default PPU. It doesn't has features argument, infact, turn on all the available features for ppu
		$Output	=	"";
	}	
	else {
		$FeaturesFromDatabase	=	explode(';', $FeaturesFromDatabase);
		$featuresBitArray	=	GetArrayOfSelectedFieldsInDecimalFormat($FeaturesFromDatabase[0]);
	}
	
	if(count($featuresBitArray) > 0)
		$features	=	implode(',', $featuresBitArray);
	
	return $features;
}

function isPresentInDatabse($table, $fieldname, $entry){
	$output	=	DB_Read(array(
					'Table'	=> 	$table,
					'Fields'=>	'*',
					'clause'=>	$fieldname.' = "'.$entry.'"',
					),'ASSOC','');
	return $output[0];						
}

function generatePDF($html, $fileName	=	''){
	if($html	!=	''){
		$timeStamp		=	time();
		$htmlFile		=	$timeStamp.'.html';
		if(isset($_SESSION['SETUP_ROOT']))
			$filePath		=	$_SESSION['SETUP_ROOT'].'/temp/';
		else
			$filePath		=	__DIR__.'./../temp/';
			
		$pdfFileName	=	$timeStamp.'.pdf';
		if($fileName	== '')
			$fileName		=	$filePath.$pdfFileName;
			
		file_put_contents($filePath.$htmlFile, $html);		//Dump html file
		
		$pdfLibraryPath	=	'xvfb-run -a wkhtmltopdf';

		$query	=	$pdfLibraryPath.' '.$filePath.$htmlFile.' '.$fileName;
		$output	=	exec ($query);
		if(!$output){
			SetErrorCodes('Error executing query on shell: -- '.$query.' --', __LINE__, __FILE__);
		}
		
		unlink($filePath.$htmlFile);	//Delete html log file
		return 	$pdfFileName;
	}
}

function defaultNOVADates ($case	=	1) {
	global $defaultNOVADates;
	return date('Y-m-d', strtotime($defaultNOVADates[$case]));
} 

/*
	Assumptions : The php variables that have been used in php file should also be defined as global inside the same html file, so that the same variables value are executed when the file is required
*/
function htmlWithPhpContent ($htmlFilePath) {
	/*Check if file exists else return false;
	If file exists then read the file and dump the contents into a new php file.
	start output buffer.
	require the new php file.
	get html contents.
	flush buffer.
	delete php file
	return html
	*/
	$htmlFilePath	=	trim($htmlFilePath);
	if(!file_exists($htmlFilePath))
		return false;
		
	$htmlBuffer	=	file_get_contents($htmlFilePath);
	$phpFilePath	=	str_replace('.html', '.php', $htmlFilePath);
	file_put_contents($phpFilePath, $htmlBuffer);
	
	ob_start();
	require_once $phpFilePath;
	$html = ob_get_contents();
	ob_clean();
	unlink($phpFilePath);	//Delete php file
	return $html;
} 

/*
	$Paymentinfo is an associate array (entry in a payment info table
	The invoice is sent to the customer who recorded this transaction
*/		
function generateAndMailInvoice($Paymentinfo, $sendMail = true){
	global $InvoiceNum;
	if($Paymentinfo){
		$info						=	getInfoFrom('retreive_data','profile',$Paymentinfo['CustomerID']);
		$Email						=	$info['Username'];
		$InvoiceUserOrganisation	=	$info['Organization'];
		$InvoiceUserAmount			=	$Paymentinfo['AmountPaid'];
		$InvoiceID 					=	$Paymentinfo['Payment_ModeID'];
		$InvoiceNum					=	$Paymentinfo['InvoiceNum'];
	}

	if(IfValid($info['phoneOffice'])){
		$Telephone	=		$info['phoneOffice'];
	}
	else
		$Telephone	=		$info['phonePersonal'];
	
	if($Paymentinfo['Pay_Mode']	==	PayPal)
		$paymentMode	=	'Paypal';
	else
		$paymentMode	=	'Voucher';
			
	//Below set of variables is required in pdf generation
	global $InvoiceDate, $UserName, $UserAddress, $UserCompany;
	global $UserTelephone, $UserCity, $UserZip, $UserEmail, $UserCountry;
	global $ItemAmount, $TotalAmount, $PurchaseDate, $PurchaseMode, $TransactionID;
	$InvoiceNum;
	$InvoiceDate	=	currentDate();
	$UserName		=	$info['Name'];
	$UserAddress	=	$info['Address'];
	$UserCompany	=	$info['Organization'];
	$UserTelephone	=	$Telephone;
	$UserCity		=	$info['City'];
	$UserZip		=	$info['PinCode'];
	$UserEmail		=	$Email;
	$UserCountry	=	$info['Country'];
	$ItemAmount		=	$InvoiceUserAmount;
	$TotalAmount	=	$InvoiceUserAmount;
	$PurchaseDate	=	$Paymentinfo['PayDate'] . ' UTC';
	$PurchaseMode	=	$paymentMode;
	$TransactionID	=	$Paymentinfo['TransactionID'];

	$NewInvoiceMailBody		=	getEmailBody('NewInvoice', array('NewInvoiceID' => $InvoiceID,'NewInvoiceUserOrganisation' => $InvoiceUserOrganisation, 'NewInvoiceAmount' => $InvoiceUserAmount));
	$NewInvoiceMailSubject	=	getEmailSubject('NewInvoice', array('NewInvoiceID' => $InvoiceID));
	
	$pdfHtmlBody			=	$NewInvoiceMailBody;	//As per old pdf html
	$ProjectName			=	'NOVA';	//variable required inside of html
	$customerInvoiceHtmlFile=	sampleInterfaces.'CustomerInvoice.html';
	$pdfHtmlBody			=	htmlWithPhpContent($customerInvoiceHtmlFile);
	$NewInvoiceMailBody		=	$pdfHtmlBody;
		
	$pdfFilename			=	$InvoiceNum.'.pdf';
	if(!file_exists(UserDataFilePath.$pdfFilename))
		$pdfName			=	generatePDF($pdfHtmlBody, UserDataFilePath.$pdfFilename);

	$output		=	$pdfFilename;
	if($sendMail) {
		$mailResult	=	send_Email($Email, $NewInvoiceMailSubject , $NewInvoiceMailBody, '' ,UserDataFilePath.$pdfFilename);
		if($mailResult)
				$output	 =	'1';
		else
			$output	 =	SetErrorCodes(18, __LINE__,  __FILE__);// failed to send email
	}		
	return $output;
}

function getUserType($UID) {
	$result = DB_Read(array(
		'Table'=> 'userinfo',						//Mandatory
		'Fields'=> 'UserType',
		'clause'=> 'UserID = '.$UID,
	));
	
	if($result) {
		$result	=	$result[0]['UserType'];
	}
	return $result;					
}
?>

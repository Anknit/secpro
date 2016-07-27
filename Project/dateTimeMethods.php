<?php
/*
* Author: Aditya
* date: 16-Sep-2014
* Description: This defines methods required for fetching dateTiem related information
*
*/

function getRemainingValidity($EndDate)
{
	$validityRemaining	=	"";	
	$TodayDate	=	date('Y-m-d');
	$diff = abs(strtotime($EndDate) - strtotime($TodayDate));
	$years = floor($diff / (365*60*60*24));
	$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	
	if($years != 0)
	{
		$validityRemaining	.=	$years." years";	
	}
	if($months != 0)
	{
		if($validityRemaining != "")
			$validityRemaining	.=	', ';
		$validityRemaining	.=	$months." months";	
	}
	if($days != 0)
	{
		if($validityRemaining != "")
			$validityRemaining	.=	', ';
		$validityRemaining	.=	$days." days";	
	}
	return $validityRemaining;
}

function HasDateExpired($date){
	
	$expdate	=	$date;
	$expirytime	=	strtotime($expdate);
	//$expirytime	=	strtotime('+1 day', $expirytime);	//Add this if the expiry should be counted as completion of that day, i.e. 24 hrs of the date, or 0 hrs of the date
	$time	=	time();

	if($time >  $expirytime) { //If voucher validity has expired
		return true;	
	}
	else
		return false;
}

function currentDate(){
	return date('Y-m-d');
}

function convertDateToFormat($date, $cases){
	switch($cases){
		case 'dmy':
			$date	=	date('d-m-Y', strtotime($date));
		break;	
		case 'mdy':
			$date	=	date('m-d-Y', strtotime($date));
		break;	
		case 'ymd':
			$date	=	date('Y-m-d', strtotime($date));
		break;	
		case 'dMy':
			$date	=	date('d M Y', strtotime($date));
		break;	
		case 'Mdy':
			$date	=	date('M d Y', strtotime($date));
		break;	
		case 'yMd':
			$date	=	date('Y M d', strtotime($date));
		break;	
	}
	return $date;
}
?>
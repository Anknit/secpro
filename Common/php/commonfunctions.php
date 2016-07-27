<?php
function ieversion()
{
  	ereg('MSIE ([0-9]\.[0-9])',$_SERVER['HTTP_USER_AGENT'],$reg);
  	if(!isset($reg[1])) 
	{
    	return -1;
  	} 
	else 
	{
    	return floatval($reg[1]);
  	}
}

//Generate a random number (as string) of length recieved in arguments
function randomNumber_String($length)
{
	$i=0;
	$randomCode	=	"".mt_rand(1,9);
	do {
		$randomCode .= mt_rand(0, 9);
	} while(++$i < $length);

	return $randomCode;
}

//This method checks if the object for  a class exists. If it doesn't then the object with class name is created with global scope. The class name is taken as an argument
function getclassObject($className, $constructorParams	=	''){
	global $$className;
	if(!isset($$className)){
		$$className	=	 new $className($constructorParams);
	}
	return $$className;
}

/*
	calls a class method and returns the output
	@param classname : exact name of the class whose method is to be called
	@param function : exact name of the class method
	@param arguments : argument should be single. If inside a function multiple arguments are required then they should be recieved via 		
	an array
	Probably this corresponds to call_user_func
*/
function getInfoFrom($className, $operationName, $arguments = '', $arg2 = '', $arg3 = '', $arg4 = ''){
	$classObject	=	 getclassObject($className);
	return call_user_func(array($classObject, $operationName), $arguments, $arg2, $arg3, $arg4);
}

function IfValid ($variable) {
	if($variable	!=	"" && $variable != NULL)
		return true;
	else
		return false;
}

function array_indexed_merge_at_end($arr1, $arr2){
	$initFrom	=	count($arr1);
	$PushUpto	=	count($arr2);
	$j = 0;
	for($i = $initFrom; $j< $PushUpto; $i++){
		if(IfValid($arr2[$j]))
			$arr1[$i]	=	$arr2[$j];
			
		$j++;
	}
	return $arr1;
}

/*
	Scenario/example usage: You have an array2. It is modified to array1. So there are two possibilities which leads to these changes. 1 is addition of elements, 2 is removal of elements. So we need to find this differential change from array 2 to array 1. So this function finds the differences made to array 2.
	
@Description:	The function compares two arrays and find out the difference in elements.
@param1: mandatory		An array(which is final version).
@param2: mandatory		An array which has been modified to array1 (given in param 1).
@Return: 		An array with two elements.
				return array[0]	=> elements added into second array
				return array[1]	=> elements removed from second array
				return array[3]	=> true/false, where false means there's no change in arrays.	
*/
function checkDifferenceInArrays($diffArr1, $diffArr2){
	//let us suppose arr1 as final version and arr2 as unchanged version
	//$diffArr1 = array("a" => "green", "red", "blue", "red");
	//$diffArr2 = array("b" => "green", "yellow", "red");
	$AddedElements 		= array_diff($diffArr1, $diffArr2);
	$RemovedElements	= array_diff($diffArr2, $diffArr1);
	
	//Check if there's any change or not
	$changes	=	false;
	if(count($AddedElements) > 0)
		$changes	=	true;
	else if(count($RemovedElements) > 0)
		$changes	=	true;
		
	return array($AddedElements, $RemovedElements, $changes);
}

/*
	This is plus to above API. Sometimes when difference between two strings(that have comma separated items) is to be required, this can be called and behaves the same way above API does.
*/
function checkDifferenceInDelimiterSeparatedStrings($stringDiff1, $stringDiff2, $Delimiter	=	','){
	$diffArr1	=	explode($Delimiter, $stringDiff1);
	$diffArr2	=	explode($Delimiter, $stringDiff2);
	
	return checkDifferenceInArrays($diffArr1, $diffArr2);
}

/*
	Below functions will work only if session_start() has been executed
*/
function setObjectInSession($sessionKey, $object){
	$_SESSION[$sessionKey]	=	serialize($object);
	return true;
}
function getObjectFromSession($sessionKey){
	$_SESSION[$sessionKey]	=	unserialize($_SESSION[$sessionKey]);
	return true;
}

/*
	 This function will work well only when HTTP raw post data is on
	 The output is an associative array where keys are querystring param name , with the corresponding values
*/
function getRaciParameters(){
	$paramStr 	= trim($GLOBALS['HTTP_RAW_POST_DATA']);
	if($paramStr	!= '' && $paramStr != NULL)
		parse_str($paramStr, $output);
	else
		$output	=	'No data recieved';	
	
	return $output;		
}

//Input can be an array or a comma separated string only
function createCommaSeparatedListForMysqlIN($inputValues){
	$resultingString	=	'';
	if(!empty($inputValues)) {
		if(!is_array($inputValues))
			$arrayValues	=	explode(',', $inputValues);
		else
			$arrayValues	=	$inputValues;
	
		$resultingString	=	'"'.implode('", "', $arrayValues).'"';
	}
	return $resultingString;
}

function sendExternalRequest($data = '', $url = ''){
	if(empty($url)) return false;	//NO API URL has been provided
	
	$context  = stream_context_create($data);
	$result = file_get_contents($url, false, $context);
	//var_dump(headers_list()); 
	return $result;
}
?>
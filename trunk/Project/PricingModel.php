<?php

//This is the rate price / meter unit 
$gRatePPUBase = '10'; //in dollars
$gRateFeature1 = '5';

//This is the min. duration of debit
$gMeterUnitSize = 1 ; //minutes for hour make it 60
$gMinFilePrice = 3; //in dollar 
$gMaxMeterUnitAllowed = 10; //meter units 


//the array key is the name of the feature and the corresponding value is the unit rate
$gPriceInfo =  array(
		"BASE"=>0.15,			/*in dollar*/
		"LOUDNESS_CORRECTION"=> 0.03,
		"ULTRA_HD"=>0.10		
);

?>
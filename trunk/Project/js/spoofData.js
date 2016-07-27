/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function randomize_Data(queryString){
    var dirtydataArray = new Array('vW2p4U2l','Fe5Vn7sR','hw9Nu8Mz','Tm4P1aD4','xo9Rb3yT','i9QsLn7g','o5jQv8eN','Szl78hCj','iIHs2dk4','Zu6wYs8b');
    var randomized_Data = "", RandomCount	= 0, keypairs;
    var fieldpairs = queryString.split("&");
	
    for(i = 0; i< fieldpairs.length ; i++){
        keypairs = fieldpairs[i].split("=");
		for( j = 0; j < keypairs.length; j++)
		{
			if(RandomCount	==	10)RandomCount = 0;
			keypairs[j]	=	dirtydataArray[RandomCount]+keypairs[j]+dirtydataArray[RandomCount+1];
			RandomCount+=2;
		}
        randomized_Data = keypairs.join("=");
		fieldpairs[i]	=	randomized_Data;
		randomized_Data	=	"";
    }
	randomized_Data = fieldpairs.join("&");
    return randomized_Data;
}

function clean_Data(randomized_Data){
	var cleaned_Data = randomized_Data.replace(/vW2p4U2l|Fe5Vn7sR|hw9Nu8Mz|Tm4P1aD4|xo9Rb3yT|i9QsLn7g|o5jQv8eN|Szl78hCj|iIHs2dk4|Zu6wYs8b/gi, "");
	return cleaned_Data;
}

function EncodeData(RandomizedData) {
	var EncodedData	=	base64_encode(unescape(encodeURIComponent(RandomizedData)));
	return EncodedData;
}
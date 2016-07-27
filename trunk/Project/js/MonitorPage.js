/* Test file for monitor page */

var htmlDataObject = new Object();
var actualDumpObject	=	new Object();
$(function(){
	changeinputValue();
});
var imagesList	=	['./../images/im1.png', './../images/red.png', './../images/tick.png', './../images/im2.png'];
var statusColor	=	['red', 'green'];
var changeinputValue	=	function(){
	actualDumpObject['1']	=	{
								'channelId':'101',
								'status':Math.floor(Math.random() * 3),
								'profiles':
									{
										'1':
											{
												'profileID':'101',
												'status':Math.floor(Math.random() * 3),
												'msg':randomCharacterString(4)
											},
										'2':
											{
												'profileID':'102',
												'status':Math.floor(Math.random() * 3),
												'msg':randomCharacterString(8)
											}
									},
								'thumbnail':imagesList[Math.floor(Math.random() * 3)+1]
								};
	actualDumpObject['2']	=	{
								'channelId':'102',
								'status':Math.floor(Math.random() * 3),
								'profiles':
									{
										'1':
											{
												'profileID':'201',
												'status':Math.floor(Math.random() * 3),
												'msg':randomCharacterString(9)
											},
										'2':
											{
												'profileID':'202',
												'status':Math.floor(Math.random() * 3),
												'msg':randomCharacterString(5)
											}
									},
									'thumbnail':imagesList[Math.floor(Math.random() * 3)]
								};
	manipulateDataAndUpdate(actualDumpObject);
	setTimeout(changeinputValue , 1000);

};
var manipulateDataAndUpdate	=	function(DataObject){
	for(var key in DataObject){
		var channelDataObject	=	DataObject[key];
		var errMsgString	=	'';
		if(channelDataObject.status	!= 0 && channelDataObject.status != '0'){
			for(var key in channelDataObject.profiles){
				var profileObject	=	channelDataObject.profiles[key];
				htmlDataObject[$('[profileId="'+profileObject["profileID"]+'"]').attr('customValueOf')]	=	{'background': setStatusColor(profileObject.status)};
				errMsgString	+=	profileObject["msg"]+'<br />';
			}
			htmlDataObject[$('.error_div[channelId="'+channelDataObject["channelId"]+'"]').attr('customValueOf')]	=	errMsgString;
			htmlDataObject[$('.timeData[channelId="'+channelDataObject["channelId"]+'"]').attr('customValueOf')]	=	new Date().toLocaleTimeString('en-US', { hour12: false });
		}
		htmlDataObject[$('img[channelId="'+channelDataObject["channelId"]+'"]').attr('customValueOf')]	=	{'src': channelDataObject["thumbnail"]};
	}
	venera_update_data(htmlDataObject);
};
var setStatusColor	=	function(status){
	var colorname;
	switch (status) {
	case 0:
		colorname	=	'green';
		break;
	case 1:
		colorname	=	'orange';
		break;
	case 2:
		colorname	=	'red';
		break;
	}
	return colorname;
};
changeImageObject	=	function(){
	setObjectKey('img_data',  {'src': './../images/red.png'});
};
changeImageObject1	=	function(){
	setObjectKey('img_data',  {'src': './../images/tick.png'});
};
var setObjectKey	=	function(key, value){
	htmlDataObject[key]	=	value;
	venera_update_data(htmlDataObject);
};
function randomCharacterString(stringLength)
{
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < stringLength; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}
/* Test file for grid monitor */

var htmlDataObject	=	new Object();
var	filetime;

$(function(){
	repeatCall();
});
function repeatCall(){
	blobBinarydata();
	setTimeout(repeatCall, 3000);
}
function blobBinarydata(){
	window.URL = window.URL || window.webkitURL;  // Take care of vendor prefixes.
	var xhr = new XMLHttpRequest();
	xhr.open('HEAD', "http://192.168.0.113/Web_Projects/Trunk/NOVA/TN/channel1.png", true);
	xhr.getResponseHeader('Last-Modified');
	xhr.onload = function(e) {
		if(this.status == 200) {
			currentFileTime	=	new Date(this.getResponseHeader('Last-Modified')).getTime();
			if(filetime != currentFileTime){
				var xhr2 = new XMLHttpRequest();
				xhr2.open('GET', "http://192.168.0.113/Web_Projects/Trunk/NOVA/TN/channel1.png", true);
				xhr2.responseType = 'blob';
				xhr2.onload = function(e) {
					if(this.status == 200) {
						var blob = this.response;
						htmlDataObject[$('img[channelId="101"]').attr('customValueOf')]	=	{'src': window.URL.createObjectURL(blob)};
						venera_update_data(htmlDataObject);
						$('[channel="101"]').html('Last Updated at '+new Date().toLocaleTimeString('en-US', { hour12: false }));
					}
				filetime = currentFileTime;
				};
				xhr2.send();
			}
		}
	};
	xhr.send();
}
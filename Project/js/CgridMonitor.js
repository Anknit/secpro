/* test file for canvas rendering */
var htmlDataObject	=	new Object();
var GlobalImage		=	new Image();
$(function(){
	repeatCall();
});
function imgOncanvas(imgData, canvID) {
	var canvas  =	$('[channelId="'+canvID+'"]');
	var ctx 	=	canvas[0].getContext("2d");
	ctx.clearRect(0, 0, canvas.width, canvas.height);
	var encodedimage	=	base64_encode(imgData).replace(/\//g,"");
	var img = $('[channelId="1010"]');
	img.attr("src","data:image/png;base64,"+encodedimage);
	ctx.drawImage(img, 20,20);
}
function repeatCall(){
	blobBinarydata();
	setTimeout(repeatCall, 3000);
}
function blobBinarydata(){
	window.URL = window.URL || window.webkitURL;  // Take care of vendor prefixes.
	var xhr = new XMLHttpRequest();
	xhr.open('GET', "http://127.0.0.1/Web_Projects/Trunk/NOVA/TN/channel1.png", true);
	xhr.responseType = 'blob';
	xhr.setRequestHeader('Access-Control-Allow-Origin', 'http://localhost');
	xhr.onload = function(e) {
	  if (this.status == 200) {
	    var blob = this.response;
	    GlobalImage.onload = function(e) {
	      window.URL.revokeObjectURL(GlobalImage.src); // Clean up after yourself.
			var canvas  =	$('[channelId="101"]');
			var ctx 	=	canvas[0].getContext("2d");
			ctx.clearRect(0,0,canvas.width(),canvas.height());
			ctx.drawImage(GlobalImage, 0,0);
	    };
	    GlobalImage.src = window.URL.createObjectURL(blob);
	  }
	};
	xhr.send();
}
var socketApiPath = "./../clack-master/lib/";
var sserver = require(socketApiPath + "SocketServer");
var clObj = new sserver(3001);
clObj.activateListeners();
clObj.on("newsocket", function (a, b) {
    console.log('ankit'+a);
    console.log('ankit'+b);
});
clObj.on("newmessage", function (a, b) {
   //clObj.sendMessage('pappa',"Abba",a.message); 
});



var express = require('express'),
    httpServer = express(),
    socketServer = require('express-ws')(httpServer),
    socketConnections = 0,
    socketMap = {};

httpServer.use(function (req, res, next) {
    console.log('middleware');
    req.testing = 'testing';
    return next();
});
 
httpServer.get('/', function(req, res, next){
    console.log('get route', req.testing);
    res.end();
});

var getConnIds = function (args) {
    return Object.keys(socketMap);
}

httpServer.ws('/', function(ws, req) {
    console.log('New Connection');
    ws.on('message', function(msg) {
        msg = JSON.parse(msg);
        if(msg.type == 'connectionId') {
            if(msg.data.connType == 'WebApp') {
                socketConnections++;
                socketMap[msg.data.connId] = ws;
                console.log(socketConnections + ' Sockets Active');
            }
        } else if(msg.type == 'picNotify') {
            var connArr = getConnIds(msg.data);
            for(var i = 0 ;i< connArr.length ; i = i + 1) {
                socketMap[connArr[i]].send(JSON.stringify({type:'notification', data:{connId: connArr[i], sourceData: msg.data}}));
            }
        }
    });
});
 
httpServer.listen(3000);
var express = require('express'),
    httpServer = express(),
    socketServer = require('express-ws')(httpServer),
    serverState = 'ideal',
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
 
httpServer.ws('/', function(ws, req) {
    console.log('New Connection');
    ws.on('message', function(msg) {
        msg = JSON.parse(msg);
        if(msg.type == 'connectionId') {
            socketConnections++;
            socketMap[msg.value] = ws;
            console.log(socketConnections + ' Sockets Active');
        }
    });
});
 
httpServer.listen(3000);
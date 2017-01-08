/*global angular*/
var ws;
(function () {
    'use strict';
    var mainapp = {},
        socketAddress = "localhost:3000";
    
    ws = new window.WebSocket("ws://" + socketAddress);
    mainapp = angular.module('mainapp', []);
    mainapp.constant('API_BASE', 'apis/v1/');

    ws.onopen = function () {
        window.appdata.userdata.socketId = window.appdata.userdata.socketId || new Date().getTime();
        ws.send(JSON.stringify({type: 'connectionId', data: {connId: window.appdata.userdata.socketId, connType: 'WebApp'}}));
    }

    ws.onclose = function () {
        alert('Socket Closed');
    }

    ws.onerror = function (message) {
        alert('error');
    }
}());
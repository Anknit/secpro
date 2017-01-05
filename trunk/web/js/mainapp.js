/*global angular*/
(function () {
    'use strict';
    var mainapp = {},
        socketAddress = "localhost:3000",
        ws = new window.WebSocket("ws://" + socketAddress);
    mainapp = angular.module('mainapp', []);
    mainapp.constant('API_BASE', 'apis/v1/');

    ws.onopen = function () {
        window.appdata.userdata.socketId = window.appdata.userdata.socketId || new Date().getTime();
        ws.send(JSON.stringify({type: 'connectionId',value : window.appdata.userdata.socketId}));
    }

    ws.onclose = function () {
//        alert('hello123');
  //      document.getElementById("connection_state").innerHTML = "Disconnected";
    }

    ws.onmessage = function (payload) {
        console.log(payload);
        var child = "<p>&#9787;&nbsp;" + payload.data + "</p>";
    //    document.getElementsByClassName("messages_received")[0].innerHTML += child;
    }

    ws.onerror = function (message) {
        alert('error');
      //   document.getElementById("connection_state").innerHTML = "Error occured while trying to connect " + socketAddress;
    }


}());
/*global angular*/
(function () {
    'use strict';
    var mainapp = {};
    mainapp = angular.module('mainapp', []);
    mainapp.constant('API_BASE', 'apis/v1/');
    var socketAddress = "54.200.50.223:3001";
    var ws = new WebSocket("ws://" + socketAddress);

    ws.onopen = function() {
        // Send the username when user is connected
        // This is required to attach the username to the server socket
        ws.send(JSON.stringify({"username" : "Abba"}));
    }

    ws.onclose = function() {
        alert('hello123');
  //      document.getElementById("connection_state").innerHTML = "Disconnected";
    }

    ws.onmessage = function(payload) {
        console.log(payload);
        var child = "<p>&#9787;&nbsp;" + payload.data + "</p>";
    //    document.getElementsByClassName("messages_received")[0].innerHTML += child;
    }

    ws.onerror = function(message) {
        alert('error');
      //   document.getElementById("connection_state").innerHTML = "Error occured while trying to connect " + socketAddress;
    }


}());
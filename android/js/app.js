/*global angular, cordova*/
(function onInit() {
    'use strict';
    var isAuth = localStorage.getItem("isAuth");
    if (typeof isAuth === "undefined") {
        window.location.href = "./signup.html";
        return true;
    }
    if (isAuth === "true") {
        window.connectionHash = window.localStorage.getItem('socketId');
    } else {
        window.location.href = "./login.html";
    }
}());
var ws = new window.WebSocket("ws://" + socketAddress);
    ws.onopen = function () {
        window.socketId = window.socketId || new Date().getTime();
        ws.send(JSON.stringify({type: 'connectionId', data:{connId: window.socketId, connType: 'SourceApp'}}));
    }

    ws.onclose = function () {
        alert('Socket Connection Closed');
    }

    ws.onmessage = function (payload) {
        console.log(payload);
    }

    ws.onerror = function (message) {
        alert('error');
    }

angular.module('secpro', ['ionic', 'app.controllers', 'app.routes', 'app.directives', 'app.services'])
    .constant('AUTH_SERVICE_BASE', window.authServiceBase)
    .constant('API_SERVICE_BASE', window.apiServiceBase)
    .constant('CONNECTION_HASH', window.connectionHash)
    .constant('CONNECTION_BASE', window.connectionBase)
    .run(function ($ionicPlatform) {
        'use strict';
        $ionicPlatform.ready(function () {
            if (window.cordova && window.cordova.plugins && window.cordova.plugins.Keyboard) {
                cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
                cordova.plugins.Keyboard.disableScroll(true);
            }
            if (window.StatusBar) {
                window.StatusBar.styleDefault();
            }
        });
    });
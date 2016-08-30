autoCapture = function (successCallback, errorCallback) {
    'use strict';
    cordova.exec(successCallback, errorCallback, "Echo", "echo", []);
};
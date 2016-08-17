/*global angular, cordova*/
(function onInit() {
    'use strict';
    var isAuth = localStorage.getItem("isAuth");
    if (typeof isAuth === "undefined") {
        window.location.href = "./signup.html";
        return true;
    }
    if (isAuth === "true") {
        window.location.href = "home.html";
    } else {
        window.location.href = "./login.html";
    }
}());
angular.module('secpro', ['ionic', 'app.controllers', 'app.routes', 'app.directives', 'app.services'])
    .constant('AUTH_SERVICE_BASE', window.authServiceBase)
    .constant('API_SERVICE_BASE', window.apiServiceBase)
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
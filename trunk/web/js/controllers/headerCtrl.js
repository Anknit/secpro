/*global angular, $*/
(function () {
    'use strict';
    angular.module('mainapp').controller('headerController', ['$scope', '$rootScope', '$http', '$window', 'API_BASE', function ($scope, $rootScope, $http, $window, API_BASE) {
        $scope.user = {fname: $window.appdata.userdata.fname} || 'User';
        $scope.logout = function () {
            $http.post(API_BASE + 'logout', '', {headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function (response) {
                if (response.data.status) {
                    $window.location.reload();
                }
            }, function () {

            });
        };
    }]);
}());
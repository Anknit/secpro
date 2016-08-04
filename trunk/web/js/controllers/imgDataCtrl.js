/*global angular, $*/
(function () {
    'use strict';
    angular.module('mainapp').controller('imageDataController', ['$scope', '$rootScope', '$http', '$interval', '$window', 'API_BASE', function ($scope, $rootScope, $http, $interval, $window, API_BASE) {
        $scope.streamdata = {imgsrc: ''};
        $scope.updateFreq = 3000;
        var intervalId;
        $scope.fetchImageStream = function () {
            $http.get(API_BASE + 'imagestream', {headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function (response) {
                if (response.data.status) {
                    $scope.streamdata.imgsrc = response.data.data.url;
                }
            }, function () {

            });
        };
        $scope.getManualModeStream = function () {
            $scope.fetchImageStream();
            $interval.cancel(intervalId);
            intervalId = undefined;
        };
        
        $scope.getAutoModeStream = function () {
            intervalId = $interval($scope.fetchImageStream, $scope.updateFreq);
        };
    }]);
}());
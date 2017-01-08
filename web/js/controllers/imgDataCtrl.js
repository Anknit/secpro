/*global angular, $*/
(function (ws) {
    'use strict';
    angular.module('mainapp').controller('imageDataController', ['$scope', '$rootScope', '$http', '$interval', '$window', 'API_BASE', function ($scope, $rootScope, $http, $interval, $window, API_BASE) {
        $scope.streamdata = {imgsrc: '', comments: '', dataObj: []};
        $scope.updateFreq = 3000;
        var intervalId;
        $scope.fetchImageStream = function () {
            $http.get(API_BASE + 'imagestream', {headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function (response) {
                if (response.data.status) {
                    $scope.streamdata.imgsrc = response.data.data.url;
                    $scope.streamdata.comments = response.data.data.comments;
                    $scope.streamdata.dataObj.unshift(response.data.data);
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
            $scope.fetchImageStream();
            intervalId = $interval($scope.fetchImageStream, $scope.updateFreq);
        };
        ws.onmessage = function (payload) {
            var data = payload.data;
            if(data && typeof data == 'string') {
                data = JSON.parse(data);
                if(data && data.type == 'notification') {
                    $scope.streamdata.imgsrc = data.data.sourceData.data.filename;
                    data.data.sourceData.timestamp = new Date().getTime();
                    $scope.streamdata.comments = '';
                    $scope.streamdata.dataObj.unshift(data.data.sourceData);
                    $scope.$apply();
                }
            }
        };
    }]);
}(window.ws));
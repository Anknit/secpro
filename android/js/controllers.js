/*global angular*/
angular.module('app.controllers', [])
  
    .controller('homeCtrl', ['$scope', '$stateParams', 'captureService', 'uploadService', '$window', '$interval', function ($scope, $stateParams, captureService, uploadService, $window, $interval) {
        'use strict';
        var uploadParams = {};
        function uploadSuccess(response) {
            if (response.status) {
                $window.alert('Image uploaded successfully');
            } else {
                $window.alert('Image upload failed from server');
            }
        }
        function uploadFail(response) {
            $window.alert('Image upload failed by device');
        }
        function captureSuccess(mediaFiles) {
            $scope.previewSrc = mediaFiles[0].fullPath;
            uploadService.uploadCapture(mediaFiles, uploadSuccess, uploadFail);
        }
        function captureMedia() {
            captureService.captureMedia(captureSuccess);
        }
        $scope.autoModeCapture = function () {
            uploadParams.sesstype = 2;
            captureService.autoModeId = $interval(captureMedia, captureService.autoModeFreq);
        };
        $scope.stopAutoMode = function () {
            $interval.cancel(captureService.autoModeId);
            captureService.autoModeId = undefined;
            delete uploadParams.sesstype;
        };
        $scope.manualCapture = function () {
            uploadParams.sesstype = 1;
            captureMedia();
        };
    }])

    .controller('settingsCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {
        'use strict';
    }])

    .controller('accountCtrl', ['$scope', '$stateParams', '$http', '$window', 'API_SERVICE_BASE', function ($scope, $stateParams, $http, $window, API_SERVICE_BASE) {
        'use strict';
        $scope.logout = function () {
            $http.post(API_SERVICE_BASE + 'logout', {}, {}).then(function (response) {
                response = response.data;
                if (response.status) {
                    localStorage.removeItem('fname');
                    localStorage.removeItem('lname');
                    localStorage.removeItem("username");
                    localStorage.removeItem("isAuth");
                    localStorage.removeItem("isRemember");
                    $window.location.reload();
                } else {
                    $window.alert('Error in logout');
                }
            }, function () {

            });
        };

    }]);
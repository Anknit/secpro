/*global angular*/
angular.module('app.controllers', [])
  
    .controller('homeCtrl', ['$scope', '$stateParams', 'captureService', 'uploadService', '$window', '$interval', function ($scope, $stateParams, captureService, uploadService, $window, $interval) {
        'use strict';
        var uploadParams = {};
        $scope.previewSrc = '';
        $scope.comments = '';
        $scope.uploadConfirm = false;
        function uploadSuccess(response) {
            if (response.status) {
                $window.alert('Image uploaded successfully');
                $scope.uploadConfirm = false;
            } else {
                $window.alert('Image upload failed from server');
            }
        }
        function uploadFail(response) {
            $window.alert('Image upload failed by device');
        }
        function captureSuccess(mediaFiles) {
            $scope.previewSrc = mediaFiles[0].fullPath;
            $scope.$digest();
            if (uploadParams.sesstype === 2) {
                uploadService.uploadCapture(mediaFiles, uploadSuccess, uploadFail, uploadParams);
            } else {
                $scope.uploadConfirm = true;
            }
        }
        function captureMedia() {
            captureService.captureMedia(captureSuccess);
        }
        
        var optionsTest = {
            name: "Image", //image suffix
            dirName: "CameraPictureBackground", //foldername
            orientation: "landscape", //or portrait
            type: "back" //or front
        };
        function takeAutoPicture () {
            window.plugins.CameraPictureBackground.takePicture(successTest, errorTest, optionsTest);
        }

        function successTest(imgurl) {
            console.log("Imgurl = " + imgurl);
        }
        function errorTest () {
            
        }
        $scope.autoModeCapture = function () {
            uploadParams.sesstype = 2;
            captureService.autoModeId = $interval(takeAutoPicture, captureService.autoModeFreq);
/*
            captureService.autoModeId = $interval(captureMedia, captureService.autoModeFreq);
*/
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
        $scope.uploadImage = function () {
            uploadParams.sessname = $scope.comments;
            uploadService.uploadCapture(mediaFiles, uploadSuccess, uploadFail, uploadParams);
        };
        $scope.cancelUpload = function () {
            $scope.uploadConfirm = false;
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
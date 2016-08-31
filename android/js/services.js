/*global angular*/
angular.module('app.services', [])

    .factory('BlankFactory', [function () {
        'use strict';
    }])

    .service('uploadService', ['API_SERVICE_BASE', '$window', '$log', function (API_SERVICE_BASE, $window, $log) {
        'use strict';
        function upload(fileURL, mime, success, error, payLoad) {
            var ft, options = new $window.FileUploadOptions();
            options.fileKey = "file";
            options.fileName = fileURL.substr(fileURL.lastIndexOf('/') + 1);
            options.mimeType = mime;
            options.params = payLoad;
            ft = new $window.FileTransfer();
            ft.upload(fileURL, encodeURI(API_SERVICE_BASE + 'upload'), success, error, options);
        }
        var uploadService = {
            uploadCapture: function (mediaFiles, success, error, payLoad) {
                var f = mediaFiles[0];
                upload(f.localURL, f.type, function (response) {
                    success(angular.fromJson(response.response));
                    $log.log(response);
                }, function (response) {
                    error(response.response);
                    $log.log(response);
                }, payLoad);
            }
        };
        return uploadService;
    }])

    .service('captureService', [function () {
        'use strict';
        var captureService = {
            autoModeId: 0,
            autoModeFreq: 5000,
            streamprivacy: 1,
            captureMedia: function (successCallback) {
                navigator.device.capture.captureImage(
                    successCallback,
                    function () {
                        window.alert('Capture Failed');
                    },
                    {}
                );
            },
            autoCaptureOptions: {
                name: "Image", //image suffix
                dirName: "SecPro", //foldername
                orientation: "portrait", //or portrait
                type: "back" //or front
            },
            takeAutoPicture: function (successCallback) {
                window.plugins.CameraPictureBackground.takePicture(
                    successCallback,
                    function () {
                        window.alert('Capture Failed');
                    },
                    this.autoCaptureOptions
                );
            },
            setAutoModeFrequency: function () {},
            changeStreamingPrivacy: function () {},
            addComments: function () {}
        };
        return captureService;
    }]);
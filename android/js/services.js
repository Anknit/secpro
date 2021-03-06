/*global angular*/
angular.module('app.services', [])

    .factory('BlankFactory', [function () {
        'use strict';
    }])

    .service('notificationService', ['CONNECTION_BASE', 'CONNECTION_HASH', '$window', '$log', function (CONNECTION_BASE, CONNECTION_HASH, $window, $log) {
        'use strict';
        var connection,
            notificationService = {
                connect: function () {
                    connection = new $window.WebSocket(CONNECTION_BASE);
                    var notifyServiceObj = this;
                    connection.onopen = function () {
                        notifyServiceObj.register();
                    };
                    connection.onclose = function () {
                    };
                    connection.onmessage = function (payload) {
                    };
                    connection.onerror = function (message) {
                        $log.error(message);
                    };
                },
                register: function () {
                    connection.send(JSON.stringify({username : CONNECTION_HASH, action: "register"}));
                },
                notify: function (msg) {
                    connection.send(JSON.stringify({from : CONNECTION_HASH, action: "oto_message", to: CONNECTION_HASH + "-client", message: msg}));
                }
            };
        return notificationService;
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
    }])
    
    .service('locationService', [function () {
        'use strict';
        var ob_options = {
            maximumAge: 3600000,
            enableHighAccuracy: true
        }, locationService = {
            fn_getPosition: function (fn_successCallback, fn_errorCallback) {
                ob_options.timeout = 10000;
                navigator.geolocation.getCurrentPosition(fn_successCallback, fn_errorCallback, ob_options);
            },
            fn_watchPosition: function (fn_successCallback, fn_errorCallback) {
                ob_options.timeout = 3000;
                navigator.geolocation.watchPosition(fn_successCallback, fn_errorCallback, ob_options);
            },
            fn_setOptions: function (ob_configObj) {
                var key;
                for (key in ob_configObj) {
                    if (ob_configObj.hasOwnProperty(key)) {
                        ob_options[key] = ob_configObj[key];
                    }
                }
            }
        };
        return locationService;
    }])

    .service('trackingService', ['locationService', function (locationService) {
        'use strict';
        function locationRecieveSuccess(response) {
            window.alert(response);
        }
        function locationRecieveFailure(response) {
            window.alert(response);
        }
        var trackingService = {
            trackingFreq: 5000,
            getLocation: function () {
                locationService.fn_getPosition(locationRecieveSuccess, locationRecieveFailure);
            },
            sendLocation: function () {
                locationService.fn_getPosition(locationRecieveSuccess, locationRecieveFailure);
            }
        };
        return trackingService;
    }]);
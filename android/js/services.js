angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('uploadService',['API_SERVICE_BASE', '$window', function (API_SERVICE_BASE, $window){
    function upload(fileURL, mime, success, error) {
        var options = new $window.FileUploadOptions();
        options.fileKey = "file";
        options.fileName = fileURL.substr(fileURL.lastIndexOf('/') + 1);
        options.mimeType = mime;
        options.params = {};
        ft = new $window.FileTransfer();
        ft.upload(fileURL, encodeURI(API_SERVICE_BASE + 'upload' ), success, error, options);
    }
    var uploadService = {
        uploadCapture: function (mediaFiles, success, error) {
            var f = mediaFiles[0];
            upload(f.localURL, f.type, function (response) {
                success(angular.fromJson(response.response));
                console.log(response);
            }, function (response) {
                error(response.response);
                console.log(response);
            });
        }
    };
    return uploadService;
}])

.service('captureService', [function(){
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
        setAutoModeFrequency: function () {},
        changeStreamingPrivacy: function () {},
        addComments: function () {}
    };
    return captureService;
}]);
angular.module('app.services', [])

.factory('BlankFactory', [function(){

}])

.service('uploadService',['$rootScope', function ($rootScope){
    var uploadService = {
        uploadCapture: function (mediaFiles) {
            $rootScope.previewSrc = mediaFiles[0]['fullPath'];
            $rootScope.$digest();
        }
    };
    return uploadService;
}])

.service('captureService', ['uploadService', function(uploadService){
    var captureService = {
        autoModeId: 0,
        autoModeFreq: 5000,
        streamprivacy: 1,
        autoModeCapture: function () {
            this.autoModeId = window.setInterval(this.captureMedia, this.autoModeFreq);
        },
        manualModeCapture: function () {
            this.captureMedia();
        },
        stopAutoModeCapture: function () {
            window.clearInterval(this.autoModeId);
        },
        captureMedia: function () {
            navigator.device.capture.captureImage(
                uploadService.uploadCapture,
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
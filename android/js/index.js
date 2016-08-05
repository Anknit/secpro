(function () {
    'use strict';
    var secpro = {
        autoModeId: 0,
        autoModeFreq: 5000,
        streamprivacy: 1,
        initialize: function () {
            this.bindEvents();
        },
        bindEvents: function () {
            document.addEventListener('deviceready', this.onDeviceReady, false);
            document.getElementById('autoModeStart').addEventListener('click', this.autoModeCapture, false);
            document.getElementById('manualModeStart').addEventListener('click', this.manualModeCapture, false);
            document.getElementById('autoModeStop').addEventListener('click', this.stopAutoModeCapture, false);
        },
        onDeviceReady: function () {
            window.alert('Deviceready');
        },
        autoModeCapture: function () {
            this.autoModeId = window.setInterval(secpro.captureMedia, this.autoModeFreq);
        },
        manualModeCapture: function () {
            this.captureMedia();
        },
        stopAutoModeCapture: function () {
            window.clearInterval(this.autoModeId);
        },
        captureMedia: function () {
            navigator.device.capture.captureImage(
                secpro.uploadCapture,
                function () {
                    window.alert('Capture Failed');
                },
                {}
            );
        },
        uploadCapture: function (mediaFiles) {
            document.getElementById('captureview').setAttribute('src', mediaFiles[0].fullPath);
        },
        setAutoModeFrequency: function () {},
        changeStreamingPrivacy: function () {},
        addComments: function () {}
        
    };
    secpro.initialize();
}());
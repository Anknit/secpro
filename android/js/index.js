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
            secpro.autoModeId = window.setInterval(secpro.captureMedia, secpro.autoModeFreq);
        },
        manualModeCapture: function () {
            secpro.captureMedia();
        },
        stopAutoModeCapture: function () {
            window.clearInterval(secpro.autoModeId);
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
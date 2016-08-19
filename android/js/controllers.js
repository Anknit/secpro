angular.module('app.controllers', [])
  
.controller('homeCtrl', ['$scope', '$stateParams', 'captureService', 'uploadService', '$window', '$interval', function ($scope, $stateParams, captureService, uploadService, $window, $interval) {
    function captureMedia () {
        captureService.captureMedia(captureSuccess);
    }
    function captureSuccess (mediaFiles) {
        $scope.previewSrc = mediaFiles[0]['fullpath'];
        uploadService.uploadCapture(mediaFiles);
    }
    $scope.autoModeCapture = function () {
        captureService.autoModeId = $interval(captureMedia, captureService.autoModeFreq);
    };
    $scope.stopAutoMode = function () {
        $interval.cancel(captureService.autoModeId);
        captureService.autoModeId = undefined;
    }
    $scope.manualCapture = function () {
        captureMedia();
    };
}])
   
.controller('settingsCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {


}])
   
.controller('accountCtrl', ['$scope', '$stateParams', '$http', '$window', 'API_SERVICE_BASE', function ($scope, $stateParams, $http, $window, API_SERVICE_BASE) {
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
                alert ('Error in logout');
            }
        }, function () {
            
        });
    };

}])
    
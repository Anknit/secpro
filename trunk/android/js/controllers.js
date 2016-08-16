angular.module('app.controllers', [])
  
.controller('homeCtrl', ['$scope', '$stateParams', 'captureService', function ($scope, $stateParams, captureService) {
    $scope.autoModeCapture = function () {
        captureService.autoModeCapture();
    };
    $scope.manualCapture = function () {
        captureService.manualModeCapture();
    };
}])
   
.controller('settingsCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {


}])
   
.controller('accountCtrl', ['$scope', '$stateParams', function ($scope, $stateParams) {


}])
    
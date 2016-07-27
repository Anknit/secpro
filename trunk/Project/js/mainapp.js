var mainapp = {};
mainapp = angular.module('mainapp',['ui.bootstrap']);
mainapp.controller('loginctrl',['$scope','$uibModal','$http','$window',function($scope,$uibModal,$http,$window){
    $scope.openModal = function (type) {
        var modalInstance = $uibModal.open({
            animation: true,
            templateUrl: 'Project/templates/loginModalContent.html',
            controller: 'ModalInstanceCtrl',
            resolve:{
                type:function(){
                    return type;
                }
            }
        });
        modalInstance.result.then(function (type) {
            // Code when opened
        }, function () {
            // Code when modal closed
        });
    };
    $scope.logout = function(){
        $http.post('Project/apis/v1/logout','',{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(response){
            if(response.data.status){
                $window.location.reload();
            }
        },function(){
            
        });
    };
}]);
mainapp.controller('ModalInstanceCtrl',['$scope','$uibModalInstance','type','$http', '$window', function ($scope, $uibModalInstance, type, $http, $window) {
    $scope.type = type;
    $scope.close = function(){
        $uibModalInstance.dismiss('cancel');
    };
    $scope.loginUser = function () {
        $http.post('Project/apis/v1/login','email='+$scope.loginmail+'&password='+$scope.loginpswd,{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(response){
            if(response.data.status){
                $window.location.reload();
            }
        },function(){
            
        });
    };
    $scope.signupUser = function () {
        $http.post('Project/apis/v1/signup','email='+$scope.signupmail,{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(){
            
        },function(){
            
        });
    };
}]);
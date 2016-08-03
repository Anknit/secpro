var mainapp = {};
mainapp = angular.module('mainapp',[]);
mainapp.constant('API_BASE','apis/v1/');
mainapp.controller('headerController',['$scope', '$http', '$window', 'API_BASE', function($scope, $http, $window, API_BASE){
    $scope.openModal = function (type) {
        $scope.type = type;
        $('#login-modal').modal('show');
    };
    $scope.close = function(){
        $('#login-modal').modal('hide');
    };
    $scope.loginUser = function () {
        $http.post(API_BASE+'login','email='+$scope.loginmail+'&password='+$scope.loginpswd,{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(response){
            if(response.data.status){
                $window.location.reload();
            }
        },function(){
            
        });
    };
    $scope.signupUser = function () {
        $http.post(API_BASE+'signup','email='+$scope.signupmail,{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(){
            
        },function(){
            
        });
    };

    $scope.logout = function(){
        $http.post(API_BASE+'logout','',{headers:{'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function(response){
            if(response.data.status){
                $window.location.reload();
            }
        },function(){
            
        });
    };
}]);

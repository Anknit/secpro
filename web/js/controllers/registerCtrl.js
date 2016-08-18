/*global angular, $*/
(function () {
    'use strict';
    angular.module('mainapp').controller('registerController', ['$scope', '$http', '$window', 'API_BASE', function ($scope, $http, $window, API_BASE) {
        $('#register-modal').modal('show');
        $scope.registeremail = $window.registerObj.email;
        $scope.firstname = '';
        $scope.lastname = '';
        $scope.registerpswd = '';
        $scope.confirmpswd = '';

        $scope.registerUser = function () {
            if ($scope.registeremail.trim() === '' || $scope.firstname.trim() === '' || $scope.lastname.trim() === '' || $scope.registerpswd.trim() === '') {
                $window.alert('Please completely fill the details');
            } else if ($scope.registerpswd.trim() !== $scope.confirmpswd.trim()) {
                $window.alert('Passwords do not match');
            } else {
                $http.post(API_BASE + 'register', 'email=' + $scope.registeremail + '&password=' + $scope.registerpswd + '&fname=' + $scope.firstname + '&lname=' + $scope.lastname + '&referrer=' + $window.registerObj.link + '&lid=' + $window.registerObj.secureId, {headers: {'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'}}).then(function (response) {
                    if (response.data.status) {
                        $window.location = './../../';
                    }
                }, function () {

                });
            }
        };
    }]);
}());
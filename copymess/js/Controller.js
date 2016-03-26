var namespace = angular.module("myApp", []);
namespace.controller("MyController", function($scope, $http){
    $http.get('http://localhost/copymess/dashboard/expenditure/dailyexpense').success(function(data) {
        $scope.author = data;
    });
});

namespace.controller("")

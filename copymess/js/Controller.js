var namespace = angular.module("myApp", []);
namespace.controller("MyController", function($scope, $http, $log){
    $http.get('http://localhost/copymess/dashboard/expenditure/dailyexpense').success(function(data) {
        $scope.author = data;
    });

    //For making Delete
    $scope.delete = function($id, $usersid, $month) {
        var cnfrm = confirm("Are you sure to delete?");
        if(cnfrm) {
            $http.post('http://localhost/copymess/ajax/Expenditure.php', {'id': $id, 'usersid': $usersid, 'month': $month})
                .success(function(data) {
                    $scope.author = data;
                })
                .error(function(err) {
                    $log.error(err);
                })
        }
    }

    //For making Edit
    $scope.edit = function($id, $usersid, $month) {
        $http.post('http://localhost/copymess/ajax/ExpenditureEdit.php', {'id': $id, 'usersid': $usersid, 'month': $month})
            .success(function(data) {
                $scope.editData = data;
            })
    }

});


var namespace = angular.module("myApp", []);
namespace.controller("MyController", function($scope, $http, $log){
    /**
     * This is for collecting data from database
     */
    $http.get('customer/data').success(function(data) {
        $scope.customer = data;
    });

    /**
     * This is for active the customer
     * @param $id expect customer id from database
     */
    $scope.active = function($id) {
        $http.post('customer/status', {'id': $id})
            .success(function(data) {
                $scope.customer = data;
            })
    }

    /**
     * This is for view customer information
     * @param $id expect customer id from database
     */
    $scope.view = function($id) {
        alert($id);
    }

    /**
     * This is for block the customer
     * @param $id expect customer id from database
     */
    $scope.block = function($id) {
        $http.post('customer/status', {'id': $id})
            .success(function(data) {
                $scope.customer = data;
            })
    }

    /**
     * This is for delete the customer information from database
     * @param $id expect customer id from database
     */
    $scope.delete = function($id) {
        var cnfrm = confirm("Are you sure to delete ?");
        if(cnfrm) {
            $http.post('customer/delete', {'id': $id})
                .success(function(data) {
                    $scope.customer = data;
                })
        }
    }

    /**
     * This is for create a new customer in the Customer table
     * @param $params
     */
    $scope.pushData = function($params) {
        $http.post('customer/create',
            {
                'firstname'     : $params.firstname,
                'surname'       : $params.surname,
                'email'         : $params.email,
                'password'      : $params.password,
                'company_name'  : $params.company_name,
                'address'       : $params.address,
                'post_number'   : $params.post_number,
                'city'          : $params.city
            })
        .success(function(data) {
                $scope.myForm.$setPristine();
                $scope.myForm.$setUntouched();
                $params.firstname       = '';
                $params.surname         = '';
                $params.email           = '';
                $params.password        = '';
                $params.cnfrm_password  = '';
                $params.company_name    = '';
                $params.address         = '';
                $params.post_number     = '';
                $params.city            = '';
                $scope.customer         = data;
        })
    }

    $scope.dataFetch = function() {
        $http.get('customer/data').success(function(data) {
            $scope.customer = data;
        });
    }
});

/**
 * This is for password matching
 */
namespace.directive("passwordVerify", function() {
    return {
        require: "ngModel",
        scope: {
            passwordVerify: '='
        },
        link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;

                if (scope.passwordVerify || ctrl.$viewValue) {
                    combined = scope.passwordVerify + '_' + ctrl.$viewValue;
                }
                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
        }
    };
});

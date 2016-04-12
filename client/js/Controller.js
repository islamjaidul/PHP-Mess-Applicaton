var namespace = angular.module("myApp", []);
namespace.controller("MyController", function($scope, $http, $log){
    /**
     * This is for collecting data from database
     */
    $http.get('customer/data').success(function(data) {
        $scope.customer = data;
    });

    /**
     * This is for getting customer id and send it for pop up in admin/common/activation_confirm.blade.php
     * @param $id expect customer id from customer.blade.js
     */
    $scope.activationId = function($id) {
        $scope.id = $id;
    }

    /**
     * This is for getting customer id and send it for pop up in admin/common/delete_confirm.blade.php
     * @param $id expect customer id from customer.blade.js
     */
    $scope.deleteId = function($id) {
        $scope.id = $id;
    }

    /**
     * This is for active the account of customer
     * @param $id expect customer id from database
     */
    $scope.active = function ($id, $status) {
        $http.post('customer/status', {'id': $id, 'status': $status})
            .success(function(data) {
                $scope.customer = data;
            })
    }

    /**
     * This is for view customer information
     * @param $id expect customer id from database
     */
    $scope.view = function($id) {
        $http.post('customer/view', {'id': $id})
            .success(function(data) {
                $scope.customerView = data;
            })
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
        $http.post('customer/delete', {'id': $id})
            .success(function(data) {
                $scope.customer = data;
            })
    }

    /**
     * This is for create a new customer in the Customer table
     * @param $params
     */
    $scope.pushData = function($params) {
        $http.post('customer/create',
            {
                'firstname'     : $params.firstname,
                'lastname'      : $params.lastname,
                'email'         : $params.email,
                'password'      : $params.password,
                'company_name'  : $params.company_name,
                'address'       : $params.address,
                'postal_code'   : $params.postal_code,
                'city'          : $params.city,
                'phone'         : $params.phone
            })
            .success(function(data) {
                $scope.myForm.$setPristine();
                $scope.myForm.$setUntouched();
                $params.firstname       = '';
                $params.lastname         = '';
                $params.email           = '';
                $params.password        = '';
                $params.cnfrm_password  = '';
                $params.company_name    = '';
                $params.address         = '';
                $params.postal_code     = '';
                $params.city            = '';
                $params.phone           = '';
                $scope.customer         = data;
            })
    }

    /**
     * This is for when the email error message show
     * Then by clicking this function it will fetch the data from database
     */
    $scope.dataFetch = function() {
        $http.get('customer/data').success(function(data) {
            $scope.customer = data;
        });
    }

    /**
     * This is for edit customer information by admin
     * @param $params
     */
    $scope.editData = function($params) {
        $http.post('customer/edit',
            {
                'id'            : $params.id,
                'firstname'     : $params.firstname,
                'lastname'      : $params.lastname,
                'email'         : $params.email,
                'company_name'  : $params.company_name,
                'address'       : $params.address,
                'postal_code'   : $params.postal_code,
                'city'          : $params.city,
                'phone'         : $params.phone
             })
            .success(function(data) {
                    $scope.myForm1.$setPristine();
                    $params.firstname       = '';
                    $params.lastname         = '';
                    $params.email           = '';
                    $params.company_name    = '';
                    $params.address         = '';
                    $params.postal_code     = '';
                    $params.city            = '';
                    $params.phone           = '';
                    $scope.customer         = data;
            })
    }

    /**
     * This is for doing live (how many days / time) the customer account
     * @param $live expect date
     */
    $scope.accountLive = function($live, $id) {
        $http.post('customer/live', {'month': $live.month, 'id': $id})
            .success(function(data) {
                $scope.liveForm.$setPristine();
                $scope.liveForm.$setUntouched();
                $live.month       = '';
                $scope.customer = data;
            })
    }

    /**
     * This is for admin register
     * @param $params expect data
     */
    $scope.adminRegister = function($params) {
        $http.post('http://localhost/client/dashboard/admin/register', {'name': $params.name, 'email': $params.email, 'password': $params.password})
            .success(function(data) {
                $scope.registerForm.$setPristine();
                $scope.registerForm.$setUntouched();
                $params.name                    = '';
                $params.email                   = '';
                $params.password                = '';
                $params.password_confirmation   = '';
                $scope.customer = data;
            })
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

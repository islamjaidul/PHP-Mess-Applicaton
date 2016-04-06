angular.module('app', ['ngRoute', 'controller'])

    .config(function($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'admin/include/dashboard.blade.php'
            })
            .when('/customer', {
                templateUrl: 'admin/include/customer.blade.php',
            })
            .otherwise({
                templateUrl: 'templates/404.html'
            })
    })

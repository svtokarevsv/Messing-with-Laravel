(function () {
    'use strict';

    angular.module('app')
        .config(config);

    config.$inject = ['$routeProvider'];

    /* @ngInject */
    function config($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '/public/project/angular-app/layout/main.html',
                controller: 'MainController',
                controllerAs: 'vm'
            })
    } 

})();

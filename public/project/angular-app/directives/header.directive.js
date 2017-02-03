(function () {
    'use strict';

    angular
        .module('app')
        .directive('appHeader', appHeader);

    appHeader.$inject = [];

    /* @ngInject */
    function appHeader() {
        var directive = {
            // bindToController: true,
            // controller: HeaderDirective,
            templateUrl: '/public/project/angular-app/directives/header.html',
            // controllerAs: 'vm',
            link: link,
            restrict: 'EA',
            // scope: {}
        };
        return directive;

        function link(scope, element, attrs) {
            
        }
    }

    appHeaderDirective.$inject = [''];

    /* @ngInject */
    function appHeaderDirective() {
        
    }

})();



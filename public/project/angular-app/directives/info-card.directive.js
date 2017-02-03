(function () {
    'use strict';

    angular
        .module('app')
        .directive('infoCard', infoCard);

    infoCard.$inject = [];

    /* @ngInject */
    function infoCard( ) {
        var directive = {
            controller: infoCardController,
            controllerAs: 'vm',
            replace:true,
            templateUrl: '/public/project/angular-app/directives/info-card.html',
            link: link,
            restrict: 'EA'
            // scope: {}
        };
        return directive;

        function link(scope, element, attrs) {
            console.log('link');
        }
    }

    infoCardController.$inject = [];

    /* @ngInject */
    function infoCardController() {
        console.log(1);
    }

})();



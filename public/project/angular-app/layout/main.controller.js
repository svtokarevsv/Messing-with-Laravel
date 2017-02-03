(function () {
    'use strict';

    angular
        .module('app')
        .controller('MainController', MainController);

    MainController.$inject = ['$location'];

    /* @ngInject */
    function MainController($location) {
        var vm = this;
        vm.title = 'Main';
        vm.test = 'test123';
        vm.show=false;
        activate();

        ////////////////

        function activate() {
            console.log(vm.title);
        }
    }

})();



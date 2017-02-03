
(function () {
    'use strict';

    angular.module('app', ['ngRoute']);

})();
angular.element(document).ready(bootstrapApp);

function bootstrapApp(){
    angular.bootstrap(document.querySelector('#app'),['app']);
}
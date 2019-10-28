(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('instructionsController', instructionsController)

    instructionsController.$inject = ['$log', '$http', 'userData', 'MAIN_MENU'];

    function instructionsController($log, $http, userData, MAIN_MENU) {
        var vm = this;
        vm.ctrlType = 'instructions';

    }

})();
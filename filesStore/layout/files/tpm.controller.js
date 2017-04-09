(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('tpmController', tpmController)

    tpmController.$inject = ['$log', '$http', 'userData', 'MAIN_MENU'];

    function tpmController($log, $http, userData, MAIN_MENU) {
        var vm = this;
        vm.ctrlType = 'tpm';

    }

})();
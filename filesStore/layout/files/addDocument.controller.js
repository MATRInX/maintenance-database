(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('addDocumentController', addDocumentController);

    function addDocumentController($uibModalInstance, dataItems, $http) {
        var vm = this;
        vm.temp = dataItems;
        vm.data = {
            fileDescription: 'test1',
            filePath: 'test2'
        };

        vm.ok = ok;
        vm.cancel = cancel;
        vm.ttt = function () {
            
        }

        var fileData = {
            fileDescription: 'test1',
            filePath: 'test2'
        }

        function ok() {
            $uibModalInstance.close(vm.data);
        }

        function cancel() {
            $uibModalInstance.dismiss('Anulowane zamkniecie');
        }
    }
})();
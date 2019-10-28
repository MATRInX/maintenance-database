(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('addSimpleDataController', addSimpleDataController);

    function addSimpleDataController($uibModalInstance, dataItems, $log) {
        var vm = this;
        vm.textToDisplay = dataItems.textToDisplay;
        vm.newDataItem = '';

        vm.submitModal = submitModal;
        vm.closeModal = closeModal;
        ////////////////////////////////////////////////////////////////////////////////////////////
        function submitModal() {
            if (vm.newDataItem !== '') {
                $uibModalInstance.close(vm.newDataItem);
            }
            else {
                $uibModalInstance.close(null);
            }            
        }
        function closeModal() {
            $uibModalInstance.dismiss(false);
        }
    }
})();
(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('yesNoModalController', yesNoModalController);

    function yesNoModalController($uibModalInstance, dataItems, $log) {
        var vm = this;
        vm.textToDisplay = dataItems.text;

        vm.submitModal = submitModal;
        vm.closeModal = closeModal;

        ////////////////////////////////////////////////////////////////////////////////////////////
        function submitModal() {
            $uibModalInstance.close(true);
        }
        function closeModal() {
            $uibModalInstance.dismiss(false);
        }
    }
})()
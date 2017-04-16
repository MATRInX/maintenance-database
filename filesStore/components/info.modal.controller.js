(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('infoModalController', infoModalController);

    function infoModalController($uibModalInstance, dataItems, $log, $timeout) {
        var vm = this;
        vm.textToDisplay = dataItems.text;
        vm.additionalText = dataItems.additionalText;

        vm.submitModal = submitModal;
        vm.closeModal = closeModal;

        $timeout(closeInfoModal, 3000);

        ////////////////////////////////////////////////////////////////////////////////////////////
        function submitModal() {
            $uibModalInstance.close(true);
        }
        function closeModal() {
            $uibModalInstance.dismiss(false);
        }
        function closeInfoModal() {
            submitModal();
        }
    }
})()
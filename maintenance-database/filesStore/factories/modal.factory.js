﻿(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .factory('modalService', modalService);

    modalService.$inject = ['$http', '$log', '$q', '$uibModal'];

    function modalService($http, $log, $q, $uibModal) {
        var modal = null;
        var service = {
            callYesNoModal: callYesNoModal,
            callInfoModal: callInfoModal,
            callRepairModal: callRepairModal,
            callAddSimpleData: callAddSimpleData
        };

        return service;

        //////////////////////////////////////////////////////////////////////////////////////////
        function callYesNoModal(textToDisplay, modalSubmitted, modalClosed) {
            if (modalSubmitted != null && modalClosed != null) {
                var templateURL = 'components/yesNo.modal.html';
                var controller = 'yesNoModalController';
                var displayText = simpleModalWithText(textToDisplay);
                callModal(templateURL, controller, displayText, modalSubmitted, modalClosed);
            }
        }
        function callInfoModal(textToDisplay, modalSubmitted, modalClosed) {
            var templateURL = 'components/info.modal.html';
            var controller = 'infoModalController';
            var displayText = simpleModalWithText(textToDisplay);
            callModal(templateURL, controller, displayText, modalSubmitted, modalClosed);
        }
        function callRepairModal(dataItems, modalSubmitted, modalClosed) {
            var templateURL = 'components/repair.modal.html';
            var controller = 'repairModalController';
            callModal(templateURL, controller, dataItems, modalSubmitted, modalClosed);
        }
        function callAddSimpleData(dataItems, modalSubmitted, modalClosed) {
            var templateURL = 'components/addSimpleData.modal.html';
            var controller = 'addSimpleDataController';
            callModal(templateURL, controller, dataItems, modalSubmitted, modalClosed);
        }

        function callModal(templateUrl, controller, dataItems, modalSubmitted, modalClosed) {
            modal = $uibModal.open({
                templateUrl: templateUrl,
                controller: controller,
                controllerAs: 'vm',
                size: 'md',
                backdrop: 'static',
                resolve: {
                    dataItems: dataItems
                }
            });
            modal.result.then(modalSubmitted, modalClosed);
        }
        function simpleModalWithText(textToDisplay) {
            var returnValue = {
                text: textToDisplay,
            }
            return returnValue;
        }
    }
})();
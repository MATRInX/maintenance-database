(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('documentsController', documentsController);

    documentsController.$inject = ['$log', '$http', 'userData', 'MAIN_MENU',
                                   'documentsHelper', '$uibModal'];

    function documentsController($log, $http, userData, MAIN_MENU, documentsHelper, $uibModal) {
        var vm = this;
        vm.ctrlType = 'documents';
        vm.formsFilter = '';
        vm.protocolsFilter = '';
        vm.listsFilter = '';
        vm.formsData = [];
        vm.protocolsData = [];
        vm.listsData = [];
        vm.modal;

        //vm.addForm = addForm;
        //vm.addProtocol = addProtocol;
        vm.call = call;
        vm.close = close;
        vm.dismiss = dismiss;

        vm.clearFilter = clearFilter;
        vm.hideItems = hideAllItems;
        vm.showItems = showAllItems;

        documentsHelper.dataInitialisation()
            .then(getFormsDocuments)
            .then(getProtocolsDocuments)
            .then(getListsDocuments);

        ////////////////////////////////////////////////////////////////////////////////////////

        function call(text) {
            vm.modal = $uibModal.open({
                templateUrl: 'layout/files/addDocument.modal.html',
                controller: 'addDocumentController',
                controllerAs: 'vm',
                size: 'lg',
                resolve: {
                    dataItems: function () {
                        $log.log(text);
                        return text;
                    }
                }
            });
            vm.modal.result.then(function (result) {
                $log.log('Poprawnie zamkniety modal');
                $log.log(result);
            }, function (reason) {
                $log.log('Nie Poprawnie zamkniety modal');
                $log.log(reason);
            });
        }

        function close() {
            $log.log('close z modala');
            vm.modal.close();
        }

        function dismiss() {
            $log.log('dismiss z modala');
            vm.modal.dismiss('cancel');
        }

        function hideAllItems(array) {
            array.forEach(hideItem);
        }

        function showAllItems(array) {
            array.forEach(showItem);
        }

        function clearFilter(filter) {
            switch (filter) {
                case 'forms': vm.formsFilter = '';
                    break;
                case 'protocols': vm.protocolsFilter = '';
                    break;
                case 'lists': vm.listsFilter = '';
                    break;
            }
        }

        function hideItem(item) {
            item.isCollapsed = true;
        }
        
        function showItem(item) {
            item.isCollapsed = false;
        }
        
        function getFormsDocuments() {
            vm.formsData = documentsHelper.getFormsDocuments();
        }

        function getProtocolsDocuments() {
            vm.protocolsData = documentsHelper.getProtocolsDocuments();
        }
        
        function getListsDocuments() {
            vm.listsData = documentsHelper.getListDocuments();
        }
    }

})();
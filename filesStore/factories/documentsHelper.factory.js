(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .factory('documentsHelper', documentsHelper);

    documentsHelper.$inject = ['$http', '$log', '$q'];

    function documentsHelper($http, $log, $q) {
        var formsDocuments = [];
        var protocolsDocuments = [];
        var listsDocuments = [];
        var service = {
            // variables

            // functions
            dataInitialisation: dataInitialisation,
            getFormsDocuments: getFormsDocuments,
            getProtocolsDocuments: getProtocolsDocuments,
            getListDocuments: getListDocuments
        };

        return service;

        ////////////////////////////////////////////////////////////////////////////////////////
        function dataInitialisation() {
            var deffered = $q.defer();
            initForms();
            initProtocols();
            initLists();
            deffered.resolve();

            //
            return deffered.promise;

            function initForms() {

            }
            function initProtocols() {
                protocolsDocuments = [{
                        caption: 'Plik związany z dostępami',
                        isCollapsed: true,
                        isFileUploaded: false,
                        hyperlink: 'nazwa pliku.xlsx',
                        addDate: '2017-02-08 12:34:45',
                        uploaded: 'M. Wojtania',
                        userRights: 'admin'
                    },
                {
                    caption: 'Plik związany z markerami',
                    isCollapsed: true,
                    isFileUploaded: false,
                    hyperlink: 'nazwa drugiego pliku.xlsx',
                    addDate: '2017-02-03 12:34:45',
                    uploaded: 'B. Wetoszka',
                    userRights: 'user'
                }];
            }
            function initLists() {

            }
        }

        function getFormsDocuments() {
            return formsDocuments;
        }

        function getProtocolsDocuments() {
            return protocolsDocuments;
        }

        function getListDocuments() {
            return listsDocuments;
        }
    };
})();
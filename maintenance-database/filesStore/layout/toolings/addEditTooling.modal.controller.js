(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('addEditToolingController', addToolingController);

    function addToolingController($uibModalInstance, dataItems, $log, toolingsHelper, $q, modalService) {
        var vm = this;
        vm.formData = {
            hashNo: '',
            toolNo: '',
            oldToolNo: '',
            process: '',
            location: '',
            path: '',
            attention: '',
            isCollapsed: true,
            addDate: '',
            lastEditDate: '',
            mass: [],
            m20v: [],
            status: '',
            numberoftoolings: 1
        }
        vm.toolingLocation = [];
        vm.toolingLocationFilter = '';
        vm.toolingProcess = [];
        vm.toolingProcessFilter = '';
        vm.massReferences = [];
        vm.selectedMass = '';
        vm.massFilter = '';
        vm.m20vReferences = [];
        vm.selectedM20v = '';
        vm.m20vFilter = '';        
        vm.modalType = '';
        vm.isTypedHashUnique = true;
        vm.isHashNumber = true;
        vm.isToolNoEmpty = false;
        vm.isOldToolNoEmpty = false;
        vm.isClipboardEmpty = true;
        
        vm.getSelectData = getSelectData;
        vm.submitModal = submitModal;
        vm.closeModal = closeModal;
        vm.addMassItem = addMassItem;
        vm.addM20vItem = addM20vItem;
        vm.deleteMassItem = deleteMassItem;
        vm.deleteM20vItem = deleteM20vItem;
        vm.checkHashId = checkHashId;
        vm.clearHashNumberStatus = clearHashNumberStatus;
        vm.pasteClipboard = pasteClipboard;
        vm.callAddNewMass = callAddNewMass;
        vm.callAddNewM20v = callAddNewM20v;        

        vm.getSelectData();

        //////////////////////////////////////////////////////////////////////////////////////////
        function getSelectData() {
            toolingsHelper.getModalLists().then(getModalListsSuccess);
            vm.modalType = dataItems.type;
            //vm.toolingLocation = dataItems.lists.locations;
            //vm.toolingProcess = dataItems.lists.process;
            //vm.massReferences = dataItems.lists.mass;
            //vm.m20vReferences = dataItems.lists.m20v;
            if (vm.modalType == "edition") {
                var dataToEdit = JSON.parse(JSON.stringify(dataItems.data));                
                // For form field I have to clear hash number from '#' sign
                dataToEdit.hashNo = clearHashNumber(dataToEdit.hashNo);
                vm.formData = dataToEdit;
                checkToolNumber();
            }
            if (dataItems.clipboard !== null) {
                vm.isClipboardEmpty = false;
            }            
            // Part necessary if data for selects will be downloaded from database after modal is open
            function getModalListsSuccess(response) {
                vm.toolingLocation = response.locations;
                vm.toolingProcess = response.process;
                vm.massReferences = response.mass;
                vm.m20vReferences = response.m20v;
            }
        }
        function submitModal() {
            vm.isHashNumber = angular.isNumber(vm.formData.hashNo);
            if (vm.isHashNumber) {
                if (vm.formData.toolNo || vm.formData.oldToolNo) {                    
                    if (vm.modalType == 'edition') {
                        checkHashSuccess(true);
                    }
                    else {
                        checkHashId(vm.formData.hashNo).then(checkHashSuccess);
                    }
                }
                else {
                    checkToolNumber();
                }
            }            
            
            function checkHashSuccess(response) {
                vm.isTypedHashUnique = response;
                if (vm.isTypedHashUnique) {
                    // Deep clone of form data to not have any problems with not number hash number
                    var returnData = JSON.parse(JSON.stringify(vm.formData));
                    returnData.hashNo = "#" + returnData.hashNo;
                    $uibModalInstance.close(returnData);
                }
            }
        }
        function closeModal() {
            $uibModalInstance.dismiss('Anulowane modala');
        }
        function addMassItem(massItem) {
            var isUnique = true;
            vm.formData.mass.forEach(checkIsMassUnique);
            if (isUnique) {
                vm.formData.mass.push({name: massItem.name});
            }
            function checkIsMassUnique(item) {
                if (isUnique) {
                    if (item.name == massItem.name) {
                        isUnique = false;
                    }
                }                
            }
        }
        function addM20vItem(m20vItem) {
            var isUnique = true;
            vm.formData.m20v.forEach(checkIsM20vUnique);
            if (isUnique) {
                vm.formData.m20v.push({ name: m20vItem.name });
            }
            function checkIsM20vUnique(item) {
                if (isUnique) {
                    if (item.name == m20vItem.name) {
                        isUnique = false;
                    }
                }
            }
        }
        function deleteMassItem(deleteItem) {
            vm.formData.mass.forEach(deleteMass);
            function deleteMass(item, index) {
                if (item.name == deleteItem.name) {
                    vm.formData.mass.splice(index, 1);
                }                
            }            
        }
        function deleteM20vItem(deleteItem) {
            vm.formData.m20v.forEach(deleteM20v);
            function deleteM20v(item, index) {
                if (item.name == deleteItem.name) {
                    vm.formData.m20v.splice(index, 1);
                }
            }
        }        
        function checkHashId(idToCheck) {
            var deffered = $q.defer();
            toolingsHelper.checkHashId(idToCheck).then(checkHashIdSuccess);
            return deffered.promise;

            function checkHashIdSuccess(response) {
                deffered.resolve(response);
            }
        }
        function clearHashNumberStatus() {
            vm.isTypedHashUnique = true;
            vm.isHashNumber = true;
        }
        function clearHashNumber(hashNumber) {
            // Function return always hash number as number
            var returnValue = 0;
            var isHashSign = hashNumber.indexOf("#");
            if (isHashSign !== -1) {
                // There is a # sign
                returnValue = parseInt(hashNumber.slice(isHashSign + 1));                
            }
            else {
                returnValue = parseInt(hashNumber);
            }
            return returnValue;
        }
        function checkToolNumber(){
            if (vm.formData.toolNo)
                vm.isToolNoEmpty = false;
            else
                vm.isToolNoEmpty = true;
            if (vm.formData.oldToolNo)
                vm.isOldToolNoEmpty = false;
            else
                vm.isOldToolNoEmpty = true;
        }
        function pasteClipboard() {
            vm.formData.toolNo = dataItems.clipboard.toolNo;
            vm.formData.oldToolNo = dataItems.clipboard.oldToolNo;
            vm.formData.process = dataItems.clipboard.process;
            vm.formData.location = dataItems.clipboard.location;
            vm.formData.path = dataItems.clipboard.path;
            vm.formData.attention = dataItems.clipboard.attention;
            vm.formData.isCollapsed = dataItems.clipboard.isCollapsed;
            vm.formData.addDate = dataItems.clipboard.addDate;
            vm.formData.lastEditDate = dataItems.clipboard.lastEditDate;
            vm.formData.mass = dataItems.clipboard.mass;
            vm.formData.m20v = dataItems.clipboard.m20v;
        }
        function callAddNewMass() {
            var dataItems = function () {
                var returnValue = {
                    textToDisplay: 'Referencja MASS*'
                }
                return returnValue;
            }
            modalService.callAddSimpleData(dataItems, modalSubmitted, modalClosed);

            function modalSubmitted(result) {
                if (result !== null) {
                    toolingsHelper.addNewSimpleData('addNewMass', result).then(getMassReferences);
                }                
            }
            function modalClosed(reason) {
                $log.log('Anulowanie dodania nowej referencji MASS');
            }
        }
        function getMassReferences() {
            toolingsHelper.getMassReferences().then(getMassSuccess);

            function getMassSuccess(response) {
                vm.massReferences = response;
            }
        }
        function callAddNewM20v() {
            var dataItems = function () {
                var returnValue = {
                    textToDisplay: 'Referencja M20V*'
                }
                return returnValue;
            }
            modalService.callAddSimpleData(dataItems, modalSubmitted, modalClosed);

            function modalSubmitted(result) {
                if (result !== null) {
                    toolingsHelper.addNewSimpleData('addNewM20v', result).then(getM20vReferences);
                }
            }
            function modalClosed(reason) {
                $log.log('Anulowanie dodania nowej referencji M20V');
            }
        }
        function getM20vReferences() {
            toolingsHelper.getM20vReferences().then(getM20vSuccess);

            function getM20vSuccess(response) {
                vm.m20vReferences = response;
            }
        }
    }
})();
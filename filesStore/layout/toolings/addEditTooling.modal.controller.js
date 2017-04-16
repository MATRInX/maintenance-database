(function () {
    'use strict';

    angular
    .module('fileStoreApp')
    .controller('addEditToolingController', addToolingController);

    function addToolingController($uibModalInstance, dataItems, $log, toolingsHelper, $q, modalService, $scope) {
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
        vm.firstDataDownload = false;
        vm.toolingLocation = [];
        vm.toolingLocationFilter = '';
        vm.toolingProcess = [];
        vm.toolingProcessFilter = '';
        vm.massReferences = [];
        vm.massAddingNewItemsActive = false;
        vm.selectedMass = '';
        vm.massFilter = '';
        vm.m20vReferences = [];
        vm.m20vAddingNewItemsActive = false;
        vm.selectedM20v = '';
        vm.m20vFilter = '';        
        vm.modalType = '';
        vm.isTypedHashUnique = true;
        vm.isHashNumber = true;
        vm.isToolNoEmpty = false;
        vm.isOldToolNoEmpty = false;
        vm.isClipboardEmpty = true;
        
        vm.massTextareaEnter = massTextareaEnter;
        vm.m20vTextareaEnter = m20vTextareaEnter;
        
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
        vm.setM20vWaiter = setM20vWaiter;
        vm.clearM20vWaiter = clearM20vWaiter;
        vm.setMassWaiter = setMassWaiter;
        vm.clearMassWaiter = clearMassWaiter;

        vm.getSelectData(null);

        //$scope.$watch('vm.testowyString', testAdd);

        //////////////////////////////////////////////////////////////////////////////////////////
        function massTextareaEnter(event, text) {
            if (event.keyCode == 13 && text !== '') {  // ENTER is pressed and text is not a empty string
                event.preventDefault();
                vm.setMassWaiter();
                var addAndCheckNewMassItems = massAddAndCheck.bind(null, text);
                vm.getSelectData(addAndCheckNewMassItems);
                vm.massFilter = '';
            }
        }
        function m20vTextareaEnter(event, text) {
            if (event.keyCode == 13 && text !== '') {  // ENTER is pressed and text is not a empty string
                event.preventDefault();
                vm.setM20vWaiter();
                var addAndCheckNewM20vItems = m20vAddAndCheck.bind(null, text);
                vm.getSelectData(addAndCheckNewM20vItems);
                vm.m20vFilter = '';
            }
        }
        function massAddAndCheck(text) {
            var textArray = [];
            var textToCheck = '';
            var dbArrayCheckString = '';

            for (var i = 0; i < vm.massReferences.length; i++)
                dbArrayCheckString += vm.massReferences[i].name;

            // Check if there is a lot o lines
            var isDivider = text.search('\n');
            if (isDivider >= 0) {
                textArray = text.split('\n');
            }
            else {
                textToCheck = text;
            }
            // regular expression to check if text is good reference type word
            var regularExpressionForMass = "^(MASS|MAD0)+\\w{5}$";
            var textCheckRegExp = new RegExp(regularExpressionForMass, "i");

            if (textArray.length > 0) {
                checkNewItemAndReturnUnique(textCheckRegExp, textArray, vm.formData.mass, dbArrayCheckString);
            }
            else {
                checkNewItemAndReturnUnique(textCheckRegExp, textToCheck, vm.formData.mass, dbArrayCheckString);
            }
            // After last operation, waiter is not needed anymore
            vm.clearMassWaiter();
        }
        function m20vAddAndCheck(text) {
            var textArray = [];
            var textToCheck = '';
            var m20vString = '';

            for (var i = 0; i < vm.m20vReferences.length; i++)
                m20vString += vm.m20vReferences[i].name;

            // Check if there is a lot o lines
            var isDivider = text.search('\n');            
            if (isDivider >= 0) {
                textArray = text.split('\n');
            }
            else {
                textToCheck = text;
            }
            // regular expression to check if text is good reference type word
            var regularExpressionForM20v = "^(MS08|MP4A|M2GA|M20V|M20M|M20G|MP40|M5KA|M5EA|N20V|MK20V|M772)+\\w{5}$";
            var textCheckRegExp = new RegExp(regularExpressionForM20v, "i");

            if (textArray.length > 0) {
                checkNewItemAndReturnUnique(textCheckRegExp, textArray, vm.formData.m20v, m20vString);
            }
            else {
                checkNewItemAndReturnUnique(textCheckRegExp, textToCheck, vm.formData.m20v, m20vString);                
            }    
            // After last operation, waiter is not needed anymore
            vm.clearM20vWaiter();
        }
        function checkNewItemAndReturnUnique(mainRegularExpression, itemForCheck, arrayToUpdate, dbUniqueArray) {
            if (angular.isArray(itemForCheck)) {
                for (var i = 0; i < itemForCheck.length; i++) {
                    var singleItemCheck = itemForCheck[i].search(mainRegularExpression);
                    if (singleItemCheck >= 0) {
                        var regexp2 = new RegExp(itemForCheck[i], "i");
                        var regCheck2 = dbUniqueArray.search(regexp2);
                        if (regCheck2 >= 0) {
                            if (checkIsTextUniqueInArray(itemForCheck[i], arrayToUpdate))
                                arrayToUpdate.push({ name: itemForCheck[i].toUpperCase(), refOkAvailable: true, refOkNotAvailabel: false, refNok: false });
                        }
                        else {
                            if (checkIsTextUniqueInArray(itemForCheck[i], arrayToUpdate))
                                arrayToUpdate.push({ name: itemForCheck[i].toUpperCase(), refOkAvailable: false, refOkNotAvailabel: true, refNok: false });
                        }

                    }
                    else {
                        if (checkIsTextUniqueInArray(itemForCheck[i], arrayToUpdate))
                            arrayToUpdate.push({ name: itemForCheck[i].toUpperCase(), refOkAvailable: false, refOkNotAvailabel: false, refNok: true });
                    }
                }
            }
            else {
                var singleItemCheck = itemForCheck.search(mainRegularExpression);
                if (singleItemCheck >= 0) {
                    var regexp2 = new RegExp(itemForCheck, "i");
                    var regCheck2 = dbUniqueArray.search(regexp2);
                    if (regCheck2 >= 0) {
                        if (checkIsTextUniqueInArray(itemForCheck, arrayToUpdate))
                            arrayToUpdate.push({ name: itemForCheck.toUpperCase(), refOkAvailable: true, refOkNotAvailabel: false, refNok: false });
                    }
                    else {
                        if (checkIsTextUniqueInArray(itemForCheck, arrayToUpdate))
                            arrayToUpdate.push({ name: itemForCheck.toUpperCase(), refOkAvailable: false, refOkNotAvailabel: true, refNok: false });
                    }

                }
                else {
                    if (checkIsTextUniqueInArray(itemForCheck, arrayToUpdate))
                        arrayToUpdate.push({ name: itemForCheck.toUpperCase(), refOkAvailable: false, refOkNotAvailabel: false, refNok: true });
                }
            }
        }
        function checkIsTextUniqueInArray(textToCheck, arrayToCheck) {
            if (angular.isArray(arrayToCheck)) {
                for (var i = 0; i < arrayToCheck.length; i++) {
                    var textToCheck1 = arrayToCheck[i].name.toUpperCase();
                    var textToCheck2 = textToCheck.toUpperCase();
                    if (textToCheck1 == textToCheck2) {
                        return false;
                    }
                }
                return true;
            }
            return true;
        }

        function getSelectData(anotherPromise) {
            toolingsHelper.getModalLists().then(getModalListsSuccess).then(anotherPromise);
            vm.modalType = dataItems.type;
            //vm.toolingLocation = dataItems.lists.locations;
            //vm.toolingProcess = dataItems.lists.process;
            //vm.massReferences = dataItems.lists.mass;
            //vm.m20vReferences = dataItems.lists.m20v;
            if ((vm.modalType == "edition") && (!vm.firstDataDownload)) {
                vm.formData = JSON.parse(JSON.stringify(dataItems.data));
                // For form field I have to clear hash number from '#' sign
                vm.formData.hashNo = clearHashNumber(vm.formData.hashNo);
                checkToolNumber();
                vm.firstDataDownload = true;
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
                    var deleteData = [];
                    returnData.hashNo = "#" + returnData.hashNo;
                    checkReferences(returnData.m20v, deleteData);
                    checkReferences(returnData.mass, deleteData);
                    returnData.deleteInfo = deleteData;
                    $uibModalInstance.close(returnData);
                }
                function checkReferences(arrayWithData, deleteData) {
                    // delete wrong references or references which are not in database
                    var arraySize = arrayWithData.length;
                    for (var i = 0; i < arraySize; i++) {                        
                        if (arrayWithData[i].refNok || arrayWithData[i].refOkNotAvailabel) {
                            deleteData.push(arrayWithData[i].name);
                            arrayWithData.splice(i, 1);
                            i--;
                            arraySize--;
                        }                            
                    }
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
        function callAddNewMass(tempReference) {
            var dataItems = function () {
                var returnValue = {
                    textToDisplay: 'Referencja MASS*',
                    tempText: tempReference
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
                checkAddedMassReferences();
            }
        }
        function checkAddedMassReferences() {
            getSelectData(updateMassReferences);
            function updateMassReferences() {
                var massString = '';
                for (var i = 0; i < vm.massReferences.length; i++)
                    massString += vm.massReferences[i].name;

                for (var i = 0; i < vm.formData.mass.length; i++) {
                    if (vm.formData.mass[i].refOkNotAvailabel) {
                        var regexp2 = new RegExp(vm.formData.mass[i].name, "i");
                        var regCheck2 = massString.search(regexp2);
                        if (regCheck2 >= 0) {
                            // Reference is added I can change status
                            vm.formData.mass[i].refOkNotAvailabel = false;
                            vm.formData.mass[i].refOkAvailable = true;
                        }
                    }
                }
            }
        }
        function callAddNewM20v(tempReference) {
            var dataItems = function () {
                var returnValue = {
                    textToDisplay: 'Referencja M20V*',
                    tempText: tempReference
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
                checkAddedM20vReferences();
            }
        }
        function checkAddedM20vReferences() {
            getSelectData(updateM20vReferences);

            function updateM20vReferences() {
                var m20vString = '';
                for (var i = 0; i < vm.m20vReferences.length; i++)
                    m20vString += vm.m20vReferences[i].name;

                for (var i = 0; i < vm.formData.m20v.length; i++) {
                    if (vm.formData.m20v[i].refOkNotAvailabel) {
                        var regexp2 = new RegExp(vm.formData.m20v[i].name, "i");
                        var regCheck2 = m20vString.search(regexp2);
                        if (regCheck2 >= 0) {
                            // Reference is added I can change status
                            vm.formData.m20v[i].refOkNotAvailabel = false;
                            vm.formData.m20v[i].refOkAvailable = true;
                        }
                    }                    
                }
            }
        }
        function setM20vWaiter() {
            vm.m20vAddingNewItemsActive = true;
        }
        function clearM20vWaiter() {
            vm.m20vAddingNewItemsActive = false;
        }
        function setMassWaiter() {
            vm.massAddingNewItemsActive = true;
        }
        function clearMassWaiter() {
            vm.massAddingNewItemsActive = false;
        }
    }
})();
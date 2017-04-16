(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('toolingsListController', toolingsListController);

    toolingsListController.$inject = ['$scope', '$http', '$log', 'toolingsHelper', 'MAIN_MENU', 'filterFilter',
                                      '$uibModal', 'logged', 'userRight', '$timeout', 'modalService', 'userData',
                                      '$location', '$filter', '$sce'];

    function toolingsListController($scope, $http, $log, toolingsHelper, MAIN_MENU, filterFilter,
                                    $uibModal, logged, userRight, $timeout, modalService, userData, $location, $filter, $sce) {
        var vm = this;
        vm.loggedStatus = logged;
        vm.userRight = userRight;
        vm.toolingsData = [];
        vm.clipboardToolingsData = null;
        vm.toolingLocation = [];
        vm.toolingProcess = [];
        vm.massReferences = [];
        vm.m20vReferences = [];
        vm.userFullName = '';
        vm.menu = MAIN_MENU.MENU;
        vm.toolingFilter = '';
        vm.itemPerPage = 10;
        vm.currentPage = 1;
        vm.itemsMaxSize = 7;
        vm.totalItems = 0;
        vm.dataLoaded = false;
        vm.modal;        
        vm.tooltip = $sce.trustAsHtml("150001 <= HR-A <= 1000000<br />" +
                                      "100001 <= HR-B <= 150000<br />" +
                                      "50001 <= HR-C <= 100000<br />" +
                                      "15001 <= HR-D <= 50000<br />" +
                                      "5001 <= HR-E <= 15000<br />" +
                                      "1001 <= HR-F <= 5000<br />" +
                                      "501 <= HR-G <= 1000<br />");

        vm.clearFilter = clearFilter;
        vm.hideItems = hideAllItems;
        vm.showItems = showAllItems;
        vm.modalCall = modalCall;
        vm.deleteTooling = deleteTooling;
        vm.simpleEditor = simpleEditor;
        vm.fullEditor = fullEditor;
        vm.logoutUser = logoutUser;
        vm.checkIsEmptyField = checkIsEmptyField;
        vm.copyData = copyData;
        vm.clearClipboard = clearClipboard;
        vm.callAddRepairModal = callAddRepairModal;
        vm.callEditRepairModal = callEditRepairModal;
        vm.finishRepair = finishRepair;
        vm.pickupRepair = pickupRepair;

        $scope.$watch('vm.toolingFilter', toolingFilterWatch);

        //$timeout(initialize, 5000);
        initialize();

        /////////////////////////////////////

        function initialize() {
            checkLoginStatus();
            getToolingList();
            getSelectData();
        }
        function clearFilter() {
            vm.toolingFilter = '';
        }
        function hideAllItems(array) {
            array.forEach(hideItem);
        }
        function hideItem(item) {
            item.isCollapsed = true;
        }
        function showAllItems(array) {
            array.forEach(showItem);
        }
        function showItem(item) {
            item.isCollapsed = false;
        }
        function modalCall(type, index) {
            if (fullEditor(vm.userRight)) {
                //var realIndex = (index + (vm.itemPerPage * (vm.currentPage - 1)));
                var dataForModal = null;
                var toolingActionSuccessful = true;
                //if (index !== -1) {                    
                dataForModal = index;//vm.toolingsData[realIndex];
                //}
                vm.modal = $uibModal.open({
                    templateUrl: 'layout/toolings/addEditTooling.modal.html',
                    controller: 'addEditToolingController',
                    controllerAs: 'vm',
                    size: 'lg',
                    backdrop: 'static',
                    resolve: {
                        dataItems: function () {
                            var returnValue = {
                                type: type,
                                data: dataForModal,
                                lists: {
                                    locations: vm.toolingLocation,
                                    process: vm.toolingProcess,
                                    mass: vm.massReferences,
                                    m20v: vm.m20vReferences
                                },
                                clipboard: vm.clipboardToolingsData
                            }
                            return returnValue;
                        }
                    }
                });
                vm.modal.result.then(modalSubmitted, modalClosed);

                ////////////////////////////////////////////////////////////////////////////////////////////
                function modalSubmitted(result) {
                    if (type == 'add') {
                        toolingsHelper.addTooling(result).then(toolingActionCompleted);
                    }
                    if (type == 'edition') {
                        toolingsHelper.editTooling(result).then(toolingActionCompleted);
                    }
                    if (toolingActionCompleted) {
                        var textToDisplay = 'Narzędzie o numerze ' + result.hashNo;
                        if (type == 'add') {
                            textToDisplay += ' zostało poprawnie dodane.';
                        }
                        if (type == 'edition') {
                            textToDisplay += ' zostało poprawnie zmienione.';
                        }
                        // Information about deleted references
                        var deleteInfo = '';
                        if (angular.isArray(result.deleteInfo)) {
                            if (result.deleteInfo.length > 0) {
                                deleteInfo = "Wprowadzone pozycje: ";
                                deleteInfo += result.deleteInfo.join(", ");
                                deleteInfo += " nie zostały dodane z powodu błędów (postać lub typ referencji).";
                            }                            
                        }                        
                        modalService.callInfoModal(textToDisplay, deleteInfo, null, null, getToolingList);
                        getToolingList();
                    }
                    else {
                        alert('Zapytanie zakończone niepowodzeniem');
                    }
                }
                function modalClosed(reason) {
                    $log.log('Modal edycji narzędzia został zamknięty');
                }
                function toolingActionCompleted(response) {
                    toolingActionSuccessful = response;
                    getToolingList();
                }
            }
            else {
                alert('Nie masz wystarczających uprawnień aby wykonać to zadanie!');
            }
        }
        function toolingFilterWatch(search) {
            //var filtered = filterFilter(vm.toolingsData, search);
            var filtered = $filter('multiwords')(vm.toolingsData, search);
            vm.totalItems = filtered.length;
        }
        function getToolingList() {
            toolingsHelper.getToolingList().then(getToolingListSuccess);
            function getToolingListSuccess(response) {                
                vm.toolingsData = response;
		        if(vm.toolingsData !== null){
		             vm.totalItems = vm.toolingsData.length;
		        }	
                	
		        else{
		             vm.totalItems = 0;
		        }
            }
        }
        function getSelectData() {
            toolingsHelper.getModalLists().then(getModalListsSuccess);

            function getModalListsSuccess(response) {
                vm.toolingLocation = response.locations;
                vm.toolingProcess = response.process;
                vm.massReferences = response.mass;
                vm.m20vReferences = response.m20v;
                vm.dataLoaded = true;                
            }
        }

        function deleteTooling(idToDelete) {
            if (fullEditor(vm.userRight)) {
                var textToDisplay = 'Czy na pewno chcesz usunąć to narzędzie?';

                modalService.callYesNoModal(textToDisplay, modalSubmitted, modalClosed);

                function deleteCompleted(response) {
                    var deleteComplete = false;
                    deleteComplete = response;
                    if (deleteComplete) {
                        $log.log('Usunięcie zakończone powodzeniem');
                        getToolingList();
                    }
                    else {
                        $log.log('Usunięcie zakończone niepowodzeniem');
                    }
                }

                function modalSubmitted(result) {
                    if (result) {
                        toolingsHelper.deleteTooling(idToDelete).then(deleteCompleted);
                    }
                }
                function modalClosed(reason) {
                    $log.log(reason);
                }
            }
            else {
                alert('Nie masz wystarczających uprawnień aby wykonać to zadanie!');
            }
        }
        function simpleEditor(userRight) {
            if (userRight == 'simpleEditor' || fullEditor(userRight)) {
                return true;
            }
            else {
                return false;
            }
        }
        function fullEditor(userRight) {
            if (userRight == 'fullEditor' || userRight == 'admin') {
                return true;
            }
            else {
                return false;
            }
        }
        // Function to logout user and destroy session
        function logoutUser() {
            userData.logoutUser().then(logoutUserSuccessful);

            function logoutUserSuccessful(response) {
                if (response) {
                    vm.isUserLogged = !response;
                    checkLoginStatus();
                    $location.path('/login');
                }
                else {
                    alert('Wylogowanie zakończone niepowodzeniem!');
                }
            }
        }
        // Function only check if user is logged in and session has been started
        function checkLoginStatus() {
            var loginStatus = userData.getLoginStatus();
            if (loginStatus === null) {
                userData.checkLoginStatus().then(checkLoginSuccessful);
            }
            else {
                checkLoginSuccessful(loginStatus);
            }            

            function checkLoginSuccessful(response) {
                vm.isUserLogged = response;                
                vm.userFullName = userData.getUserName();
            }
        }
        function checkIsEmptyField(value) {
            var returnValue = true;
            var isString = angular.isString(value);
            if (isString) {
                if (value === '') {
                    returnValue = false;
                }
            }
            return returnValue;
        }
        function copyData(dataToCopy) {
            vm.clipboardToolingsData = JSON.parse(JSON.stringify(dataToCopy));
        }
        function clearClipboard() {
            vm.clipboardToolingsData = null;
        }
        function callAddRepairModal(toolData, type) {
            var repairData = {
                id: '',
                hashId: toolData.hashNo,
                partdesc: toolData.process + " " + toolData.location,
                failuredesc: '',
                repairdesc: '',
                breakdownDate: new Date(),
                repairDate: '',
                estimatedRepairDate: '',
                lastedit: '',
                status: 0
            }
            var dataItems = function () {
                var returnValue = {
                    type: type,
                    data: repairData
                }
                return returnValue;
            }
            modalService.callRepairModal(dataItems, modalSubmitted, modalClosed);

            /////////////////
            function modalSubmitted(result) {
                //$log.log(result);
                toolingsHelper.addRepair(result).then(getToolingList);
            }
            function modalClosed(reason) {
                $log.log('Modal dodania naprawy narzędzia został zamknięty');
            }
        }
        function callEditRepairModal(toolData, type) {
            //$log.log('Edit repair data');
            //$log.log(toolData);
            var repairData = {
                id: toolData.id,
                hashId: toolData.hashId,
                partdesc: toolData.partdesc,
                failuredesc: toolData.failuredesc,
                repairdesc: toolData.repairdesc,
                breakdownDate: new Date(toolData.breakdownDate),
                repairDate: new Date(toolData.repairDate),
                estimatedRepairDate: new Date(toolData.estimatedRepairDate),
                lastedit: toolData.lastedit,
                status: toolData.status,
                lastEditor: toolData.lastEditor,
                pickupDate: toolData.pickupDate
            }
            var dataItems = function () {
                var returnValue = {
                    type: type,
                    data: repairData
                }
                return returnValue;
            }
            modalService.callRepairModal(dataItems, modalSubmitted, modalClosed);

            /////////////////
            function modalSubmitted(result) {
                //$log.log('Repair edit data');
                //$log.log(result);
                toolingsHelper.editRepair(result).then(getToolingList);
            }
            function modalClosed(reason) {
                $log.log('Modal edycji naprawy narzędzia został zamknięty');
            }
        }
        function finishRepair(toolData) {
            toolData.status = 'Naprawa zakończona';
            toolingsHelper.finishRepair(toolData).then(getToolingList);
        }
        function pickupRepair(toolData) {
            toolData.status = 'Naprawa zakończona - odebrana';
            toolingsHelper.pickupRepair(toolData).then(getToolingList);
        }
    }
})();
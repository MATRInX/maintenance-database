(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('repairListController', repairListController);

    repairListController.$inject = ['$log', '$http', '$location', 'userData', 'MAIN_MENU', 'toolingsHelper',
                                    'logged', 'userRight', 'modalService'];

    function repairListController($log, $http, $location, userData, MAIN_MENU, toolingsHelper, logged, userRight,
                                  modalService) {
        var vm = this;
        vm.loggedStatus = logged;
        vm.userRight = userRight;
        vm.menu = MAIN_MENU.MENU;
        vm.userFullName = '';
        vm.repairFilter = '';
        vm.choiceIdVisible = false;

        vm.repairList = [];

        vm.logoutUser = logoutUser;
        vm.addRepair = addRepair;
        vm.editRepair = editRepair;
        vm.finishRepair = finishRepair;
        vm.pickupRepair = pickupRepair;
        vm.showAllRepairs = showAllRepairs;
        vm.hideAllRepairs = hideAllRepairs;
        vm.clearFilter = clearFilter;
        vm.checkFilterChoices = checkFilterChoices;

        initialize();

        //////////////////////////////////////////////////////////////////////////////////
        function checkFilterChoices() {
            if (vm.repairFilter === '') {
                vm.choiceIdVisible = false;
            }
            else {
                vm.choiceIdVisible = true;
            }
        }
        function initialize() {
            checkLoginStatus();
            getRepairList();
        }
        function getRepairList() {
            toolingsHelper.getRepairList().then(repairListFromDBSuccessful);

            function repairListFromDBSuccessful(response) {
                vm.repairList = response;
                $log.log(response);
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
        function addRepair(toolData, type) {
            var repairData = {
                id: '',
                hashId: '',
                partdesc: '',
                failuredesc: '',
                repairdesc: '',
                breakdownDate: new Date(),
                repairDate: '',
                estimatedRepairDate: '',
                lastedit: '',
                status: 'W trakcie naprawy'
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
                toolingsHelper.addRepair(result).then(getRepairList);
            }
            function modalClosed(reason) {
                $log.log('Modal dodania naprawy narzędzia został zamknięty');
            }
        }
        function editRepair(toolData, type) {
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
                toolingsHelper.editRepair(result).then(getRepairList);
            }
            function modalClosed(reason) {
                $log.log('Modal edycji naprawy narzędzia został zamknięty');
            }
        }
        function finishRepair(toolData) {
            //toolData.status = 'Naprawa zakończona';
            //toolData.breakdownDate = dateToString(toolData.breakdownDate);
            //toolData.repairDate = dateToString(toolData.repairDate);
            //toolData.estimatedRepairDate = dateToString(toolData.estimatedRepairDate);
            //toolData.pickupDate = dateToString(toolData.pickupDate);
            toolingsHelper.finishRepair(toolData).then(getRepairList);
        }
        function pickupRepair(toolData) {
            //toolData.status = 'Naprawa zakończona - odebrana';
            //toolData.breakdownDate = dateToString(toolData.breakdownDate);
            //toolData.repairDate = dateToString(toolData.repairDate);
            //toolData.estimatedRepairDate = dateToString(toolData.estimatedRepairDate);
            //toolData.pickupDate = dateToString(toolData.pickupDate);
            toolingsHelper.pickupRepair(toolData).then(getRepairList);
        }
        function showAllRepairs(array) {
            array.forEach(showRepair);
        }
        function hideAllRepairs(array) {
            array.forEach(hideRepair);
        }
        function showRepair(item) {
            item.isCollapsed = false;
        }
        function hideRepair(item) {
            item.isCollapsed = true;
        }
        function clearFilter() {
            vm.repairFilter = '';
            vm.choiceIdVisible = false;
        }
        function dateToString(date) {
            if (angular.isDate(date)) {
                var returnString = '';
                var YYYY = date.getFullYear();
                var mm = date.getMonth() + 1;
                var dd = date.getDate();
                var HH = date.getHours();
                var MM = date.getMinutes();
                var SS = date.getSeconds();
                returnString = YYYY + "-" + (mm > 9 ? mm : "0" + mm) + "-" + (dd > 9 ? dd : "0" + dd) + " ";
                returnString = returnString + (HH > 9 ? HH : "0" + HH) + ":" + (MM > 9 ? MM : "0" + MM) + ":" + (SS > 9 ? SS : "0" + SS);
                return returnString;
            }
            else
                return date;
        }
    }
})();
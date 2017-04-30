(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('referenceListController', referenceListController);

    referenceListController.$inject = ['$scope', '$http', '$log', 'toolingsHelper', 'MAIN_MENU', 'logged', 'userRight',
                                       'userData', '$location', '$filter', '$sce'];

    function referenceListController($scope, $http, $log, toolingsHelper, MAIN_MENU, logged, userRight,
                                       userData, $location, $filter, $sce) {
        var vm = this;
        vm.loggedStatus = logged;
        vm.userRight = userRight;
        vm.userFullName = '';
        vm.menu = MAIN_MENU.MENU;
        vm.m20v = [];
        vm.m20vDataComplete = false;

        vm.logoutUser = logoutUser;

        initialize();
        /////////////////////////////////////////////////////////////////////////////////////////

        // Function to logout user and destroy session
        function initialize() {
            $log.log('initialize reference list');
            getM20VListWithRunner();
        }
        function getM20VListWithRunner() {
            $log.log('getm20vlist with runner');
            if (toolingsHelper.isM20vListWithRunnerLoaded()) {
                vm.m20v = toolingsHelper.getM20VListWithRunner();
                vm.m20vDataComplete = true;
            }
            else {
                toolingsHelper.getM20VListWithRunner().then(getM20VListWithRunnerSuccess);
            }
            

            function getM20VListWithRunnerSuccess(response) {
                $log.log('getM20VListWithRunnerSuccess');
                vm.m20v = response;
                $log.log(response);
                vm.m20vDataComplete = true;
            }
        }
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
    }
})();
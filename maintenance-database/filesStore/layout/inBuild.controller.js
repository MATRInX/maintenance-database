(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('inBuildController', inBuildController);

    inBuildController.$inject = ['$log', '$http', '$location', 'userData', 'MAIN_MENU', 'documentsHelper'];

    function inBuildController($log, $http, $location, userData, MAIN_MENU) {
        var vm = this;
        vm.isUserLogged = false;
        vm.userLogin = '';
        vm.userPassword = '';
        vm.userFullName = '';
        vm.menu = MAIN_MENU.MENU;

        vm.logoutUser = logoutUser;

        activate();

        ////////////////////////////////////////////////////////////////////////////////////////
        // Function for activation controller
        function activate() {
            checkLoginStatus();
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

    }
})();
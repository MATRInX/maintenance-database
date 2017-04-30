(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('referenceItemController', referenceItemController);

    referenceItemController.$inject = ['$scope', '$http', '$log', 'toolingsHelper', 'MAIN_MENU', 'logged', 'userRight',
                                       'userData', '$location', '$filter', '$sce'];

    function referenceItemController($scope, $http, $log, toolingsHelper, MAIN_MENU, logged, userRight,
                                       userData, $location, $filter, $sce) {
        var vm = this;
        vm.loggedStatus = logged;
        vm.userRight = userRight;
        vm.userFullName = '';
        vm.menu = MAIN_MENU.MENU;

        vm.logoutUser = logoutUser;
        /////////////////////////////////////////////////////////////////////////////////////////

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
    }
})();
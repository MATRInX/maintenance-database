(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .controller('loginController', loginController);

    loginController.$inject = ['$log', '$http', '$location', 'userData', 'MAIN_MENU', 'documentsHelper'];

    function loginController($log, $http, $location, userData, MAIN_MENU) {
        var vm = this;
        vm.isUserLogged = false;
        vm.userLogin = '';
        vm.userPassword = '';
        vm.dataLoaded = false;
        
        vm.loginSubmit = loginSubmit;

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
                if (vm.isUserLogged) {
                    // Go to toolings page - this is main page
                    var toolingsPath = '/' + MAIN_MENU.MENU[0].menu[0].path;
                    $location.path(toolingsPath);
                }
                else {
                    vm.dataLoaded = true;
                }
                    
            }
        }
        // Function to log in user with entered login and passsword
        function loginSubmit() {
            userData.loginSubmit(vm.userLogin, vm.userPassword).then(loginSubmitSuccessful);

            function loginSubmitSuccessful(response) {
                vm.isUserLogged = response;
                vm.userLogin = '';
                vm.userPassword = '';
                $location.path('/' + MAIN_MENU.MENU[0].menu[0].link);
            }
        }
    }
})();
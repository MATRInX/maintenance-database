(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .factory('userData', userData);

    userData.$inject = ['$http', '$log', '$q'];

    function userData($http, $log, $q) {
        var userId = -1;
        var userFullName = '';
        var loginStatus = null;
        var service = {
            userId: userId,
            userFullName: userFullName,

            checkLoginStatus: checkLoginStatus,
            getLoginStatus: getLoginStatus,
            getUserId: getUserId,
            getUserName: getUserName,
            getUserFullName: getUserFullName,
            getUserRights: getUserRights,
            loginSubmit: loginSubmit,
            logoutUser: logoutUser            
        };
        return service;

        ////////////////////////////////////////////////////////////////////////////////////////

        function checkLoginStatus() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/userDataModel.php",
                data: {
                    'query': 'checkLoginStatus',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(checkLoginComplete);
            return deffered.promise;

            function checkLoginComplete(response) {                
                loginStatus = response.data.logoutStatus;
                if (loginStatus) {
                    getUserFullName().then(function () {
                        deffered.resolve(loginStatus);
                    });
                }
                else {
                    deffered.resolve(loginStatus);
                }
            }
        }

        function getUserFullName() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/userDataModel.php",
                data: {
                    'query': 'getUserFullName',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getUserFullNameComplete);
            return deffered.promise;

            function getUserFullNameComplete(response) {
                userFullName = response.data.userFullName;
                deffered.resolve(userFullName);
            }
        }

        function getUserRights() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/userDataModel.php",
                data: {
                    'query': 'getUserRights',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getUserRightSuccess);

            return deffered.promise;

            function getUserRightSuccess(response) {
                deffered.resolve(response.data.userRights);
            }
        }

        function loginSubmit(login, password) {
            var deffered = $q.defer();
            $http({
                    method: "POST",
                url: "models/userDataModel.php",
                data: {
                    'query': 'loginSubmit',
                    'data': [{ 'key': 'login', 'value': login },
                             { 'key': 'password', 'value': password }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(loginSubmitComplete);
            return deffered.promise;

            function loginSubmitComplete(response) {
                deffered.resolve(response.data.logoutStatus);
            }
        }

        function logoutUser() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/userDataModel.php",
                data: {
                    'query': 'logoutUser',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(logoutUserComplete);
            return deffered.promise;

            function logoutUserComplete(response) {
                deffered.resolve(response.data.logoutStatus);
            }
        }

        function getUserId() {
            return userId;
        }
        function getUserName() {
            return userFullName;
        }
        function getLoginStatus() {
            return loginStatus;
        }
    }

})();
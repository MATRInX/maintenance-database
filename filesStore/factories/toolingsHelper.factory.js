(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .factory('toolingsHelper', toolingsHelper);

    toolingsHelper.$inject = ['$http', '$log', '$q'];

    function toolingsHelper($http, $log, $q) {
        var toolingsData = [];
        var m20vData = [];
        var m20vDataLoaded = false;
        var service = {
            // variables

            // functions
            getToolingList: getToolingList,
            getToolingLocations: getToolingLocations,
            getProcessTypes: getProcessTypes,
            getMassReferences: getMassReferences,
            getM20vReferences: getM20vReferences,
            getModalLists: getModalLists,
            getM20VListWithRunner: getM20VListWithRunner,
            isM20vListWithRunnerLoaded: isM20vListWithRunnerLoaded,
            checkHashId: checkHashId,
            addTooling: addTooling,
            editTooling: editTooling,
            deleteTooling: deleteTooling,
            getRepairList: getRepairList,
            addRepair: addRepair,
            editRepair: editRepair,
            finishRepair: finishRepair,
            pickupRepair: pickupRepair,
            addNewSimpleData: addNewSimpleData
        };

        return service;

        ////////////////////////////////////////////////////////////////////////////////////////
        function getToolingList() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getToolingList',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getToolingListFromDB);
            return deffered.promise;

            function getToolingListFromDB(response) {                
                var toolingsDataRet = response.data.toolingList;
                toolingsData = toolingsDataRet;
                deffered.resolve(toolingsData);
            }
        }
        function getToolingLocations() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getToolingLocations',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getToolingLocationsFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getToolingLocationsFromDB(response) {
                var locations = response.data.locations;
                deffered.resolve(locations);
            }
        }
        function getProcessTypes() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getProcessTypes',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getProcessTypesFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getProcessTypesFromDB(response) {
                var process = response.data.process;
                deffered.resolve(process);
            }
        }
        function getMassReferences() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getMassReferences',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getMassReferencesFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getMassReferencesFromDB(response) {
                var mass = response.data.reference;
                deffered.resolve(mass);
            }
        }
        function getM20vReferences() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getM20vReferences',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getM20vReferencesFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getM20vReferencesFromDB(response) {
                var m20v = response.data.reference;
                deffered.resolve(m20v);
            }
        }
        function getModalLists() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getModalLists',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getModalListsFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getModalListsFromDB(response) {
                var lists = response.data.modalLists;
                deffered.resolve(lists);
            }
        }
        function getM20VListWithRunner() {
            $log.log('getM20VListWithRunner poczatek');
            if (!m20vDataLoaded) {
                var deffered = $q.defer();
                $http({
                    method: "POST",
                    url: "models/toolingsModel.php",
                    data: {
                        'query': 'getM20VListWithRunner',
                        'data': [{ 'key': '', 'value': '' }]
                    },
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
                })
                .then(getM20VListWithRunnerFromDB);
                $log.log('getM20VListWithRunner koniec');
                return deffered.promise;
            }
            else {
                return m20vData;
            }
            ////////////////////////////////////////////////////////////////////////////////

            function getM20VListWithRunnerFromDB(response) {
                $log.log('getM20VListWithRunner response i resolve');
                $log.log(response);
                var m20vRunnerList = response.data.m20vRunnerList;
                m20vData = m20vRunnerList;
                m20vDataLoaded = true;
                $log.log(m20vRunnerList);
                deffered.resolve(m20vRunnerList);
            }
        }
        function isM20vListWithRunnerLoaded() {
            return m20vDataLoaded;
        }
        function checkHashId(idToCheck) {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'checkHashId',
                    'data': [{ 'key': 'hashId', 'value': idToCheck }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(checkHashIdInDB);
            return deffered.promise;

            function checkHashIdInDB(response) {
                deffered.resolve(response.data.idIsUnique);
            }
        }
        function addTooling(toolData) {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'addTooling',
                    'data': toolData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(addToolingToDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function addToolingToDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function editTooling(toolData) {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'editTooling',
                    'data': toolData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(editToolingToDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function editToolingToDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function deleteTooling(idToDelete) {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'deleteTooling',
                    'data': { 'idToDelete': idToDelete }
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(deleteToolingFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function deleteToolingFromDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function getRepairList() {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'getRepairList',
                    'data': [{ 'key': '', 'value': '' }]
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(getRepairListsFromDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function getRepairListsFromDB(response) {
                var repairList = response.data.repairList;
                var arrayLenght = repairList.length;
                for (var i = 0; i < arrayLenght; i++) {
                    var tempData = new Date(repairList[i].breakdownDate);
                    if (angular.isDate(tempData) && tempData != "Invalid Date")
                        repairList[i].breakdownDate = tempData;
                    else
                        repairList[i].breakdownDate = '';
                    tempData = new Date(repairList[i].estimatedRepairDate);
                    if (angular.isDate(tempData) && tempData != "Invalid Date")
                        repairList[i].estimatedRepairDate = tempData;
                    else
                        repairList[i].estimatedRepairDate = '';
                    tempData = new Date(repairList[i].repairDate);
                    if (angular.isDate(tempData) && tempData != "Invalid Date")
                        repairList[i].repairDate = tempData;
                    else
                        repairList[i].repairDate = '';
                    tempData = new Date(repairList[i].pickupDate);
                    if (angular.isDate(tempData) && tempData != "Invalid Date")
                        repairList[i].pickupDate = tempData;
                    else
                        repairList[i].pickupDate = '';
                    $log.log(repairList[i].pickupDate);
                }
                deffered.resolve(repairList);
            }
        }
        function addRepair(repairData) {
            var deffered = $q.defer();
            repairData.breakdownDate = dateToString(repairData.breakdownDate);
            repairData.repairDate = dateToString(repairData.repairDate);
            repairData.estimatedRepairDate = dateToString(repairData.estimatedRepairDate);
            repairData.pickupDate = dateToString(repairData.pickupDate);
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'addRepair',
                    'data': repairData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(addRepairToDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function addRepairToDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function editRepair(repairData) {
            var deffered = $q.defer();
            repairData.breakdownDate = dateToString(repairData.breakdownDate);
            repairData.repairDate = dateToString(repairData.repairDate);
            repairData.estimatedRepairDate = dateToString(repairData.estimatedRepairDate);
            repairData.pickupDate = dateToString(repairData.pickupDate);
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'updateRepair',
                    'data': repairData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(editRepairInDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function editRepairInDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function finishRepair(repairData) {
            var deffered = $q.defer();
            repairData.status = 'Naprawa zakończona';
            repairData.breakdownDate = dateToString(repairData.breakdownDate);
            repairData.repairDate = dateToString(repairData.repairDate);
            repairData.estimatedRepairDate = dateToString(repairData.estimatedRepairDate);
            repairData.pickupDate = dateToString(repairData.pickupDate);
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'finishRepair',
                    'data': repairData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(finishRepairInDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function finishRepairInDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function pickupRepair(repairData) {
            var deffered = $q.defer();
            repairData.status = 'Naprawa zakończona - odebrana';
            repairData.breakdownDate = dateToString(repairData.breakdownDate);
            repairData.repairDate = dateToString(repairData.repairDate);
            repairData.estimatedRepairDate = dateToString(repairData.estimatedRepairDate);
            repairData.pickupDate = dateToString(repairData.pickupDate);
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': 'pickupRepair',
                    'data': repairData
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(pickupRepairInDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function pickupRepairInDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
        }
        function addNewSimpleData(query, dataToAdd) {
            var deffered = $q.defer();
            $http({
                method: "POST",
                url: "models/toolingsModel.php",
                data: {
                    'query': query,
                    'data': dataToAdd
                },
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            })
            .then(finishRepairInDB);
            return deffered.promise;
            ////////////////////////////////////////////////////////////////////////////////

            function finishRepairInDB(response) {
                var feedback = response.data.feedback;
                deffered.resolve(feedback);
            }
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
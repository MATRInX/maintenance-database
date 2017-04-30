(function () {
    'use strict';

    angular
        .module('fileStoreApp')
        .config(config)
        .constant('MAIN_MENU', (function () {
            return {
                MENU: [
                {
                    name: 'NARZĘDZIA',
                    path: 'Narzedzia',
                    menu: [{ name: 'Baza narzędzi', link: '#/Narzedzia', path: 'Narzedzia'},
                           { name: 'Lokalizacje', link: '#/Lokalizacje', path: 'Lokalizacje'},
                           { name: 'Typy procesów', link: '#/Procesy', path: 'Procesy'},
                           { name: 'Referencje MASS', link: '#/Mass', path: 'Mass'},
                           { name: 'Referencje M20V', link: '#/M20v', path: 'M20v'},
                           { name: 'Baza części narzędzi', link: '#/Czesci', path: 'Czesci'}]
                },
                {
                    name: 'BAZA PLIKÓW UR',
                    path: 'Pliki',
                    menu: [{ name: 'Dokumenty proste', link: '#/Dokumenty', path: 'Dokumenty' },
                            { name: 'Instrukcje', link: '#/Instrukcje', path: 'Instrukcje' },
                            { name: 'TPM', link: '#/TPM', path: 'TPM'}]
                },
                {
                    name: 'NAPRAWY UR',
                    path: 'Naprawy',
                    menu: [{ name: 'Naprawy UR', link: '#/Naprawy', path: 'Naprawy' }]
                }
                ]
            };
        })()
        );

    function config($routeProvider, $locationProvider, MAIN_MENU) {
        //$locationProvider.html5Mode(true);
        $locationProvider.hashPrefix('');
        // Default view
        $routeProvider.when('/', {
            redirectTo: '/login'
        });
        // Logged out view
        $routeProvider.when('/login', {
            templateUrl: 'layout/loginContent.html',
            controller: 'loginController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Toolings
        var toolingPath = '/' + MAIN_MENU.MENU[0].menu[0].path;
        $routeProvider.when(toolingPath, {
            templateUrl: 'layout/toolings/toolingsMainContent.html',
            controller: 'toolingsListController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Locations
        var locationPath = '/' + MAIN_MENU.MENU[0].menu[1].path;
        $routeProvider.when(locationPath, {
            templateUrl: 'layout/inBuildContent.html',
            controller: 'inBuildController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Process
        var processPath = '/' + MAIN_MENU.MENU[0].menu[2].path;
        $routeProvider.when(processPath, {
            templateUrl: 'layout/inBuildContent.html',
            controller: 'inBuildController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // MASS references
        var massPath = '/' + MAIN_MENU.MENU[0].menu[3].path;
        $routeProvider.when(massPath, {
            templateUrl: 'layout/references/referenceList.html',
            controller: 'referenceListController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // M20V references
        var m20vPath = '/' + MAIN_MENU.MENU[0].menu[4].path;
        $routeProvider.when(m20vPath, {
            templateUrl: 'layout/references/referenceList.html',
            controller: 'referenceListController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Tooling parts
        var toolPartPath = '/' + MAIN_MENU.MENU[0].menu[5].path;
        $routeProvider.when(toolPartPath, {
            templateUrl: 'layout/inBuildContent.html',
            controller: 'inBuildController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Documents - Simple files - forms, procedures, lists
        var documentsPath = '/' + MAIN_MENU.MENU[1].menu[0].path;
        $routeProvider.when(documentsPath, {
            //templateUrl: 'layout/files/filesLayout.html',
            templateUrl: 'layout/inBuildContent.html',
            controller: 'documentsController',
            controllerAs: 'vm'
        });
        // Documents - Instructions
        var instructionsPath = '/' + MAIN_MENU.MENU[1].menu[1].path;
        $routeProvider.when(instructionsPath, {
            //templateUrl: 'layout/files/filesLayout.html',
            templateUrl: 'layout/inBuildContent.html',
            controller: 'instructionsController',
            controllerAs: 'vm'
        });
        // Documents - TPM files
        var tpmPath = '/' + MAIN_MENU.MENU[1].menu[2].path;
        $routeProvider.when(tpmPath, {
            //templateUrl: 'layout/files/filesLayout.html',
            templateUrl: 'layout/inBuildContent.html',
            controller: 'tpmController',
            controllerAs: 'vm'
        });
        // Repair list
        var repairListPath = '/' + MAIN_MENU.MENU[2].menu[0].path;
        $routeProvider.when(repairListPath, {
            //templateUrl: 'layout/files/filesLayout.html',
            templateUrl: 'layout/toolings/repairList.complex.html',
            controller: 'repairListController',
            controllerAs: 'vm',
            resolve: {
                logged: getloggedStatus,
                userRight: getUserRights
            }
        });
        // Other url's
        $routeProvider.otherwise({
            redirectTo: '/'
        });

        function getloggedStatus(userData, $log, $location, $q) {
            var deffered = $q.defer();
            userData.checkLoginStatus().then(function (isUserLogged) {
                if (!isUserLogged) {
                    $location.path('/login');
                }
                deffered.resolve(isUserLogged);
            });
            return deffered.promise;
        }
        function getUserRights(userData) {
            return userData.getUserRights();
        }
    }
})();
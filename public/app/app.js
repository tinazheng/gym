'use strict';

var gym = angular.module('gym', ['ui.router','ui.bootstrap']);

gym.run(function ($rootScope, $state, $stateParams) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
});

//Angular UI Router Config
gym.config(function($logProvider, $urlRouterProvider, $stateProvider){

    $logProvider.debugEnabled(true);
    $urlRouterProvider.otherwise('/');
    $stateProvider
        .state('index', {
            url: '/',
            title: 'Gym!',
            views: {
                'content':{
                    templateUrl: 'app/login/login.html',
                    controller: 'LoginCtrl'
                }
            }
        })
        .state('settings', {
            url: '/settings',
            title: 'Gym!',
            views: {
                'content':{
                    templateUrl: 'app/settings/settings.html',
                    controller: 'SettingsCtrl'
                }
            }
        })
        .state('dashboard', {
            url: '/dashboard',
            title: 'Gym!',
            views: {
                'content':{
                    templateUrl: 'app/dashboard/dashboard.html',
                    controller: 'DashboardCtrl'
                }
            }
        })
    ;
});

//fuck for loops
gym.filter('range', function() {
    return function(input, total) {
        total = parseInt(total);
        for (var i=0; i<total; i++)
            input.push(i);
        return input;
    };
});
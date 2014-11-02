'use strict';

var gym = angular.module('gym', ['ui.router','ui.bootstrap']);

//Angular UI Router Config
gym.config(function($logProvider, $urlRouterProvider, $stateProvider){

    //TODO: Remove Debugging
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
        });
});
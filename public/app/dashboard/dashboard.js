angular.module("gym")
    .controller('DashboardCtrl', function($scope, gymUser) {
        console.log('From Dashboard Ctrl');
        gymUser.getTransactionHistory()
            .success(function(data){
                console.log(data);
                $scope.transHist=data;
            });

        gymUser.getProgress()
            .success(function(data){
                console.log(data);
                $scope.prog=data;
                $scope.antiProg = 7-data;
            });

        $scope.checkIn = function(){
            console.log("Checked In!");
            navigator.geolocation.getCurrentPosition(function(position){
                gymUser.pushCheckIn(position.coords.longitude, position.coords.latitude);
            });
        };
    });
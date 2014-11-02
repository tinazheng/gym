angular.module("gym")
    .controller('DashboardCtrl', function($scope, gymUser,ngToast) {

        //TODO: Needs to be an API Call
        $scope.left = 5;
        $scope.checkedIn = false;

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

            //TODO: Should be in success
            ngToast.create({
                content: 'Congrats! You have accomplished your goal today!',
                horizontalPosition: 'center',
                timeout: 6000
            });
            $scope.checkedIn = true;

            navigator.geolocation.getCurrentPosition(function(position){
                gymUser.pushCheckIn(position.coords.longitude, position.coords.latitude)
                    .success(function(data){

                    });
            });
        };
    });
angular.module("gym")
    .controller('DashboardCtrl', function($scope, gymUser,ngToast) {

        //TODO: Needs to be an API Call
        $scope.left = 5;
        $scope.checkedIn = false;

        $scope.max=14;

        gymUser.getTransactionHistory()
            .success(function(data){
                console.log(data);
                $scope.transHist=data;
            });

		$scope.setProgress = function(progress){
			$scope.prog = progress;
			$scope.antiProg = $scope.max - progress;
		
		};
		
		$scope.debugPay = function(){
			gymUser.debugPay()
				.success(function(data){
					ngToast.create({
							content: '$'+data.paid+' has been succesfully transferred from your account to your friends!',
							horizontalPosition: 'center',
							timeout: 6000
						});
				});
		};
			
        gymUser.getProgress()
            .success(function(data){
                //console.log(data);
                $scope.setProgress(data.progress);
            });

        $scope.checkIn = function(){

            //TODO: Should be in success
            

            navigator.geolocation.getCurrentPosition(function(position){
                gymUser.pushCheckIn(position.coords.longitude, position.coords.latitude)
                    .success(function(data){
						ngToast.create({
							content: 'Congrats! You have accomplished your goal today!',
							horizontalPosition: 'center',
							timeout: 6000
						});
						$scope.checkedIn = true;
						$scope.setProgress(data.progress);
                    });
            });
        };
    });

angular.module("gym")
    .controller('SettingsCtrl', [function($scope,$http,$stateParams) {
        console.log('From Settings Ctrl');

        $scope.listFriends = function(){
            $http.get("https://api.venmo.com/v1/users/:user_id/friends?access_token=<access_token>")
                .success(function(data){
                  console.log(data);
                });
        };

}]);
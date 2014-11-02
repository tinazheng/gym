angular.module("gym")
    .controller('SettingsCtrl', function($scope,gymUser) {
        console.log('From Settings Ctrl');

        gymUser.listFriends()
            .success(function(data){
               $scope.friends = data.data;
                console.log($scope.friends);
            });

});
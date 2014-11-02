angular.module("gym")
    .controller('SettingsCtrl', function($scope,gymUser,$state,$rootScope) {

        $scope.noFriendsSelected = false;

        gymUser.listFriends()
            .success(function(data){
               $scope.friends = data.data;
            });

        $scope.selectFriend = function(index){
            var targetFriend =$scope.friends[index];
            if(targetFriend.hasOwnProperty('selected')){
              targetFriend.selected = !targetFriend.selected;
              }
            else{
              targetFriend['selected']=true;
            }
        };

        $scope.getSelectedFriends = function(){
            var ids = new Array();
          $scope.friends.forEach(function(friend){
              if(friend.selected)
                ids.push(friend.id);
          });
            return ids;
        };

        $scope.submitSettings = function(){

            if($scope.getSelectedFriends().length){
                var settings = {
                    goal: $scope.settings.frequency,
                    amount: $scope.settings.amount,
                    friends: $scope.getSelectedFriends()
                };

                gymUser.submitSettings(settings)
                    .success(function(data){
                        $state.go('dashboard');
                    });
            }
            else{
                $scope.noFriendsSelected = true;
            }

        }
});

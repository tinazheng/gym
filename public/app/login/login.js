angular.module("gym")
    .controller('LoginCtrl', function($scope,gymUser) {
        console.log('From Login Ctrl');

        gymUser.getUser()
            .success(function(data){
               console.log(data);
            });
});
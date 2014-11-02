/**
 * Created by Jacky on 11/1/14.
 */
angular.module("gym")
    .factory('gymUser', function ($http) {
        return {

            getUser: function(){
                return $http.get("/user/me");
            },

            listFriends: function(){
              return $http.get("/user/friends")
            },

            submitSettings: function(settings){
                //TODO: Should be PUT
                return $http.get("/user",settings);
            }


        }
    });
/**
 * Created by Jacky on 11/1/14.
 */
angular.module("gym")
    .factory('gymUser', function ($http) {
        return {

            getUser: function(){
                return $http.get("/users/me");
            },

            listFriends: function(){
              return $http.get("/users/friends")
            }

        }
    });
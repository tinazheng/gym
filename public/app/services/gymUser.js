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
              return $http.get("/users/friends");
            },

            getProgress: function(){
                return $http.get("/users/progress");
            },

            getTransactionHistory: function(){
                return $http.get("/users/transactions");
            },

            pushCheckIn: function(long,lat){
                return $http.post('/user/checkIn',
                    {
                        longitude:long,
                        latitude:lat
                    });
            }

        }
    });
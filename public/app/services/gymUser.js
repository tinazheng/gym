/**
 * Created by Jacky on 11/1/14.
 */
angular.module("gym")
    .factory('gymUser', function ($http) {
        return {

            getUser: function(){
                return $http.get("/user");
            },

            listFriends: function(){
              return $http.get("/user/friends");
            },

            getProgress: function(){
                return $http.get("/user/progress");
            },

            getTransactionHistory: function(){
                return $http.get("/user/transactions");
            },

            pushCheckIn: function(long,lat){
                return $http.post('/user/checkin',
                    {
                        longitude:long,
                        latitude:lat
                    });
            },
            submitSettings: function(settings){
                return $http.put("/user",settings);
            }

        }
    });

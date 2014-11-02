/**
 * Created by Jacky on 11/1/14.
 */
angular.module("gym")
    .factory('gymUser', function ($http) {
        return {

            getUser: function(){
                return $http.get("https://api.venmo.com/v1/me?access_token="+"kcrf6dZ3TrvBWEGsnxuVnFJfCZwH2ePS");
            }

        }
    });
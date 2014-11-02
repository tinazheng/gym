<?php

$router->get('/', function(){ return file_get_contents(__DIR__ . '/../../public/app/index.html'); });

Route::get('/users/me',function(){
    return response()->json(array(
        'data'=>array(
            'balance'=>102.3,
            'user'=>array(
                "username"=>"delavara",
                 "first_name"=>"Cody",
                 "last_name"=>"De La Vara",
                 "display_name"=>"Cody De La Vara",
                 "is_friend"=>false,
                 "friends_count"=>165,
                 "about"=>"So happy!",
                 "email"=>null,
                 "phone"=>null,
                 "profile_picture_url"=>"https://venmopics.appspot.com/u/v3/s/6ecc7b37-5c4a-49df-b91e-3552f02dc397",
                 "id"=>"1088551785594880949",
                 "date_joined"=>"2013-02-10T21:58:05"
            )
        )
    ));
});

Route::get('/users/transactions',function(){
    return response()->json(array('asdfasdfasdfasdfaw3raw3rawr3', 'asdfasdfasdf','124124'));

});

Route::get('/users/progress',function(){
    return response()->json(4);
});

Route::get('/users/friends',function(){
   return response()->json(array(

       "pagination"=>array(
            "next"=>"https://api.venmo.com/v1/users/1088551785594880949/friends?after=161568197181440668&limit=3"
        ),
       "data"=>array(
          array(
              "username"=>"kortina",
             "about"=>"make a joyful sound, la da da da",
             "last_name"=>"Kortina",
             "display_name"=>"Andrew Kortina",
             "first_name"=>"Andrew",
             "profile_picture_url"=>"https://venmopics.appspot.com/u/v5/s/25f9c7a0-5d5c-4988-8737-a3278d78ae42",
             "id"=>"145434160922624167"
            ),
          array(
              "username"=>"iqram",
             "about"=>"Frisbee enthusiast",
             "last_name"=>"magdon-ismail - organic",
             "display_name"=>"Iqram magdon-ismail - organic",
             "first_name"=>"Iqram",
             "profile_picture_url"=>"https://venmopics.appspot.com/u/v11/s/6c3740ad-26bd-475c-9da2-7cb3fd7591da",
             "id"=>"145436736225280235"
            ),
          array(
              "username"=>"staub",
             "about"=>"phonewalletbaby",
             "last_name"=>"Staub",
             "display_name"=>"Andrew Staub",
             "first_name"=>"Andrew",
             "profile_picture_url"=>"https://venmopics.appspot.com/u/v1/s/0b4b85ab-a72b-4326-a887-5bf7a08ff445",
             "id"=>"152710129123328341"
            ),
          array(
              "username"=>"azeem",
             "about"=>"No Short Bio",
             "last_name"=>"Ansar",
             "display_name"=>"Azeem Ansar",
             "first_name"=>"Azeem",
             "profile_picture_url"=>"https://venmopics.appspot.com/u/v1/s/2b797ba9-1bd5-41b8-a5a9-f133e128f234",
             "id"=>"161568197181440668"
            )
        )
   ));
});
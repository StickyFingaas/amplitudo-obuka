<?php

    // REST
    
    header("Access-Control-Allow-Origin: *");

    // fat-arrow  =>
    $users = [
        [ "first_name" => "Marko", "last_name" => "Markovic", "email" => "marko@gmail.com" ],
        [ "first_name" => "Janko", "last_name" => "Jankovic", "email" => "janko@gmail.com" ],
        [ "first_name" => "Filip", "last_name" => "Filipovic", "email" => "filip@gmail.com" ]
    ];

    $json = json_encode($users);
    echo $json;   

?>
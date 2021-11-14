<?php

    include './file_functions.php';
    include './users_functions.php';


    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['user_id'];
        $country = $_POST['country'];
        $city = $_POST['city'];

        $users = getUsersFromFile(); // fetch from "DB"

        foreach($users as &$user){
            if($user['id'] == $id){
                $user['country'] = $country;
                $user['city']= $city;
        }
    }
        writeToFile(json_encode($users));  // save to "DB"

        header("location:index.php");
    }



?>
<?php

    require '../file_functions.php'; // throws an error


    $countries = getUsersFromFile("../countries.txt");
    if($countries){
        echo json_encode(["status" => true, "data" => $countries]);
    }else{
        echo json_encode(["status" => false, "data" => null]);
    }

?>
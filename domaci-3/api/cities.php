<?php

    require '../file_functions.php'; // throws an error


    $cities = getUsersFromFile("../cities.txt");
    if($cities){
        echo json_encode(["status" => true, "data" => $cities]);
    }else{
        echo json_encode(["status" => false, "data" => null]);
    }

?>
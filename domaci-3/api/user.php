<?php 

    require '../file_functions.php'; // throws an error
    require '../users_functions.php';

    $user = findUserByID(getUsersFromFile("../database.txt"), $_GET['id']);
    if($user){
        echo json_encode(["status" => true, "data" => $user]);
    }else{
        echo json_encode(["status" => false, "data" => null]);
    }

?>
<?php 

    // superglobals
    // $_REQUEST, $_POST, $_GET, $_SERVER, $_SESSION

    include './file_functions.php';
    include './users_functions.php';
    require './auth_functions.php';
    
    checkAuth();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $users = getUsersFromFile(); // fetch from "DB"
        $new_user = [ "id" => nextID($users) , "first_name" => $first_name, "last_name" => $last_name, "email" => $email, "password" => md5($password) ];

        array_push($users, $new_user);
        writeToFile(json_encode($users));  // save to "DB"

        // redirect to index with message
        header("location:index.php?user_saved=1");
    }

    

?>
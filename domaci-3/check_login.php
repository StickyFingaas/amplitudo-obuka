<?php 

    require './file_functions.php'; // throws an error
    require './users_functions.php';

    session_start();
    
    $users = getUsersFromFile();

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $email = $_POST['email'];
        $password = $_POST['password'];

        $loginCheck = findUserByEmailAndPassword($users, $email, $password);

        if($loginCheck){
            $_SESSION['login'] = true;
            $_SESSION['user'] = $loginCheck;
            header("location:index.php?logged_in=1");
        }else{
            header("location:login.php?wrong_credentials=1");
        }
    }

?>
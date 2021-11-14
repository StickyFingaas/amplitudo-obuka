<?php 

    require './users_functions.php';
    require './file_functions.php';
    require './auth_functions.php';
    
    checkAuth();

    $users = removeUser( getUsersFromFile(), $_GET['id'] );
    writeToFile(json_encode($users));  // save to "DB"

    // redirect to index with message
    header("location:index.php?user_deleted=1");

?>
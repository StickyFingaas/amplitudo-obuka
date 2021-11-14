<?php 

    function filterUsers($users, $term){
        $users_filtered = [];
        foreach($users as $user){
            $first_name = strtolower($user['first_name']);
            $last_name = strtolower($user['last_name']);
            if( strpos($first_name, $term) !== FALSE || strpos($last_name, $term) !== FALSE)
                $users_filtered[] = $user;
        }
        return $users_filtered;
    }

    function removeUser($users, $id){
        $result = [];
        foreach($users as $user){
            if($user['id'] != $id) $result[] = $user;
        }
        return $result;
    }

    function nextID($users){
        $max = 0;
        foreach($users as $user){
            if($user['id'] > $max) $max = $user['id'];
        }
        return $max+1;
    }

    function findUserByID($users, $id){
        foreach($users as $user){
            if($user['id'] == $id) return $user;
        }
        return false;
    }

    function findUserByEmailAndPassword($users, $email, $password){
        foreach($users as $user){
            if($user['email'] == $email && $user['password'] == md5($password)) return $user;
        }
        return false;
    }
?>
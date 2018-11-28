<?php
session_start();
//include the db layer
require_once "/home/MAIN/cnd9351/Sites/442/connectFour/DataLayer/user.php";
//include my dbInfo
require_once "/home/MAIN/cnd9351/Sites/dbInfoPS.inc";

/*
* Authenticate the User
 * - data{username: username, password:password}
*/
function authenticate($data){
    $json = json_decode($data);
    if($json->username && $json->password){
        $username = sanitizeString($json->username);
        $password = hash('sha256',sanitizeString($json->password));
        //call the db to finish the authentication
        return authenticateUser($username, $password);
    }else{
        return "error";
    }
}

function getUsers($data){
    //check that no data was sent in and that the user is logged in
   if($data == null && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){
       return getAllUsers();
   }
}
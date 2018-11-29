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

/**
 * Get Users
 * @return string
 */
function getUsers(){
    //check data was sent and that they are logged in
   if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){
       return getAllUsers($_SESSION['username']);
   }
}

/**
 * Challenge the selected user
 * @param $data
 */
function challenge($data){
    $json = json_decode($data);
    if(isset($_SESSION['username']) && $_SESSION['authenticated'] && $json->challenge && $json->challengeId){
        //send the request to that user
        changeChallengeStatus($json->challengeId, $json->challenge, $json->challengeId);
    }
}

function changeChallengeStatus($challengeId = null, $challengeUser = "", $setTo = 0){
    if($challengeUser == "" || $challengeId == null){
        updateChallengeStatus($_SESSION['userid'], $_SESSION['username'], $setTo);
    }
    updateChallengeStatus($challengeId, $challengeUser, $setTo);
}



<?php
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
        //var_dump($_SESSION);
    }else{
        return "error";
    }
}

/**
 * Function to loggout the user
 */
function logoutUser(){
    if($_SESSION['authenticated'] == true) {
        //they are logged in so log them out
        logout($_SESSION['userid']);
    }
}

function challengeResponse($data){
    if($_SESSION['authenticated'] == true){
        $json = json_decode($data);
        var_dump($data);
        if($json->response == "Accept"){
            return changeChallengeResponse(1);
        }else if($json->response == "Decline"){
            return changeChallengeResponse(2);
        }
    }
}

function changeChallengeResponse($value){
    if($_SESSION['authenticated'] == true){
        changeChallengeResponseData($_SESSION['challengerid'],$value);
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
    if(isset($_SESSION['username']) && isset($_SESSION['authenticated']) && $json->challenge != null && $json->challengeId != null ){
        //send the request to that user
        changeChallengeStatus($json->challengeId, $_SESSION['userid']);
    }
}

function changeChallengeStatus($challengeId, $setTo){
    if($challengeId == null){
        updateChallengeStatus($_SESSION['userid'], 0);
    }
    updateChallengeStatus($challengeId, $setTo);
}

function checkGame(){
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true && isset($_SESSION['gameid'])){
        $gameid = (string)$_SESSION['gameid'];
        //var_dump($_SESSION['gameid']);
        return json_encode("{'gameid': $gameid}");
    }
}

function checkForChallenge(){
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true && isset($_SESSION['userid'])){
        return checkChallengeStatus($_SESSION['userid']);
    }
}

function checkReplyChallenge(){
    if(isset($_SESSION['authenticated'])){
        //make the call
        $result = checkChallengeReplyStatus($_SESSION['userid']);
        //get result
        if($result != 'failed'){
            //reset my challenge response
            changeChallengeStatus($_SESSION['userid'], 0);
            //reset challenger was Challeneged
            updateChallengeStatus($_SESSION['challengerid'], 0);
            if($result == 1){
                //start the game
                //DO THE THING JULIE
                include_once ('./../game/gameService.php');
                //create 2D array let the x be 7 y= 6
                $board = array();
                for($i = 0; i < 7; $i++){
                    $board[$i] = array();
                    for($j = 0; $j<6; $j++) {
                        $board[$i][$j] = 0;
                    }
                }
                gameStart($_SESSION['userid'],$_SESSION['challengerid'],$board);
                return 'accepted';
            }elseif ($result == 2){
                return 'declined';
            }
        }else{
            return "failed";
        }
        //start game if accept
        //print out declined message if declined
    }
}

function getUsernamebyID($username){
    if (isset($_SESSION['authenticated'])){
        return getUsername($username);
    }
}



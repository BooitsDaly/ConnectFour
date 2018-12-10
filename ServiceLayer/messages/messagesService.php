<?php
//include the db layer
require_once "/home/MAIN/cnd9351/Sites/442/connectFour/DataLayer/messages.php";
//include my dbInfo
require_once "/home/MAIN/cnd9351/Sites/dbInfoPS.inc";

function saveMessage($data){
    $json = json_decode($data);
    insertMessage($_SESSION['userid'], $_SESSION['username'], $_SESSION['gameid'], $json->message);
}

function getMessages(){
    return allMessages($_SESSION['gameid']);
}
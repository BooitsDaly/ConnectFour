<?php
/**
 * Grab all the messages by lobby
 * @param $gameid
 * @return string
 */
function allMessages($gameid){
    global $mysqli;
    $query = "SELECT message, username FROM messages WHERE gameid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            return returnJSON($stmt);
        }
    }catch(Exception $e){
        return "{\"error\": \"error\"}";
    }
}

/**
 * add messages when sent
 *
 * @param $userid
 * @param $username
 * @param $gameid
 * @param $message
 */
function insertMessage($userid, $username, $gameid, $message){
    global $mysqli;
    $query = "INSERT INTO messages (gameid,userid, username, message) VALUES (?,?,?,?)";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("iiss",$gameid,$userid, $username,$message);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

/**
 * delete all messages in lobby
 *
 * @param $gameid
 */
function deleteMessages($gameid){
    global $mysqli;
    $query = "DELETE FROM messages WHERE gameid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('i', $gameid);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}
<?php

/**
 * creates a new game in the game table
 *
 * @param $player1id
 * @param $player2id
 * @param $board
 * @param $date
 */
function createNewGame($player1id, $player2id, $board, $date){
    global $mysqli;
    $query = "INSERT INTO games (turn,board,last_updated, player1, player2, win) VALUES (?,?,?,?,?,0)";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('issii', $player1id,$board, $date, $player1id, $player2id);
            $stmt->execute();
            return $stmt->insert_id;
        }
    }catch(Exception $e){
        //log errors
        return null;
    }
}

function selectGame($gameid){
    global $mysqli;
    $query = "SELECT * from games WHERE gameid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            //grab the data
            //format the data
            return returnJSON($stmt);
        }
    }catch(Exception $e){
        return $e;
    }
}

function getTurn($gameid){
    global $mysqli;
    $query = "SELECT turn FROM games WHERE gameid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($game);
            $stmt->fetch();
            return $game;
        }
    }catch(Exception $e){

    }
}

function getBoard($gameid){
    global $mysqli;
    $query = "SELECT board FROM games WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($board);
            $stmt->fetch();
            return $board;
        }
    }catch(Exception $e){

    }
}

function updateBoardMove($board, $player, $gameid){
    global $mysqli;
    $query = "UPDATE games SET board = ?, last_move = ? WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("sii", $board, $player,$gameid);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

function updateWin($userid,$gameid){
    global $mysqli;
    $query = "UPDATE games SET win = ? WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("ii", $userid,$gameid);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

function updateTurn($userid, $gameid){
    global $mysqli;
    $query = "UPDATE games SET turn = ? WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("ii", $userid,$gameid);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

function getLastPiece($gameid){
    global $mysqli;
    $query = "SELECT last_move FROM games WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($lastMove);
            $stmt->fetch();
            return $lastMove;
        }
    }catch(Exception $e){

    }
}

function getWin($gameid){
    global $mysqli;
    $query = "SELECT win FROM games WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($win);
            $stmt->fetch();
            if($win == 0){
                return false;
            }else{
                return true;
            }
        }
    }catch(Exception $e){

    }
}


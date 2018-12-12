<?php

/**
 * creates a new game in the game table
 *
 * @param $player1id
 * @param $player2id
 * @param $board
 * @param $date
 * @return null
 */
function createNewGame($player1id, $player2id, $board){
    global $mysqli;
    $query = "INSERT INTO games (turn,board, player1, player2, win) VALUES (?,?,?,?,0)";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('isii', $player1id,$board, $player1id, $player2id);
            $stmt->execute();
            return $stmt->insert_id;
        }
    }catch(Exception $e){
        //log errors
        return null;
    }
}

/**
 * gets the needed game data
 *
 * @param $gameid
 * @return Exception|string
 */
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

/**
 * Checks whose turn it is
 *
 * @param $gameid
 * @return mixed
 */
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

/**
 * Gets the board array from the specified gameid
 *
 * @param $gameid
 * @return mixed
 */
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
            return json_decode($board);
        }
    }catch(Exception $e){

    }
}

/**
 * updates the board and the move from the specified game id
 *
 * @param $board
 * @param $peice
 * @param $gameid
 */
function updateBoardMove($board, $peice, $gameid){
    global $mysqli;
    $query = "UPDATE games SET board = ?, last_move = ? WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("ssi", json_encode($board), json_encode($peice),$gameid);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

/**
 * if someone wins this column is updated
 *
 * @param $userid
 * @param $gameid
 */
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

/**
 * updates the turn to the next player
 *
 * @param $userid
 * @param $gameid
 * @return Exception
 */
function updateTurn($userid, $gameid){
    global $mysqli;
    $query = "UPDATE games SET turn = ? WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("ii", $userid,$gameid);
            $stmt->execute();
        }
    }catch(Exception $e){
        return $e;
    }
}

/**
 * Gets the last piece that was played to place on the board
 *
 * @param $gameid
 * @return mixed
 */
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

/**
 * Checks if someone won
 *
 * @param $gameid
 * @return bool
 */
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

/**
 * Deletes the game when a player whants to leave
 *
 * @param $gameid
 */
function deleteGame($gameid){
    global $mysqli;
    $query = "DELETE FROM games WHERE gameid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i", $gameid);
            $stmt->execute();
        }

    }catch(Exception $e){

    }
}


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
    $query = "INSERT INTO games (turn,board,last_updated, player1, player2) VALUES (?,?,?,?,?)";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('issii', $player1id,$board, $date, $player1id, $player2id);
            $stmt->execute();
        }
    }catch(Exception $e){
        //log errors
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


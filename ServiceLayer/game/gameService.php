<?php
/**
 * Function to start the game between 2 players
 * - Needs player1 and player2, board size, date
 * - create a game
 */
function gameStart($player1, $player2, $board){
    //create a game in the game  table
    $gameinfo = createNewGame($player1,$player2, $board,new Date());
    $gameid = getPlayerGameid($player1);
    //update each players gameid to the new gameid
    setGameId($player1, $gameid);
    setGameId($player2, $gameid);
}
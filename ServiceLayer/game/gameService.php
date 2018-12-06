<?php
/**
 * Function to start the game between 2 players
 * - Needs player1 and player2, board size, date
 * - create a game
 */
function gameStart($player1, $player2, $board){
    //include the game datalayer this is called from userService after the challenge
    include_once ('./DataLayer/game.php');
    //create a game in the game  table


    //TODO: Make this return the gameID
    createNewGame($player1,(int)$player2, $board,date("Y-m-d h:i:s"));

    $gameid = getPlayerGameid($player1);
    //update each players gameid to the new gameid
    setGameId($player1, $gameid);
    setGameId($player2, $gameid);
}
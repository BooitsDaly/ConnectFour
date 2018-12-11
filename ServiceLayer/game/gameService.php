<?php
if(isset($_SESSION['authenticated'])) {
    //include the db layer
    require_once "/home/MAIN/cnd9351/Sites/442/connectFour/DataLayer/game.php";
//include my dbInfo
    require_once "/home/MAIN/cnd9351/Sites/dbInfoPS.inc";
    /**
     * Function to start the game between 2 players
     * - Needs player1 and player2, board size, date
     * - create a game
     */
    function gameStart($player1, $player2, $board){
        $gameid = createNewGame($player1, (int)$player2, $board, date("Y-m-d h:i:s"));
        if (is_numeric($gameid)) {
            //update each players gameid to the new gameid
            setGameId($player1, $gameid);
            setGameId($player2, $gameid);
         }
    }

    /**
     * Gets all the game info in JSON format
     *
     * @return Exception|string
     */
    function getGameInfo(){
        return selectGame($_SESSION['gameid']);
    }

    /**
     * checks if it thier turn
     * checks to see if the other user won
     * gets the last peice played
     * @return string
     */
    function checkTurn(){
        if($_SESSION['userid'] == getTurn($_SESSION['gameid'])){
            //your turn -- what do I need?
            //check if the other person won
            $win = getWin($_SESSION['gameid']);
            //last peice placed
            $piece = getLastPiece($_SESSION['gameid']);
            $json = "{\"piece\": \"$piece\", \"win\": \"$win\",\"turn\":\"turn\"}";
            return ($json);
        }else{
            //not your turn
            return "{\"turn\":\"notTurn\"}";
        }
    }

    /**
     * checks to see if its thier turn
     * validates move and checks win condition
     * updates turn
     * @param $piece
     * @return string
     */
    function changeTurn($piece){
        //is it your turn?
        $json = json_decode($piece);
        $piece = array();
        $piece[0] = $json->col;
        $piece[1] = $json->row;
        $col = $piece[0];
        $row = $piece[1];
        $board = getBoard($_SESSION['gameid']);
        if($_SESSION['userid'] == getTurn($_SESSION['gameid'])){
            //yes -- change turn -- send the
            if(validateMove($piece)){
                //did they win?
                if(winCondition($board,$row,$col)){
                    return "win";
                }
                updateTurn($_SESSION['userid'],$_SESSION['gameid']);
                $board[$col][$row] = $_SESSION['userid'];
                updateBoardMove($board,$_SESSION['userid'], $_SESSION['gameid']);
            }else{
                //they didnt win -- they cheated
                return "cheater";
            }
        }else{
            //no - return not your turn
            return "notTurn";
        }
    }

    /**
     * checks to see if the move is valid by iterating through the passed in col
     * looks for the first '0' value found  and checks if the row is the same if it is then its a valid move
     * checks the win condition
     * updates board
     *
     * @param $piece
     * @return bool
     */
    function validateMove($piece){
        //get the board
        $board = getBoard($_SESSION['gameid']);
        var_dump($board);
        //is it a free space? -- look for the
        //check row and col are correct size
        $col = $piece[0];
        $row = $piece[1];
        var_dump($_SESSION);
        var_dump($row);
        var_dump($board->length);
        if($row < $board->length && $col < $board[0]->length){
            if($board[$col][$row] == 0){
                for($i=$row-1; i > -1 ; $i--){
                    if($board[$col][$row] != 0){
                        return false;
                    }
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Checks to see if the win condition has been met
     * - horizontal at Row
     * - vertical at Column
     * - diagonal right - smaller number [minus][minus]
     * - diagonal left - smaller number [minus][plus]
     *  -- iterate by: (total row/column - (bigger number - smaller))
     *
     * @param $board
     * @param $row
     * @param $col
     * @return bool
     */
    function winCondition($board, $row, $col){
        $maxRow = $board->length;
        $maxCol =$board[0]->length;
        //horizonal check
        $cnt=0;
        //look left
        for($i=$row; $i<0; $i--){
            if($board[$col][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }
        //look right
        for($i=$row; $i<$maxRow; $i++){
            if($board[$col][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }

        //vertical check
        $cnt=0;
        $value = $col;
        while($value != 0 && $board[$value][$row] == $_SESSION['userid']){
            $cnt++;
            $value++;
            if($cnt == 3){
                return true;
            }
        }

        //diagonal check down right
        $cnt=0;
        for($i=$row; $i<$maxRow; $i++){
            for($j=$row; $j<$maxCol; $j++){
                if($board[$j][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 3){
                        return true;
                    }
                }else{
                    break;
                }
            }
        }

        //check up left
        for($i=$row; $i<0; $i--){
            for($j=$row; $j<0; $j--){
                if($board[$j][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 3){
                        return true;
                    }
                }else{
                    break;
                }
            }
        }

        //check down left
        $cnt=0;
        for($i=$row; $i<$maxRow; $i++){
            for($j=$row; $j<0; $j--){
                if($board[$j][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 3){
                        return true;
                    }
                }else{
                    break;
                }
            }
        }
        //diagonal check - up
        for($i=$row; $i<0; $i--){
            for($j=$row; $j<$maxCol; $j++){
                if($board[$j][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 3){
                        return true;
                    }
                }else{
                    break;
                }
            }
        }
        return false;

    }
}
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
            return json_encode($json);
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
        if($_SESSION['userid'] == getTurn($_SESSION['gameid'])){
            //yes -- change turn -- send the
            if(validateMove($piece)){
                //they won
                updateTurn($_SESSION['userid'], $_SESSION['gameid']);
                return "win";
            }else{
                //they didnt win
                updateTurn($_SESSION['userid'], $_SESSION['gameid']);
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
        //is it a free space? -- look for the
        //check row and col are correct size
        if($piece[0] < $_SESSION['row'] && $piece[1] < $_SESSION['columns']){
            $col = $piece[1];
            $row = $piece[0];
            for($i = 0; $i < $_SESSION['rows']; $i++){
                if($board[$i][$col] == 0 && $i == $row){
                    //this is a valid move
                    $board[$i][$col] = $_SESSION['userid'];
                    //run the win condition
                    if(winCondition($board, $row, $col)){
                        // player won
                        //update winner to userid
                        updateWin($_SESSION['userid'], $_SESSION['gameid']);
                        updateBoardMove($board,$_SESSION['challengerid'],$_SESSION['gameid']);
                        //return win
                        return true;
                    }
                }
            }
            //if not win update board
            updateBoardMove($board,$_SESSION['challengerid'],$_SESSION['gameid']);
            return false;
        }
        //[row][col]
        //check the col get first 0 --if equal then valid move if not -- not valid -- run the win condition now
        //yes -- change it in the board --change it in the last_move
        //no -- not a valid move
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
        $maxRow = $_SESSION['rows'];
        $maxCol = $_SESSION['columns'];
        //horizonal check
        $cnt=0;
        for($i = 0; $i<$_SESSION['columns']; $i++){
            if($board[$row][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 4){
                    //win!!
                    return true;
                }
            }
        }

        //vertical check
        $cnt=0;
        for($i = 0; $i <$_SESSION['row']; $i++){
            if($board[$i][$col] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 4){
                    //win
                    return true;
                }
            }
        }

        //diagonal check down
        if($col > $row){
            $startcol = $col - $row;
            $cnt=0;
            $difference = $maxCol - $startcol;
            for($i = 0; $i < $difference; $i++){
                if($board[$i][$startcol] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 4){
                        //win
                        return true;
                    }
                }
                $startcol++;
            }
        }else{
            $cnt=0;
            $startrow = $row - $col;
            $difference = $maxRow - $startrow;
            for($i = 0; $i<$difference; $i++){
                if($board[$startrow][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 4){
                        //win
                        return true;
                    }
                }
                $startrow++;
            }
        }

        //diagonal check - up
        if($col > $row){
            $cnt=0;
           $startcol = $col - $row;
           $difference = $maxCol - $startcol;
           for($i = $maxRow; $i > $difference; $i--){
               if($board[$startcol][$i] == $_SESSION['userid']){
                   $cnt++;
                   if($cnt == 4){
                       //win
                       return true;
                   }
               }
               $startcol++;
           }
        }else{
            $cnt=0;
            $startRow = $row -$col;
            $difference = $maxRow - $startRow;
            for($i = $maxCol; $i > $difference; $i--){
                if($board[$i][$startRow] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 4){
                        //win
                        return true;
                    }
                }
                $startRow++;
            }
        }
        return false;
    }
}
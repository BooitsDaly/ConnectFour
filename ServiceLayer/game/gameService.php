<?php
if(isset($_SESSION['authenticated'])) {
    //include the db layer
    require_once "./DataLayer/game.php";
    //include my dbInfo
    require_once "/home/MAIN/cnd9351/Sites/dbInfoPS.inc";
    /**
     * Function to start the game between 2 players
     * - Needs player1 and player2, board size, date
     * - create a game
     */
    function gameStart($player1, $player2, $board){
        $gameid = createNewGame($player1, (int)$player2, $board);
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
     * delete the game and messages and reset the game id for the users
     *
     * @return bool
     */
    function leave(){
        if($_SESSION['gameid'] != 0){
            //what does this mean? -- how to display this to the other user?
            //delete messages then change gameid of users then delete game
            require_once ('./DataLayer/messages.php');
            deleteMessages($_SESSION['gameid']);
            require_once ('./DataLayer/user.php');
            setGameId($_SESSION['userid'],0);
            setGameId($_SESSION['challengerid'],0);
            deleteGame($_SESSION['gameid']);
            return true;
        }else{
            return false;
        }
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
            $json = array(
                    'piece' => $piece,
                    'win' => $win,
                    'turn' => 'turn'
            );
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
        $json = json_decode($piece);
        $piece = array();
        $piece[0] = $json->col;
        $piece[1] = $json->row;
        $col = $piece[0];
        $row = $piece[1];
        $board = getBoard($_SESSION['gameid']);
        //did someone already win??
        if(getWin($_SESSION['gameid']) == true){
            return 'gameOver';
        }
        if($_SESSION['userid'] == getTurn($_SESSION['gameid'])){
            //yes -- change turn -- send the
            if(validateMove($piece)){
                //did they win?
                if(winCondition($board,$row,$col)){
                    $board[$col][$row] = $_SESSION['userid'];
                    updateBoardMove($board,$piece, $_SESSION['gameid']);
                    updateTurn($_SESSION['challengerid'],$_SESSION['gameid']);
                    updateWin($_SESSION['userid'],$_SESSION['gameid']);
                    return "win";
                }
                updateTurn($_SESSION['challengerid'],$_SESSION['gameid']);
                $board[$col][$row] = $_SESSION['userid'];
                updateBoardMove($board,$piece, $_SESSION['gameid']);
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

        //is it a free space? -- look for the
        //check row and col are correct size
        $col = $piece[0];
        $row = $piece[1];
        if($row < count($board[0]) && $col < count($board)){
            if($board[$col][$row] == 0){
                for($i=$row+1; $i < count($board[0]) ; $i++){
                    if($board[$col][$i] == 0){
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
        $maxRow = count($board[0]);
        $maxCol =count($board);
        //horizonal check
        $cnt=0;
        //look left
        for($i=$col-1; $i>-1; $i--){
            if($board[$i][$row] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }
        //look right
        for($i=$col+1; $i<$maxCol+1; $i++){
            if($board[$i][$row] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }
        //Vertical Check
        $cnt=0;
        for($i=$row+1; $i<$maxRow+1; $i++){
            if($board[$col][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }



        //diagonal check down right
        $cnt=0;
        $j=$col+1;
        for($i=$row+1; $i<$maxRow+1; $i++){
            if($j == $maxCol+1){
                break;
            }
            if($board[$j][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
            }else{
                break;
            }
        }

        //check up left
        $j = $col -1;
        for($i=$row-1; $i>-1; $i--){
            if($j==-1){break;}
            if($board[$j][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
                $j--;
            }else{
                break;
            }
        }
        //check down left
        $cnt=0;
        $j=$col-1;
        for($i=$row+1; $i<$maxRow+1; $i++){
            if($j==-1){break;}
                if($board[$j][$i] == $_SESSION['userid']){
                    $cnt++;
                    if($cnt == 3){
                        return true;
                    }
                    $j--;
                }else{
                    break;
                }
        }
        //diagonal check - up
        $j=$col+1;
        for($i=$row-1; $i>-1; $i--){
            if($j==$maxCol+1){break;}
            if($board[$j][$i] == $_SESSION['userid']){
                $cnt++;
                if($cnt == 3){
                    return true;
                }
                $j++;
            }else{
                break;
            }
        }
        return false;

    }
}
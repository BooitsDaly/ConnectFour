<?php

//TODO:include a section for logging errors?

/**
 * Database Query to authenticate and log in user
 * - check for the user and pass in db
 * - validated?
 * - set sessions
 * - update db to show user as "authenticated"
 */
//check the db for the user pass --check if validated --  and set sessions in here -- also mark them as validated

function authenticateUser($username,$password){
    global $mysqli;
    try{
        $query = "SELECT username, gameid, userid FROM users WHERE username = ? AND password = ? AND isAuthenticated = 0";
        if($stmt = $mysqli->prepare($query)){
            //bind the params
            $stmt->bind_param("ss",$username,$password);
            //execute the query
            $stmt->execute();
            $stmt->store_result();

            // get variables from result.
            $stmt->bind_result($user, $gameid, $userid);
            $stmt->fetch();
            if($stmt->num_rows == 1){
                //check if gameid = 0 if not reset it
                if($gameid != 0){
                    if($stmtgame = $mysqli->prepare("UPDATE users SET gameid=0 WHERE username = :username")){
                        $stmtgame->bind_param('s', $username);
                        $stmtgame->execute();
                    }
                }

                //change authenticated in the server
                if($stmtauth = $mysqli->prepare("UPDATE users SET isAuthenticated = 1 WHERE username = ?")){
                    $stmtauth->bind_param('s', $username);
                    $stmtauth->execute();
                }

                // set the sessions for the user
                $_SESSION['authenticated'] = true;
                $_SESSION['username'] = $user;
                $_SESSION['gameid'] = 0;
                $_SESSION['userid'] = $userid;
                $_SESSION['start'] = date();
                $_SESSION['expire'] = $_SESSION['start'] + (3 * 60 * 60);

                //return the success call
                return "Success";
            }else{
                return "Error logging in";
            }
        }else{
            return "error logging in";
        }
    }catch(Exception $e){
        // log the error
        return "Error";
    }
}

/**
 * FUnction to logout the user
 * -set authenticated to 0 so they show offline to other users
 * -they can re-log
 * @param $userid
 * @return string
 */
function logout($userid){
    global $mysqli;
    $query = "UPDATE users SET isAuthenticated = 0 WHERE userid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('i', $userid);
            $stmt->execute();
            session_unset();
            session_destroy();
        }
        header('Locations: '.'index.php');
    }catch(Exception $e){

    }
}

/**
 * Database Query to get all of the Users in the user table
 * -set up the query
 * -query for all users but the user who sent the request
 * -convert json
 * -return the users
 */
function getAllUsers($username){
    global $mysqli;
    $query = "SELECT username, gameid, userid from users WHERE isAuthenticated = 1 AND username <> ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("s", $username);
            $stmt->execute();
            //grab the data
            //format the data
            return returnJSON($stmt);
            //return data
        }else{
            return "error retrieving online users";
        }

    }catch(Exception $e){

    }
}


/**
 * DataBase update challenge status to the user that challenged them
 *
 * @param $id
 * @param $user
 * @param $setTo
 * @return string
 */
function updateChallengeStatus($id,$setTo){
    global $mysqli;
    $query = "UPDATE users SET wasChallenged = ? WHERE userid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("ii",$setTo,$id);
            $stmt->execute();
            return "success";
        }
    }catch(Exception $e){
        return "error";
    }
}

/**
 * Check the wasChalleneged from the table
 * -if challenged return yes and set session for challenger
 * -else return none
 * @param $userid
 * @return string
 */
function checkChallengeStatus($userid){
    global $mysqli;
    $query = "SELECT wasChallenged FROM users WHERE userid = ? AND wasChallenged <> 0";
    try{
        if($stmt = $mysqli->prepare($query)){

            $stmt->bind_param('i', $userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($challenger);
            $stmt->fetch();
            if($stmt->num_rows != 0){
                $_SESSION['challengerid'] = $challenger;
                return 'yes';
            }
        }
    }catch(Exception $e){
        return 'none';
    }
}

/**
 * Check to see if there is a response
 * send back failed if no rows
 * sebd back the value if non-zero
 *
 * @param $userid
 * @return string
 */
function checkChallengeReplyStatus($userid){
    global $mysqli;
    $query = "SELECT responseChallenge FROM users WHERE userid= ? AND responseChallenge <> 0";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('i',$userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($responseChallenge);
            $stmt->fetch();
            if($stmt->num_rows !=0){
                return $responseChallenge;
            }else{
                return 'failed';
            }
        }else{
            return 'failed';
        }
    }catch(Exception $e){
        return 'failed';
    }
}

/**
 * changes the challenge response data
 *
 * @param $userid
 * @param $status
 * @return Exception
 */
function changeChallengeResponseData($userid, $status){
    global $mysqli;
    $query = "UPDATE users SET responseChallenge = ? WHERE userid = ?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param('ii',$status,$userid);
            $stmt->execute();
        }
    }catch(Exception $e){
        return $e;
    }
}

function setGameId($player,$value){
    global $mysqli;
    $query = "UPDATE user SET gameid=? WHERE userid=?";
    try{
        if($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param("ii", $value, $player);
            $stmt->execute();
        }
    }catch(Exception $e){

    }
}

function getPlayerGameid($userid){
    global $mysqli;
    $query = "SELECT gameid FROM users WHERE userid=?";
    try{
        if($stmt = $mysqli->prepare($query)){
            $stmt->bind_param("i",$userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($gameID);
            $stmt->fetch();
            if($stmt->num_rows !=0){
                return $gameID;
            }
        }
    }catch(Exception $e){}
}


/**
 * Gets the Username of a user by userid
 *
 * @param $userid
 * @return string
 */
function getUsername($userid){
    global $mysqli;
    try{
        if($stmt = $mysqli->prepare("SELECT username FROM users WHERE userid = ?")){
            $stmt->bind_param('i',$userid);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($username);
            $stmt->fetch();
            if($stmt->num_row != 0){
                return $username;
            }
        }
    }catch(Exception $e){
        return "doesnt exist";
    }
}




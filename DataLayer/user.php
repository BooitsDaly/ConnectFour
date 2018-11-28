<?php

//include a section for logging errors?

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
                    if($stmt = $mysqli->prepare("UPDATE users SET gameid=0 WHERE username = :username")){
                        $stmt->bind_param('s', $username);
                        $stmt->execute();
                    }
                }

                // set the sessions for the user (set up a token??)
                $_SESSION['authenticated'] = true;
                $_SESSION['username'] = $user;
                $_SESSION['gameid'] = 0;
                $_SESSION['userid'] = $userid;

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
 * Database Query to get all of the Users in the user table
 * -set up the query
 * -query for all users
 * -convert json
 * -return the users
 */
function getAllUsers(){
    global $mysqli;
    $query = "SELECT username, gameid, userid from users WHERE isAuthenticated = 1";
    try{
        if($stmt = $mysqli->prepare($query)){
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
 * Function call to execute query and format the JSON to return
 * -get query
 * -execute
 * -get result and format
 * takes :bound prepared statement
 * returns: 2D array
 */
function returnJSON($stmt){
    $stmt->execute();
    $stmt->store_result();
    $meta = $stmt->result_metadata();
    $bindVarsArray = array();
    //using the stmt, get it's metadata (so we can get the name of the name=val pair for the associate array)!
    while ($column = $meta->fetch_field()) {
        $bindVarsArray[] = &$results[$column->name];
    }
    //bind it!
    call_user_func_array(array($stmt, 'bind_result'), $bindVarsArray);
    //now, go through each row returned,
    while($stmt->fetch()) {
        $clone = array();
        foreach ($results as $k => $v) {
            $clone[$k] = $v;
        }
        $data[] = $clone;
    }
//    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
//    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
//    header("Cache-Control: no-store, no-cache, must-revalidate");
//    header("Cache-Control: post-check=0, pre-check=0", false);
//    header("Pragma: no-cache");
//    //MUST change the content-type
//    header("Content-Type:text/plain");
//    // This will become the response value for the XMLHttpRequest object
    return json_encode($data);
}

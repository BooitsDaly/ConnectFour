<?php
session_start();

//include a section for logging errors?

/*
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
            $stmt->bind_param("s",$username);
            $stmt->bind_param("s",$password);
            //execute the query
            $stmt->execute();
            $data = $stmt->fetch();
            //check if gameid = 0 if not reset it
            if($data[0]['gameid'] != 0){
                if($stmt = $mysqli->prepare("UPDATE users SET gameid=0 WHERE username = :username")){
                    $stmt->bind_param('s', $username);
                    $stmt->execute();
                }
            }
            $_SESSION['authenticated'] = true;
            // set the sessions for the user (set up a token??)

            //return the success call
            return "Success";
        }else{
            return "error logging in";
        }
    }catch(Exception $e){
        // log the error
        return "Error";
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
//    $stmt->execute();
//    $stmt->store_results();
//    $metadata = $stmt->result_metadata();
//    $array = array();
//    while($column = $meta->fetch_field()){
//        $array[] = &$results[column->name];
//    }
}
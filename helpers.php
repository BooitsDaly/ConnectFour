<?php
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
    return json_encode($data);
}

/**
 * sanitize string
 * @param $var
 * @return string
 */
function sanitizeString($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}
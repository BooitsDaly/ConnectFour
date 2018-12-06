<?php
session_start();
//include the files needed for the "method"
if(isset($_REQUEST['method'])){
    require_once ('./helpers.php');
    foreach(glob("./ServiceLayer/" .$_REQUEST['a'] . "/*.php") as $filename){
        require ($filename);
    }
    //echo getcwd();
    //require_once "./ServiceLayer/users/userService.php";
    //set the variables

    $now = time(); // Checking the time now when home page starts.

    if (isset($_SESSION['expire']) && $now > $_SESSION['expire']) {
        //check that it wasnt included
        if($_REQUEST['a'] != 'users'){
            require ('./ServiceLayer/users/userService.php');
            logoutUser();
        }
    }

    $serviceMethod = $_REQUEST['method'];
    $data = $_REQUEST['data'];

    //TODO:validate and sanitize

    //make the method call
    $result = @call_user_func($serviceMethod,$data);
    //check valid data and echo
    if($result){
        header("Content-Type: text/plain");
        echo $result;
    }
}

function sanitizeString($var){
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlentities($var);
    $var = strip_tags($var);
    return $var;
}

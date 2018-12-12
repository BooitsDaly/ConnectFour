<?php
session_start();
//include the files needed for the "method"
if(isset($_REQUEST['method']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true && isset($_SESSION['userid'])){
    require_once ('./helpers.php');
    foreach(glob("./ServiceLayer/" .$_REQUEST['a'] . "/*.php") as $filename){
        require_once ($filename);
    }
    $serviceMethod = $_REQUEST['method'];
    $data = sanitizeString($_REQUEST['data']);

    //TODO:validate and sanitize

    //make the method call
    $result = @call_user_func($serviceMethod,$data);
    //check valid data and echo
    if($result){
        header("Content-Type: text/plain");
        echo $result;
    }
}



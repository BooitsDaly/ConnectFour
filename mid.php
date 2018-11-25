<?php
//include the files needed for the "method"
if(isset($_REQUEST['method'])){
    foreach(glob("./ServiceLayer/" .$_REQUEST['a'] . "/*.php") as $filename){
        include_once($filename);
    }
    //set the variables

    //make the method call

    //check valid data and echo
}

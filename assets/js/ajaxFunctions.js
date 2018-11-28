/*
* Ajax calls
* Use - ajax.functionName
*
*/

const ajax = {
    /*
    * The base ajax call
    */
    ajaxCall: function(getPost, data, url){
        console.log(data);
        return $.ajax({
            type: getPost,
            async: true,
            cache: false,
            url: url,
            data: data
        });
    },

    /*
    * Ajax login function
    * - success means redirect
    * - failure show the user an error message
    */
    ajaxLogin: function(whatMethod, val) {
        ajax.ajaxCall("POST", {method: whatMethod, a:'users', data: val}, "./mid.php").done(function (result) {
            $('body').append(result);
            if(result === 'Success'){
                //redirect to the lobby
                window.location.href = "./PresentationLayer/loby.php";
            }else{
                //display an error message on the top of the page
                displayFeedback('error','Login Failed');
            }
        });
    },
    ajaxGetUsers: function(whatMethod, val){
        ajax.ajaxCall("GET",{method: whatMethod, a:'users', data: val},"./../mid.php").done(function(json){
           console.log(json);
        });
    }


};
/*
* Ajax calls
* Use - ajax.functionName
*
*/

const ajax = {
    /*
    * The base ajax call
    */
    ajaxCall: function(getPost, data){
        console.log("here 1");
        return $.ajax({
            type: getPost,
            async: true,
            cache: false,
            url: "mid.php",
            data: data
        });
    },

    /*
    * Ajax login function
    * - success means redirect
    * - failure show the user an error message
    */
    ajaxLogin: function(whatMethod, val) {
        console.log("calling the function");
        console.log(whatMethod);
        console.log(val);
        ajax.ajaxCall("POST", {method: whatMethod, a:'users', data: val}).done(function (result) {
            $('body').append(result);
            if(result === 'Success'){
                //redirect to the lobby
                window.location.href = "./PresentationLayer/loby.php";
            }else{
                //display an error message on the top of the page
                displayFeedback('error','Login Failed');
            }
        });
    }


};
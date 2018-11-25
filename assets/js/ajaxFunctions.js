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
        return $.ajax({
            type: getPost,
            async: true,
            cache: false,
            url: "mid.php",
            data: data,
            dataType: 'json'
        });
    },

    /*
    * Ajax login function
    */
    ajaxLogin: function(whatMethod, val) {
        ajax.ajaxCall("POST", whatMethod, val).done(function (json) {

        });
    }


};
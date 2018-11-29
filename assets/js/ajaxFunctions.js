/*
* Ajax calls
* Use - ajax.functionName
*
*/

const ajax = {
    /**
    * The base ajax call
    */
    ajaxCall: function(getPost, data, url){
        return $.ajax({
            type: getPost,
            async: true,
            cache: false,
            url: url,
            data: data
        });
    },

    /**
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
    /**
     * Ajax Get Users Function
     * - get the data and display it on the user list
     * @param whatMethod
     * @param val
     */
    ajaxGetUsers: function(whatMethod, val){
        ajax.ajaxCall("GET",{method: whatMethod, a:'users', data: val},"./../mid.php").done(function(json){
           let data = JSON.parse(json);
           let markup = `<ul id="userList" class="list-group list-group-flush">`;
           $.each(data,function(value){
               markup += `<li class="list-group-item" data=${data[value].userId}>${data[value].username}<button class="btn btn-danger challengeBtn">Challenge</button></li>`;
           });
           markup += `</ul>`;
           $("#Users").html(markup);
        });

        //set timer so that the user table stays up to date
        setInterval(ajax.ajaxGetUsers(whatMethod,val),10000);
    },
    /**
     * Ajax Challenge Function
     * - sends challenge
     * - receives response
     * @param whatMethod
     * @param val
     */
    ajaxChallenge: function(whatMethod, val){
        ajax.ajaxCall("POST",{method: whatMethod, a:'users', data:val},"./../mid.php").done(function(result){
            console.log(result);
            if(result === "Accepted"){
                ajax.ajaxCall("POST",{method: 'changeChallengeStatus', a: 'users', data: 'default'}, './../mid.php');
                console.log("updated back");
            }else{

            }
        });
    },

    /**
     * Ajax Receive Challenge Function
     * - Check while the user is in lobby if someone challenges them
     */
    ajaxReciveChallengeCheck: function(){
        ajax.ajaxCall({method: 'checkForChallenge', a:'users', data: null}).done(function(response){
            if(response == 'yes'){
                //challenged
                console.log("You have been challenged");
                //change the status back to not challenged
            }else{
                //check again
                setInterval(ajax.ajaxReciveChallengeCheck(),5000)
            }
        });
    }


};
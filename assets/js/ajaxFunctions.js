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
                setTimeout(function(){window.location.href = "./PresentationLayer/loby.php";},1000);
            }else{
                //display an error message on the top of the page
                displayFeedback('error','Login Failed');
            }
        });
    },
    /**
     * Ajax logout method
     * @param whatMethod
     * @param val
     */
    ajaxLogout:function(whatMethod, val){
       ajax.ajaxCall("POST",{method: whatMethod, a:'users', data: val}, "./../mid.php");
    },
    /**
     * Ajax Get Users Function
     * - get the data and display it on the user list
     * @param whatMethod
     * @param val
     */
    ajaxGetUsers: function(whatMethod, val) {
        let game = ajax.checkGame();
        if (game === undefined) {
            ajax.ajaxCall("GET", {method: whatMethod, a: 'users', data: val}, "./../mid.php").done(function (json) {
                let data = JSON.parse(json);
                let markup = `<ul id="userList" class="list-group list-group-flush">`;
                $.each(data, function (value) {
                    markup += `<li class="list-group-item" id=${data[value].userid}>${data[value].username}<button class="btn btn-danger challengeBtn">Challenge</button></li>`;
                });
                markup += `</ul>`;
                $("#Users").html(markup);
            });
            setTimeout(function(){
                ajax.ajaxGetUsers(whatMethod,val);
            },3000);
        }else{

        }


        //set timer so that the user table stays up to date

    },
    /**
     * Ajax Challenge Function
     * - sends challenge
     * - receives response
     * @param whatMethod
     * @param val
     */
    ajaxChallenge: function(whatMethod, val){
        ajax.ajaxCall("POST",{method: whatMethod, a:'users', data:val},"./../mid.php").done(function(){
            setTimeout(function(){ajax.resolveChallenge();},3000);
        });
    },

    /**
     * Ajax Receive Challenge Function
     * - Check while the user is in lobby if someone challenges them
     */
    ajaxReciveChallengeCheck: function(){
        if(ajax.checkGame() === undefined) {
            ajax.ajaxCall("GET", {
                method: 'checkForChallenge',
                a: 'users',
                data: null
            }, "./../mid.php").done(function (response) {
                if (response == 'yes') {
                    //challenged
                    //TODO: print out the person who challenged you
                    let markup = `<div class="modal" tabindex="-1" role="dialog">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Challenge</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <p>You have been challenged to a game</p>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-primary challengeResponse" data-dismiss="modal">Accept</button>
                                            <button type="button" class="btn btn-secondary challengeResponse" data-dismiss="modal">Decline</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>`;
                    $('body').append(markup);
                    setTimeout(function(){$('.modal').modal('toggle');},1000);
                    //change the status back to not challenged
                } else {
                    //check again
                    setTimeout(function(){ajax.ajaxReciveChallengeCheck();},5000);
                }
            });
        }
    },
    /**
     * Check what game the User is currently in
     * -make call to get game
     * -return the game value
     */
    checkGame: function(){
        ajax.ajaxCall("GET",{method: 'checkGame', a: 'users', data: null},"./../mid.php").done(function(game){
            return game;
        });
    },

    /**
     * Ajax call to response to the challenge with a yes or no
     * @param whatMethod
     * @param val
     */
    replyChallenge:function(whatMethod, val){
        ajax.ajaxCall("POST",{method: whatMethod ,a: 'users',data: val},'./../mid.php');
    },

    /**
     * After challenge is initiated check for a response
     * - keep checking until get a response
     */
    resolveChallenge: function(){
        ajax.ajaxCall("GET",{method:'checkReplyChallenge',a:'users', data: null},'./../mid.php').done(function(result){
            if(result == 'declined'){
                displayFeedback('error','Challenge has been declined');
            }else if(result == 'accepted'){
                displayFeedback('success',"Challenge Accepted");
            }else{
                setTimeout(function(){ajax.resolveChallenge();},3000);
            }

        });
    }

};
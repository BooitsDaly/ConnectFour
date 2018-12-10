/*
* Ajax calls
* Use - ajax.functionName
*
*/

const ajax = {
    gameid: "",
    username: "",
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
       ajax.ajaxCall("POST",{method: whatMethod, a:'users', data: val}, "./../mid.php").done(function(){
           setTimeout(function(){window.location.href = "./../index.php";},1000);
       });
    },
    ajaxRegister:function(whatMethod,val){
        ajax.ajaxCall("POST",{method: whatMethod, a:'users', data: val},"./../mid.php").done(function(result){
            if(result === 'Success'){
                //redirect to the lobby
                setTimeout(function(){window.location.href = "./loby.php";},1000);
            }else{
                //display an error message on the top of the page
                displayFeedback('error','Registration Failed');
            }
        });
    },
    /**
     * Ajax Get Users Function
     * - get the data and display it on the user list
     * @param whatMethod
     * @param val
     */
    ajaxGetUsers: function(whatMethod, val) {
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
    },
    getMessages:function(){
        ajax.ajaxCall("GET",{method: 'getMessages', a: 'messages', data:null}, "./../mid.php").done(function(data){
            let json = JSON.parse(data);
            $('#chatlog').html("");
            $.each(json,function(value){
                chatMessages(json[value].message, json[value].username);
            });
        });
        setTimeout(function(){ajax.getMessages();},2000);

    },
    sendMessage: function(whatMethod,val){
        ajax.ajaxCall("POST",{method: whatMethod, a: 'messages', data:val},"./../mid.php").done(function(){

        });
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
        if(ajax.gamid === 0 || ajax.gamid === undefined) {
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
            ajax.gameid = game;
            setTimeout(function(){ajax.checkGame();},5000);
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
            $('body').append(result);
            if(result === 'declined'){
                displayFeedback('error','Challenge has been declined');
            }else if(result === 'accepted'){
                displayFeedback('success',"Challenge Accepted");
            }else{
                setTimeout(function(){ajax.resolveChallenge();},3000);
            }

        });
    },

    startGame: function(){
        let gameid = ajax.gameid;
        console.log(gameid);
        if(gameid !== 0 && gameid !== undefined && gameid !== "") {
            ajax.ajaxCall("GET",{method:'getGameInfo', a:'game', data: gameid},'./../mid.php').done(function(json){
                console.log(json);
                let data = JSON.parse(json);
                console.log(data);
                new Game(data.player1, data.player2);
                ajax.checkTurn();
            });
        }else{
            setTimeout(function(){ajax.startGame();},3000);
        }
    },
    //get turn
    checkTurn:function(){
        if(ajax.gameid !== 0){
            ajax.ajaxCall("GET",{method:'checkTurn', a:'game', data: null},'./../mid.php').done(function(json){
                let data = JSON.parse(json);
                console.log(data);
                //is it my turn?
                if(data.turn === "turn"){
                    //change identifier for turn
                    //place the opponents peice if not empty(first turn)
                    if(data.piece !== ""){
                        //place piece
                    }
                }else{
                    setTimeout(function(){ajax.checkTurn();},5000);
                }
            });
        }
    },
    //change turn
    changeTurn: function(){

    },
    leaveGame: function(){
        ajax.ajaxCall("POST",{"POST",{},"./../mid.php").done(function(){
            displayFeedback('error', "You have ended the game");
        });
    }
    

};
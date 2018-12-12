/*
* Ajax calls
* Use - ajax.functionName
*
*/

const ajax = {
    gameid: 0,
    username: "",
    turn: false,
    userid: null,
    game: null,
    opponent: null,
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
            setTimeout(function(){ajax.resolveChallenge();},2000);
        });
    },

    /**
     * Ajax Receive Challenge Function
     * - Check while the user is in lobby if someone challenges them
     */
    ajaxReciveChallengeCheck: function(){
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
                setTimeout(function(){ajax.ajaxReciveChallengeCheck();},2000);
            }
        });

    },
    /**
     * Check what game the User is currently in
     * -make call to get game
     * -return the game value
     */
    checkGame: function(){
        ajax.ajaxCall("GET",{method: 'checkGame', a: 'users', data: null},"./../mid.php").done(function(game){
            if(game === null){
                ajax.gameid = 0;
            }else{
                ajax.gameid = game;
            }
            console.log(ajax.gameid);
            setTimeout(function(){ajax.checkGame();},2000);
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
            if(result === 'declined'){
                displayFeedback('error','Challenge has been declined');
            }else if(result === 'accepted'){
                displayFeedback('success',"Challenge Accepted");
            }else{
                setTimeout(function(){ajax.resolveChallenge();},2000);
            }

        });
    },

    startGame: function(){
        let gameid = ajax.gameid;
        if(gameid !== 0 && gameid !== undefined && gameid !== "" && gameid != null) {
            ajax.ajaxCall("GET",{method:'getGameInfo', a:'game', data: gameid},'./../mid.php').done(function(json){
                $('.page-header').html('In Game');
                let data = JSON.parse(json);
                ajax.game = new Game(data[0].player1, data[0].player2);
                if(data[0].player1 == ajax.userid){
                    ajax.opponent = data[0].player2;
                }else if(data[0].player2 == ajax.userid){
                    ajax.opponent = data[0].player1;
                }
                //get the board and populate it if there are peices already in play
                let board = JSON.parse(data[0].board);
                for(let i = 0; i < board.length; i++){
                    for(let j = board[0].length-1; j >-1; j--){
                        console.log(board[i][j]);
                        if(board[i][j] !== 0){
                            //is it me or them?
                            console.log(i);
                            console.log(j);
                            if(board[i][j] === ajax.userid){
                                console.log('here');
                                ajax.game.animatePiece(i,j,true);
                            }else{
                                console.log("not here");
                                ajax.game.animatePiece(i,j,false);
                            }
                        }
                    }
                }
                ajax.game.boardArr = board;
                ajax.checkTurn();
            });
        }else{
            setTimeout(function(){ajax.startGame();},1000);
        }
    },
    //get turn
    checkTurn:function(){
        if(ajax.gameid !== 0 || ajax.gameid !== null || ajax.gameid !== ""){
            ajax.ajaxCall("GET",{method:'checkTurn', a:'game', data: null},'./../mid.php').done(function(json) {
                let data = JSON.parse(json);
                let game = ajax.game;
                //is it my turn?
                if (data.turn === "turn") {
                    ajax.turn = true;
                    displayFeedback('success', 'It is your turn');
                    //change identifier for turn
                    //place the opponents peice if not empty(first turn)
                    if (data.piece !== null) {
                        //place piece
                        let piece = JSON.parse(data.piece);
                        console.log(game.boardArr[piece[0]][piece[1]]);
                        if(game.boardArr[piece[0]][piece[1]] === 0){
                            game.animatePiece(piece[0], piece[1], false);
                            game.boardArr[piece[0]][piece[1]] = ajax.opponent;
                        }
                        if (data.win === true) {
                            displayFeedback('error', 'You lose');
                            ajax.turn = false;
                        }
                    }
                }else{
                    setTimeout(function(){ajax.checkTurn();},1000);
                }
            });
        }else{
            displayFeedback('error','The game has ended');
            setTimeout(function(){location.reload();},3000);
        }
    },
    //change turn
    changeTurn: function(whatMethod, data){
        ajax.ajaxCall("POST",{method: whatMethod, a:'game', data:data}, "./../mid.php").done(function(data){
            $('body').append(data);

            if(data === 'win'){
                displayFeedback('success', "You won!");
                ajax.turn = false;
                ajax.checkTurn();
            }else if(data === "cheater"){
                displayFeedback('error', 'That is not a valid move');
            }else if(data === 'notTurn'){
                displayFeedback('error','It is not your turn');
            }else if(data === 'gameOver'){
                displayFeedback('error', 'Game is already over');
            }else{
                ajax.turn = false;
                ajax.checkTurn();
            }
        });
    },
    getUserInfo:function () {
        ajax.ajaxCall("GET",{method:'getUserInfo', a:'users', data:null},"./../mid.php").done(function(data){
            let json = JSON.parse(data);
            ajax.username = json[0].username;
            ajax.userid = json[0].userid;
        });
    },
    leaveGame: function(){
        ajax.ajaxCall("POST",{method:'leave', a:'game', data: null},"./../mid.php").done(function(result){
            if(result == false){
                displayFeedback('error', 'Your are not in a game');
                setTimeout(function(){location.reload();},3000);
            }else{
                displayFeedback('success', "You have ended the game");
                setTimeout(function(){location.reload();},3000);
            }
        });
    }


};
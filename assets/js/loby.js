$(document).ready(function(){
    //on load populate the users tab
    ajax.ajaxGetUsers("getUsers", null);
    ajax.getMessages();
    //start the challenge checker
    ajax.ajaxReciveChallengeCheck();
    ajax.checkGame();
    ajax.startGame();

    /**
     * click event handler for the challenge button
     * - grab the username that they challenge
     * - format the json
     * - send the request
     */
    $(document).on("click",".challengeBtn",function(){
        let string = $(this).closest("li").prop('textContent');
        let user = string.replace('Challenge', '');
        let id = $(this).closest("li").attr('id');
        let data = `{\"challenge\":\"${user}\", \"challengeId\": \"${id}\"}`;
        ajax.ajaxChallenge("challenge",data);
    });

    /**
     * Logout Action Listener
     * -call the logout
     */
    $(document).on("click", '#logout', function(e){
       e.preventDefault();
       ajax.ajaxLogout('logoutUser', null);
       window.location.herf = "./index.php";
    });

    $('body').on('click', '.challengeResponse', function(){
       let response = $(this).prop('innerHTML');
       let string = `{\"response\": \"${response}\"}`;
       ajax.replyChallenge("challengeResponse", string);
    });
    $('#sendMessage').on('click',function(){
        let msg = document.getElementById('message').value;
        chatMessages(msg, ajax.username);
        ajax.sendMessage("saveMessage","{\"message\": \""+msg+"\"}");
        document.getElementById('message').value = "";
    });
});
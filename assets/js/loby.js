$(document).ready(function(){
    //on load populate the users tab
    ajax.ajaxGetUsers("getUsers", null);
    //start the challenge checker
    ajax.ajaxReciveChallengeCheck();

    /**
     * click event handler for the challenge button
     * - grab the username that they challenge
     * - format the json
     * - send the request
     */
    $(".challengeBtn").on("click",function(){
        let user = this.parent().innerText;
        let id = this.parent().data;
        let data = "{\"challenge\":\""+ user +"\", \"challengeId\": \""+ id +"\"}";
        ajax.ajaxChallenge("challenge",data);
    });
});
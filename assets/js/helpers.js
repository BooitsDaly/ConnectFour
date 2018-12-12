var player;
var playerid;
var gameid;

/**
 * Toggle the tabs between users and messages
 * @param evt
 * @param tab
 */
function toggleTabs(evt,tab){
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tab).style.display = "block";
    evt.currentTarget.className += " active";
}

/**
 * displays feedback for users
 * @param type
 * @param message
 */
function displayFeedback(type, message){
    let markup = `
    <div class="row">
       <div class="col-lg-12">
       ${messageType(type,message)}
       </div>
   </div>
    `;
    $('#user-message').html(markup);
    setTimeout(function(){$('#user-message').html("");},6000);
}

/**
 * Determains the message type to display
 * @param type
 * @param message
 * @returns {string}
 */
function messageType(type,message){
    if(type === "success"){
        return `<div class="alert alert-success">${message}</div>`;
    }else if(type === 'error'){
        return `<div class=\"alert alert-danger\">${message}</div>`;
    }
}

/**
 * displays the users for challenge
 * @param json
 */
function displayUsers(json){
    let markup = `<ul class="list-group list-group-flush">`;
    $.each(json, function(data, index){
       markup += `<li class="list-group-item">${json.username}<button></button></li>`;
    });
}

/**
 * displays chat messages
 * @param msg
 * @param username
 */
function chatMessages(msg,username){
    let p = document.createElement("p");
    let message = document.createTextNode(username+": " + msg);
    p.appendChild(message);
    document.getElementById('chatlog').appendChild(p);
}
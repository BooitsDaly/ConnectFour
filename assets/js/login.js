/**
 * log in the user
 */
$('#loginBtn').on('click', function(e){
    e.preventDefault();
  //grab the username and password out of the text fields
  let user = document.getElementById('username').value;
  let password = document.getElementById('password').value;
  //format the data
  let data = "{\"username\":\"" + user +"\",\"password\": \""+ password +"\"}";
  //ajax
  ajax.ajaxLogin("authenticate",data);
});

/**
 * register the user
 */
$('#registerbtn').on('click', function(e){
   e.preventDefault();
   let username = document.getElementById('usernameReg').value;
   let pass1 = document.getElementById('passReg').value;
   let pass2 = document.getElementById('passRegConfirm').value;
   if(pass1 === pass2){
       let data = "{\"username\":\"" + username +"\",\"password\": \""+ pass1 +"\"}";
       ajax.ajaxRegister("register",data);
   }else{
       displayFeedback('error','Your passwords do no match');
   }

});
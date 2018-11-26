$('#loginBtn').on('click', function(e){
    e.preventDefault();
  //grab the username and password out of the text fields
  let user = document.getElementById('username').value;
  let password = document.getElementById('password').value;
  //TODO: may need to encrypt the password here
  //format the data
  let data = "{\"username\":\"" + user +"\",\"password\": \""+ password +"\"}";
  //ajax
    console.log(data);
  ajax.ajaxLogin("authenticate",data);
});
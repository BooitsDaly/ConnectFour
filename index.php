<?php
echo "<!doctype html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

    <title>Connect Four</title>

    <!-- Bootstrap core CSS -->
    <link href=\"./assets/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Custom styles for this template -->
    <link href=\"./assets/css/styles.css\" rel=\"stylesheet\">
  </head>

  <body>

    <nav class=\"navbar navbar-expand-md navbar-dark fixed-top bg-dark\">
      <a class=\"navbar-brand\" href=\"#\">Connect Four</a>
      <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarsExampleDefault\" aria-controls=\"navbarsExampleDefault\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
      </button>

      <div class=\"collapse navbar-collapse\" id=\"navbarsExampleDefault\">
        <ul class=\"navbar-nav mr-auto\">";
              echo "<li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"./\">Login <span class=\"sr-only\"></span></a>
          </li>
          <li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"./PresentationLayer/register.php\">Register <span class=\"sr-only\"></span></a>
          </li>";

        echo "</ul>
       
      </div>
    </nav>
    <div id='user-message'></div>
<div class=\"col-md-4 offset-md-4 login\">
  <h2 class=\"page-header\">Account Login</h2>
  <form>
    <div class=\"form-group \">
      <label>Username</label>
      <input type=\"text\" id='username' class=\"form-control\" name=\"username\" placeholder=\"Username\">
    </div>
    <div class=\"form-group\">
      <label>Password</label>
      <input type=\"password\" id='password' class=\"form-control\" name=\"password\" placeholder=\"Password\">
    </div>
    <button class=\"btn btn-default\" id='loginBtn'>Submit</button>
  </form>
</div>
<footer class=\"container\">
              <p>&copy; Connect Four </p>
            </footer>
            <script src=\"https://code.jquery.com/jquery-latest.js\"></script>
            <script type=\"text/javascript\" src='./assets/js/helpers.js'></script>
            <script type=\"text/javascript\" src='./assets/js/bootstrap.bundle.js'></script>
            <script type=\"text/javascript\" src='./assets/js/bootstrap.js'></script>
            <script type=\"text/javascript\" src='./assets/js/ajaxFunctions.js'></script>
            <script type=\"text/javascript\" src='./assets/js/login.js'></script>
          </body>
        </html>";
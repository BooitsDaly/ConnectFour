<?php
function addHeader(){
    echo "<!doctype html>
<html lang=\"en\">
  <head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">

    <title>Connect Four</title>

    <!-- Bootstrap core CSS -->
    <link href=\"./../assets/css/bootstrap.min.css\" rel=\"stylesheet\">
    

    <!-- Custom styles for this template -->
    <link href=\"./../assets/css/styles.css\" rel=\"stylesheet\">
  </head>

  <body class='container'>

    <nav class=\"navbar navbar-expand-md navbar-dark fixed-top bg-dark\">
      <a class=\"navbar-brand\" href=\"#\">Connect Four</a>
      <button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarsExampleDefault\" aria-controls=\"navbarsExampleDefault\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
        <span class=\"navbar-toggler-icon\"></span>
      </button>

      <div class=\"collapse navbar-collapse\" id=\"navbarsExampleDefault\">
        <ul class=\"navbar-nav mr-auto\">";
          if(isset($_SESSION['authenticated']) && !empty($_SESSION['authenticated'])){
          echo "<li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"loby.php\">Dashboard <span class=\"sr-only\"></span></a>
          </li>
          <li class=\"nav-item active\">
            <a id='logout' class=\"nav-link\">Logout <span class=\"sr-only\"></span></a>
          </li>";
            }else{
          echo "<li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"./../index.php\">Login <span class=\"sr-only\"></span></a>
          </li>
          <li class=\"nav-item active\">
            <a class=\"nav-link\" href=\"./register.php\">Register <span class=\"sr-only\"></span></a>
          </li>";
            }
        echo "</ul>
       
      </div>
    </nav>
    <div id='user-message'></div>";
}
function addFooter(){
    echo "<footer class=\"container\">
              <p>&copy; Connect Four </p>
            </footer>
            <script
              src=\"https://code.jquery.com/jquery-3.3.1.min.js\"
              integrity=\"sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=\"
              crossorigin=\"anonymous\"></script>
            <script src=\"//cdn.jsdelivr.net/npm/velocity-animate@2.0/velocity.min.js\"></script>
            <script type=\"text/javascript\" src='./../assets/js/helpers.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/bootstrap.bundle.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/bootstrap.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/ajaxFunctions.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/login.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/loby.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/game.class.js'></script>



          </body>
        </html>";
}

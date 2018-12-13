<?php
include_once ("./outline.php");
addHeader();
echo "<div class=\"col-md-4 offset-md-4 login\">
  <h2 class=\"page-header\">Register</h2>
  <form>
    <div class=\"form-group\">
      <label>Username</label>
      <input id='usernameReg' type=\"text\" class=\"form-control\" placeholder=\"Username\" name=\"username\">
    </div>
    <div class=\"form-group\">
      <label>Password</label>
      <input id='passReg' type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"password\">
    </div>
    <div class=\"form-group\">
      <label>Confirm Password</label>
      <input id='passRegConfirm' type=\"password\" class=\"form-control\" placeholder=\"Password\" name=\"password2\">
    </div>
    <button type=\"submit\" id='registerbtn' class=\"btn btn-default\">Submit</button>
  </form>
</div>
<footer class=\"container\">
              <p>&copy; Connect Four </p>
            </footer>
            <script
              src=\"https://code.jquery.com/jquery-3.3.1.min.js\"
              integrity=\"sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=\"
              crossorigin=\"anonymous\"></script>
            <script type=\"text/javascript\" src='./../assets/js/helpers.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/bootstrap.bundle.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/bootstrap.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/ajaxFunctions.js'></script>
            <script type=\"text/javascript\" src='./../assets/js/login.js'></script>
          </body>
        </html>";


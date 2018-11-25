<?php
require_once ("./outline.php");
addHeader();
echo "<div class=\"col-md-4 offset-md-4 login\">
  <h2 class=\"page-header\">Account Login</h2>
  <form method=\"post\" action=\"/users/login\" >
    <div class=\"form-group \">
      <label>Username</label>
      <input type=\"text\" class=\"form-control\" name=\"username\" placeholder=\"Username\">
    </div>
    <div class=\"form-group\">
      <label>Password</label>
      <input type=\"password\" class=\"form-control\" name=\"password\" placeholder=\"Password\">
    </div>
    <button type=\"submit\" class=\"btn btn-default\">Submit</button>
  </form>
</div>";
addFooter();

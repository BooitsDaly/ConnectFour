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
</div>";
addFooter();


<?php
//SQL Connect
$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);
//Header
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>
<!-- Import Form -->
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
    <div class ="body bodytext">
      <ul class="nav nav-tabs">
        <li><a data-toggle="tab" href="#login">Login</a></li>
        <li><a data-toggle="tab" href="#register">Register</a></li>
</ul>
<div class="tab-content">
        <div id="login"  class="tab-pane fade in active">
<div class="col-md-10 col-centered">
  <div class="pagetitle">Login</div>
  <div class="col-sm-6 typebox col-centered" id="name">
      <form method="post" action="loginprocess.php" id="loginform" enctype="multipart/form-data">
      <div class="text">Username</div><input class="textbox" type="text" name="username" id="username" placeholder="username" required>
      <div class="text">Password</div><input class="textbox" type="password" name="password" id="password" required>

</div>

<div class="col-centered">
<input form="loginform" class="btn btn-primary col-centered" type="submit" value="Submit">

</div>
</form>

</div>
</div>

<div id="register" class="tab-pane fade">

<div class="col-md-10 col-centered">
  <div class="pagetitle">Register</div>
<div class="col-sm-6 typebox col-centered" id="name">
<form method="post" action="registerprocess.php" id="registerform" enctype="multipart/form-data">
<div class="text">Userame</div><input class="textbox" type="text" name="username" id="username" placeholder="username" required>
<div class="text">Password</div><input class="textbox" type="password" name="password" id="password" required>
<div class="text">Confirm Password</div><input class="textbox" type="password" name="passwordconfirm" id="passwordconfirm" required>

</div>

<div class="col-centered">
<input form="registerform" class="btn btn-primary col-centered" type="submit" value="Submit">

</div>
</form>

</div>
</div>

</div>
</div>
</div>
<!-- Footer -->
<?php
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath);
 ?>

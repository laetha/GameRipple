<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);

$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);



// Create variables
$username=$_POST['username'];
$password=$_POST['password'];
$userlog = 0;
//$username=htmlentities(trim(addslashes($usernametemp)));
//$password=htmlentities(trim(addslashes($passwordtemp)));
$usercheck = "SELECT * FROM `users`";
$userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {
$hash = $row['password'];
  if ($row['username'] == $username) {
    if (password_verify($password, $hash)) {
    $loggedinuser = $row['username'];
    $userlog = 1;
  }
  }

}

if ($userlog == 1) {
  $_SESSION["newsession"]=$loggedinuser;
echo ('<script>window.location.replace("/index.php"); </script>');
          }
          else {
              include('logfailure.php');
              include('login.php');
        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

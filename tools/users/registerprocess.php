<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath); ?>

<!-- Header -->
<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);

// Create variables
$username=$_POST['username'];
$password=$_POST['password'];
$passwordconfirm=$_POST['passwordconfirm'];
$friend = 0;
if ($password == $passwordconfirm) {


//$username=htmlentities(trim(addslashes($usernametemp)));
//$password=htmlentities(trim(addslashes($passwordtemp)));
$duplicate = 0;
$usercheck = "SELECT username FROM `users`";
$userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {

  if ($row['username'] == $username) {
    $duplicate = 1;
  }

}

if ($duplicate != 1) {
  $hash = password_hash($password, PASSWORD_DEFAULT);
  //Execute the query
  $sql = "INSERT INTO users(username,password,friend)
          VALUES('$username','$hash','$friend')";

          if ($dbcon->query($sql) === TRUE) {
            include('success.php');
          }
          else {
              echo "Error: " . $sql . "<br>" . $dbcon->error;
          }
}
else {
  echo ('Username Already Exists');
}
}
else {
  echo ('Passwords Do Not Match');
}
//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

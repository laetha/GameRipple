<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$guid = $_REQUEST['guid'];
$status = $_REQUEST['status'];

if ($status == 'Finished'){
  $findate = time();
}
else {
  $findate = 0;
}
//$findate = 1;

$sql = "UPDATE games SET status='$status', fin_date='$findate' WHERE guid LIKE '$guid'";

        if ($dbcon->query($sql) === TRUE) {
					
        }
				else {

        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>
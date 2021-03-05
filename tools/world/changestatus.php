<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$guid = $_REQUEST['guid'];
$status = $_REQUEST['status'];


$sql = "UPDATE games SET status='$status' WHERE guid LIKE '$guid'";

        if ($dbcon->query($sql) === TRUE) {
					
        }
				else {

        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>
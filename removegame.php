<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$guid = $_REQUEST['guid'];


$sql = "UPDATE games SET active=0 WHERE guid LIKE '$guid'";

        if ($dbcon->query($sql) === TRUE) {
					
        }
				else {

        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>
<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$title =$_REQUEST['title'];
$delid =$_REQUEST['id'];


$sql = "DELETE FROM favourites WHERE id = $delid";

        if ($dbcon->query($sql) === TRUE) {

        }
				else {

        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

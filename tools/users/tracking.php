<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$charID = $_REQUEST['id'];
$currenthp = $_REQUEST['currenthp'];
$currentlp = $_REQUEST['currentlp'];
$temphp = $_REQUEST['temphp'];
$slots = $_REQUEST['slots'];


$sql = "UPDATE characters
SET currenthp = '$currenthp', currentlp = '$currentlp', temphp = '$temphp', slots = '$slots'
WHERE id = $charID;";

        if ($dbcon->query($sql) === TRUE) {

        }
				else {
        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

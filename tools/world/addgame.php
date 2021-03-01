<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$title =$_REQUEST['title'];
$guid = $_REQUEST['guid'];

$sqlcompendium = "SELECT * FROM games WHERE guid LIKE '$guid'";
            $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
            if (mysqli_num_rows($compendiumdata)==0) { 
$sql = "INSERT INTO games(title,guid,active)
				VALUES('$title','$guid',1)";

        if ($dbcon->query($sql) === TRUE) {
					
        }
				else {

        }
      }
      else {
        $sql = "UPDATE games SET active=1 WHERE guid LIKE '$guid'";

        if ($dbcon->query($sql) === TRUE) {
					
        }
				else {

        }
      }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>
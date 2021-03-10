<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$titletemp =$_REQUEST['title'];
$title=htmlentities(trim(addslashes($titletemp)));
$guid = $_REQUEST['guid'];
$imgurl = $_REQUEST['gameImage'];
$gallery = $_REQUEST['gallery'];


$sqlcompendium = "SELECT * FROM games WHERE guid LIKE '$guid'";
            $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
            if (mysqli_num_rows($compendiumdata)==0) {
$sql = "INSERT INTO games(title,guid,status,rating,active,gallery,playlist,review,imgurl)
				VALUES('$title','$guid','Unplayed',0,1,'$gallery','','','$imgurl')";

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
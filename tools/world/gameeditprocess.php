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
$id=$_POST['id'];
$guid=$_POST['guid'];
$gallerytemp=$_POST['gallery'];
$playlisttemp=$_POST['playlist'];
$reviewtemp=$_POST['review'];
$gallery=htmlentities(trim(addslashes($gallerytemp)));
$playlist=htmlentities(trim(addslashes($playlisttemp)));
$review=htmlentities(trim(addslashes($reviewtemp)));

$sql = "UPDATE games
SET gallery = '$gallery', playlist = '$playlist', review = '$review'
WHERE guid LIKE '$guid';";

        if ($dbcon->query($sql) === TRUE) {

            echo ('<script type="text/javascript">location.href = "game.php?id='.$guid.'";</script>');
                //header('game.php?id='.$guid);
					//include('game.php?id='.$guid);
        }
				else {
            echo "Error: " . $sql . "<br>" . $dbcon->error;
        }

//Footer
 ?>

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
$reviewbox=$_POST['reviewBox'];
$gallery=htmlentities(trim(addslashes($gallerytemp)));
$playlist=htmlentities(trim(addslashes($playlisttemp)));
if ($reviewbox === 'yes'){
    $reviewtemp=$_POST['review'];
    $review=htmlentities(trim(addslashes($reviewtemp)));
}
else {
    $review = '';
}
$sql = "UPDATE games
SET gallery = '$gallery', playlist = '$playlist', review = '$review'
WHERE guid LIKE '$guid';";

        if ($dbcon->query($sql) === TRUE) {

            echo ('<script type="text/javascript">location.href = "apitest.php?id='.$guid.'";</script>');
                //header('apitest.php?id='.$guid);
					//include('apitest.php?id='.$guid);
        }
				else {
            echo "Error: " . $sql . "<br>" . $dbcon->error;
        }

//Footer
 ?>

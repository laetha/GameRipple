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
$nametemp=$_POST['name'];
$texttemp=$_POST['notetext'];
$user = $_REQUEST['noteuser'];
$name=htmlentities(trim(addslashes($nametemp)));
$text=htmlentities(trim(addslashes($texttemp)));

//Execute the query
$sql = "INSERT INTO notes(title,text,user)
				VALUES('$name','$text','$user')";

        if ($dbcon->query($sql) === TRUE) {
					?>
					<script>
            $(document).ready(function (){
              window.location.href = "notes.php";
            });
          </script>
					<?php
        }
				else {
            echo "Error: " . $sql . "<br>" . $dbcon->error;
        }
//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

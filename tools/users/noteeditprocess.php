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
$id=$_POST['editid'];
$nametemp=$_POST['name'];
$texttemp=$_POST['notetext'];
$name=htmlentities(trim(addslashes($nametemp)));
$text=htmlentities(trim(addslashes($texttemp)));

//Execute the query
$sql = "UPDATE notes
SET title = '$name', text = '$text'
WHERE id = $id;";

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
 ?>

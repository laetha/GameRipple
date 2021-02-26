<?php
include('header.php');

//SQL Connect
 $sqlpath = $_SERVER['DOCUMENT_ROOT'];
 $sqlpath .= "/sql-connect.php";
 include_once($sqlpath);

 ?>

<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
				<h1 class="pagetitle">DnD Tools</h1>
			  <div class="quote">
          <?php
          $sqlworld = "SELECT * FROM quotes ORDER BY RAND() LIMIT 1";
          $worlddata = mysqli_query($dbcon, $sqlworld) or die('error getting data');
          while($linkrow = mysqli_fetch_array($worlddata, MYSQLI_ASSOC)) {
            echo ('<em>"'.utf8_encode($linkrow['quote']).'"</em>');
            echo ('<br>');
            echo ('<div style="text-align: right;">- '.$linkrow['source'].'</div>');
          }
           ?>
        </div>
        <div class="fp-img">
          <?php
      		$handle1 = opendir(dirname(realpath(__FILE__)).'/assets/images/hp/');
      		while( $entry1 = readdir($handle1) )
      		{
      		    if( $entry1 != '.' && $entry1 != '..' )
      		    {
      		        $files1[] = $entry1;
      		    }
      		}

      		closedir($handle1);

      		sort($files1);

      		  $i1 = rand(0, count($files1)-1); // generate random number size of the array
      		  $selectedBg1 = "$files1[$i1]"; // set variable equal to which random filename was chosen
      		?>
          <img style="max-width: 90%; height: auto; max-width: 600px;" src="/assets/images/hp/<?php echo $selectedBg1; ?>" />
        </div>
			</div>
<?php include('footer.php'); ?>

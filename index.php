<?php
  //SQL Connect
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $pgtitle = '';
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);
   /*if ($loguser !== 'tarfuin') {
   echo ('<script>window.location.replace("/oops.php"); </script>');
 }*/
   ?>
   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js" type="text/javascript"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
   <div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">

     <!-- Page Header -->
     <div class="col-md-12">
     <div class="pagetitle" id="pgtitle">Gameripple</div>
   </div>
     <div class="body sidebartext col-xs-12" id="body">
     <div class="col-md-4">Currently Playing<p>
     <?php
     $usercheck = "SELECT * FROM games WHERE status LIKE 'Playing'";
		 $userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
		 while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {
      echo ('<a href="game.php?id='.$row['guid'].'"><img src="'.$row['imgurl'].'" height="300px" />');
      echo ('<p>'.$row['title'].'</a>');
     }
     ?>
     </div>
     
     <div class="col-md-4">Last Finished<p>
     <?php
     $usercheck = "SELECT * FROM games ORDER BY fin_date DESC LIMIT 1";
		 $userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
		 while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {
      echo ('<a href="game.php?id='.$row['guid'].'"><img src="'.$row['imgurl'].'" height="300px" />');
      echo ('<p>'.$row['title'].'</a>');
     }
     ?>
     </div>
     <div class="col-md-4">Random Game<p>
     <?php
     $usercheck = "SELECT * FROM games ORDER BY RAND() LIMIT 1";
		 $userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
		 while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {
      echo ('<a href="game.php?id='.$row['guid'].'"><img src="'.$row['imgurl'].'" height="300px" />');
      echo ('<p>'.$row['title'].'</a>');

     }
     ?>
     </div>


</div>
</div>
</div>
   <?php
   //Footer
   $footpath = $_SERVER['DOCUMENT_ROOT'];
   $footpath .= "/footer.php";
   include_once($footpath);
    ?>

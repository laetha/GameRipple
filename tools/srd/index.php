<?php
$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/plugins/Parsedown.php";
include_once($sqlpath);
 ?>
 <?php  $Parsedown = new Parsedown(); ?>
<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="/tools/compendium/statblock.css" rel="stylesheet" type="text/css">
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">

  <!-- Page Header -->
  <div class="col-md-12">
  <div class="pagetitle" id="pgtitle"><?php
  $id = addslashes($id);
  $stripid = str_replace("'", "", $id);
  $stripid = stripslashes($stripid);
  $worldtitle = "SELECT * FROM `srd` WHERE `title` LIKE '$id'";
  $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
  while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
   echo htmlspecialchars($row['title']);
   $title = $row['title'];

  ?>
</div>
</div>
<div class="nav sidebartext col-md-12" style="margin-bottom:30px;">
<a href="/index.php">Home</a>  <?php echo ('&rarr;'); ?> <a href="/tools/srd/srd.php">SRD</a> <?php echo ('&rarr; '.ucwords($row['title'])); ?>
</div>
<?php
}
?>
  <div class="body sidebartext col-xs-12 srd" id="body">
    <!-- Body Text -->
      <?php
        $worldtitle = "SELECT * FROM `srd` WHERE `title` LIKE '$id'";
        $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
        while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
          echo $Parsedown->text($row['text']);
}
?>
</div>
</div>

<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>

<div class="mainbox col-sm-10 col-xs-12 col-sm-offset-1">
  <h1 class="pagetitle">World Building</h1>
<div class ="body bodytext">
  <div class="col-md-12 col-centered"><a href="/tools/world/import.php">Import</a></div>
      <div class="toc bodytext">

      <!-- Settlements -->
      <div class="tocitem col-md-3">
        <h2>Resources</h2>
        <a href="monsterharvest.php"><p>Monster Harvester's Handbook</p></a>

      </div>
  </div>
</div>

   <?php
   //Footer
   $footpath = $_SERVER['DOCUMENT_ROOT'];
   $footpath .= "/footer.php";
   include_once($footpath);
    ?>

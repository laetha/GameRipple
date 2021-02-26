<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>

<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <h1 class="pagetitle">DM Resources</h1>
<div class ="body bodytext">
      <div class="toc bodytext">

      <!-- Settlements -->
      <div class="tocitem col-md-3 col-centered" style="margin-top: 50px;">
        <a href="monsterharvest.php"><p>Monster Harvester's Handbook</p></a>

      </div>
      <div class="tocitem col-md-3 col-centered" style="margin-top: 50px;">
        <a href="http://homebrewery.naturalcrit.com/share/HkMxFdZY" target="_blank"><p>A Guide to Magical Tattoos</p></a>

      </div>

    <!--  <div class="tocitem col-md-3 col-centered" style="margin-top: 50px;">
        <a href="/tools/world/map.php" target="_blank"><p>World Map</p></a>

      </div> -->

      <div class="tocitem col-md-3 col-centered" style="margin-top: 50px;">
        <a href="https://noblecrumpet-dorkvision.tumblr.com/post/171143898431/random-jewelry-generator" target="_blank"><p>Jewelry Generator</p></a>

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

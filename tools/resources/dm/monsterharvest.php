<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
<!-- Page Header -->
<div class="col-md-12">
<div class="pagetitle" id="pgtitle">Monster Harvester Handbook</div>
</div>
<div class="body sidebartext col-xs-12" id="body">

<embed class="col-centered" src="/assets/resources/The-Monster-Harvester-Handbook.pdf" width="800" height="500" alt="pdf" pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
</div>

     <?php
     //Footer
     $footpath = $_SERVER['DOCUMENT_ROOT'];
     $footpath .= "/footer.php";
     include_once($footpath);
      ?>

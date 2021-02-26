<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
<!-- Page Header -->
<div class="col-md-12">
<div class="pagetitle" id="pgtitle">Campaign Calendar</div>
</div>
<div class="body sidebartext col-xs-12" id="body">

<iframe src="http://app.fantasy-calendar.com/calendars/5752f966e0418bff07ba310d8817dd86" style="width:100%; height:800px;"/>
</div>

     <?php
     //Footer
     $footpath = $_SERVER['DOCUMENT_ROOT'];
     $footpath .= "/footer.php";
     include_once($footpath);
      ?>

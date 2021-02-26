<?php
//SQL Connect
$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

//Header
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);

$id = "index";

         ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
crossorigin=""/>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
crossorigin=""></script>

         <div class="tocbox col-md-12">
           <div class ="body bodytext">
         <h1 class="pagetitle">Add Note</h1>
       <div class="col-md-10 col-centered">
         <div class="col-sm-6 typebox col-centered" id="name">
             <form method="post" action="noteprocess.php" id="noteimport" enctype="multipart/form-data">
               <select form="noteimport" name="noteuser" id="noteuser" style="display:none;" required="yes">
                 <option id="noteUser" value="<?php echo $loguser; ?>" selected></option>
                 </select>
             <div class="text">Title</div><input class="textbox" style="text-align:center;" type="text" name="name" id="name" placeholder="Title...">
       </div>
       <div class="text col-centered col-md-12"><textarea style="width:100%;" type="text" name="notetext" id="notetext" placeholder="Note...." style="height:100px;"></textarea></div>

       <!-- 'Type' Dropbox -->

       <div class="col-centered">
       <input class="btn btn-primary col-centered inline" type="submit" value="Save">
       <a class="clean" href="note.php?id=<?php echo $id; ?>"><button class="btn btn-danger col-centered inline" type="button">Cancel</button></a>
       </div>
      </form>

     </div>
   </div>
  </div>
         <?php

  ?>
  <!-- Import Form -->

<?php

  ?>

<!-- Footer -->
<?php
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath);
 ?>

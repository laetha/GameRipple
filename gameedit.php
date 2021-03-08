<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
crossorigin=""/>
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
crossorigin="">
</script>

<?php
//SQL Connect
$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

//Header
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);

$sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/plugins/Parsedown.php";
include_once($sqlpath);
/*if ($loguser !== 'tarfuin') {
echo ('<script>window.location.replace("/oops.php"); </script>');
}*/
  $Parsedown = new Parsedown();

$id = "index";
$disallowed_paths = array('header', 'footer');
if (!empty($_GET['id'])) {
  $tmp_action = basename($_GET['id']);
  if (!in_array($tmp_action, $disallowed_paths) /*&& file_exists("world/{$tmp_action}.php")*/)
        $id = $tmp_action;
        $id = addslashes($id);
        $worldedit = "SELECT * FROM games WHERE guid LIKE '$id'";
        $editdata = mysqli_query($dbcon, $worldedit) or die('error getting data');
        while($editrow =  mysqli_fetch_array($editdata, MYSQLI_ASSOC)) {
         echo '<div class="pagetitle" id="pgtitle"> Edit - '.$editrow['title'].'</div><p>';
         $editid = $editrow['id'];
         $guid = $editrow['guid'];
         $gallery = $editrow['gallery'];
         $playlist = $editrow['playlist'];
         $review = $editrow['review'];

          
        $path = $_SERVER['DOCUMENT_ROOT'].'/gallery/'.$gallery.'/';
        $files = scandir($path);
?>

        <div class="col-md-10 col-centered">
         <div class="col-sm-6 typebox col-centered" id="name">
             <form method="post" action="gameeditprocess.php" id="import" enctype="multipart/form-data">
             <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
             <input type="hidden" name="guid" id="guid" value="<?php echo $guid; ?>">
             <div class="text">Gallery Folder</div><input class="textbox" style="text-align:center;" type="text" name="gallery" id="gallery" value="<?php echo $gallery; ?>"><p>
             <div class="text">Playlist URL</div><input class="textbox" style="text-align:center;" type="text" name="playlist" id="playlist" value="<?php echo $playlist; ?>">
             </div>
             <dic class="col-sm-10 col-centered typebox">
             <div class="nonav" id="nanogallery2"></div>
             <script>
   jQuery(document).ready(function () {
        jQuery("#nanogallery2").nanogallery2( {
          // ### gallery settings ### 
          thumbnailHeight:  180,
          thumbnailWidth:   320,
          itemsBaseURL:     '/gallery/' + '<?php echo $gallery; ?>/',
          galleryDisplayMode: 'pagination',
          galleryMaxRows: 5,
          viewerTools:    {
        topLeft:    'pageCounter',
        topRight:   'linkOriginalButton, zoomButton, fullscreenButton, closeButton'
      },
          // ### gallery content ### 
          items: [
            <?php
              foreach ($files as $img){
                if (strpos($img,'.png') !== false || strpos($img,'.jpg') !== false || strpos($img,'.jpeg') !== false){
                echo ("{ src: '".$img."' },");
                }
              }

            ?>
            ]
        });
    });

    function addimg(){
   
   $('#nanogallery2').removeClass('nonav');
   $('#nanogallery2').nanogallery2('refresh');
 
 }
</script>
             <div class="text col-centered col-md-12">Review<textarea type="text" name="review" id="review"><?php 
             if ($review == ''){
               
             }
             else {
              echo $review;
             }
             ?>
             </textarea></div></div>
        
             <!-- <div class="sidebartext col-centered"><input type="checkbox" name="reviewBox" id="reviewBox" value="yes" onclick="showReview()">Review?</div> -->
       </div>
        </div>

<?php
}
       ?>
       <div class="col-centered">
       <input class="btn btn-primary col-centered inline" type="submit" value="Save">
       <a class="clean" href="/game.php?id=<?php echo $id; ?>"><button class="btn btn-danger col-centered inline" type="button">Cancel</button></a>
       </div>
      </form>

     </div>
   </div>
  </div>

<style>
.editor-toolbar{
  background-color: white;
}
</style>

<script>
var simplemde = new SimpleMDE({ element: document.getElementById("review") });

$(document).ready(function(){

  $(".fa-question-circle").after('<i class="separator">|</i><a title="Image from Gallery" tabindex="-1" class="fa fa-picture-o" onclick="addimg()"></a>');
  
});

</script>

         <?php
       }
  ?>
  <!-- Import Form -->


<!-- Footer -->
<?php
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath);
 ?>

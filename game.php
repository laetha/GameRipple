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
   /* if ($loguser !== 'tarfuin') {
   echo ('<script>window.location.replace("/oops.php"); </script>');
 }*/
   ?>
   <?php
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/plugins/Parsedown.php";
   include_once($sqlpath);
    ?>
    <?php  $Parsedown = new Parsedown();
    ?>
   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js" type="text/javascript"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
   <script type="text/javascript" src="/apikey.js"></script> 
    <!-- nanogallery2 -->


   <div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">

     <div class="col-md-12">
  <?php
  $id = $_GET['id'];
  $stripid = str_replace("'", "", $id);
  $stripid = stripslashes($stripid);
  $id = addslashes($id);
 
  $sqlcompendium = "SELECT * FROM games WHERE guid LIKE '$id'";
  $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
  if (mysqli_num_rows($compendiumdata)==0) { ?>
    <div class="pagetitle" id="pgtitle"></div>
    <div class="nonav" id="gameImage"></div>
    <div class="sidebartext col-md-8">
      <span id="gamedeck"></span>
      <p>
  <?php }
  else {
  while($row = mysqli_fetch_array($compendiumdata, MYSQLI_ASSOC)) {
    $title = $row['title'];
    $rating = $row['rating'];
    $gallery = $row['gallery'];
    $galleryclean = addslashes($gallery);
    $playlist = $row['playlist'];
    $review = $row['review'];


  }
  if (isset($gallery) && $gallery !== ''){

        $path = $_SERVER['DOCUMENT_ROOT'].'/gallery/'.$gallery.'/';
        $files = scandir($path);
  }
  else {
    if (is_dir($_SERVER['DOCUMENT_ROOT'].'/gallery/'.$title) == true){
      $path = $_SERVER['DOCUMENT_ROOT'].'/gallery/'.$title.'/';
        $files = scandir($path);
        $gallery = $title;
    }
    
  }        

  ?>
     <div class="pagetitle" id="pgtitle"></div>
     <div class="sidebartext col-md-8">
       <span id="gamedeck"></span>
       <p>
       <?php if ($gallery == '' && isset($files) == false && $review == '' && $playlist == ''){

       }
       else {
       echo ('<ul class="nav nav-tabs">');
       if (isset($review) && $review !== ''){
        echo ('<li><a data-toggle="tab" href="#reviewtab" onclick="showReview()">Review</a></li>');
        }
       if (isset($playlist) && $playlist !== ''){
       echo ('<li><a data-toggle="tab" href="#videotab">Video</a></li>');
       }
       if (isset($files)){
        echo ('<li><a data-toggle="tab" href="#gallerytab" onclick="showGallery()">Gallery</a></li>');
        }
        
       echo ('</ul>');
       }
       ?>
       <div class="tab-content">
       <div class="tab-pane fade" id="videotab">
         <?php
          if (isset($playlist) && $playlist !== ''){
            $PL1 = 'https://www.youtube.com/embed/videoseries?list=';
            $PL2 = $playlist;
            echo ('<div class="col-centered"><iframe width="560" height="315" src="'.$PL1.$PL2.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe></div>'); 
          }

          
         ?>
       </div>
       <?php
       if (isset($gallery) && $gallery !== ''){
       
            echo ('<div class="tab-pane fade" id="gallerytab">');
          }
          else {
            echo ('<div class="tab-pane fade" id="gallerytab">');
          }
          ?>
       
<!-- ### position of the gallery ### -->
<div id="nanogallery2"></div>

<script>
   jQuery(document).ready(function () {
        jQuery("#nanogallery2").nanogallery2( {
          // ### gallery settings ### 
          thumbnailHeight:  180,
          thumbnailWidth:   320,
          itemsBaseURL:     '/gallery/' + '<?php echo $galleryclean; ?>/',
          galleryDisplayMode: 'pagination',
          galleryMaxRows: 6,
          
          // ### gallery content ### 
          items: [
            <?php
              foreach ($files as $img){
                $img = addslashes($img);
                if (strpos($img,'.png') !== false || strpos($img,'.jpg') !== false || strpos($img,'.jpeg') !== false){
                echo ("{ src: '".$img."' },");
                }
              }

            ?>
            ]
        });
        updateGallery();
    });
</script>
       </div>
       <?php
       if (isset($review) && $review !== ''){

            echo ('<p><div class="tab-pane fade" style="text-align:left;" id="reviewtab">'.$Parsedown->text($review));
          }
          else {
            echo ('<div class="tab-pane fade" id="reviewtab">');
          }
          ?>
       </div>
       </div>
       <?php } ?>
     </div>

     <div class="sidebartext col-md-4" style="text-align:right;">
     <span style="width:100%;" id="gameposter"></span>
     <table align="right">
       <tr>
         <td class="buttoncell">
         <?php
            $sqlcompendium = "SELECT * FROM games WHERE guid LIKE '$id' AND active=1";
            $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
            if (mysqli_num_rows($compendiumdata)==0) { 
              $gallery = '';
              echo '<button class="btn btn-success" id="addGame" onClick="addGame()">Add</button>';
              echo '<button class="btn btn-danger nonav" id="removeGame" onClick="removeGame()">Remove</button>';
            }
            else {
              echo '<button class="btn btn-success nonav" id="addGame" onClick="addGame()">Add</button>';
              echo '<button class="btn btn-danger" id="removeGame" onClick="removeGame()">Remove</button>';
            }
         ?>
     
</td>
<td class="buttoncell">
<div class="dropdown">
  <button class="btn btn-primary dropdown-toggle" type="button" id="gameStatus" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php
  $sqlcompendium = "SELECT status FROM games WHERE guid LIKE '$id'";
               $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
               if (mysqli_num_rows($compendiumdata)==0) {
                echo 'Status';
               }
               else {
                while($row = mysqli_fetch_array($compendiumdata, MYSQLI_ASSOC)) {
                  if ($row['status'] == ''){
                    echo 'Status';
                  }
                  else {
                    echo $row['status'];
                  }
                }  
               }
    ?>
  </button>
  <ul class="dropdown-menu">
    <li class="dropbutton" id="Unplayed" onClick="statusChange('Unplayed')">Unplayed</li>
    <li class="dropbutton" id="Playing" onClick="statusChange('Playing')">Playing</li>
    <li class="dropbutton" id="Played" onClick="statusChange('Played')">Played</li>
    <li class="dropbutton" id="Finished" onClick="statusChange('Finished')">Finished</li>
  </div>
</div>
<!--     <button class="btn btn-primary">Status</button> -->
</td>
<td class="buttoncell">
     <a href="gameedit.php?id=<?php echo $id; ?>"><button class="btn btn-info">Edit</button></a><br>
</td>
</tr>
</table>
     <div class="col-md-12 disabled" id="starRatings"><div class="rating"><input type="radio" name="rating" value="5" id="5" onClick="rateGame('5')"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4" onClick="rateGame('4')"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3" onClick="rateGame('3')"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2" onClick="rateGame('2')"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1" onClick="rateGame('1')">☆</label>
</div></div>
    </div>
     

     
<script>
function showGallery(){
  $('#nanogallery2').nanogallery2('refresh');
}

var gameInfo;
var gamePoster;
    /* aaaaa
 *  Send a get request to the Giant bomb api.
 *  @param string resource set the RESOURCE.
 *  @param object data specifiy any filters or fields.
 *  @param object callbacks specify any custom callbacks.
 */
function sendRequest(resource, data, callbacks) {
    var baseURL = 'http://giantbomb.com/api';
    var apiKey = GBKey;
    var format = 'jsonp';

    // make sure data is an empty object if its not defined.
    data = data || {};

    // Proccess the data, the ajax function escapes any characters like ,
    // So we need to send the data with the "url:"
    var str, tmpArray = [], filters;
    $.each(data, function(key, value) {
        str = key + '=' + value;
        tmpArray.push(str);
    });

    // Create the filters if there were any, else it's an empty string.
    filters =  (tmpArray.length > 0) ? '&' + tmpArray.join('&') : '';

    // Create the request url.
    var requestURL = baseURL + resource + "?api_key=" + apiKey + "&format=" + format + filters;

    // Set custom callbacks if there are any, otherwise use the default onces.
    // Explanation: if callbacks.beforesend is passend in the argument callbacks, then use it. 
    // If not "||"" set an default function.
    var callbacks = callbacks || {};
    callbacks.beforeSend = callbacks.beforeSend || function(response) {};
    callbacks.success = callbacks.success || function(response) {};
    callbacks.error = callbacks.error || function(response) {};
    callbacks.complete = callbacks.complete || function(response) {};

    // the actual ajax request
    $.ajax({
                    url: requestURL,
                    dataType: "jsonp",
                    jsonp: 'json_callback',
                    format: 'jsonp',
                    success: function(res) {
                      gameTitle = res.results.name;
                      gameAlias = res.results.aliases;
                      gameDeck = res.results.deck;
                      gameImage = res.results.image.medium_url;
                        $('#pgtitle').html(gameTitle);
                        $('#gamedeck').html(gameDeck);
                        $('#gameposter').html('<img src=' + gameImage + ' height="300px" />');
                        $('#gameImage').html(gameImage);

                    }
                });
}
$(document).ready(function(){

 // get game id from somewhere like a link.
 var gameID = '<?php echo $id; ?>';
    var resource = '/game/' + gameID;

    // Set the fields or filters 
    var data = {
        field_list: 'name,deck,image,aliases'
    };

    // No custom callbacks defined here, just use the default onces.
    sendRequest(resource, data);
    <?php
    if (isset($rating)){
      ?>
      var currentRating = '#<?php echo $rating; ?>';
    $(currentRating).prop("checked", true);
    <?php
    }
    ?>
    
    //$("em").css("text-align","center");
    //$("em").addClass("caption");

});

function showReview(){
  var currentReview = $('#reviewtab').html();

var newReview  = currentReview.replace(/<em>/g, '<div class="caption"><em>');
newReview  = newReview.replace(/<\/em>/g, '<\/div><\/em>');
$('#reviewtab').html(newReview);
}

function addGame(){

  var gameID = '<?php echo $id; ?>';
  var gameTitle = $('#pgtitle').html();
  var gameImage = $('#gameImage').html(); 
  var gameGallery = "<?php echo $gallery; ?>";

  $.ajax({
    url : 'addgame.php',
    type: 'GET',
    data : { "title" : gameTitle, "guid" : gameID, "gameImage" : gameImage, "gallery" : gameGallery },
    success: function()
    {
        //if success then just output the text to the status div then clear the form inputs to prepare for new data
        $("#addGame").addClass('nonav');
        $("#removeGame").removeClass('nonav');
        $('#starRatings').removeClass('nonav');
    },
    error: function (jqXHR, status, errorThrown)
    {
        //if fail show error and server status
        $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
    }
});
}

function removeGame(){

var gameID = '<?php echo $id; ?>';

$.ajax({
  url : 'removegame.php',
  type: 'GET',
  data : { "guid" : gameID },
  success: function()
  {
      //if success then just output the text to the status div then clear the form inputs to prepare for new data
      $("#addGame").removeClass('nonav');
      $("#removeGame").addClass('nonav');
      $('#starRatings').addClass('nonav');
  },
  error: function (jqXHR, status, errorThrown)
  {
      //if fail show error and server status
      $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
  }
});
}

function updateGallery(){
  var gameID = '<?php echo $id; ?>';
  var gameGallery = "<?php echo $gallery; ?>";

  $.ajax({
  url : 'updateGallery.php',
  type: 'GET',
  data : { "guid" : gameID, "gallery" : gameGallery },
  success: function()
  {
      //if success then just output the text to the status div then clear the form inputs to prepare for new data
  },
  error: function (jqXHR, status, errorThrown)
  {
      //if fail show error and server status
      $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
  }
});
}

function statusChange(value){
  var gameID = '<?php echo $id; ?>';
  var gameStatus = value;
  //var currentDate = new Date();
  //var findate = currentDate.getTime();
           /* var date = ("0" + currentDate.getDate()).slice(-2);
            var month = ("0" + currentDate.getMonth()).slice(-2);
            month = parseInt(month) + 1;
            var year = currentDate.getFullYear();
            var dateString = year + '' + (month) + '' + date;*/

  $.ajax({
  url : 'changestatus.php',
  type: 'GET',
  data : { "guid" : gameID, "status" : gameStatus },
  success: function()
  {
      //if success then just output the text to the status div then clear the form inputs to prepare for new data
      $('#gameStatus').html(value);
  },
  error: function (jqXHR, status, errorThrown)
  {
      //if fail show error and server status
      $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
  }
});
}

function rateGame(value){
  var gameRating = value;
  var gameID = '<?php echo $id; ?>';
  $.ajax({
  url : 'rategame.php',
  type: 'GET',
  data : { "guid" : gameID, "rating" : gameRating },
  success: function()
  {
      //if success then just output the text to the status div then clear the form inputs to prepare for new data
      //$('#gameStatus').html(value);
  },
  error: function (jqXHR, status, errorThrown)
  {
      //if fail show error and server status
      $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
  }

});
}

</script>
</div>
<style>
  p img {
    max-width:100%;
    border-bottom: 22px solid black;
  }

</style>
   <?php
   //Footer
   $footpath = $_SERVER['DOCUMENT_ROOT'];
   $footpath .= "/footer.php";
   include_once($footpath);
    ?>

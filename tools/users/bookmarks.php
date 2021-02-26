<?php
  //SQL Connect
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $pgtitle = 'Bookmarks - ';
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);
?>


<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <div class ="body bodytext">

    <h1 class="pagetitle"><?php echo ucwords($loguser); ?>'s Bookmarks</h1>

			</div>
      <div class="body sidebartext col-xs-12" id="body">
        <div class="col-md-12">
        <ul>
      <?php
      $favtitle = "SELECT * FROM `favourites` WHERE `user` LIKE '$loguser'";
      $favdata = mysqli_query($dbcon, $favtitle) or die('error getting data');
      while($favrow =  mysqli_fetch_array($favdata, MYSQLI_ASSOC)) {
          $favmodal = addslashes($favrow['title']);
          $favid = addslashes($favrow['id']);
          echo ('<li id="'.$favid.'-id">');
          ?>
          <form onSubmit="return false" id='favRemForm<?php echo $favid; ?>' style="display:inline-block; margin-left: 20px;">
          <button type="submit" id="favButton<?php echo $favid; ?>" name="favButton<?php echo $favid; ?>" class="logbtn btn btn-danger btn-sq-xs" style="margin-right:15px;"><span class="glyphicon glyphicon-remove"></span></button>
        </form>
          <a onclick="favModalChange('<?php echo $favmodal; ?>')"><?php echo $favrow['title']; ?> (<?php echo $favrow['type']; ?>)</a></li>

          <script>
          $("#favButton<?php echo $favid; ?>").click(function(){
           //get the form values
           var ftitle = '<?php echo $favrow['title']; ?>';
           var fid = '<?php echo $favid; ?>';

           //make the postdata
           //call your input.php script in the background, when it returns it will call the success function if the request was successful or the error one if there was an issue (like a 404, 500 or any other error status)

           $.ajax({
              url : 'favdelete.php',
              type: 'POST',
              data : { "title" : ftitle, "id" : fid },
              success: function()
              {
                  //if success then just output the text to the status div then clear the form inputs to prepare for new data
                  $("#<?php echo $favid; ?>-id").addClass('nonav');
              },
              error: function (jqXHR, status, errorThrown)
              {
                  //if fail show error and server status
                  $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
              }
          });
          });
          </script>

          <?php
      }

    ?>
    </ul>
  </div>
  <script>
  function favModalChange(value) {
    document.getElementById("favModalBody").innerHTML = '<div class="iframe-container"><iframe id="favFrame" frameBorder="0" src="/tools/compendium/compendium.php?id=' + value + '#body" seamless /></div>';
    function showFavModal() {
      //$("#favFrame").contents().find(".nonav").css('display', 'none');

      $("#favModal").modal();
    }
    showFavModal();
    function hideNav() {

      var iFrameDOM = $("iframe#frameID").contents();

	     iFrameDOM.find("#nonav").css("background-color", "#fff");
    }
    hideNav();
  }

  </script>
  <!-- Item Modal -->
  <div class="modal fade bd-example-modal-lg" id="favModal" role="dialog">
    <div class="modal-dialog" style="width: 80%; max-width:1200px;">

      <!-- Modal content-->
      <div class="modal-content modalstyle bodytext" style="height:100%;">
        <div class="modal-header" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        <div class="modal-body" id="favModalBody" style="height:100%; padding-top: 0px;">
          <iframe frameBorder="0" src="" />
        </div>

      </div>

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

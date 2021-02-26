<?php
  //SQL Connect
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $pgtitle = 'Characters - ';
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);



$id = "index";
$disallowed_paths = array('header', 'footer');
if (!empty($_GET['id'])) {
  $tmp_action = basename($_GET['id']);
  if (!in_array($tmp_action, $disallowed_paths) /*&& file_exists("world/{$tmp_action}.php")*/)
        $id = $tmp_action;
  include("charindex.php");
  }
if (empty($_GET['id'])) {
?>


<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <div class ="body bodytext">

    <h1 class="pagetitle"><?php echo ucwords($loguser); ?>'s Characters</h1>
    <button class="btn btn-info" onclick="window.location.href='createcharacter.php'">Create New Character</button>

			</div>
      <div class="body sidebartext col-xs-12" id="body">
        <div class="col-md-12">
        <ul>
      <?php
      if ($loguser !== 'tarfuin'){
      $chartitle = "SELECT * FROM `characters` WHERE `user` LIKE '$loguser'";
      $chardata = mysqli_query($dbcon, $chartitle) or die('error getting data');
    }
    else {
      $chartitle = "SELECT * FROM `characters`";
      $chardata = mysqli_query($dbcon, $chartitle) or die('error getting data');
    }
      while($charrow =  mysqli_fetch_array($chardata, MYSQLI_ASSOC)) {
          $charmodal = addslashes($charrow['title']);
          $charid = addslashes($charrow['id']);
          echo ('<li id="'.$charid.'-id">');
          ?>
          <form onSubmit="return false" id='charRemForm<?php echo $charid; ?>' style="display:inline-block; margin-left: 20px;">
          <button type="submit" id="charButton<?php echo $charid; ?>" name="charButton<?php echo $charid; ?>" class="logbtn btn btn-danger btn-sq-xs" style="margin-right:15px;"><span class="glyphicon glyphicon-remove"></span></button>
        </form>

          <?php // echo('<a onclick="charModalChange(\''.$charmodal.'\')">'.$charrow['title'].' (Level '.$charrow['level'].' '.$charrow['class1']);
              echo('<a href="/tools/users/characters.php?id='.$charmodal.'">'.$charrow['title'].' (Level '.$charrow['level'].' '.$charrow['class1']);
              if ($loguser == 'tarfuin') {
                  echo (' :: '.$charrow['user']);
              }

            if ($charrow['class2lvl'] !== '0') {
              echo ('/'.$charrow['class2']);
            }

            echo (')</a></li>');
            ?>

          <script>
          $("#charButton<?php echo $charid; ?>").click(function(){
           var ftitle = '<?php echo $charrow['title']; ?>';
           var fid = '<?php echo $charid; ?>';

           //make the postdata
           //call your input.php script in the background, when it returns it will call the success function if the request was successful or the error one if there was an issue (like a 404, 500 or any other error status)

           $.ajax({
              url : 'chardelete.php',
              type: 'POST',
              data : { "title" : ftitle, "id" : fid },
              success: function()
              {
                  //if success then just output the text to the status div then clear the form inputs to prepare for new data
                  $("#<?php echo $charid; ?>-id").addClass('nonav');
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
  function charModalChange(value) {
    document.getElementById("charModalBody").innerHTML = '<div class="iframe-container"><iframe id="charFrame" frameBorder="0" src="/tools/users/characters.php?id=' + value + '#body" seamless /></div>';
    function showcharModal() {
      //$("#charFrame").contents().find(".nonav").css('display', 'none');

      $("#charModal").modal();
    }
    showcharModal();
    function hideNav() {

      var iFrameDOM = $("iframe#frameID").contents();

	     iFrameDOM.find("#nonav").css("background-color", "#fff");
    }
    hideNav();
  }

  </script>
  <!-- Item Modal -->
  <div class="modal fade bd-example-modal-lg" id="charModal" role="dialog">
    <div class="modal-dialog" style="width: 80%; max-width:1200px;">

      <!-- Modal content-->
      <div class="modal-content modalstyle bodytext" style="height:100%;">
        <div class="modal-header" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        <div class="modal-body" id="charModalBody" style="height:100%; padding-top: 0px;">
          <iframe frameBorder="0" src="" />
        </div>

      </div>

    </div>
  </div>

    </div>
  </div>


      <?php
    }
      //Footer
      $footpath = $_SERVER['DOCUMENT_ROOT'];
      $footpath .= "/footer.php";
      include_once($footpath);
      ?>

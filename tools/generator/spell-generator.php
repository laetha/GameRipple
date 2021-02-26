<?php
  //SQL Connect
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);
   ?>
   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" type="text/javascript"></script>
   <script src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap.min.js" type="text/javascript"></script>
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
   <div class="mainbox col-sm-10 col-xs-12 col-sm-offset-1">

     <!-- Page Header -->
     <div class="col-md-12">
     <div class="pagetitle" id="pgtitle">Spell Generator</div>
   </div>
     <div class="body sidebartext col-xs-12" id="body">

         <select form="import" required="yes" name="class" id="class">
           <option value="all">All Classes</option>
           <option value="bard">Bard</option>
           <option value="cleric">Cleric</option>
           <option value="druid">Druid</option>
           <option value="sorcerer">Sorcerer</option>
           <option value="wizard">Wizard</option>
         </select>

         <select form="import" required="yes" name="level" id="level">
           <option value="all">All Levels</option>
           <option value="0">Cantrip</option>
           <option value="1">1</option>
           <option value="2">2</option>
           <option value="3">3</option>
           <option value="4">4</option>
           <option value="5">5</option>
           <option value="6">6</option>
           <option value="7">7</option>
           <option value="8">8</option>
           <option value="9">9</option>
         </select>

         <button class="btn btn-primary col-centered" onclick="genSpell();">Submit</button>

       <div class="col-md-12">
         <div id="spell"></div>
       </div>

<script>
function genSpell() {
  var spellClass = $('#class').val();
  var spellLevel = $('#level').val();

  $.ajax({
     url : 'spellprocess.php',
     type: 'GET',
     data : { "spellClass" : spellClass, "spellLevel" : spellLevel },
     success: function(data)
     {
         document.getElementById('spell').innerHTML = data;
     },
     error: function (jqXHR, status, errorThrown)
     {
         //if fail show error and server status
         $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
     }
 });

};

</script>

</div>
</div>
   <?php
   //Footer
   $footpath = $_SERVER['DOCUMENT_ROOT'];
   $footpath .= "/footer.php";
   include_once($footpath);
    ?>

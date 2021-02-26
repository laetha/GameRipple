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
<script src="/plugins/rpg-dice-roller-master/dice-roller.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap.min.css">
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">

<script>


//DISABLE ALL INPUTS
$(document).ready(function lockSheet() {
var inputs = document.getElementsByTagName("input");
var textareas = document.getElementsByTagName("textarea");
textareas[0].disabled = true;
for (var i = 0; i < inputs.length; i++) {
    if(inputs[i].id.indexOf("search") > -1 == false){
      if(inputs[i].id.indexOf("itemSearch") > -1 == false){
    inputs[i].disabled = true;
  }
  }
  }
  var selects = document.querySelectorAll('.selector .subclassSelect, .charClassSelect');
  for (var i = 0; i < selects.length; i++) {
      selects[i].disabled = true;
    }
    var trackers = document.querySelectorAll('.vitals1');
    for (var i = 0; i < trackers.length; i++) {
        trackers[i].disabled = false;
      }
      var prepbox = document.querySelectorAll('.prepbox');
      for (var i = 0; i < prepbox.length; i++) {
          prepbox[i].disabled = false;
        }
  /*document.getElementById('currentlp').disabled = false;
  document.getElementById('currenthp').disabled = false;
  document.getElementById('temphp').disabled = false;*/
});

//EDIT SHEET, ENABLE ALL INPUTS
function editSheet() {
  classSelect();
  multiSelect();
  var dels = document.getElementsByName("delitem");
  var d = 0;

  for (d = 0; d < dels.length; d++) {
    dels[d].style = "display:inline-block"
  }

  document.getElementById('spellsShow').style = "display:block";
  document.getElementById('spellWarning').style = "display:none";
  var inputs = document.getElementsByTagName("input");
  var textareas = document.getElementsByTagName("textarea");
  textareas[0].style = "background-color: #717782; opacity: 0.6; color:white;";
  textareas[0].disabled = false;
  for (var i = 0; i < inputs.length; i++) {
      inputs[i].disabled = false;
      inputs[i].style = "background-color: #717782; opacity: 0.6;";

      var selects = document.querySelectorAll('.subclassSelect, .charClassSelect');
      for (var s = 0; s < selects.length; s++) {
          //selects[s].style = "background-color: #717782;";
          selects[s].disabled = false;
        //  selects[s].style = "background-color: #717782;";

        }

    }
    document.getElementById("editSheet").style = "display:none";
    document.getElementsByName("currentSubclass").style = "display:none";
    document.getElementById("saveSheet").style = "display:inline-block";
    document.getElementById("cancelSheet").style = "display:inline-block";
    document.getElementById("spellsButton").style = "display:block";
    document.getElementById("itemSearchBox").style = "display:block";
    document.getElementById("featButton").style = "display:block";
    document.getElementById("multiButton").style = "display:block";
    document.getElementById("charClasses").style = "display:none;";
    document.getElementById("charClass").style = "display:inline-block";
    document.getElementById("charSubclass").style = "display:inline-block";

};

</script>


  <!-- Page Header -->
  <div class="col-md-12">
  <!-- <div class="pagetitle" id="pgtitle" style="visibility: visible;"> -->
    <?php
  $stripid = str_replace("'", "", $id);
  $stripid = stripslashes($stripid);
  $id = addslashes($id);
  $worldtitle = "SELECT * FROM `characters` WHERE `title` LIKE '$id'";
  $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
  while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
    if ($row['user'] !== $loguser && $loguser !== 'tarfuin'){
      header("Location: /tools/users/login.php");
      die();
    }
   //echo $row['title'];
   $charuser = $row['user'];
   $title = $row['title'];
   $charID = $row['id'];
   $fullclass = $row['class1'];
   $fullmulticlass = $row['class2'];
   $dexmod = floor((($row['dex']-10)/2));
   $coreclass = substr($fullclass, 0, strpos($fullclass, "(") -1);
   $coremulticlass = substr($fullmulticlass, 0, strpos($fullmulticlass, "(") -1);
   $subclasstemp = substr($fullclass, strpos($fullclass, "(") +1);
   $multisubclasstemp = substr($fullmulticlass, strpos($fullmulticlass, "(") +1);
   $subclass = trim($subclasstemp, ')');
   $multisubclass = trim($multisubclasstemp, ')');
   $coreclassbare = ucwords($coreclass);
   $coremultibare = ucwords($coremulticlass);
   $coremulticlassbare = ucwords($coremulticlass);
   $background = $row['background'];
   $race = $row['race'];
   $bgbare = ucwords($row['background']);
   $coreclass = $coreclass.' core';
   $checkprofs = $row['proficiencies'];
   $checksaves = $row['saves'];
   $checkexperts = $row['expertise'];
   $allattacks = $row['attacks'];
   $allspells = $row['spells'];
   $spellslots = $row['slots'];
   $allfeats = $row['feats'];
   $maxhp = $row['maxhp'];
   $spellsarray = explode(',', $allspells);
   $slotsarray = explode(',', $spellslots);
   $customattacks = $row['customattacks'];
   $charNotes = $row['notes'];
   $charItems = $row['items'];
   $level = $row['level'];
   $multiclasslevel = (int)$row['class2lvl'];
   $mainclasslevel = (int)$level - $multiclasslevel;
   $spellsarray = explode(',', $allspells);
   $spellsarray = join("','",$spellsarray);
   $prepped = $row['prepped'];


   ?>
   <script>
   $(document).ready(function (){
     var allSlots = '<?php echo $spellslots; ?>';
     //document.getElementById('spellslot9').value = allSlots;
      var slotArray = allSlots.split(',');
      var coreclass = '<?php echo $coreclassbare; ?>';
      var subclass = '<?php echo $subclass; ?>';
      slotnum = 1;
      for (index = 0; index < slotArray.length; ++index) {
        if (coreclass == 'Mystic'){
          var slot = 'mysticslot' + slotnum;
        }
        else if (coreclass == 'Warlock' || subclass == 'Order of the Profane Soul'){
          var slot = 'lockslot' + slotnum;
        }
        else {
        var slot = 'spellslot' + slotnum;
      }
        document.getElementById(slot).value = slotArray[index];
        slotnum = slotnum + 1;
      }
   });
   </script>


   <script>

   $(document).ready(function() {
     var allFeats = '<?php echo $allfeats; ?>';
     var featArray = allFeats.split(',');
     var index1 = 0;
     var entryFeatNS = '';
     for (index1 = 0; index1 < allFeats.length; ++index1) {
       entryFeatNS = featArray[index1].replace(/ /g,'');
       $('#' + entryFeatNS + 'Box').prop('checked', true);
     }
   });
   $(document).ready(function() {
     var spelltable = $('#spelldc').html();
     if (spelltable == 'N/A'){
       document.getElementById('spellmain').style = "display:none";
     }
     var spelltable2 = $('#spelldc2').html();
     var multicheck = '<?php echo $row['class2lvl']; ?>';
     if (spelltable2 == 'N/A' || multicheck == '0'){
       document.getElementById('spelloff').style = "display:none";
     }
     var hd2 = '<?php echo $row['hitdice2']; ?>';
     var hd1 = '<?php echo $row['hitdice']; ?>';
     if (hd2 == '6' || hd2 == '8' || hd2 == '10' || hd2 == '12'){
       document.getElementById('hitDice').innerHTML = "d<?php echo $row['hitdice']; ?>/d" + hd2;
     }
     else {
       document.getElementById('hitDice').innerHTML = "d" + hd1;
     }
     var allSpells = '<?php echo $allspells; ?>';
      var spellArray = allSpells.split(',');
      var index = 0;
      var entryNS = '';
      for (index = 0; index < allSpells.length; ++index) {
        entryNS = spellArray[index].replace(/ /g,'');
        $('#' + entryNS + 'Box').prop('checked', true);
      }
      });
</script>
<script>
 $(document).ready(function () {
      var itemsDirty = '<?php echo $charItems; ?>';
      var currentItems = itemsDirty.split('_');
      var itemTable = $('#itemTable').html();
      var item = 0;
      for (item = 0; item < currentItems.length; ++item) {
        currentItems[item] = currentItems[item].replace('?', '\'');
        itemTable = itemTable + '<tr id="delrow' + item + '" style="display:block;"><td><form onSubmit="return false" name="delitem" style="display:none;"><button type="submit" class="logbtn btn btn-danger btn-sq-xs delitem" style="margin-right:15px;"  onclick="delItem(\'' + item + '\')"><span class="glyphicon glyphicon-remove"></span></button></form></td><td id ="deltd' + item + '"><a class="featureName" id="delitem' + item + '" data-toggle="collapse" href="#' + item + 'show">' + currentItems[item] + '</a></td></tr><tr><td colspan="2"><div class="featureDetails collapse" id="' + item + 'show">';
        itemTable = itemTable + '<iframe class="charCreateFrame" src="/tools/world/popout.php?id=' + currentItems[item] + '" style="width: 100%; height: 300px;" seamless></iframe></td></tr>';
      }
      document.getElementById('itemTable').innerHTML = itemTable;
   });

    function delItem(value){
        var itemsRaw = $('#currentItemsRaw').html();
        var toDelete = $('#delitem' + value).html();
        var toDelete = toDelete.replace('\'', '?');
        if (itemsRaw.includes("_" + toDelete) == true){
          itemsRaw = itemsRaw.replace('_' + toDelete, '');
        }
        itemsRaw = itemsRaw.replace(toDelete, '');
        document.getElementById('currentItemsRaw').innerHTML = itemsRaw;
        document.getElementById('delrow' + value).style = "display:none;";
    };
 </script>
   <button class="btn btn-success" id="saveSheet" onclick="saveSheet()" style="display:none;">Save</button>
   <button class="btn btn-danger" onclick="window.location.reload()" id="cancelSheet" style="display:none;">Cancel</button>
   <div class="btn-group btn-group-toggle" data-toggle="buttons">
  <label class="btn btn-primary active">
    <input type="radio" name="options" id="option1" autocomplete="off" onchange="showBlock('all')" checked> Show All
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option2" autocomplete="off" onchange="showBlock('statsBlock')"> Stats
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option3" autocomplete="off" onchange="showBlock('vitalsBlock')"> Vitals
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option4" autocomplete="off" onchange="showBlock('abilitiesBlock')"> Abilities
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option5" autocomplete="off" onchange="showBlock('attacksBlock')"> Attacks
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option6" autocomplete="off" onchange="showBlock('spellsBlock')"> Spells
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option7" autocomplete="off" onchange="showBlock('itemsBlock')"> Items
  </label>
  <label class="btn btn-primary">
    <input type="radio" name="options" id="option8" autocomplete="off" onchange="showBlock('notesBlock')"> Notes
  </label>

</div>
<a href="/tools/compendium/spell1.php?id=<?php echo $row['title']; ?>" target="_blank"><button class="btn btn-warning"><div style="color:black;">Spell Sheet</div></button></a>
<button class="btn btn-danger" onclick="longrest()">Long Rest</button>
<button class="btn btn-success" data-toggle="modal" href="#levelModal">Level Up!</button>
<button class="btn btn-info" onclick="editSheet()" id="editSheet">Edit</button>

 </div>
<?php    echo ('<div id="prepSpells" class="hide">'.$prepped.'</div>');
 ?>
<!-- LEVEL UP MODAL -->
<!-- Item Modal -->
<div class="modal fade bd-example-modal-lg" id="levelModal" role="dialog">
  <div class="modal-dialog" style="max-width:1200px;">

    <!-- Modal content-->
    <div class="modal-content modalstyle bodytext" style="height:100%;">
      <div class="modal-header" style="padding-bottom: 0px;">
        <div class="sidebartext hide" id="lvlmulticlass"></div>
        <div class="sidebartext hide" id="mainoffLevel"></div>
        <div class="sidebartext hide" id="lvlhitdie"><?php echo $row['hitdice']; ?></div>
        <div class="sidebartext hide" id="lvlhitdie2"><?php echo $row['hitdice2']; ?></div>
        <div class="sidebartext hide" id="mainoffroll"></div>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
      <div class="modal-body createModal" id="charModalBody" style="height:100%; padding-top: 0px;">

        <div id="lvlupLP">
<?php
        $newlevel = (int)$row['level'] + 1;
        $oldLP = (int)$row['level'] * 3;
        $newLP = $newlevel * 3;
        echo ('<div class="sidebartext col-centered">Ding! This will help you level up to Level '.$newlevel.'</div>');
        echo ('<div class="sidebartext col-centered">You old Life Points: '.$oldLP.'</div>');
        echo ('<div class="sidebartext col-centered">You NEW Life Points: '.$newLP.'</div>');
        echo ('<div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="startLevelUp()">Next</button></div>');
?>
</div>

<div id="lvlupMultiSelect" style="display:none;">
  <div class="col-centered">Select Class to Level:</div>
  <div class="col-centered">
    <?php
    if ($row['class2lvl'] !== '0'){
      echo ('<button class="btn btn-success" onclick="levelupNoMulti(\'main\')">'.ucwords($row['class1']).'</button>
      <button class="btn btn-info" onclick="levelupNoMulti(\'off\')">'.ucwords($row['class2']).'</button>');
    }
    else {
      echo ('<button class="btn btn-success" onclick="levelupNoMulti(\'main\')">Same Class</button>
      <button class="btn btn-info" onclick="levelupMulti()">Multiclass</button>');
    }
   ?>
</div>
</div>


<div id="lvlupMultiClass" style="display:none;">
  <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="levelupMultiSubclass()">Next</button></div>
  <div class="col-centered">Class</div>
  <div class="col-xs-12"><select class="sheetDrop" name="charClasseAdd" id="charClassAdd"  onchange="showClassDetails()">
    <option value="">Select Class...
    <?php
    $racetitle = "SELECT name FROM `subclasses` WHERE `name` LIKE '%core%'";
    $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
    while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
      $classNameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
      echo ('<option value="'.$classNameClean.'">'.$classNameClean);
    }
     ?>
  </select>
</div>
  <div class="col-xs-12 iframe-container"><iframe class="charCreateFrame" frameBorder="0" id="classDetails" seamless></iframe></div>
</div>

<div id="lvlupMultiSubclass" style="display:none;">
  <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="levelupAbilities()">Next</button></div>
  <div class="col-centered">Subclass</div>
  <div class="col-xs-12"><select class="charSubclassSelect sheetDrop" name="charSubClassAdd" id="charSubclassAdd"  onchange="showSubclassDetails()">
    <option value="">Select Subclass...
    <?php
    $racetitle = "SELECT name, class FROM `subclasses` WHERE `name` NOT LIKE '%core%'";
    $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
    while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
      $classns = str_replace(' ', '', $row1['class']);
      //$classNameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
      echo ('<option class="'.$classns.'1" style="display:none;" value="'.$row1['name'].'">'.$row1['name']);
    }
     ?>
  </select>
</div>
  <div class="col-xs-12 iframe-container"><iframe class="charCreateFrame" frameBorder="0" id="subclassDetails" seamless></iframe></div>
</div>


<div id="lvlupAbilities" style="display:none;">
  <div class="sidebartext col-centered" id="lvlability">At this level you gain the following new abilities (if any).</div>
<?php
$newmain = (int)$newlevel - (int)$row['class2lvl'];
$newoff = (int)$row['class2lvl'] + 1;
$lvltitle = "SELECT * FROM `subclasses` WHERE name LIKE '$coreclass'";
$lvldata = mysqli_query($dbcon, $lvltitle) or die('error getting data');
while($row2 =  mysqli_fetch_array($lvldata, MYSQLI_ASSOC)) {
  foreach($row2 as $column1=>$field1) {
    if ($newmain == 1) {
      $lvlcheck = (' '.$newmain.'st level');
    }
    else if ($newmain == 2) {
      $lvlcheck = (' '.$newmain.'nd level');
    }
    else if ($newmain == 3) {
      $lvlcheck = (' '.$newmain.'rd level');
    }
    else {
      $lvlcheck = (' '.$newmain.'th level');
    }

    if (strpos($field1, $lvlcheck) !== false) {
      $featuretitle1 = str_replace('text', 'name', $column1);
      $featuretitlens1 = str_replace(' ', '', $row2[$featuretitle1]);
      $featuretitlens1 = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens1);

      echo ('<a name="main" class="featureName" data-toggle="collapse" href="#'.$featuretitlens1.'show1" style="display:none;">'.$row2[$featuretitle1].' ('.$row2['class'].')</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens1.'show1" name="'.$featuretitlens1.'show1">'.nl2br($field1).'</div>');
    }
  }
}

$lvl1title = "SELECT * FROM `subclasses` WHERE name LIKE '$subclass'";
$lvl1data = mysqli_query($dbcon, $lvl1title) or die('error getting data');
while($row3 =  mysqli_fetch_array($lvl1data, MYSQLI_ASSOC)) {
  ?>

  <?php
  foreach($row3 as $column=>$field) {
    if ($newmain == 1) {
      $lvlcheck1 = (' '.$newmain.'st level');
    }
    else if ($newmain == 2) {
      $lvlcheck1 = (' '.$newmain.'nd level');
    }
    else if ($newmain == 3) {
      $lvlcheck1 = (' '.$newmain.'rd level');
    }
    else {
      $lvlcheck1 = (' '.$newmain.'th level');
    }

    if (strpos($field, $lvlcheck1) !== false) {
      $featuretitle = str_replace('text', 'name', $column);
      $featuretitlens = str_replace(' ', '', $row3[$featuretitle]);
      $featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);

      echo ('<a name="main" class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show" style="display:none;">'.$row3[$featuretitle].' ('.$row3['class'].')</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
    }
  }
}
$coremulticlassUC = $coremulticlass.' core';
$lvltitle = "SELECT * FROM `subclasses` WHERE name LIKE '$coremulticlassUC'";
$lvldata = mysqli_query($dbcon, $lvltitle) or die('error getting data');
while($row4 =  mysqli_fetch_array($lvldata, MYSQLI_ASSOC)) {
  foreach($row4 as $column2=>$field2) {
    if ($newoff == 1) {
      $lvlcheck2 = (' '.$newoff.'st level');
    }
    else if ($newoff == 2) {
      $lvlcheck2 = (' '.$newoff.'nd level');
    }
    else if ($newoff == 3) {
      $lvlcheck2 = (' '.$newoff.'rd level');
    }
    else {
      $lvlcheck2 = (' '.$newoff.'th level');
    }

    if (strpos($field2, $lvlcheck2) !== false) {
      $featuretitle2 = str_replace('text', 'name', $column2);
      $featuretitlens2 = str_replace(' ', '', $row4[$featuretitle2]);
      $featuretitlens2 = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens2);

      echo ('<a name="off" class="featureName" data-toggle="collapse" href="#'.$featuretitlens2.'show1" style="display:none;">'.$row4[$featuretitle2].' ('.$row4['class'].')</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens2.'show1" name="'.$featuretitlens2.'show1">'.nl2br($field2).'</div>');
    }
  }
}

$lvl1title = "SELECT * FROM `subclasses` WHERE name LIKE '$multisubclass'";
$lvl1data = mysqli_query($dbcon, $lvl1title) or die('error getting data');
while($row5 =  mysqli_fetch_array($lvl1data, MYSQLI_ASSOC)) {
  ?>

  <?php
  foreach($row5 as $column3=>$field3) {
    if ($newoff == 1) {
      $lvlcheck3 = (' '.$newoff.'st level');
    }
    else if ($newoff == 2) {
      $lvlcheck3 = (' '.$newoff.'nd level');
    }
    else if ($newoff == 3) {
      $lvlcheck3 = (' '.$newoff.'rd level');
    }
    else {
      $lvlcheck3 = (' '.$newoff.'th level');
    }

    if (strpos($field3, $lvlcheck3) !== false) {
      $featuretitle3 = str_replace('text', 'name', $column3);
      $featuretitlens3 = str_replace(' ', '', $row5[$featuretitle3]);
      $featuretitlens3 = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens3);

      echo ('<a name="off" class="featureName" data-toggle="collapse" href="#'.$featuretitlens3.'show" style="display:none;">'.$row5[$featuretitle3].' ('.$row5['class'].')</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens3.'show" name="'.$featuretitlens3.'show">'.nl2br($field3).'</div>');
    }
  }
}


echo ('<div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="levelupHP()">Next</button></div>');
?>
</div>

<div id="lvlupHP" style="display:none;">
  <div class="sidebartext col-centered">Roll for Max HP! (Or click "Next" and add manually from the sheet)</div>
<?php

  echo ('<div class="col-centered">Current Max HP: '.$row['maxhp'].'</div>');
  echo ('<div class="col-centered"><button class="btn btn-success" onclick="rollHP(\''.$row['hitdice'].'\')">Roll!</button></div>');
  echo ('<div style="display:none;" class="col-centered" id="hpRoll"></div>');
  echo ('<div style="display:none;" class="col-centered" id="hpMod"></div>');
  echo ('<div class="col-centered">New Max HP: <div style="font-size:30px; color: #42f486;" id="newmaxhp">'.$row['maxhp'].'</div></div>');
  echo ('<div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="levelupStats()">Next</button></div>');
?>
</div>

<div id="lvlupStats" style="display:none;">
  <div class="sidebartext col-centered"></div>
<?php
  if ($newlevel == 5 || $newlevel == 9 || $newlevel == 13 || $newlevel == 17){
  if ($newlevel == 5){
    echo ('<div class="sidebartext col-centered">Your Proficiency bonus has increased to 3!</div>');
  }
  if ($newlevel == 9){
    echo ('<div class="sidebartext col-centered">Your Proficiency bonus has increased to 4!</div>');
  }
  if ($newlevel == 13){
    echo ('<div class="sidebartext col-centered">Your Proficiency bonus has increased to 5!</div>');
  }
  if ($newlevel == 17){
    echo ('<div class="sidebartext col-centered">Your Proficiency bonus has increased to 6!</div>');
  }
  echo ('<div class="sidebartext col-centered">This will give you an additional +1 to all proficient skills, attacks saving throws, your spell attack bonus, and your spell DC.</div>');
}
else {
  echo ('<div class="col-centered">Your proficiency bonus does not increase this level.</div>');
}

  echo ('<div id="lvlstats" style="display:none;">');
  echo ('<div class="sidebartext col-centered">At this level you get an Ability Score Improvement. You may increase two skills by 1, or one skill by 2.</div>');
  ?>
  <div class="col-sm-4 sidebartext col-centered">Stat 1
  <select class="classSelect" id="stat1drop" onchange="calcStats()">
    <option id="stat1null" value="null" selected>
    <option id="stat1str" value="str">STR
    <option id="stat1dex" value="dex">DEX
    <option id="stat1con" value="con">CON
    <option id="stat1intel" value="int">INT
    <option id="stat1wis" value="wis">WIS
    <option id="stat1cha" value="cha">CHA
  </select>
  </div>
  <div class="col-sm-4 sidebartext col-centered">Stat 2
  <select class="classSelect" id="stat2drop" onchange="calcStats()">
    <option id="stat2null" value="null" selected>
    <option id="stat2str" value="str">STR
    <option id="stat2dex" value="dex">DEX
    <option id="stat2con" value="con">CON
    <option id="stat2intel" value="int">INT
    <option id="stat2wis" value="wis">WIS
    <option id="stat2cha" value="cha">CHA
  </select>
  </div>


  <table style="width:100%;" class="sidebartext">
    <tr>
      <td>STR</td>
      <td>DEX</td>
      <td>CON</td>
      <td>INT</td>
      <td>WIS</td>
      <td>CHA</td>
    </tr>
      <td><div id="Strtotal"><?php echo $row['str']; ?></div><div id="strStat"></div></td>
      <td><div id="Dextotal"><?php echo $row['dex']; ?></div><div id="dexStat"></div></td>
      <td><div id="Contotal"><?php echo $row['con']; ?></div><div id="conStat"></div></td>
      <td><div id="Inttotal"><?php echo $row['intel']; ?></div><div id="intStat"></div></td>
      <td><div id="Wistotal"><?php echo $row['wis']; ?></div><div id="wisStat"></div></td>
      <td><div id="Chatotal"><?php echo $row['cha']; ?></div><div id="chaStat"></div></td>
    </tr>
  </table>
  <?php
  echo ('<div class="sidebartext col-centered">You may choose to take a feat instead. Please add your selected feat from the character edit screen.</div>');
echo ('</div>');
  echo ('<div class="col-centered" id="noability" style="display:block;">You do not get an Ability Score Improvement this level.</div>');

echo ('<div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="levelupTable()">Next</button></div>');

?>

</div>


<div id="lvlupTable" style="display:none;">

  <div class="col-centered" id="lvlchanges" style="margin-bottom: 15px;">Here's what's changed from your old level to your new level:</div>
  <table id="levelclasstable" class="table lvltable table-striped table-condensed table-responsive">
<thead>
<?php
$upclass = ucwords($coreclassbare);
$upmulticlass = ucwords($coremultibare);
$newrow = $upclass.$newmain;
$oldrow = $upclass.$mainclasslevel;
$newmcrow = $upmulticlass.$newoff;
$oldmcrow = $upmulticlass.$multiclasslevel;
if($upclass == "Artificer" || $upmulticlass = "Artificer") {
  echo ('<tr class="Artificer ctable">');
  echo('<th class="Artificer ctable">Level</th>');
  echo('<th class="Artificer ctable">Proficiency</th>');
  echo('<th class="Artificer ctable">Features</th>');
  echo('<th class="Artificer ctable">Spells Known</th>');
  echo('<th class="Artificer ctable">1st</th>');
  echo('<th class="Artificer ctable">2nd</th>');
  echo('<th class="Artificer ctable">3rd</th>');
  echo('<th class="Artificer ctable">4th</th>');
  echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Artificer%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {
  $mcrowclass = str_replace(' ', '', $classtablerow['class']);
  echo ('<tr id="'.$classtablerow['name'].'" class="Artificer ctable hide"><td>'.$classtablerow['level'].'</td>');
  echo ('<td>'.$classtablerow['proficiency'].'</td>');
  echo ('<td>'.$classtablerow['feature'].'</td>');
  echo ('<td>'.$classtablerow['known'].'</td>');
  echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
  echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
  echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
  echo ('<td>'.$classtablerow['spelllvl4'].'</td></tr>');

  }
}

if($upclass == "Barbarian" || $upmulticlass = "Barbarian") {
echo ('<tr class="Barbarian ctable">');
echo('<th class="Barbarian ctable">Level</th>');
echo('<th class="Barbarian ctable">Proficiency</th>');
echo('<th class="Barbarian ctable">Features</th>');
echo('<th class="Barbarian ctable">Rages</th>');
echo('<th class="Barbarian ctable">Rage Damage</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Barbarian%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Barbarian ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['resource'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td></tr>');

}
}

if($upclass == "Bard" || $upmulticlass = "Bard") {
  echo ('<tr class="Bard ctable">');
echo('<th class="Bard ctable">Level</th>');
echo('<th class="Bard ctable">Proficiency</th>');
echo('<th class="Bard ctable">Features</th>');
echo('<th class="Bard ctable">Cantrips</th>');
echo('<th class="Bard ctable">Spells Known</th>');
echo('<th class="Bard ctable">1st</th>');
echo('<th class="Bard ctable">2nd</th>');
echo('<th class="Bard ctable">3rd</th>');
echo('<th class="Bard ctable">4th</th>');
echo('<th class="Bard ctable">5th</th>');
echo('<th class="Bard ctable">6th</th>');
echo('<th class="Bard ctable">7th</th>');
echo('<th class="Bard ctable">8th</th>');
echo('<th class="Bard ctable">9th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Bard%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Bard ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td>');
echo ('<td>'.$classtablerow['spelllvl6'].'</td>');
echo ('<td>'.$classtablerow['spelllvl7'].'</td>');
echo ('<td>'.$classtablerow['spelllvl8'].'</td>');
echo ('<td>'.$classtablerow['spelllvl9'].'</td></tr>');

}
}

if($upclass == "Cleric" || $upmulticlass = "Cleric") {
  echo ('<tr class="Cleric ctable">');
echo('<th class="Cleric ctable">Level</th>');
echo('<th class="Cleric ctable">Proficiency</th>');
echo('<th class="Cleric ctable">Features</th>');
echo('<th class="Cleric ctable">Cantrips</th>');
echo('<th class="Cleric ctable">1st</th>');
echo('<th class="Cleric ctable">2nd</th>');
echo('<th class="Cleric ctable">3rd</th>');
echo('<th class="Cleric ctable">4th</th>');
echo('<th class="Cleric ctable">5th</th>');
echo('<th class="Cleric ctable">6th</th>');
echo('<th class="Cleric ctable">7th</th>');
echo('<th class="Cleric ctable">8th</th>');
echo('<th class="Cleric ctable">9th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Cleric%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Cleric ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td>');
echo ('<td>'.$classtablerow['spelllvl6'].'</td>');
echo ('<td>'.$classtablerow['spelllvl7'].'</td>');
echo ('<td>'.$classtablerow['spelllvl8'].'</td>');
echo ('<td>'.$classtablerow['spelllvl9'].'</td></tr>');

}
}

if($upclass == "Druid" || $upmulticlass = "Druid") {
  echo ('<tr class="Druid ctable">');
echo('<th class="Druid ctable">Level</th>');
echo('<th class="Druid ctable">Proficiency</th>');
echo('<th class="Druid ctable">Features</th>');
echo('<th class="Druid ctable">Cantrips</th>');
echo('<th class="Druid ctable">1st</th>');
echo('<th class="Druid ctable">2nd</th>');
echo('<th class="Druid ctable">3rd</th>');
echo('<th class="Druid ctable">4th</th>');
echo('<th class="Druid ctable">5th</th>');
echo('<th class="Druid ctable">6th</th>');
echo('<th class="Druid ctable">7th</th>');
echo('<th class="Druid ctable">8th</th>');
echo('<th class="Druid ctable">9th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Druid%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Druid ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td>');
echo ('<td>'.$classtablerow['spelllvl6'].'</td>');
echo ('<td>'.$classtablerow['spelllvl7'].'</td>');
echo ('<td>'.$classtablerow['spelllvl8'].'</td>');
echo ('<td>'.$classtablerow['spelllvl9'].'</td></tr>');

}
}

if($upclass == "Fighter" || $upmulticlass = "Fighter") {
  echo ('<tr class="Fighter ctable">');
echo('<th class="Fighter ctable">Level</th>');
echo('<th class="Fighter ctable">Proficiency</th>');
echo('<th class="Fighter ctable">Features</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Fighter%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Fighter ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td></tr>');

}
}

if($upclass == "Monk" || $upmulticlass = "Monk") {
  echo ('<tr class="Monk ctable">');
echo('<th class="Monk ctable">Level</th>');
echo('<th class="Monk ctable">Proficiency</th>');
echo('<th class="Monk ctable">Martial Arts</th>');
echo('<th class="Monk ctable">Ki Points</th>');
echo('<th class="Monk ctable">Unarmored Movement</th>');
echo('<th class="Monk ctable">Features</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Monk%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Monk ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['resource'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td></tr>');

}
}

if($upclass == "Mystic" || $upmulticlass = "Mystic") {
  echo ('<tr class="Mystic ctable">');
echo('<th class="Mystic ctable">Level</th>');
echo('<th class="Mystic ctable">Proficiency</th>');
echo('<th class="Mystic ctable">Features</th>');
echo('<th class="Mystic ctable">Talents Known</th>');
echo('<th class="Mystic ctable">Disciplines Known</th>');
echo('<th class="Mystic ctable">Psi Points</th>');
echo('<th class="Mystic ctable">Psi Limit</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Mystic%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Mystic ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td></tr>');

}
}

if($upclass == "Paladin" || $upmulticlass = "Paladin") {
  echo ('<tr class="Paladin ctable">');
echo('<th class="Paladin ctable">Level</th>');
echo('<th class="Paladin ctable">Proficiency</th>');
echo('<th class="Paladin ctable">Features</th>');
echo('<th class="Paladin ctable">1st</th>');
echo('<th class="Paladin ctable">2nd</th>');
echo('<th class="Paladin ctable">3rd</th>');
echo('<th class="Paladin ctable">4th</th>');
echo('<th class="Paladin ctable">5th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Paladin%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Paladin ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td></tr>');

}
}

if($upclass == "Ranger" || $upmulticlass = "Ranger") {
  echo ('<tr class="Ranger ctable">');
echo('<th class="Ranger ctable">Level</th>');
echo('<th class="Ranger ctable">Proficiency</th>');
echo('<th class="Ranger ctable">Features</th>');
echo('<th class="Ranger ctable">Spells Known</th>');
echo('<th class="Ranger ctable">1st</th>');
echo('<th class="Ranger ctable">2nd</th>');
echo('<th class="Ranger ctable">3rd</th>');
echo('<th class="Ranger ctable">4th</th>');
echo('<th class="Ranger ctable">5th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Ranger%' AND name NOT LIKE ' Ranger%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Ranger ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td></tr>');

}
}

if($upclass == "Rogue" || $upmulticlass = "Rogue") {
echo ('<tr class="Rogue ctable">');
echo('<th class="Rogue ctable">Level</th>');
echo('<th class="Rogue ctable">Proficiency</th>');
echo('<th class="Rogue ctable">Sneak Attack</th>');
echo('<th class="Rogue ctable">Features</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Rogue%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Rogue ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');

}
}


if($upclass == "Sorcerer" || $upmulticlass = "Sorcerer") {
  echo ('<tr class="Sorcerer ctable">');
echo('<th class="Sorcerer ctable">Level</th>');
echo('<th class="Sorcerer ctable">Proficiency</th>');
echo('<th class="Sorcerer ctable">Sorcery Points</th>');
echo('<th class="Sorcerer ctable">Features</th>');
echo('<th class="Sorcerer ctable">Cantrips</th>');
echo('<th class="Sorcerer ctable">Spells Known</th>');
echo('<th class="Sorcerer ctable">1st</th>');
echo('<th class="Sorcerer ctable">2nd</th>');
echo('<th class="Sorcerer ctable">3rd</th>');
echo('<th class="Sorcerer ctable">4th</th>');
echo('<th class="Sorcerer ctable">5th</th>');
echo('<th class="Sorcerer ctable">6th</th>');
echo('<th class="Sorcerer ctable">7th</th>');
echo('<th class="Sorcerer ctable">8th</th>');
echo('<th class="Sorcerer ctable">9th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Sorcerer%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Sorcerer ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['resource'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td>');
echo ('<td>'.$classtablerow['spelllvl6'].'</td>');
echo ('<td>'.$classtablerow['spelllvl7'].'</td>');
echo ('<td>'.$classtablerow['spelllvl8'].'</td>');
echo ('<td>'.$classtablerow['spelllvl9'].'</td></tr>');

}
}

if($upclass == "Warlock" || $upmulticlass = "Warlock") {
  echo ('<tr class="Warlock ctable">');
echo('<th class="Warlock ctable">Level</th>');
echo('<th class="Warlock ctable">Proficiency</th>');
echo('<th class="Warlock ctable">Features</th>');
echo('<th class="Warlock ctable">Cantrips</th>');
echo('<th class="Warlock ctable">Spells Known</th>');
echo('<th class="Warlock ctable">Spell Slots</th>');
echo('<th class="Warlock ctable">Slot Level</th>');
echo('<th class="Warlock ctable">Invocations Known</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Warlock%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Warlock ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['resource'].'</td></tr>');

}
}

if($upclass == "Wizard" || $upmulticlass = "Wizard") {
  echo ('<tr class="Wizard ctable">');
echo('<th class="Wizard ctable">Level</th>');
echo('<th class="Wizard ctable">Proficiency</th>');
echo('<th class="Wizard ctable">Features</th>');
echo('<th class="Wizard ctable">Cantrips</th>');
echo('<th class="Wizard ctable">1st</th>');
echo('<th class="Wizard ctable">2nd</th>');
echo('<th class="Wizard ctable">3rd</th>');
echo('<th class="Wizard ctable">4th</th>');
echo('<th class="Wizard ctable">5th</th>');
echo('<th class="Wizard ctable">6th</th>');
echo('<th class="Wizard ctable">7th</th>');
echo('<th class="Wizard ctable">8th</th>');
echo('<th class="Wizard ctable">9th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Wizard%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {

$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$classtablerow['name'].'" class="Wizard ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['cantrips'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td>');
echo ('<td>'.$classtablerow['spelllvl6'].'</td>');
echo ('<td>'.$classtablerow['spelllvl7'].'</td>');
echo ('<td>'.$classtablerow['spelllvl8'].'</td>');
echo ('<td>'.$classtablerow['spelllvl9'].'</td></tr>');

}
}

if($upclass == "Blood Hunter" || $upmulticlass = "Blood Hunter") {
  echo ('<tr class="BloodHunter ctable">');
echo('<th class="BloodHunter ctable">Level</th>');
echo('<th class="BloodHunter ctable">Proficiency</th>');
echo('<th class="BloodHunter ctable">Crimson Rite</th>');
echo('<th class="BloodHunter ctable">Features</th>');
echo('<th class="BloodHunter ctable">Blood Curses Known</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Blood Hunter%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {
 $ctr = str_replace(' ', '', $classtablerow['name']);
$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$ctr.'" class="BloodHunter ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['resource'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');

  }
}

if($upclass == "Revised Ranger" || $upmulticlass = "Revised Ranger") {
  echo ('<tr class="RevisedRanger ctable">');
echo('<th class="RevisedRanger ctable">Level</th>');
echo('<th class="RevisedRanger ctable">Proficiency</th>');
echo('<th class="RevisedRanger ctable">Features</th>');
echo('<th class="RevisedRanger ctable">Spells Known</th>');
echo('<th class="RevisedRanger ctable">1st</th>');
echo('<th class="RevisedRanger ctable">2nd</th>');
echo('<th class="RevisedRanger ctable">3rd</th>');
echo('<th class="RevisedRanger ctable">4th</th>');
echo('<th class="RevisedRanger ctable">5th</th>');
echo('</tr>');
echo('</thead>');
echo('<tbody>');


$classtabletitle = "SELECT * FROM `classtable` WHERE name LIKE 'Revised Ranger%'";
$classtabledata = mysqli_query($dbcon, $classtabletitle) or die('error getting data');
while($classtablerow =  mysqli_fetch_array($classtabledata, MYSQLI_ASSOC)) {
  $ctr = str_replace(' ', '', $classtablerow['name']);
$mcrowclass = str_replace(' ', '', $classtablerow['class']);
echo ('<tr id="'.$ctr.'" class="RevisedRanger ctable hide"><td>'.$classtablerow['level'].'</td>');
echo ('<td>'.$classtablerow['proficiency'].'</td>');
echo ('<td>'.$classtablerow['feature'].'</td>');
echo ('<td>'.$classtablerow['known'].'</td>');
echo ('<td>'.$classtablerow['spelllvl1'].'</td>');
echo ('<td>'.$classtablerow['spelllvl2'].'</td>');
echo ('<td>'.$classtablerow['spelllvl3'].'</td>');
echo ('<td>'.$classtablerow['spelllvl4'].'</td>');
echo ('<td>'.$classtablerow['spelllvl5'].'</td></tr>');

}
}
?>
</tbody>
</table>
<div class="col-centered"><button class="btn btn-success" class="nextButton" onclick="saveLevel()">Finish Level Up!</button></div>

</div>

</div>
</div>
</div>
</div>

<script>
function showClassDetails(){
  var selectedClass = document.getElementById('charClassAdd').value;
  var classFrame = document.getElementById('classDetails');
  classFrame.addEventListener("load", function() {
  this.contentWindow.document.getElementById('nonav').style = "display:none";
  this.contentWindow.document.getElementById('headbody').style = "background:none";
  var mainBox = this.contentWindow.document.getElementsByClassName('mainbox');
  mainBox[0].style = "background:none";
});
  classFrame.src= "/tools/compendium/compendium.php?id=" + selectedClass;
};

function showSubclassDetails(){
  var selectedSubclass = document.getElementById('charSubclassAdd').value;
  var subclassFrame = document.getElementById('subclassDetails');
  subclassFrame.addEventListener("load", function() {
  this.contentWindow.document.getElementById('nonav').style = "display:none";
  this.contentWindow.document.getElementById('body').style = "background:none";
});
  subclassFrame.src= "/tools/compendium/popout.php?id=" + selectedSubclass;
};


$(document).ready(function() {

    // DataTable
    var table = $('#levelclasstable').DataTable({
      "ordering": false,
      "paging": false,
      "searching": false,
      "info": false,
      "scrollX": true
    });

    $(".dataTables_scrollHeadInner").css({"width":"100%"});

    $(".lvltable").css({"width":"100%"});
} );


function startLevelUp() {
  $('#lvlupLP').fadeOut(500);
  $('#lvlupMultiSelect').delay(400).fadeIn(300);
};

function levelupNoMulti(value){
  var mainoff = value;
  var newmain = <?php echo $newmain; ?>;
  var newoff = <?php echo $newoff; ?>;

  if (mainoff == 'main'){
    document.getElementById('mainoffroll').innerHTML = "main";
    document.getElementById('mainoffLevel').innerHTML = '<?php echo $row['class2lvl']; ?>';
    document.getElementById('lvlhitdie').innerHTML = '<?php echo $row['hitdice']; ?>';
    document.getElementById('lvlhitdie2').innerHTML = '<?php echo $row['hitdice2']; ?>';
    var showmain = document.getElementsByName('main');
    for (var i = 0; i < showmain.length; i++) {
      showmain[i].style = "display:block";
    }
    var offtable = document.getElementsByClassName('ctable');
    var x = <?php echo $newmain; ?>;
    var y = <?php echo $mainclasslevel; ?>;
      for (var i = 0; i < offtable.length; i++) {
        var showid = '<?php echo $coreclassbare; ?>' + x;
        var showid1 = '<?php echo $coreclassbare; ?>' + y;

        if ($(offtable[i]).hasClass('<?php echo $coreclassbare; ?>') !== false){

          if ($(offtable[i]).has("#" + showid1)){
            document.getElementById(showid1).style.color = "red";
            $('#' + showid1).removeClass("hide");
          }
          if ($(offtable[i]).has("#" + showid)){
            document.getElementById(showid).style.color = "#42f486";
            $('#' + showid).removeClass("hide");
          }
        }
        else {
          offtable[i].style = "display:none";
        }
    }
    var mainstat = '<?php echo $coreclassbare.$newmain; ?>';
    if (newmain == 4 || newmain == 8 || newmain == 12 || newmain == 16 || newmain == 19 || mainstat == 'Fighter6' || mainstat == 'Fighter14'){
      document.getElementById('lvlstats').style = "display:block";
      document.getElementById('noability').style = "display:none";
    }
    else {
      document.getElementById('noability').style = "display:block";
    }
  }
  else if (mainoff == 'off'){
    document.getElementById('mainoffroll').innerHTML = "off";
    document.getElementById('mainoffLevel').innerHTML = '<?php echo (int)$row['class2lvl'] + 1; ?>';
    document.getElementById('lvlhitdie').innerHTML = '<?php echo $row['hitdice']; ?>';
    document.getElementById('lvlhitdie2').innerHTML = '<?php echo $row['hitdice2']; ?>';
    var showoff = document.getElementsByName('off');
    for (var i = 0; i < showoff.length; i++) {
      showoff[i].style = "display:block";
    }
    var maintable = document.getElementsByClassName('ctable');
    var x = <?php echo $newoff; ?>;
    var y = <?php echo $multiclasslevel; ?>;
    for (var i = 0; i < maintable.length; i++) {
      var showid = '<?php echo $coremultibare; ?>' + x;
      var showid1 = '<?php echo $coremultibare; ?>' + y;
      if ($(maintable[i]).hasClass('<?php echo $coremultibare; ?>') !== false){

        if ($(maintable[i]).has("#" + showid1)){
          document.getElementById(showid1).style.color = "red";
            $('#' + showid1).removeClass("hide");
        }
        if ($(maintable[i]).has("#" + showid)){
          document.getElementById(showid).style.color = "#42f486";
          $('#' + showid).removeClass("hide");
        }
      }
      else {
        maintable[i].style = "display:none";
      }
    }
    var offstat = '<?php echo $coremulticlassbare.$newoff; ?>';
     if (newoff == 4 || newoff == 8 || newoff == 12 || newoff == 16 || newoff == 19 || offstat == 'Fighter6' || offstat == 'Fighter14'){
       document.getElementById('lvlstats').style = "display:block";
       document.getElementById('noability').style = "display:none";
     }
     else {
       document.getElementById('noability').style = "display:block";
     }
  }
  document.getElementById('lvlmulticlass').innerHTML = '<?php echo $row['class2']; ?>';
  $('#lvlupMultiSelect').fadeOut(500);
  $('#lvlupAbilities').delay(400).fadeIn(300);
};

function levelupMulti(){
  var hiderows = document.getElementsByClassName('ctable');
  for (var i = 0; i < hiderows.length; i++) {
    hiderows[i].style = "display:none";
  }
  document.getElementById('lvlchanges').innerHTML = "All done! Enjoy your new multiclass!";
  $('#lvlupMultiSelect').fadeOut(500);
  $('#lvlupMultiClass').delay(400).fadeIn(300);
};

jQuery.fn.toggleOption = function( show ) {
    jQuery( this ).toggle( show );
    if( show ) {
        if( jQuery( this ).parent( 'span.toggleOption' ).length )
            jQuery( this ).unwrap( );
    } else {
        if( jQuery( this ).parent( 'span.toggleOption' ).length == 0 )
            jQuery( this ).wrap( '<span class="toggleOption" style="display: none;" />' );
    }
};

function levelupMultiSubclass(){
  var charClass1 = document.getElementById('charClassAdd').value;
  var charClassns1 = charClass1.replace(' ', '');
  //document.getElementById(charClassns + 'prof').style = "display:block";
  if (charClass1 == ''){
  }
  else {
  //document.getElementById('charClass').innerHTML = charClass1;
  var charClass1lower = charClass1.toLowerCase();
  if (charClass1 == 'Artificer' || charClass1 == 'Bard' || charClass1 == 'Cleric' || charClass1 == 'Druid' || charClass1 == 'Monk' || charClass1 == 'Mystic' || charClass1 == 'Rogue'){
    document.getElementById('lvlhitdie2').innerHTML = '8';
  }
  else if (charClass1 == 'Blood Hunter' || charClass1 == 'Fighter' || charClass1 == 'Ranger' || charClass1 == 'Revised Ranger' || charClass1 == 'Paladin') {
    document.getElementById('lvlhitdie2').innerHTML = '10';
  }
  else if (charClass1 == 'Barbarian'){
    document.getElementById('lvlhitdie2').innerHTML = '12';
  }
  else {
    document.getElementById('lvlhitdie2').innerHTML = '6';
  }
  document.getElementById('lvlmulticlass').innerHTML = charClass1lower;
  jQuery('.' + charClassns1 + '1').toggleOption(true); // show option
  document.getElementById('lvlability').innerHTML = "Congrats on your Multiclass, next you roll for max HP."
  $('#lvlupMultiClass').fadeOut(500);
  $('#lvlupMultiSubclass').delay(400).fadeIn(300);
  }
};

function levelupAbilities() {
  var tempmulticlass = document.getElementById('lvlmulticlass').innerHTML;
  var tempmultisub = document.getElementById('charSubclassAdd').value;
  document.getElementById('lvlmulticlass').innerHTML = tempmulticlass + ' (' + tempmultisub + ')';
  document.getElementById('mainoffLevel').innerHTML = 1;

  $('#lvlupMultiSubclass').fadeOut(500);
  $('#lvlupAbilities').delay(400).fadeIn(300);
};

function levelupHP() {
  $('#lvlupAbilities').fadeOut(500);
  $('#lvlupHP').delay(400).fadeIn(300);
};

function levelupStats() {
  $('#lvlupHP').fadeOut(500);
  $('#lvlupStats').delay(400).fadeIn(300);
};

function levelupTable() {
  $('#lvlupStats').fadeOut(500);
  $('#lvlupTable').delay(400).fadeIn(300);
};

function rollHP(){
  var hitdie = $('#lvlhitdie').html();
  var hitdie2 = $('#lvlhitdie2').html();
  const roller = new DiceRoller();
  var mainoffroll = $('#mainoffroll').html();
  if (mainoffroll == 'main'){
    var rolltemp = roller.roll('1d' + hitdie);
    document.getElementById('hpRoll').innerHTML = "On your d" + hitdie + " you rolled a ";
  }
  else {
    var rolltemp = roller.roll('1d' + hitdie2);
    document.getElementById('hpRoll').innerHTML = "On your d" + hitdie2 + " you rolled a ";
  }
  var rollstring = rolltemp.toString();
  var roll = rollstring.split('= ')[1];
  if (roll == 1){
    document.getElementById('hpRoll').innerHTML = document.getElementById('hpRoll').innerHTML + "1. Go ahead and roll again.";
  }
  else{
  document.getElementById('hpRoll').innerHTML = document.getElementById('hpRoll').innerHTML + roll;
  var conMod = parseInt(document.getElementById('conMod').innerHTML);
  document.getElementById('hpMod').innerHTML = "Plus your CON mod of " + conMod;
  document.getElementById('hpMod').style = "display:block";
  document.getElementById('hpRoll').style = "display:block";
  var newmax =  parseInt(<?php echo $row['maxhp']; ?>) + parseInt(roll) + conMod;
  document.getElementById('newmaxhp').innerHTML = newmax;
}
  document.getElementById('hpRoll').style = "display:block";
}


function calcStats(){
  var currentStr = $('#Strtotal').html();
  var currentDex = $('#Dextotal').html();
  var currentCon = $('#Contotal').html();
  var currentInt = $('#Inttotal').html();
  var currentWis = $('#Wistotal').html();
  var currentCha = $('#Chatotal').html();
  var stat1Type = $('#stat1drop').val();
  var stat2Type = $('#stat2drop').val();
  var strBonus = 0;
  var dexBonus = 0;
  var conBonus = 0;
  var intBonus = 0;
  var wisBonus = 0;
  var chaBonus = 0;
  if (stat1Type == 'str'){
    if (stat2Type == 'str'){
      strBonus = 2;
    }
    else {
      strBonus = 1;
    }

  }
    if (stat1Type == 'dex'){
    if (stat2Type == 'dex'){
      dexBonus = 2;
    }
    else {
      dexBonus = 1;
    }

    }
  if (stat1Type == 'con'){
    if (stat2Type == 'con'){
      conBonus = 2;
    }
    else {
      conBonus = 1;
    }

  }
  if (stat1Type == 'int'){
    if (stat2Type == 'int'){
      intBonus = 2;
    }
    else {
      intBonus = 1;
    }

  }
  if (stat1Type == 'wis'){
    if (stat2Type == 'wis'){
      wisBonus = 2;
    }
    else {
      wisBonus = 1;
    }

  }
  if (stat1Type == 'cha'){
    if (stat2Type == 'cha'){
      chaBonus = 2;
    }
    else {
      chaBonus = 1;
    }

  }

  if (stat2Type == 'str'){
    if (stat1Type == 'str'){
      strBonus = 2;
    }
    else {
      strBonus = 1;
    }

  }
  if (stat2Type == 'dex'){
    if (stat1Type == 'dex'){
      dexBonus = 2;
    }
    else {
      dexBonus = 1;
    }

    }
  if (stat2Type == 'con'){
    if (stat1Type == 'con'){
      conBonus = 2;
    }
    else {
      conBonus = 1;
    }

  }
  if (stat2Type == 'int'){
    if (stat1Type == 'int'){
      intBonus = 2;
    }
    else {
      intBonus = 1;
    }

  }
  if (stat2Type == 'wis'){
    if (stat1Type == 'wis'){
      wisBonus = 2;
    }
    else {
      wisBonus = 1;
    }

  }
  if (stat2Type == 'cha'){
    if (stat1Type == 'cha'){
      chaBonus = 2;
    }
    else {
      chaBonus = 1;
    }
  }
  document.getElementById('strStat').innerHTML = '+' + strBonus;
  document.getElementById('dexStat').innerHTML = '+' + dexBonus;
  document.getElementById('conStat').innerHTML = '+' + conBonus;
  document.getElementById('intStat').innerHTML = '+' + intBonus;
  document.getElementById('wisStat').innerHTML = '+' + wisBonus;
  document.getElementById('chaStat').innerHTML = '+' + chaBonus;


}

function saveLevel(){
  var levelName = '<?php echo $title; ?>';
  var charID = '<?php echo $charID; ?>';
  var charNewLevel = '<?php echo $newlevel; ?>';
  var charNewMax = parseInt($('#newmaxhp').html());
  var charOldStr = parseInt($('#strScore').val());
  var charOldDex = parseInt($('#dexScore').val());
  var charOldCon = parseInt($('#conScore').val());
  var charOldInt = parseInt($('#intScore').val());
  var charOldWis = parseInt($('#wisScore').val());
  var charOldCha = parseInt($('#chaScore').val());
  var addStrtemp = $('#strStat').html();
  var addDextemp = $('#dexStat').html();
  var addContemp = $('#conStat').html();
  var addInttemp = $('#intStat').html();
  var addWistemp = $('#wisStat').html();
  var addChatemp = $('#chaStat').html();
  if (addStrtemp){
  var addStr = parseInt(addStrtemp.replace('+', ''));
  var addDex = parseInt(addDextemp.replace('+', ''));
  var addCon = parseInt(addContemp.replace('+', ''));
  var addInt = parseInt(addInttemp.replace('+', ''));
  var addWis = parseInt(addWistemp.replace('+', ''));
  var addCha = parseInt(addChatemp.replace('+', ''));
  var charNewStr = charOldStr + addStr;
  var charNewDex = charOldDex + addDex;
  var charNewCon = charOldCon + addCon;
  var charNewInt = charOldInt + addInt;
  var charNewWis = charOldWis + addWis;
  var charNewCha = charOldCha + addCha;
}
else {
  var charNewStr = charOldStr;
  var charNewDex = charOldDex;
  var charNewCon = charOldCon;
  var charNewInt = charOldInt;
  var charNewWis = charOldWis;
  var charNewCha = charOldCha;
}

var checklvlmulti = document.getElementById('lvlmulticlass').innerHTML;
if (checklvlmulti == ''){
  var charMultiClass = 'ranger (Gloom Stalker Conclave)';
  var charMultiLevel = '0';
}
 else {
   var charMultiClass = checklvlmulti;
   var charMultiLevel = $('#mainoffLevel').html();
 }
   var lvlhitdie = $('#lvlhitdie').html();
   var lvlhitdie2 = $('#lvlhitdie2').html();

  $.ajax({
     url : 'charlevel.php',
     type: 'GET',
     data : { "charID" : charID, "strength" : charNewStr, "dexterity" : charNewDex, "constitution" : charNewCon, "intelligence" : charNewInt, "wisdom" : charNewWis, "charisma" : charNewCha, "maxhp" : charNewMax, "charLevel" : charNewLevel, "charMultiClass" : charMultiClass, "class2lvl" : charMultiLevel, "hitdice" : lvlhitdie, "hitdice2" : lvlhitdie2 },
     success: function()
     {
         //if success then just output the text to the status div then clear the form inputs to prepare for new data
       //  $("#favButton").addClass('disabled');
         //$('#favButton').html('In Favourites');
         var newURL = '/tools/users/characters.php?id=' + levelName;
         $(location).attr('href', newURL)
     },
     error: function (jqXHR, status, errorThrown)
     {
         //if fail show error and server status
         $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
     }
 });
};

</script>

<div class=" col-md-4 col-sm-6 col-xs-12">
  <input class="charName" id="charName" value="<?php echo $title; ?>">
 </div>

<div class="col-md-8 col-sm-6 col-xs-12 sidebartext">
  <table style="width: 100%;">
    <tr>
      <td>
        <?php echo ('<div id="charClasses">'.ucwords($fullclass).' '.$mainclasslevel);
        if ($multiclasslevel != 0){
        echo ('/<br />'.ucwords($fullmulticlass).' '.$multiclasslevel.'</div>');
      }
      else {
        echo ('</div>');
      }
        ?>
        <select class="charClassSelect sheetDrop" name="charClass" id="charClass" onchange="classSelect()" style="display:none;">
        <?php
        echo ('<option value="'.$coreclassbare.'" selected>'.$coreclassbare);
        $classtitle = "SELECT name FROM `subclasses` WHERE `name` LIKE '%core%'";
        $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
          $classNameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
            echo ('<option value="'.$classNameClean.'">'.$classNameClean);
          }
          ?>
  </select>
    <?php
        $storeArray = Array();
        $classtitle = "SELECT class FROM `subclasses`";
        $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
          if (!in_array($row1['class'], $storeArray, true)){
            array_push($storeArray, $row1['class']);
          }
        }
      foreach ($storeArray as $item) {
        $itemNS = str_replace(' ', '', $item);
        echo ('<select class="subclassSelect sheetDrop selector" name="'.strtolower($itemNS).'SubList" id="'.strtolower($itemNS).'SubList" onchange="classSelect()>');
        echo ('<option name="currentSubclass" value="'.$subclass.'">'.$subclass);
        $classtitle = "SELECT name, class FROM `subclasses`";
        $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
          if ($row1['class'] == $item) {
          $subclassNameClean = ucwords($row1['name']);
          $subclassNameCleanns = str_replace(' ', '', $subclassNameClean);
          if (strPos($subclassNameClean, " Core") === false){
            echo ('<option value="'.$subclassNameClean);
            if ($subclassNameClean === $subclass){
              echo ('" selected>'.$subclassNameClean);
            }
            else {
                echo ('">'.$subclassNameClean);
            }
          }
          }
      }
      echo ('</select>');
}
      ?>
      <button id="multiButton" class="btn btn-primary" href="#multis" data-toggle="collapse" style="display:none;">Multiclass</button>
<div class="featureDetails collapse" id="multis">
  <select class="charClassSelect sheetDrop" name="charMulti" id="charMulti" onchange="multiSelect()">
  <?php
  echo ('<option value="'.$coremultibare.'" selected>'.$coremultibare);
  $classtitle = "SELECT name FROM `subclasses` WHERE `name` LIKE '%core%'";
  $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
  while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
    $multiNameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
      echo ('<option value="'.$multiNameClean.'">'.$multiNameClean);
    }
    ?>
</select>
<?php
  $multiArray = Array();
  $classtitle = "SELECT class FROM `subclasses`";
  $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
  while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
    if (!in_array($row1['class'], $multiArray, true)){
      array_push($multiArray, $row1['class']);
    }
  }
foreach ($multiArray as $item) {
  $itemNS = str_replace(' ', '', $item);
  echo ('<select class="multisubclassSelect sheetDrop selector" name="'.strtolower($itemNS).'SubList1" id="'.strtolower($itemNS).'SubList1" onchange="multiSelect()">');
  //echo ('<option name="currentSubclass" value="'.$subclass.'">'.$subclass);
  $classtitle = "SELECT name, class FROM `subclasses`";
  $classdata = mysqli_query($dbcon, $classtitle) or die('error getting data');
  while($row1 =  mysqli_fetch_array($classdata, MYSQLI_ASSOC)) {
    if ($row1['class'] == $item) {
    $multisubclassNameClean = ucwords($row1['name']);
    $multisubclassNameCleanns = str_replace(' ', '', $multisubclassNameClean);
    if (strPos($multisubclassNameClean, " Core") === false){
      echo ('<option value="'.$multisubclassNameClean);
      if ($multisubclassNameClean === $multisubclass){
        echo ('" selected>'.$multisubclassNameClean);
      }
      else {
          echo ('">'.$multisubclassNameClean);
      }
    }
    }
}
echo ('</select>');
}
echo ('<select class="sheetDrop selector" name="multiLevel" id="multiLevel" onchange="multiSelect()">');
echo ('<option value="'.$multiclasslevel.'" selected>'.$multiclasslevel);
echo ('<option value="0">Remove Multiclass');

$mltitle = "SELECT level FROM `characters` WHERE title LIKE '$title'";
$mldata = mysqli_query($dbcon, $mltitle) or die('error getting data');
while($mlrow1 =  mysqli_fetch_array($mldata, MYSQLI_ASSOC)) {
  //echo ('<option value="'.$multiclasslevel.'">'.$multiclasslevel);
  $totalLevel = (int)$mlrow1['level'];
  $totalLeveltemp = $totalLevel - 1;
  for ($i=1; $i < $totalLevel; $i++) {
    echo ('<option value="'.$i.'">'.$i);
  }
}
?>
</select>
</div>
</td>



      <td><select class="charClassSelect sheetDrop" name="charLevel" id="charLevel">
          <option value="<?php echo $row['level']; ?>" selected><?php echo $row['level']; ?>
          <option value="1">1
          <option value="2">2
          <option value="3">3
          <option value="4">4
          <option value="5">5
          <option value="6">6
          <option value="7">7
          <option value="8">8
          <option value="9">9
          <option value="10">10
          <option value="11">11
          <option value="12">12
          <option value="13">13
          <option value="14">14
          <option value="15">15
          <option value="16">16
          <option value="17">17
          <option value="18">18
          <option value="19">19
          <option value="20">20
      </select>
</td>
      <td><select class="charClassSelect sheetDrop" name="charAlignment" id="charAlignment">
          <option value="<?php echo $row['alignment']; ?>" selected><?php echo $row['alignment']; ?>
          <option value="Lawful Good">Lawful Good
          <option value="Neutral Good">Neutral Good
          <option value="Chaotic Good">Chaotic Good
          <option value="Lawful Neutral">Lawful Neutral
          <option value="True Neutral">True Neutral
          <option value="Chaotic Neutral">Chaotic Neutral
          <option value="Lawful Evil">Lawful Evil
          <option value="Neutral Evil">Neutral Evil
          <option value="Chaotic Evil">Chaotic Evil
          </select>
          </td>
    <tr>

    <tr style="border-top: 1px solid white;">
      <td><div class="charDeet">Class</div></td>
      <td><div class="charDeet">Level</div></td>
      <td><div class="charDeet">Alignment</div></td>
    </tr>
    <tr>
      <td><select class="charClassSelect sheetDrop selector" name="charRace" id="charRace">
          <?php
          $raceNameNoR = str_replace('(race)', '', $race);
          echo ('<option value="'.$raceNameNoR.'" selected>'.$raceNameNoR);
          $racetitle = "SELECT * FROM `compendium` WHERE `type` LIKE 'race'";
          $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
          while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
            $raceNameNoR = str_replace('(race)', '', $row1['title']);
            $raceNameClean = preg_replace('/[^a-z\d]+/i', '', $raceNameNoR);
              echo ('<option value="'.$raceNameNoR.'">'.$raceNameNoR);
            }
            ?>
    </select>
      </td>
      <td><select class="charClassSelect sheetDrop selector" name="charBackgroundSelect" id="charBackground">
        <?php
        echo ('<option value="'.$bgbare.'" selected>'.$bgbare);
        $bgtitle = "SELECT title FROM `compendium` WHERE `type` LIKE 'background'";
        $bgdata = mysqli_query($dbcon, $bgtitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($bgdata, MYSQLI_ASSOC)) {
          $bgNameNoBG = str_replace('(background)', '', $row1['title']);
          $bgNameClean = preg_replace('/[^a-z\d]+/i', '', $bgNameNoBG);
            echo ('<option value="'.$bgNameNoBG.'">'.$bgNameNoBG);
          }
          ?>
  </select>
      </td>
    </tr>
    <tr  style="border-top: 1px solid white;">
      <td><div class="charDeet">Race</div></td>
      <td><div class="charDeet">Background</div></td>
    </tr>
  </table>
</div>

<script>

$(document).ready(function (){
  var selectedClass = $('#charClass').val();
  classPrep = selectedClass.toLowerCase();
  classPrep = classPrep.replace(/ +/g, "");
  var subID = classPrep + 'SubList';
  var hideAll = document.getElementsByClassName('subclassSelect');
 for (var i = 0; i < hideAll.length; i++ ) {
    hideAll[i].style.display = "none";
}
  //document.getElementById(subID).style = "display:inline-block";
  document.getElementById(subID).disabled = "true";

});

function classSelect(){
  var selectedClass = $('#charClass').val();
  classPrep = selectedClass.toLowerCase();
  classPrep = classPrep.replace(/ +/g, "");

  var subID = classPrep + 'SubList';
  var hideAll = document.getElementsByClassName('subclassSelect');
 for (var i = 0; i < hideAll.length; i++ ) {
    hideAll[i].style.display = "none";
}
  document.getElementById(subID).style = "display:inline-block";
  //document.getElementById('currentSpells').innerHTML = "";
  document.getElementById('spellsShow').style = "display:none";
  document.getElementById('spellWarning').style = "display:block";

};
</script>
<script>
function multiSelect(){
  var selectedClass = $('#charMulti').val();
  classPrep = selectedClass.toLowerCase();
  classPrep = classPrep.replace(/ +/g, "");

  var subID = classPrep + 'SubList1';
  var hideAll = document.getElementsByClassName('multisubclassSelect');
 for (var i = 0; i < hideAll.length; i++ ) {
    hideAll[i].style.display = "none";
}
  document.getElementById(subID).style = "display:inline-block";
  document.getElementById('multiLevel').style = "display:inline-block";
  //document.getElementById('currentSpells').innerHTML = "";
  document.getElementById('spellsShow').style = "display:none";
  document.getElementById('spellWarning').style = "display:block";

};

</script>

 <?php
}
  ?>

  <div class="body sidebartext col-xs-12" id="body" style="margin-top: 10px;">

    <!-- Body Text -->
      <?php
        $worldtitle = "SELECT * FROM `characters` WHERE `title` LIKE '$id'";
        $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
        while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {

          $strmod = floor((($row['str']-10)/2));
          $dexmod = floor((($row['dex']-10)/2));
          $conmod = floor((($row['con']-10)/2));
          $intelmod = floor((($row['intel']-10)/2));
          $wismod = floor((($row['wis']-10)/2));
          $chamod = floor((($row['cha']-10)/2));
          $level = $row['level'];
          $multiclasslevel = (int)$row['class2lvl'];
          $mainclasslevel = (int)$level - $multiclasslevel;


          if ($row['level'] >= 1 && $row['level'] <= 4) {
            $profbonus = 2;
          }
          if ($row['level'] >= 5 && $row['level'] <= 8) {
            $profbonus = 3;
          }
          if ($row['level'] >= 9 && $row['level'] <= 12) {
            $profbonus = 4;
          }
          if ($row['level'] >= 13 && $row['level'] <= 16) {
            $profbonus = 5;
          }
          if ($row['level'] >= 17 && $row['level'] <= 20) {
            $profbonus = 6;
          }

          ?>
          <div class="col-md-4 col-sm-6 col-xs-12" name="mainBlock" id="statsBlock">

            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="strBox">
              <input class="statScore" id="strScore" value="<?php echo $row['str']; ?>"></input>
              <div class="statMod" id="strMod"><?php echo $strmod; ?></div>
              <div class="statName" id="strName" onclick="abilityCheck('str<?php echo $strmod; ?>')">Strength</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="strSaveProf" type="checkbox" onclick="addStrProf('strSave')"></input>
              <input type="checkbox" class="expertRadio" id="strSaveExpert" onclick="addStrProf('strSave')"></input><input class="prof" id="strSaveVal" value="<?php echo $strmod; ?>" disabled></input><span class="profName" id="strSaveName" onclick="profRoll('strSaveVal')"><b>Saving Throw</b></div>

            <div class="statProf"><input class="profRadio" id="athleticsProf" type="checkbox" onclick="addStrProf('athletics')"></input>
              <input type="checkbox" class="expertRadio" id="athleticsExpert" onclick="addStrProf('athletics')"></input><input class="prof" id="athleticsVal" value="<?php echo $strmod; ?>" disabled></input><span class="profName" id="athleticsName" onclick="profRoll('athleticsVal')">Athletics</div>
          </div>
        </div>
            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="dexBox">
              <input class="statScore" id="dexScore" value="<?php echo $row['dex']; ?>"></input>
              <div class="statMod" id="dexMod"><?php echo $dexmod; ?></div>
              <div class="statName" id="dexName" onclick="abilityCheck('dex<?php echo $dexmod; ?>')">Dexterity</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="dexSaveProf" type="checkbox" onclick="addDexProf('dexSave')"></input>
              <input type="checkbox" class="expertRadio" id="dexSaveExpert" onclick="addDexProf('dexSave')"></input><input class="prof" id="dexSaveVal" value="<?php echo $dexmod; ?>" disabled></input><span class="profName" id="dexSaveName" onclick="profRoll('dexSaveVal')"><b>Saving Throw</b></div>

            <div class="statProf"><input class="profRadio" id="acrobaticsProf" type="checkbox" onclick="addDexProf('acrobatics')"></input>
              <input type="checkbox" class="expertRadio" id="acrobaticsExpert" onclick="addDexProf('acrobatics')"></input><input class="prof" id="acrobaticsVal" value="<?php echo $dexmod; ?>" disabled></input><span class="profName" id="acrobaticsName" onclick="profRoll('acrobaticsVal')">Acrobatics</div>

            <div class="statProf"><input class="profRadio" id="sleightProf" type="checkbox" onclick="addDexProf('sleight')"></input>
              <input type="checkbox" class="expertRadio" id="sleightExpert" onclick="addDexProf('sleight')"></input><input class="prof" id="sleightVal" value="<?php echo $dexmod; ?>" disabled></input><span class="profName" id="sleightName" onclick="profRoll('sleightVal')">Sleight of Hand</div>

            <div class="statProf"><input class="profRadio" id="stealthProf" type="checkbox" onclick="addDexProf('stealth')"></input>
              <input type="checkbox" class="expertRadio" id="stealthExpert" onclick="addDexProf('stealth')"></input><input class="prof" id="stealthVal" value="<?php echo $dexmod; ?>" disabled></input><span class="profName" id="stealthName" onclick="profRoll('stealthVal')">Stealth</div>

          </div>
          </div>
            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="conBox">
              <input class="statScore" id="conScore" value="<?php echo $row['con']; ?>"></input>
              <div class="statMod" id="conMod"><?php echo $conmod; ?></div>
              <div class="statName" id="conName" onclick="abilityCheck('con<?php echo $conmod; ?>')">Constitution</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="conSaveProf" type="checkbox" onclick="addConProf('conSave')"></input>
              <input type="checkbox" class="expertRadio" id="conSaveExpert" onclick="addConProf('conSave')"></input><input class="prof" id="conSaveVal" value="<?php echo $conmod; ?>" disabled></input><span class="profName" id="conSaveName" onclick="profRoll('conSaveVal')"><b>Saving Throw</b></div>
          </div>
        </div>

            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="intBox">
              <input class="statScore" id="intScore" value="<?php echo $row['intel']; ?>"></input>
              <div class="statMod" id="intMod"><?php echo $intelmod; ?></div>
              <div class="statName" id="intName" onclick="abilityCheck('int<?php echo $intelmod; ?>')">Intelligence</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="intelSaveProf" type="checkbox" onclick="addIntelProf('intelSave')"></input>
              <input type="checkbox" class="expertRadio" id="intelSaveExpert" onclick="addIntelProf('intelSave')"></input><input class="prof" id="intelSaveVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="intelSaveName" onclick="profRoll('intelSaveVal')"><b>Saving Throw</b></div>

            <div class="statProf"><input class="profRadio" id="arcanaProf" type="checkbox" onclick="addIntelProf('arcana')"></input>
              <input type="checkbox" class="expertRadio" id="arcanaExpert" onclick="addIntelProf('arcana')"></input><input class="prof" id="arcanaVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="arcanaName" onclick="profRoll('arcanaVal')">Arcana</div>

            <div class="statProf"><input class="profRadio" id="historyProf" type="checkbox" onclick="addIntelProf('history')"></input>
              <input type="checkbox" class="expertRadio" id="historyExpert" onclick="addIntelProf('history')"></input><input class="prof" id="historyVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="historyName" onclick="profRoll('historyVal')">History</div>

            <div class="statProf"><input class="profRadio" id="investigationProf" type="checkbox" onclick="addIntelProf('investigation')"></input>
              <input type="checkbox" class="expertRadio" id="investigationExpert" onclick="addIntelProf('investigation')"></input><input class="prof" id="investigationVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="investigationName" onclick="profRoll('investigationVal')">Investigation</div>

            <div class="statProf"><input class="profRadio" id="natureProf" type="checkbox" onclick="addIntelProf('nature')"></input>
              <input type="checkbox" class="expertRadio" id="natureExpert" onclick="addIntelProf('nature')"></input><input class="prof" id="natureVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="natureName" onclick="profRoll('natureVal')">Nature</div>

            <div class="statProf"><input class="profRadio" id="religionProf" type="checkbox" onclick="addIntelProf('religion')"></input>
              <input type="checkbox" class="expertRadio" id="religionExpert" onclick="addIntelProf('religion')"></input><input class="prof" id="religionVal" value="<?php echo $intelmod; ?>" disabled></input><span class="profName" id="religionName" onclick="profRoll('religionVal')">Religion</div>
          </div>
        </div>

            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="wisBox">
              <input class="statScore" id="wisScore" value="<?php echo $row['wis']; ?>"></input>
              <div class="statMod" id="wisMod"><?php echo $wismod; ?></div>
              <div class="statName" id="wisName" onclick="abilityCheck('wis<?php echo $wismod; ?>')">Wisdom</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="wisSaveProf" type="checkbox" onclick="addWisProf('wisSave')"></input>
              <input type="checkbox" class="expertRadio" id="wisSaveExpert" onclick="addWisProf('wisSave')"></input><input class="prof" id="wisSaveVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="wisSaveName" onclick="profRoll('wisSaveVal')"><b>Saving Throw</b></span></div>

            <div class="statProf"><input class="profRadio" id="animalProf" type="checkbox" onclick="addWisProf('animal')"></input>
              <input type="checkbox" class="expertRadio" id="animalExpert" onclick="addWisProf('animal')"></input><input class="prof" id="animalVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="animalName" onclick="profRoll('animalVal')">Animal Handling</div>

            <div class="statProf"><input class="profRadio" id="insightProf" type="checkbox" onclick="addWisProf('insight')"></input>
              <input type="checkbox" class="expertRadio" id="insightExpert" onclick="addWisProf('insight')"></input><input class="prof" id="insightVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="insightName" onclick="profRoll('insightVal')">Insight</div>

            <div class="statProf"><input class="profRadio" id="medicineProf" type="checkbox" onclick="addWisProf('medicine')"></input>
              <input type="checkbox" class="expertRadio" id="medicineExpert" onclick="addWisProf('medicine')"></input><input class="prof" id="medicineVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="medicineName" onclick="profRoll('medicineVal')">Medicine</div>

            <div class="statProf"><input class="profRadio" id="perceptionProf" type="checkbox" onclick="addWisProf('perception')"></input>
              <input type="checkbox" class="expertRadio" id="perceptionExpert" onclick="addWisProf('perception')"></input><input class="prof" id="perceptionVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="perceptionName" onclick="profRoll('perceptionVal')">Perception</div>

            <div class="statProf"><input class="profRadio" id="survivalProf" type="checkbox" onclick="addWisProf('survival')"></input>
              <input type="checkbox" class="expertRadio" id="survivalExpert" onclick="addWisProf('survival')"></input><input class="prof" id="survivalVal" value="<?php echo $wismod; ?>" disabled></input><span class="profName" id="survivalName" onclick="profRoll('survivalVal')">Survival</div>
          </div>
        </div>

            <div class="row fullStatBox">
            <div class="statBox col-xs-5" id="chaBox">
              <input class="statScore" id="chaScore" value="<?php echo $row['cha']; ?>"></input>
              <div class="statMod" id="chaMod"><?php echo $chamod; ?></div>
              <div class="statName" id="chaName" onclick="abilityCheck('cha<?php echo $chamod; ?>')">Charisma</div>
            </div>

          <div class="statProfs col-xs-7">
            <div class="statProf"><input class="profRadio" id="chaSaveProf" type="checkbox" onclick="addChaProf('chaSave');"></input>
              <input type="checkbox" class="expertRadio" id="chaSaveExpert" onclick="addChaProf('chaSave');"></input><input class="prof" id="chaSaveVal" value="<?php echo $chamod; ?>" disabled></input><span class="profName" id="chaSaveName" onclick="profRoll('chaSaveVal')"><b>Saving Throw</b></div>

            <div class="statProf"><input class="profRadio" id="deceptionProf" type="checkbox" onclick="addChaProf('deception');"></input>
              <input type="checkbox" class="expertRadio" id="deceptionExpert" onclick="addChaProf('deception');"></input><input class="prof" id="deceptionVal" value="<?php echo $chamod; ?>" disabled></input><span class="profName" id="deceptionName" onclick="profRoll('deceptionVal')">Deception</div>

            <div class="statProf"><input class="profRadio" id="intimidationProf" type="checkbox" onclick="addChaProf('intimidation');"></input>
              <input type="checkbox" class="expertRadio" id="intimidationExpert" onclick="addChaProf('intimidation');"></input><input class="prof" id="intimidationVal" value="<?php echo $chamod; ?>" disabled></input><span class="profName" id="intimidationName" onclick="profRoll('intimidationVal')">Intimidation</div>

            <div class="statProf"><input class="profRadio" id="performanceProf" type="checkbox" onclick="addChaProf('performance');"></input>
              <input type="checkbox" class="expertRadio" id="performanceExpert" onclick="addChaProf('performance');"></input><input class="prof" id="performanceVal" value="<?php echo $chamod; ?>" disabled></input><span class="profName" id="performanceName" onclick="profRoll('performanceVal')">Performance</div>

            <div class="statProf"><input class="profRadio" id="persuasionProf" type="checkbox" onclick="addChaProf('persuasion');"></input>
              <input type="checkbox" class="expertRadio" id="persuasionExpert" onclick="addChaProf('persuasion');"></input><input class="prof" id="persuasionVal" value="<?php echo $chamod; ?>" disabled></input><span class="profName" id="persuasionName" onclick="profRoll('persuasionVal')">Persuasion</div>
          </div>
        </div>
        </div>


        <!-- VITALS BLOCKS -->

        <div class="roundBorder col-md-4 col-sm-6 col-xs-12 sidebartext sheetBlock" name="mainBlock" id="vitalsBlock">
          <table class="vitalsTable">
            <tr>
              <td><input class="vitals" id="initiative" value="<?php echo $dexmod; ?>"></td>
              <td rowspan="3"><input class="vitals bigVital" id="maxHP" value="<?php echo $row['maxhp']; ?>"></td>
              <td><div class="col-centered" id="hitDice"></div></td>
            </tr>
            <tr>
              <td><div class="charDeet profName" id="initiativeName" onclick="profRoll('initiative')">Initiative</div></td>
              <td><div class="charDeet">Hit Dice</div></td>
            </tr>
            <tr>
              <td><input class="vitals" id="speed" value="<?php echo $row['speed']; ?>"></td>
              <td><input class="vitals" id="armorClass" value="<?php echo $row['armorclass']; ?>"></td>
            </tr>
            <tr>
              <td><div class="charDeet">Speed</div></td>
              <td><div class="charDeet">Max HP</div></td>
              <td><div class="charDeet">AC</div></td>
            </tr>
            <tr>
              <td><input id="currentlp" class="vitals1" onkeyup="tracking()" value="<?php echo $row['currentlp']; ?>"></td>
              <td class="col-centered"><input id="currenthp" class="vitals1 bigvital" onkeyup="tracking()" value="<?php echo $row['currenthp']; ?>"></td>
              <td><input id="temphp" class="vitals1" onkeyup="tracking()" value="<?php echo $row['temphp']; ?>"></td>
            </tr>
            <tr>
              <td><div class="charDeet">LP</div></td>
              <td><div class="charDeet">HP</div></td>
              <td><div class="charDeet">Temp HP</div></td>
            </tr>
          </table>

          <table style="width:100%;">
            <?php
            if ($coreclassbare == 'Warlock' || strpos($subclass, 'Profane Soul') !== false) { ?>
              <tr class="col-centered col-xs-12">
                <td class="slotcell" style="border-left: 1px solid white;">Slots</td>
                <td class="slotcell">Slot Level</td>
              </tr>

              <tr class="bigt col-centered col-xs-12"> <?php
            }
            else if ($coreclassbare == 'Mystic'){ ?>
              <tr class="col-centered col-xs-12">
                <td class="slotcell" style="border-left: 1px solid white;">Psi Points</td>
                <td class="slotcell">Psi Limit</td>
              </tr>

              <tr class="bigt col-centered col-xs-12"> <?php
            }
            else {
              ?>
            <tr class="col-centered col-xs-12">
              <td class="slotcell" style="border-left: 1px solid white;">1st</td>
              <td class="slotcell">2nd</td>
              <td class="slotcell">3rd</td>
              <td class="slotcell">4th</td>
              <td class="slotcell">5th</td>
              <td class="slotcell">6th</td>
              <td class="slotcell">7th</td>
              <td class="slotcell">8th</td>
              <td class="slotcell">9th</td>
            </tr>

            <tr class="bigt col-centered col-xs-12">
              <?php
            }
             if (strpos($subclass, 'Profane Soul') !== false){
               $spellsub = 'Profane';
             }
             else if (strpos($subclass, 'Arcane Trickster') !== false){
               $spellsub = 'Trickster';
             }
             else if (strpos($subclass, 'Eldritch Knight') !== false){
               $spellsub = 'Knight';
             }
             else {
               $spellsub = $coreclassbare;
             }
              $worldtitle1 = "SELECT * FROM `classtable` WHERE `class` LIKE '$spellsub'";
              $titledata1 = mysqli_query($dbcon, $worldtitle1) or die('error getting data');
              while($row1 =  mysqli_fetch_array($titledata1, MYSQLI_ASSOC)) {
                $checktable = str_replace($row1['class'], '', $row1['name']);
                if ($checktable == $mainclasslevel) {
                  $lockslot1 = $row1['spelllvl1'];
                  $lockslot2 = $row1['spelllvl2'];
                  $mysticslot1 = $row1['spelllvl3'];
                  $mysticslot2 = $row1['spelllvl4'];
                  echo ('<div id="defaultslots" style="display:none;">'.$row1['spelllvl1'].','.$row1['spelllvl2'].','.$row1['spelllvl3'].','.$row1['spelllvl4'].','.$row1['spelllvl5'].','.$row1['spelllvl6'].','.$row1['spelllvl7'].','.$row1['spelllvl8']);
                  echo (','.$row1['spelllvl9'].'</div>');
                  if ($coreclassbare == 'Warlock' || strpos($subclass, 'Profane Soul') !== false) { ?>
                    <td class="slotcell" style="border-left: 1px solid white;"><input class="vitals1" onkeyup="tracking()" style="width:50px;" type="text" id="lockslot1" value="<?php echo $row1['spelllvl1']; ?>"></td>
                    <td class="slotcell"><input class="vitals1" onkeyup="tracking()" style="width:50px;" type="text" id="lockslot2" value="<?php echo $row1['spelllvl2']; ?>">
                      <input class="hide" id="lockslot3">
                      <input class="hide" id="lockslot4">
                      <input class="hide" id="lockslot5">
                      <input class="hide" id="lockslot6">
                      <input class="hide" id="lockslot7">
                      <input class="hide" id="lockslot8">
                      <input class="hide" id="lockslot9">
                    </td>

                  <?php
                }
               else if ($coreclassbare == 'Mystic') { ?>
                  <td class="slotcell" style="border-left: 1px solid white;"><input class="vitals1" onkeyup="tracking()" style="width:50px;" type="text" id="mysticslot1" value="<?php echo $row1['spelllvl3']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" style="width:50px;" type="text" id="mysticslot2" value="<?php echo $row1['spelllvl4']; ?>">
                  <input class="hide" id="mysticslot3">
                  <input class="hide" id="mysticslot4">
                  <input class="hide" id="mysticslot5">
                  <input class="hide" id="mysticslot6">
                  <input class="hide" id="mysticslot7">
                  <input class="hide" id="mysticslot8">
                  <input class="hide" id="mysticslot9">
                  </td>

                <?php
              }
                  else {
                  ?>
                  <td class="slotcell" style="border-left: 1px solid white;"><input class="vitals1" onkeyup="tracking()" id="spellslot1" type="text"value="<?php echo $row1['spelllvl1']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot2" type="text"value="<?php echo $row1['spelllvl2']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot3" type="text"value="<?php echo $row1['spelllvl3']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot4" type="text"value="<?php echo $row1['spelllvl4']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot5" type="text"value="<?php echo $row1['spelllvl5']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot6" type="text"value="<?php echo $row1['spelllvl6']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot7" type="text"value="<?php echo $row1['spelllvl7']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot8" type="text"value="<?php echo $row1['spelllvl8']; ?>"></td>
                  <td class="slotcell"><input class="vitals1" onkeyup="tracking()" id="spellslot9" type="text"value="<?php echo $row1['spelllvl9']; ?>"></td>

                   <?php
                 }
               }
            }

               ?>

            </tr>
          </table>
        </div>


      <!-- CLASS FEATURES -->
      <div class="roundBorder col-md-4 col-sm-6 col-xs-12 sidebartext sheetBlock floatright" name="mainBlock" id="abilitiesBlock" style="float:right; min-height:225px;">
        <div style="margin-bottom: 5px; border-bottom:1px solid white;">Abilities</div>

        <?php
        $coreclass = substr($fullclass, 0, strpos($fullclass, "(") -1);
        $subclasstemp = substr($fullclass, strpos($fullclass, "(") +1);
        $coremulticlass = substr($fullmulticlass, 0, strpos($fullmulticlass, "(") -1);
        $multisubclasstemp = substr($fullmulticlass, strpos($fullmulticlass, "(") +1);
        $subclass = trim($subclasstemp, ')');
        $coreclass = $coreclass.' core';
        $multisubclass = trim($multisubclasstemp, ')');
        $coremulticlass = $coremulticlass.' core';

//ABILITIES
//CLASS ABILITIES
          $worldtitle = "SELECT * FROM `subclasses` WHERE name LIKE '$coreclass'";
          $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
          while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
            ?>

            <!-- LEVEL 1 -->
            <?php
            if ($mainclasslevel >= 1) {
            foreach($row as $column=>$field) {
              if (strpos($field, ' 1st level') !== false) {
                $featuretitle = str_replace('text', 'name', $column);
                $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
                $featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


                echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
                echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
              }
            }
          }
      ?>

      <!-- LEVEL 2 -->
      <?php
      if ($mainclasslevel >= 2) {
      foreach($row as $column=>$field) {
        if (strpos($field, ' 2nd level') !== false && strpos($field, ' 1st level') == false) {
          $featuretitle = str_replace('text', 'name', $column);
          $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


          echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
          echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
      }
    }
  }
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 3) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 3rd level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 4) {
foreach($row as $column=>$field) {
if (strpos($field, ' 4th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 5) {
foreach($row as $column=>$field) {
if (strpos($field, ' 5th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 6) {
foreach($row as $column=>$field) {
if (strpos($field, ' 6th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');

}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 7) {
foreach($row as $column=>$field) {
if (strpos($field, ' 7th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 8) {
foreach($row as $column=>$field) {
if (strpos($field, ' 8th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 9) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 9th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 10) {
foreach($row as $column=>$field) {
if (strpos($field, ' 10th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 11) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 11th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 12) {
foreach($row as $column=>$field) {
if (strpos($field, ' 12th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 13) {
foreach($row as $column=>$field) {
if (strpos($field, ' 13th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 14) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 14th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 15) {
foreach($row as $column=>$field) {
if (strpos($field, ' 15th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 16) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 16th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 17) {
foreach($row as $column=>$field) {
if (strpos($field, ' 17th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 18) {
foreach($row as $column=>$field) {
  if (strpos($field, ' 18th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 19) {
foreach($row as $column=>$field) {
if (strpos($field, ' 19th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($mainclasslevel >= 20) {
foreach($row as $column=>$field) {
if (strpos($field, ' 20th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false && strpos($field, ' 19th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}


?>

            <?php
          }
          echo ('<hr>');
          $worldtitle = "SELECT * FROM `subclasses` WHERE `name` LIKE '$subclass'";
          $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
          while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
            ?>

            <!-- LEVEL 1 -->
            <?php
            if ($mainclasslevel >= 1) {
            foreach($row as $column=>$field) {
              if (strpos($field, ' 1st level') !== false) {
                $featuretitle = str_replace('text', 'name', $column);
                $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


                echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
                echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
              }
            }
          }
      ?>

      <!-- LEVEL 2 -->
      <?php
      if ($mainclasslevel >= 2) {
      foreach($row as $column=>$field) {
        if (strpos($field, ' 2nd level') !== false && strpos($field, ' 1st level') == false) {
          $featuretitle = str_replace('text', 'name', $column);
          $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


          echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
          echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
      }
    }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 3) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 3rd level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 4) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 4th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 5) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 5th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 6) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 6th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');

  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 7) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 7th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    $featuretitlens = str_replace('(', '', $featuretitlens);
    $featuretitlens = str_replace(')', '', $featuretitlens);
    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 8) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 8th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 9) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 9th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 10) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 10th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 11) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 11th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 12) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 12th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 13) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 13th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 14) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 14th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 15) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 15th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 16) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 16th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 17) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 17th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 18) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 18th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 19) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 19th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }
  ?>

  <!-- LEVEL 3 -->
  <?php
  if ($mainclasslevel >= 20) {
  foreach($row as $column=>$field) {
  if (strpos($field, ' 20th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false && strpos($field, ' 19th level') == false) {
    $featuretitle = str_replace('text', 'name', $column);
    $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);
    echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
    echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
  }
  }
  }


  ?>
            <?php
          }


//MULTICLASS ABILITIES
if ($fullmulticlass !== '') {
  echo ('<hr>');
}
$worldtitle = "SELECT * FROM `subclasses` WHERE name LIKE '$coremulticlass'";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  ?>

  <!-- LEVEL 1 -->
  <?php
  if ($multiclasslevel >= 1) {
  foreach($row as $column=>$field) {
    if (strpos($field, ' 1st level') !== false) {
      $featuretitle = str_replace('text', 'name', $column);
      $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
      $featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


      echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
    }
  }
}
?>

<!-- LEVEL 2 -->
<?php
if ($multiclasslevel >= 2) {
foreach($row as $column=>$field) {
if (strpos($field, ' 2nd level') !== false && strpos($field, ' 1st level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 3) {
foreach($row as $column=>$field) {
if (strpos($field, ' 3rd level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 4) {
foreach($row as $column=>$field) {
if (strpos($field, ' 4th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 5) {
foreach($row as $column=>$field) {
if (strpos($field, ' 5th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 6) {
foreach($row as $column=>$field) {
if (strpos($field, ' 6th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');

}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 7) {
foreach($row as $column=>$field) {
if (strpos($field, ' 7th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 8) {
foreach($row as $column=>$field) {
if (strpos($field, ' 8th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 9) {
foreach($row as $column=>$field) {
if (strpos($field, ' 9th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 10) {
foreach($row as $column=>$field) {
if (strpos($field, ' 10th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 11) {
foreach($row as $column=>$field) {
if (strpos($field, ' 11th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 12) {
foreach($row as $column=>$field) {
if (strpos($field, ' 12th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 13) {
foreach($row as $column=>$field) {
if (strpos($field, ' 13th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 14) {
foreach($row as $column=>$field) {
if (strpos($field, ' 14th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 15) {
foreach($row as $column=>$field) {
if (strpos($field, ' 15th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 16) {
foreach($row as $column=>$field) {
if (strpos($field, ' 16th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 17) {
foreach($row as $column=>$field) {
if (strpos($field, ' 17th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 18) {
foreach($row as $column=>$field) {
if (strpos($field, ' 18th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 19) {
foreach($row as $column=>$field) {
if (strpos($field, ' 19th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 20) {
foreach($row as $column=>$field) {
if (strpos($field, ' 20th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false && strpos($field, ' 19th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].' ('.$row['class'].')</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}


?>

  <?php
}
if ($fullmulticlass !== '') {
  echo ('<hr>');
}
$worldtitle = "SELECT * FROM `subclasses` WHERE `name` LIKE '$multisubclass'";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  ?>

  <!-- LEVEL 1 -->
  <?php
  if ($multiclasslevel >= 1) {
  foreach($row as $column=>$field) {
    if (strpos($field, ' 1st level') !== false) {
      $featuretitle = str_replace('text', 'name', $column);
      $featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


      echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
      echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
    }
  }
}
?>

<!-- LEVEL 2 -->
<?php
if ($multiclasslevel >= 2) {
foreach($row as $column=>$field) {
if (strpos($field, ' 2nd level') !== false && strpos($field, ' 1st level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 3) {
foreach($row as $column=>$field) {
if (strpos($field, ' 3rd level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 4) {
foreach($row as $column=>$field) {
if (strpos($field, ' 4th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 5) {
foreach($row as $column=>$field) {
if (strpos($field, ' 5th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 6) {
foreach($row as $column=>$field) {
if (strpos($field, ' 6th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');

}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 7) {
foreach($row as $column=>$field) {
if (strpos($field, ' 7th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


$featuretitlens = str_replace('(', '', $featuretitlens);
$featuretitlens = str_replace(')', '', $featuretitlens);
echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 8) {
foreach($row as $column=>$field) {
if (strpos($field, ' 8th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 9) {
foreach($row as $column=>$field) {
if (strpos($field, ' 9th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 10) {
foreach($row as $column=>$field) {
if (strpos($field, ' 10th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 11) {
foreach($row as $column=>$field) {
if (strpos($field, ' 11th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 12) {
foreach($row as $column=>$field) {
if (strpos($field, ' 12th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 13) {
foreach($row as $column=>$field) {
if (strpos($field, ' 13th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 14) {
foreach($row as $column=>$field) {
if (strpos($field, ' 14th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 15) {
foreach($row as $column=>$field) {
if (strpos($field, ' 15th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 16) {
foreach($row as $column=>$field) {
if (strpos($field, ' 16th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 17) {
foreach($row as $column=>$field) {
if (strpos($field, ' 17th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 18) {
foreach($row as $column=>$field) {
if (strpos($field, ' 18th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 19) {
foreach($row as $column=>$field) {
if (strpos($field, ' 19th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);


echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}
?>

<!-- LEVEL 3 -->
<?php
if ($multiclasslevel >= 20) {
foreach($row as $column=>$field) {
if (strpos($field, ' 20th level') !== false && strpos($field, ' 1st level') == false && strpos($field, ' 2nd level') == false && strpos($field, ' 3rd level') == false && strpos($field, ' 4th level') == false && strpos($field, ' 5th level') == false && strpos($field, ' 6th level') == false && strpos($field, ' 7th level') == false && strpos($field, ' 8th level') == false && strpos($field, ' 9th level') == false && strpos($field, ' 10th level') == false && strpos($field, ' 11th level') == false && strpos($field, ' 12th level') == false && strpos($field, ' 13th level') == false && strpos($field, ' 14th level') == false && strpos($field, ' 15th level') == false && strpos($field, ' 16th level') == false && strpos($field, ' 17th level') == false && strpos($field, ' 18th level') == false && strpos($field, ' 19th level') == false) {
$featuretitle = str_replace('text', 'name', $column);
$featuretitlens = str_replace(' ', '', $row[$featuretitle]);
$featuretitlens = preg_replace('/[^a-z\d]+/i', '_', $featuretitlens);
echo ('<a class="featureName" data-toggle="collapse" href="#'.$featuretitlens.'show">'.$row[$featuretitle].'</a><br />');
echo ('<div class="featureDetails collapse" id="'.$featuretitlens.'show" name="'.$featuretitlens.'show">'.nl2br($field).'</div>');
}
}
}


?>
  <?php
}



          //BACKGROUND TRAITS
          echo ('<hr>');
          $bgtitle = "SELECT title, backgroundTraits FROM `compendium` WHERE `title` LIKE '$background' OR `title` LIKE '$background(background)'";
          $bgdata = mysqli_query($dbcon, $bgtitle) or die('error getting data');
          while($bgrow =  mysqli_fetch_array($bgdata, MYSQLI_ASSOC)) {
            if (strpos($bgrow['title'], '(background)') !== false) {
            $bgName = substr($bgrow['title'], 0, strpos($bgrow['title'], "("));
          }
            else {
              $bgName = $bgrow['title'];
            }
          echo ('<a class="featureName" data-toggle="collapse" href="#backgroundshow">'.$bgName.' (Background)</a><br />');
          $bgTemp = substr($bgrow['backgroundTraits'], strpos($bgrow['backgroundTraits'], "*") -1);
          $bgTemp = substr($bgTemp, 0, strpos($bgTemp, "**Personality"));
          echo ('<div class="featureDetails collapse" id="backgroundshow" name="backgroundshow">'.$Parsedown->text(nl2br($bgTemp)).'</div>');
          }


         //RACIAL TRAITS
         echo ('<hr>');
         $racetitle = "SELECT title, raceTraits FROM `compendium` WHERE `title` LIKE '$race' OR `title` LIKE '$race(race)'";
         $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
         while($racerow =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
           if (strpos($racerow['title'], '(race)') !== false) {
           $raceName = substr($racerow['title'], 0, strpos($racerow['title'], "("));
         }
           else {
             $raceName = $racerow['title'];
           }
         echo ('<a class="featureName" data-toggle="collapse" href="#raceshow">'.$raceName.' (Race)</a><br />');
         $raceTemp = $racerow['raceTraits'];
         echo ('<div class="featureDetails collapse" id="raceshow" name="raceshow">'.$Parsedown->text(nl2br($raceTemp)).'</div>');
         }

         //FEATS
         $featcount = 0;
         if ($allfeats == '' || $allfeats == ','){

         }
         else {
           echo ('<hr>');
         }
         $racetitle = "SELECT title, text FROM `compendium` WHERE `type` LIKE 'feat'";
         $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
         while($racerow =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
           $featarray = explode(",", $allfeats);
           $feattitlespec = str_replace('\'', '_', $racerow['title']);
           foreach ($featarray as $feat) {
             $feattitlespec = str_replace('\'', '_', $feat);
             if ($racerow['title'] == $feattitlespec){
               echo ('<a class="featureName" data-toggle="collapse" href="#raceshow'.$featcount.'">'.$racerow['title'].' (Feat)</a><br />');
               echo ('<div class="featureDetails collapse" id="raceshow'.$featcount.'" name="raceshow">'.$Parsedown->text(nl2br($racerow['text'])).'</div>');
               $featcount = $featcount + 1;
             }
           }
           /*if (strpos($racerow['title'], '(race)') !== false) {
           $raceName = substr($racerow['title'], 0, strpos($racerow['title'], "("));
         }
           else {
             $raceName = $racerow['title'];
           }*/

         }
        ?>

        <button id="featButton" style="display:none;" class="btn btn-info" data-toggle="collapse" href="#addFeat">Feats</button>

          <div class="featureDetails collapse" id="addFeat">

                <table id="feats" class="table table-condensed table-striped table-responsive dt-responsive" cellspacing="0" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php

//FEATS
                $feattitle = "SELECT * FROM `compendium` WHERE `type` LIKE 'feat'";
                $featdata = mysqli_query($dbcon, $feattitle) or die('error getting data');
                while($featrow =  mysqli_fetch_array($featdata, MYSQLI_ASSOC)) {
                    //$featuretitle = str_replace('text', 'name', $column);
                    $feattitlens = str_replace(' ', '', $featrow['title']);
                    $feattitlespec = str_replace('\'', '_', $featrow['title']);
                    $feattitlens = preg_replace('/[^a-z\d]+/i', '_', $feattitlens);
                      echo ('<tr><td><input type="checkbox" id="'.$feattitlens.'Box" onclick="featList(\''.$feattitlespec.'\')"></input></td>');
                      echo ('<td><a class="featureName" data-toggle="collapse" href="#'.$feattitlens.'show">'.$featrow['title'].'</a></td>');
                      echo ('</tr><tr></tr>');
                      echo ('<tr><td colspan="3"><div class="featureDetails collapse" id="'.$feattitlens.'show" name="'.$feattitlens.'show">');
                      echo (nl2br($featrow['text']).'</div></tr>');
                  }

            ?>
            </tbody>
            </table>

            </div>




        </div>

        <div class="roundBorder col-md-4 col-sm-6 col-xs-12 sidebartext sheetBlock" style="padding:0px; border:0px;">

          <div class="roundBorder col-xs-12 sidebartext sheetBlock" name="mainBlock" id="itemsBlock" style="margin-top:10px;" style="float:right;">
            <div style="margin-bottom: 5px; border-bottom:1px solid white;">Items</div>
            <div id="itemSearchBox" style="display:none;">
            <select id="itemSearch">
            <option value=""></option>
            <?php

            $searchdrop = "SELECT title FROM compendium WHERE type LIKE 'item'";
            $searchdata = mysqli_query($dbcon, $searchdrop) or die('error getting data');
            while($searchrow =  mysqli_fetch_array($searchdata, MYSQLI_ASSOC)) {
              $search = $searchrow['title'];
              $searchspec = str_replace('\'', '?', $search);
              echo "<option value=\"$searchspec\">$search</option>";
            }
          ?>
          </select>
          </div>
          <div id="currentItemsClean"></div>
          <div id="currentItemsRaw" style="display:none;"><?php echo $charItems; ?></div>
          <table id="itemTable">
          </table>

          </div>

          <div class="col-xs-12 sidebartext sheetBlock" name="mainBlock" id="attacksBlock" style="margin-top:10px;">
            <div style="margin-bottom: 10px; border-bottom:1px solid white;">Attacks</div>
            <table class="attackTable">

          <tr>
            <td class="wideCell"><select class="charClassSelect attackDrop sheetDrop selector" name="attack1Select" id="attack1Select" onchange="attack(1)">
              <?php
              list($attack1, $attack2) = explode(',', $allattacks);

              $at1title = "SELECT * FROM `compendium` WHERE `itemType` LIKE '%weapon%' AND title LIKE '$attack1'";
              $at1data = mysqli_query($dbcon, $at1title) or die('error getting data');
              while($at1 =  mysqli_fetch_array($at1data, MYSQLI_ASSOC)) {
                echo ('<option value="'.$at1['title'].'['.$at1['itemRange'].']'.$at1['itemDmg1'].'{'.$at1['itemProperty'].'">'.$at1['title']);
              }


              echo ('<option value="null">');
              $at1title = "SELECT * FROM `compendium` WHERE `itemType` LIKE '%weapon%' AND itemMagic NOT LIKE '1'";
              $at1data = mysqli_query($dbcon, $at1title) or die('error getting data');
              while($at1 =  mysqli_fetch_array($at1data, MYSQLI_ASSOC)) {
                //$bgNameNoBG = str_replace('(background)', '', $row1['title']);
                //$bgNameClean = preg_replace('/[^a-z\d]+/i', '', $bgNameNoBG);
                  echo ('<option value="'.$at1['title'].'['.$at1['itemRange'].']'.$at1['itemDmg1'].'{'.$at1['itemProperty'].'">'.$at1['title']);
                }
                ?>
        </select></td>
          <td class="narrowCell"><input class="statScore lightBox" id="at1Range" value="<?php echo $row['str']; ?>"></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel" onclick="attackRoll('1')">Attack</div></td>
        <td><div class="attackLabel">Range</div></td>
        </tr>
        <tr>
        <td><input class="statScore lightBox" id="at1Damage" value="<?php echo $row['str']; ?>"></input>
        </td>
        <td><input class="statScore lightBox" id="at1ToHit" value="<?php echo $row['str']; ?>"></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel">Damage</div></td>
        <td><div class="attackLabel">To Hit</div></td>
        </tr>

        </table>
        <table class="attackTable">

        <tr>
        <td class="wideCell"><select class="charClassSelect attackDrop sheetDrop selector" name="attack2Select" id="attack2Select" onchange="attack(2)">
        <?php
        $at2title = "SELECT * FROM `compendium` WHERE `itemType` LIKE '%weapon%' AND title LIKE '$attack2'";
        $at2data = mysqli_query($dbcon, $at2title) or die('error getting data');
        while($at2 =  mysqli_fetch_array($at2data, MYSQLI_ASSOC)) {
          echo ('<option value="'.$at2['title'].'['.$at2['itemRange'].']'.$at2['itemDmg1'].'{'.$at2['itemProperty'].'">'.$at2['title']);
        }


        echo ('<option value="null">');
        $at2title = "SELECT * FROM `compendium` WHERE `itemType` LIKE '%weapon%' AND itemMagic NOT LIKE '1'";
        $at2data = mysqli_query($dbcon, $at2title) or die('error getting data');
        while($at2 =  mysqli_fetch_array($at2data, MYSQLI_ASSOC)) {
          //$bgNameNoBG = str_replace('(background)', '', $row2['title']);
          //$bgNameClean = preg_replace('/[^a-z\d]+/i', '', $bgNameNoBG);
          echo ('<option value="'.$at2['title'].'['.$at2['itemRange'].']'.$at2['itemDmg1'].'{'.$at2['itemProperty'].'">'.$at2['title']);
          }
          ?>
        </select></td>
        <td class="narrowCell"><input class="statScore lightBox" id="at2Range" value="<?php echo $row['str']; ?>"></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel" onclick="attackRoll('2')">Attack</div></td>
        <td><div class="attackLabel">Range</div></td>
        </tr>
        <tr>
        <td><input class="statScore lightBox" id="at2Damage" value="<?php echo $row['str']; ?>"></input>
        </td>
        <td><input class="statScore lightBox" id="at2ToHit" value="<?php echo $row['str']; ?>"></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel">Damage</div></td>
        <td><div class="attackLabel">To Hit</div></td>
        </tr>
        </table>

        <table class="attackTable">
        <tr>
        <td class="wideCell"><input class="statScore lightBox" name="attack3Select" id="attack3Select"></td>
        <td class="narrowCell"><input class="statScore lightBox" id="at3Range" value=""></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel" onclick="attackRoll('3')">Attack</div></td>
        <td><div class="attackLabel">Range</div></td>
        </tr>
        <tr>
        <td><input class="statScore lightBox" id="at3Damage" value=""></input>
        </td>
        <td><input class="statScore lightBox" id="at3ToHit" value=""></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel">Damage</div></td>
        <td><div class="attackLabel">To Hit</div></td>
        </tr>
        </table>

        <table class="attackTable">
        <tr>
        <td class="wideCell"><input class="statScore lightBox" name="attack4Select" id="attack4Select"></td>
        <td class="narrowCell"><input class="statScore lightBox" id="at4Range" value=""></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel" onclick="attackRoll('4')">Attack</div></td>
        <td><div class="attackLabel">Range</div></td>
        </tr>
        <tr>
        <td><input class="statScore lightBox" id="at4Damage" value=""></input>
        </td>
        <td><input class="statScore lightBox" id="at4ToHit" value=""></input></td>
        </tr>
        <tr>
        <td><div class="attackLabel">Damage</div></td>
        <td><div class="attackLabel">To Hit</div></td>
        </tr>
        </table>


        <div class="hide" id="attack1">null</div>
        <div class="hide" id="attack2">null</div>
        <div class="hide" id="attack3">null</div>
          </div>

        </div>



        <div class="roundBorder col-md-4 col-sm-6 col-xs-12 sidebartext sheetBlock floatright" name="mainBlock" id="spellsBlock" style="margin-top:10px;" style="float:left;">
          <div style="margin-bottom: 5px; border-bottom:1px solid white;">Spells</div>
          <div style="display:none; float:left;" id="spellWarning">Please save changes to your class/subclass before adding spells.</div>
          <?php
            $basespelldc = 8 + (int)$profbonus;
            if ($coreclassbare == 'Paladin' || $coreclassbare == 'Sorcerer' || $coreclassbare == 'Warlock' || $coreclassbare == 'Bard'){
              $spelldc = $basespelldc + $chamod;
              $spellattack = $chamod + (int)$profbonus;
            }
            else if ($coreclassbare == 'Wizard' || $coreclassbare == 'Mystic' || $coreclassbare == 'Artificer' || $subclass == 'Eldritch Knight' || $subclass == 'Arcane Trickster'){
              $spelldc = $basespelldc + $intelmod;
              $spellattack = $intelmod + (int)$profbonus;
            }
            else if ($coreclassbare == 'Cleric' || $coreclassbare == 'Druid' || $coreclassbare == 'Monk' || $coreclassbare == 'Ranger' || $coreclassbare == 'Revised Ranger'){
              $spelldc = $basespelldc + $wismod;
              $spellattack = $wismod + (int)$profbonus;
            }
            else {
              $spelldc = 'N/A';
              $spellattack = 'N/A';
            }
            if ($coremultibare == 'Paladin' || $coremultibare == 'Sorcerer' || $coremultibare == 'Warlock' || $coremultibare == 'Bard'){
              $spelldc2 = $basespelldc + $chamod;
              $spellattack2 = $chamod + (int)$profbonus;
            }
            else if ($coremultibare == 'Wizard' || $coremultibare == 'Mystic' || $coremultibare == 'Artificer' || $multisubclass == 'Eldritch Knight' || $multisubclass == 'Arcane Trickster'){
              $spelldc2 = $basespelldc + $intelmod;
              $spellattack2 = $intelmod + (int)$profbonus;
            }
            else if ($coremultibare == 'Cleric' || $coremultibare == 'Druid' || $coremultibare == 'Monk' || $coremultibare == 'Ranger' || $coremultibare == 'Revised Ranger'){
              $spelldc2 = $basespelldc + $wismod;
              $spellattack2 = $wismod + (int)$profbonus;
            }
            else {
              $spelldc2 = 'N/A';
              $spellattack2 = 'N/A';
            }
           ?>
          <table class="vitalsTable" id="spellmain" style="width: 100%;">
            <tbody>
            <tr>
              <td><div class="col-centered" id="spellclass"><?php echo $coreclassbare; ?></div></td>
              <td><div class="col-centered spellinfo" id="spelldc"><?php echo $spelldc; ?></div></td>
              <td><div class="col-centered spellinfo" id="spellattack">+<?php echo $spellattack; ?></div></td>
            </tr>
            <tr>
              <td><div class="charDeet">Main Class</div></td>
              <td><div class="charDeet">Spell DC</div></td>
              <td><div class="charDeet">Spell Attack</div></td>
            </tr>
          </tbody>
        </table>
        <table class="vitalsTable" id="spelloff" style="width: 100%;">
            <tr>
              <td><div class="col-centered" id="spellclass2"><?php echo $coremultibare; ?></div></td>
              <td><div class="col-centered spellinfo" id="spelldc2"><?php echo $spelldc2; ?></div></td>
              <td><div class="col-centered spellinfo" id="spellattack2">+<?php echo $spellattack2; ?></div></td>
            </tr>
            <tr>
              <td><div class="charDeet">Multiclass</div></td>
              <td><div class="charDeet">Spell DC</div></td>
              <td><div class="charDeet">Spell Attack</div></td>
            </tr>
          </tbody>
        </table>

          <?php
          $coreclass = substr($fullclass, 0, strpos($fullclass, "(") -1);
          $coreTemp = $coreclass.' core';
          $ucClass = ucwords($coreclass);
          $subclass = trim($subclasstemp, ')');
          $coremulticlass = substr($fullmulticlass, 0, strpos($fullmulticlass, "(") -1);
          $multicoreTemp = $coremulticlass.' core';
          $ucmultiClass = ucwords($coremulticlass);
          $multisubclass = trim($multisubclasstemp, ')');

          echo ('<div class="hide" id="currentSpells">'.$allspells.'</div>');
          echo ('<div class="hide" id="currentFeats">'.$allfeats.'</div>');


            ?>
            <button id="spellsButton" style="display:none;" class="btn btn-info" href="#spells" data-toggle="collapse">Spells</button>
        <div id="spellsShow" >

            <table id="spells" class="table table-condensed table-striped table-responsive dt-responsive featureDetails collapse" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">
                          <?php
                          if ($ucClass == 'Mystic') {
                            echo ('Ability');
                          }
                          else {
                            echo ('Spell');
                          }
                          ?>
                        </th>
                        <th scope="col">
                          <?php
                          if ($ucClass == 'Mystic') {
                            echo ('Type');
                          }
                          else {
                            echo ('Level');
                          }
                          ?>

                        </th>

                    </tr>
                </thead>
                <tbody>
            <?php
        //  SPELLS Section
  $spelltitle = "SELECT * FROM `compendium` WHERE `spellClasses` LIKE '%$ucClass%' OR `spellClasses` LIKE '%$subclass%' ORDER BY spellLevel, title";
  $spelldata = mysqli_query($dbcon, $spelltitle) or die('error getting data');

            while($spellrow =  mysqli_fetch_array($spelldata, MYSQLI_ASSOC)) {
              ?>

              <?php
                  //$featuretitle = str_replace('text', 'name', $column);
                $spelltitlens = str_replace(' ', '', $spellrow['title']);
                $spelltitlespec = str_replace('\'', '_', $spellrow['title']);
                $spelltitlens = preg_replace('/[^a-z\d]+/i', '_', $spelltitlens);
                  echo ('<tr><td><input type="checkbox" id="'.$spelltitlens.'Box" onclick="spellList(\''.$spelltitlespec.'\')"></input></td>');
                  echo ('<td><a class="featureName" data-toggle="collapse" href="#'.$spelltitlens.'show">'.$spellrow['title'].' (');
                  if (strpos($spellrow['spellClasses'], $ucClass) !== false) {
                    echo $ucClass;
                  }
                  if (strpos($spellrow['spellClasses'], $subclass) !== false) {
                    echo $subclass;
                  }
                  if ($multiclasslevel !== 0){
                  if (strpos($spellrow['spellClasses'], $ucmultiClass) !== false) {
                    echo $ucmultiClass;
                  }
                  if (strpos($spellrow['spellClasses'], $multisubclass) !== false) {
                    echo $multisubclass;
                  }
                }
                  echo (')</a></td>');

                  if ($ucClass == 'Mystic') {
                    echo ('<td>'.ucwords($spellrow['spellSchool']).'</td></tr>');

                  }
                  else {
                  echo ('<td>'.$spellrow['spellLevel'].'</td></tr>');
                }
                  echo ('<tr></tr>');
                  echo ('<tr><td colspan="3"><div class="featureDetails collapse" id="'.$spelltitlens.'show" name="'.$spelltitlens.'show">');
                  echo ('Casting Time: '.$spellrow['spellTime']);
                  echo ('<br />Duration: '.$spellrow['spellDuration']);
                  echo ('<br />Range: '.$spellrow['spellRange']);
                  echo ('<br />Components: '.$spellrow['spellComponents']);
                  echo ('<br />'.nl2br($spellrow['text']).'</div></td></tr>');

              }

        ?>
        </tbody>
        </table>

        <table id="myspells" class="table table-condensed table-striped table-responsive dt-responsive" cellspacing="0" width="100%">
                <thead class="thead-dark">
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">lvl</th>
                      <th scope="col">Prep?</th>
                      <th scope="col">Prep</th>
                      <th scope="col" class="none"></th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">lvl</th>
                      <th scope="col">Prep?</th>
                      <th scope="col">Prep</th>
                      <th scope="col"></th>

                    </tr>
                </tfoot>
                <tbody>
                  <?php
                    $a = 1;
                    $sqlcompendium = "SELECT * FROM compendium WHERE type LIKE 'spell' AND title NOT LIKE '%*' AND title NOT LIKE '%(Ritual Only)' AND title NOT LIKE '%invocation%' AND title IN ('$spellsarray')";
                    $compendiumdata = mysqli_query($dbcon, $sqlcompendium) or die('error getting data');
                    while($row = mysqli_fetch_array($compendiumdata, MYSQLI_ASSOC)) {
                      $spelltitlens = str_replace(' ', '', $row['title']);
                      $spelltitlespec = str_replace('\'', '_', $row['title']);
                      $spelltitlens = preg_replace('/[^a-z\d]+/i', '_', $spelltitlens);
                    echo ('<tr style="padding:50px;"><td class="bigt">');
                    $entry = $row['title'];
                    echo ('<div class="fakelink">');
                    echo $entry;
                    echo "</div></td>";
                    echo ('<td>'.$row['spellLevel'].'</td>');
                    //echo ('<td>'.$row['spellTime'].'</td>');
                    //echo ('<td>'.$row['spellDuration'].'</td>');
                    //echo ('<td>'.$row['spellRange'].'</td>');
                    /*if (strpos($row['text'], 'Strength saving throw') !== false){
                      echo ('<td>STR Save</td>');

                    }
                    else if (strpos($row['text'], 'Dexterity saving throw') !== false){
                      echo ('<td>DEX Save</td>');

                    }
                    else if (strpos($row['text'], 'Constitution saving throw') !== false){
                      echo ('<td>CON Save</td>');

                    }
                    else if (strpos($row['text'], 'Intelligence saving throw') !== false){
                      echo ('<td>INT Save</td>');

                    }
                    else if (strpos($row['text'], 'Wisdom saving throw') !== false){
                      echo ('<td>WIS Save</td>');

                    }
                    else if (strpos($row['text'], 'Charisma saving throw') !== false){
                      echo ('<td>CHA Save</td>');

                    }
                    else if (strpos($row['text'], 'spell attack') !== false){
                      echo ('<td>Spell Attack</td>');

                    }
                    else {
                      echo ('<td>-</td>');
                    }*/
                    echo ('<td><input type="checkbox" class="expertRadio prepbox" id="'.$spelltitlens.'prepbox" onclick="prepList(\''.$spelltitlespec.'\')"></input></td>');
                    echo ('<td id="'.$spelltitlens.'prep"></td>');
                    $spelldeet = substr($row['text'], 0, strpos($row['text'], "Source:"));
                    $spelldeet = rtrim($spelldeet);
                    echo ('<td class="smallt" id="spell'.$a.'">');
                    echo ('<br/><b>Casting Time:</b> '.$row['spellTime'].'</br>');
                    echo ('<b>Range:</b> '.$row['spellRange'].'</br>');
                    echo ('<b>Duration:</b> '.$row['spellDuration'].'</br>');
                    echo ('<b>Components:</b> '.$row['spellComponents'].'</br>');
                    echo nl2br($spelldeet).'</td>';
                    echo ('</tr>');
                    ?>
                    <?php
                  }
                    ?>

        </tbody>
        </table>
        <script>
        $(document).ready(function prepcheck() {
          // Handle click on "Collapse All" button
        var prepped = '<?php echo $prepped; ?>';
        var prepArray = prepped.split(',');
        var index = 0;
        var entryNS = '';
        for (index = 0; index < prepArray.length; ++index) {
          entryNS = prepArray[index].replace(/ /g,'');
          var entryNSbox = entryNS + 'prepbox';

          var checkbox = document.getElementById(entryNSbox);
          if (checkbox) {
               $('#' + entryNSbox).prop('checked', true);
               document.getElementById(entryNS + 'prep').innerHTML = "YES";
          }
        }

        });
        </script>

        <script>
        function prepList(value) {

        var spellList = document.getElementById('prepSpells').innerHTML;
        var valueNS = value.replace(/[() ]/g,'');
        var spellBoxID = valueNS + 'prepbox';
        var charID = '<?php echo $charID; ?>';

        if (document.getElementById(spellBoxID).checked) {
         spellList = spellList + value + ',';
        }
        else {
        if (spellList.includes(value + ',') == true){
        /*   if (spellList.startsWith(value)){
          if (spellList.includes(value + ',')) {*/
          spellList = spellList.replace(value + ',', '');
          }
          /*else {
           spellList = spellList.replace(value , '');
         }*/
        }
         //else {
           //spellList = spellList.replace(',' + value, '');
         //}

        //}

        if (spellList.startsWith(',') == false){
        spellList = ',' + spellList;
        }
        if (spellList.endsWith(',') == false){
        spellList = spellList + ',';
        }

        document.getElementById('prepSpells').innerHTML = spellList;
        //document.getElementById('prepwarning').style = "display:block";


        $.ajax({
        url : '/tools/compendium/prep.php',
        type: 'GET',
        data : { "id" : charID, "prepped" : spellList },
        success: function()
        {
            //if success then just output the text to the status div then clear the form inputs to prepare for new data
          //  $("#favButton").addClass('disabled');
            //$('#favButton').html('In Favourites');
            //var newURL = '/tools/compen/characters.php?id=' + levelName;
            //$(location).attr('href', newURL)
        },
        error: function (jqXHR, status, errorThrown)
        {
            //if fail show error and server status
            $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
        }
        });
        };



        $(document).ready(function() {
         // Setup - add a text input to each footer cell


         // DataTable
         var table = $('#myspells').DataTable( {
             responsive: {
                 details: {
                     //display: $.fn.dataTable.Responsive.display.childRowImmediate,
                     type: ''
                 }
             },
              "order": [[ 3, "desc" ], [ 1, "asc" ]],
              "pageLength": 50,
              "searching": false,
              "paging": false,
              "info": false,
              "columnDefs": [
                  { "width": "70%", "targets": 0 }

  ]
         }
      );

        } );


        </script>
</div>
</div>

<div class="roundBorder col-md-4 col-sm-6 col-xs-12 sidebartext sheetBlock" name="mainBlock" id="notesBlock" style="margin-top:10px;" style="float:left;">
  <div style="margin-bottom: 5px; border-bottom:1px solid white;">Notes</div>
    <div>General Notes</div>
    <textarea type="text" class="notestext" id="charNotes" value="<?php echo $charNotes; ?>"><?php echo $charNotes; ?></textarea><br />
    <table>
      <tr>
        <td><div style="margin-right: 10px;">Saved Notes</div></td>
        <td><a href="/tools/users/noteimport.php" target="blank"><button class="btn btn-success">+</button></a></td>
      </tr>
    </table><br />
    <table id="myNotes" class="table table-condensed table-striped table-responsive dt-responsive halftable" cellspacing="0" width="50%">
      <?php
      $notecount = 1;
      $notestitle = "SELECT * FROM `notes` WHERE `user` LIKE '$charuser'";
      $notesdata = mysqli_query($dbcon, $notestitle) or die('error getting data');
      while($notesrow =  mysqli_fetch_array($notesdata, MYSQLI_ASSOC)) {
          echo ('<tr><td><a class="featureName" data-toggle="collapse" href="#'.$notecount.'note">'.$notesrow['title'].'</a></td></tr>');
          echo ('<tr><td><div class="featureDetails collapse" id="'.$notecount.'note" name="'.$notecount.'note">'.nl2br($notesrow['text']).'</div></td></tr>');
          $notecount++;
      }
      ?>
    </table>



</div>
<script>
function longrest() {
  var defaultslots = $('#defaultslots').html();
  var coreclass = '<?php echo $coreclassbare; ?>';
  var subclass = '<?php echo $subclass; ?>';
  var defaultArray = defaultslots.split(",");
  var currenthp = <?php echo $maxhp; ?>;
  var temphp = 0;
  var currentlp = $('#currentlp').val();
  var charID = <?php echo $charID; ?>;
  var lockslot1 = '<?php echo $lockslot1; ?>';
  var lockslot2 = '<?php echo $lockslot2; ?>';
  var mysticslot1 = '<?php echo $mysticslot1; ?>';
  var mysticslot2 = '<?php echo $mysticslot2; ?>';
  var slotnum = 1;
  for (index = 0; index < defaultArray.length; ++index) {
    if (coreclass == 'Mystic'){
      var slot = 'mysticslot' + slotnum;
      var defaultArray = [mysticslot1, mysticslot2, '-', '-', '-', '-', '-', '-', '-'];
    }
    else if (coreclass == 'Warlock' || subclass == 'Order of the Profane Soul'){
      var slot = 'lockslot' + slotnum;
      var defaultArray = [mysticslot1, mysticslot2, '-', '-', '-', '-', '-', '-', '-'];
    }
    else {
    var slot = 'spellslot' + slotnum;
  }
    document.getElementById(slot).value = defaultArray[index];
    slotnum = slotnum + 1;
  }
  document.getElementById('currenthp').value = currenthp;
  document.getElementById('currentlp').value = currentlp;
  document.getElementById('temphp').value = temphp;
  defaultArray = defaultArray.toString();

  $.ajax({
     url : 'tracking.php',
     type: 'GET',
     data : { "currentlp" : currentlp, "currenthp" : currenthp, "temphp" : temphp, "id" : charID, "slots" : defaultArray },
     success: function()
     {
         //if success then just output the text to the status div then clear the form inputs to prepare for new data
       //  $("#favButton").addClass('disabled');
         //$('#favButton').html('In Favourites');
      //   var newURL = '/tools/users/characters.php?id=' + charName;
        // $(location).attr('href', newURL)
     },
     error: function (jqXHR, status, errorThrown)
     {
         //if fail show error and server status
         $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
     }
  });
};
</script>


        <script type="text/javascript">
        function tracking(){
          var currentlp = $('#currentlp').val();
          var currenthp = $('#currenthp').val();
          var temphp = $('#temphp').val();
          var charID = <?php echo $charID; ?>;
          var slot1 = $('#spellslot1').val();
          var slot2 = $('#spellslot2').val();
          var slot3 = $('#spellslot3').val();
          var slot4 = $('#spellslot4').val();
          var slot5 = $('#spellslot5').val();
          var slot6 = $('#spellslot6').val();
          var slot7 = $('#spellslot7').val();
          var slot8 = $('#spellslot8').val();
          var slot9 = $('#spellslot9').val();
          var lockslot1 = $('#lockslot1').val();
          var lockslot2 = $('#lockslot2').val();
          var mysticslot1 = $('#mysticslot1').val();
          var mysticslot2 = $('#mysticslot2').val();
          var coreclass = '<?php echo $coreclassbare; ?>';
          var subclass = '<?php echo $subclass; ?>';
          if (coreclass == 'Mystic'){
              var spellslots = [mysticslot1, mysticslot2, '-', '-', '-', '-', '-', '-', '-'];
          }
          else if (coreclass == 'Warlock' || subclass == 'Order of the Profane Soul'){
            var spellslots = [lockslot1, lockslot2, '-', '-', '-', '-', '-', '-', '-'];
          }
          else {
          var spellslots = [slot1, slot2, slot3, slot4, slot5, slot6, slot7, slot8, slot9];
        }
          spellslots = spellslots.toString();

          $.ajax({
             url : 'tracking.php',
             type: 'GET',
             data : { "currentlp" : currentlp, "currenthp" : currenthp, "temphp" : temphp, "id" : charID, "slots" : spellslots },
             success: function()
             {
                 //if success then just output the text to the status div then clear the form inputs to prepare for new data
               //  $("#favButton").addClass('disabled');
                 //$('#favButton').html('In Favourites');
              //   var newURL = '/tools/users/characters.php?id=' + charName;
                // $(location).attr('href', newURL)
             },
             error: function (jqXHR, status, errorThrown)
             {
                 //if fail show error and server status
                 $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
             }
         });
        };
</script>
<script>
      	$('#itemSearch').selectize({
				onChange: function(value){
          if (value !== ""){
          var currentItems = $('#currentItemsRaw').html();
          var currentItemsClean = $('#currentItemsClean').html();
          var newItemsArray = '';
          if (currentItems !== '' && currentItems.includes('_') == false){
          newItemsArray = currentItems + '_' + value;
          cleaItemsArray = currentItems + ', ' + value;
        }
          else if (currentItems == ''){
            newItemsArray = value;
            cleanItemsArray = value;
          }
          else {
            newItemsArray = currentItems + '_' + value;
            cleanItemsArray = currentItems + '_' + value;
          }
          document.getElementById('currentItemsRaw').innerHTML = newItemsArray;
          document.getElementById('currentItemsClean').innerHTML = cleanItemsArray;
          }
				},
				create: false,
				openOnFocus: false,
				maxOpions: 4,
				sortField: 'text',
				placeholder: 'search...'
				},);


        $(document).ready(function() {
            // DataTable
            var table = $('#spells').DataTable(
              {
                "paging": false,
                "order": [[ 2, "asc" ]],
                "searching": false
              }
            );

        } );
        $(document).ready(function() {

            // DataTable
            var table = $('#mySpells').DataTable(
              {
                "paging": false,
                "order": [[ 1, "asc" ]],
                "searching": false
              }
            );

        } );

        $(document).ready(function() {
            // DataTable
            var table = $('#feats').DataTable(
              {
                "paging": false,
                "order": [[ 2, "asc" ]],
                "searching": false
              }
            );

        } );
        $(document).ready(function() {

            // DataTable
            var table = $('#myFeats').DataTable(
              {
                "paging": false,
                "order": [[ 1, "asc" ]],
                "searching": false
              }
            );

        } );

        function spellList(value) {
          var spellList = document.getElementById('currentSpells').innerHTML;
          var valueNS = value.replace(/[() ]/g,'');
          var spellBoxID = valueNS + 'Box';
          if (document.getElementById(spellBoxID).checked) {
            spellList = spellList + value + ',';
        }
        else {
          if (spellList.includes(value + ',') == true){
        /*   if (spellList.startsWith(value)){
             if (spellList.includes(value + ',')) {*/
             spellList = spellList.replace(value + ',', '');
             }
             /*else {
              spellList = spellList.replace(value , '');
            }*/
          }
            //else {
              //spellList = spellList.replace(',' + value, '');
            //}

          //}

       if (spellList.startsWith(',') == false){
          spellList = ',' + spellList;
        }
        if (spellList.endsWith(',') == false){
          spellList = spellList + ',';
        }

        document.getElementById('currentSpells').innerHTML = spellList;
      };

      function featList(value) {
        var featList = document.getElementById('currentFeats').innerHTML;
        var featvalueNS = value.replace(/[() ]/g,'');
        var featBoxID = featvalueNS + 'Box';
        if (document.getElementById(featBoxID).checked) {
          featList = featList + value + ',';
      }
      else {
        if (featList.includes(value + ',') == true){

          featList = featList.replace(value + ',', '');
           }
        }

     if (featList.startsWith(',') == false){
        featList = ',' + featList;
      }
      if (featList.endsWith(',') == false){
        featList = featList + ',';
      }

      document.getElementById('currentFeats').innerHTML = featList;
    };
        </script>


<!-- FILL ATTACK FIELDS -->
<script>
  function attack(value) {
      var selectName = "attack" + value + "Select";
      var damageName = "at" + value + "Damage";
      var rangeName = "at" + value + "Range";
      var toHitName = "at" + value + "ToHit";
      var damageValTemp = "at" + value + "DamageVal";
      var mainString = document.getElementById(selectName).value;
      if (mainString == "null") {
        document.getElementById(damageName).value = "";
        document.getElementById(rangeName).value = "";
        document.getElementById(toHitName).value = "";
        document.getElementById(attack + "value").innerHTML = "null";
      }
      else {
      var attackName = mainString.substr(0, mainString.indexOf('['));
      document.getElementById('attack' + value).innerHTML = attackName;
      var attackRange = mainString.match(/\[(.*)\]/).pop();
      var attackDamage = mainString.match(/\](.*)\{/).pop();
      var attackType = mainString.split('{')[1];
      var profBonus = <?php echo $profbonus; ?>;
      var toHitDex = <?php echo $dexmod; ?>;
      var toHitStr = <?php echo $strmod; ?>;
      var toHit = profBonus;
      if (attackType.includes("F") == true) {
          if (toHitStr >= toHitDex) {
            toHit = profBonus + toHitStr;
          }
          else {
            toHit = profBonus + toHitStr;
          }
        }
        else if (attackType.includes("T") == true) {
          toHit = profBonus + toHitStr;
        }
        else if (attackType.includes("T") == false && attackRange !== '') {
            toHit = profBonus + toHitDex;
        }
        else {
          toHit = profBonus + toHitStr;
        }

      finalDamage = toHit - profBonus;
      attackDamage = attackDamage + " + " + finalDamage;
      var toHitVal = "+" + toHit;
      document.getElementById(damageName).value = attackDamage;
      document.getElementById(rangeName).value = attackRange;
      document.getElementById(toHitName).value = toHitVal;
    }
  }

  $(document).ready(function() {
        var allCustomAttacks = '<?php echo $customattacks; ?>';
        var attackArray = allCustomAttacks.split('_');
       document.getElementById('attack3Select').value = attackArray[0];
        document.getElementById('at3Range').value = attackArray[1];
        document.getElementById('at3Damage').value = attackArray[2];
        document.getElementById('at3ToHit').value = attackArray[3];
        document.getElementById('attack4Select').value = attackArray[4];
        document.getElementById('at4Range').value = attackArray[5];
        document.getElementById('at4Damage').value = attackArray[6];
        document.getElementById('at4ToHit').value = attackArray[7];
  });

  $(document).ready(function() {
    attack("1");
    attack("2");
    customAttack();
  });

</script>
<?php
//CHECK EXISTING PROFICIENCIES
if (strpos($checksaves, 'Strength') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#strSaveProf').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checksaves, 'Dexterity') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#dexSaveProf').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checksaves, 'Constitution') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#conSaveProf').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checksaves, 'Intelligence') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#intelSaveProf').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checksaves, 'Wisdom') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#wisSaveProf').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checksaves, 'Charisma') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#chaSaveProf').prop('checked', true);

  });

  </script>
<?php
}

  if (strpos($checkprofs, 'Athletics') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#athleticsProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Acrobatics') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#acrobaticsProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Sleight of Hand') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#sleightProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Stealth') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#stealthProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Arcana') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#arcanaProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'History') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#historyProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Investigation') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#investigationProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Nature') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#natureProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Religion') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#religionProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Animal Handling') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#animalProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Insight') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#insightProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Medicine') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#medicineProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Perception') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#perceptionProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Survival') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#survivalProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Deception') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#deceptionProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Intimidation') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#intimidationProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Persuasion') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#persuasionProf').prop('checked', true);

    });

    </script>
  <?php
  }
  if (strpos($checkprofs, 'Performance') !== false) {
    ?><script>
    $(document).ready(function() {
      $('#performanceProf').prop('checked', true);

    });

    </script>
  <?php
  }



//EXPERTISE CHECKBOXES
if (strpos($checkexperts, 'Athletics') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#athleticsExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Acrobatics') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#acrobaticsExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Sleight of Hand') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#sleightExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Stealth') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#stealthExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Arcana') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#arcanaExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'History') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#historyExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Investigation') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#investigationExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Nature') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#natureExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Religion') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#religionExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Animal Handling') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#animalExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Insight') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#insightExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Medicine') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#medicineExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Perception') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#perceptionExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Survival') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#survivalExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Deception') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#deceptionExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Intimidation') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#intimidationExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Persuasion') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#persuasionExpert').prop('checked', true);

  });

  </script>
<?php
}
if (strpos($checkexperts, 'Performance') !== false) {
  ?><script>
  $(document).ready(function() {
    $('#performanceExpert').prop('checked', true);

  });

  </script>
<?php
}

// PROFICIENCIES
    ?>
    <script>
    function addStrProf(value) {
      var currentVal = <?php echo $strmod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
 {
   if (document.getElementById(value + 'Expert').checked) {
        newVal = currentVal + <?php echo $profbonus; ?> * 2;
   }
   else {
    newVal = currentVal + <?php echo $profbonus; ?>;
  }
     document.getElementById(value + 'Val').value = newVal;
 }

 else {
   document.getElementById(value + 'Val').value = currentVal;
 }
    }

    function addDexProf(value) {
      var currentVal = <?php echo $dexmod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
    {
      if (document.getElementById(value + 'Expert').checked) {
           newVal = currentVal + <?php echo $profbonus; ?> * 2;
      }
      else {
       newVal = currentVal + <?php echo $profbonus; ?>;
     }
        document.getElementById(value + 'Val').value = newVal;
    } else {
    document.getElementById(value + 'Val').value = currentVal;
    }
    }

    function addConProf(value) {
      var currentVal = <?php echo $conmod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
 {
   if (document.getElementById(value + 'Expert').checked) {
        newVal = currentVal + <?php echo $profbonus; ?> * 2;
   }
   else {
    newVal = currentVal + <?php echo $profbonus; ?>;
  }
     document.getElementById(value + 'Val').value = newVal;
 } else {
   document.getElementById(value + 'Val').value = currentVal;
 }
    }

    function addIntelProf(value) {
      var currentVal = <?php echo $intelmod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
 {
   if (document.getElementById(value + 'Expert').checked) {
        newVal = currentVal + <?php echo $profbonus; ?> * 2;
   }
   else {
    newVal = currentVal + <?php echo $profbonus; ?>;
  }
     document.getElementById(value + 'Val').value = newVal;
 } else {
   document.getElementById(value + 'Val').value = currentVal;
 }
    }

    function addWisProf(value) {
      var currentVal = <?php echo $wismod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
 {
   if (document.getElementById(value + 'Expert').checked) {
        newVal = currentVal + <?php echo $profbonus; ?> * 2;
   }
   else {
    newVal = currentVal + <?php echo $profbonus; ?>;
  }
     document.getElementById(value + 'Val').value = newVal;
 } else {
   document.getElementById(value + 'Val').value = currentVal;
 }
    }

    function addChaProf(value) {
      var currentVal = <?php echo $chamod; ?>;
      var newVal = 0;
      if (document.getElementById(value + 'Prof').checked)
 {
   if (document.getElementById(value + 'Expert').checked) {
        newVal = currentVal + <?php echo $profbonus; ?> * 2;
   }
   else {
    newVal = currentVal + <?php echo $profbonus; ?>;
  }
     document.getElementById(value + 'Val').value = newVal;
 } else {
   document.getElementById(value + 'Val').value = currentVal;
 }
    }


//ROLLS
function profRoll(value) {
  var modifier = parseInt(document.getElementById(value).value, 10);
  var roll = Math.floor(Math.random() * 20) + 1;
  var result = roll + modifier;
  var typeID = value.replace('Val', '');
  var typeName = document.getElementById(typeID + 'Name').innerHTML;
  document.getElementById('rollResult').innerHTML = result;
  document.getElementById('rollFormula').innerHTML = roll + ' + (' + modifier + ')';

  if (typeName == '<b>Saving Throw</b>') {
    saveType = typeID.replace('Save', '');
    saveType = saveType.toUpperCase();
    typeName = '<b>' + saveType + ' Saving Throw</b>';
  }
  if (roll == 20) {
    document.getElementById('nat20').innerHTML = 'Natural 20!';
    document.getElementById('rollResult').classList.add('nat20');
    document.getElementById('rollFormula').classList.add('nat20');
    document.getElementById('rollType').classList.add('nat20');

  }
  else if (roll == 1) {
    document.getElementById('nat1').innerHTML = 'Natural 1!';
    document.getElementById('rollResult').classList.add('nat1');
    document.getElementById('rollFormula').classList.add('nat1');
    document.getElementById('rollType').classList.add('nat1');
  }
  else {
    document.getElementById('rollResult').classList.remove('nat1');
    document.getElementById('rollFormula').classList.remove('nat1');
    document.getElementById('rollType').classList.remove('nat1');
    document.getElementById('rollResult').classList.remove('nat20');
    document.getElementById('rollFormula').classList.remove('nat20');
    document.getElementById('rollType').classList.remove('nat20');
    document.getElementById('nat20').innerHTML = '';
    document.getElementById('nat1').innerHTML = '';
  }
  document.getElementById('rollType').innerHTML = typeName;

  function showRollModal() {
    $("#rollModal").modal();
  }
  showRollModal();
}

function attackRoll(value) {
  var cleanModifier = document.getElementById('at' + value + 'ToHit').value;
  var modifier = parseInt(cleanModifier.replace('+', ''), 10);
  var roll = Math.floor(Math.random() * 20) + 1;
  var result = roll + modifier;
  //var typeID = value.replace('Val', '');
  var typeName = document.getElementById('attack' + value + 'Select').value;
  typeName = typeName.substr(0, typeName.indexOf('['));
  document.getElementById('rollResult').innerHTML = result;
  document.getElementById('rollFormula').innerHTML = roll + ' + (' + modifier + ')';

  if (roll == 20) {
    document.getElementById('nat20').innerHTML = 'Natural 20!';
    document.getElementById('rollResult').classList.add('nat20');
    document.getElementById('rollFormula').classList.add('nat20');
    document.getElementById('rollType').classList.add('nat20');

  }
  else if (roll == 1) {
    document.getElementById('nat1').innerHTML = 'Natural 1!';
    document.getElementById('rollResult').classList.add('nat1');
    document.getElementById('rollFormula').classList.add('nat1');
    document.getElementById('rollType').classList.add('nat1');
  }
  else {
    document.getElementById('rollResult').classList.remove('nat1');
    document.getElementById('rollFormula').classList.remove('nat1');
    document.getElementById('rollType').classList.remove('nat1');
    document.getElementById('rollResult').classList.remove('nat20');
    document.getElementById('rollFormula').classList.remove('nat20');
    document.getElementById('rollType').classList.remove('nat20');
    document.getElementById('nat20').innerHTML = '';
    document.getElementById('nat1').innerHTML = '';
  }
  document.getElementById('rollType').innerHTML = typeName;

  function showRollModal() {
    $("#rollModal").modal();
  }
  showRollModal();
}

function abilityCheck(value) {
  var modifier = parseInt(value.substring(3), 10);
  var roll = Math.floor(Math.random() * 20) + 1;
  var result = roll + modifier;
  var typeID = value.substring(0,3);
  var typeName = document.getElementById(typeID + 'Name').innerHTML;
  document.getElementById('rollResult').innerHTML = result;
  document.getElementById('rollFormula').innerHTML = roll + ' + (' + modifier + ')';

  if (roll == 20) {
    document.getElementById('nat20').innerHTML = 'Natural 20!';
    document.getElementById('rollResult').classList.add('nat20');
    document.getElementById('rollFormula').classList.add('nat20');
    document.getElementById('rollType').classList.add('nat20');
    document.getElementById('rollResult').classList.remove('nat1');
    document.getElementById('rollFormula').classList.remove('nat1');
    document.getElementById('rollType').classList.remove('nat1');

  }
  else if (roll == 1) {
    document.getElementById('nat1').innerHTML = 'Natural 1!';
    document.getElementById('rollResult').classList.add('nat1');
    document.getElementById('rollFormula').classList.add('nat1');
    document.getElementById('rollType').classList.add('nat1');
    document.getElementById('rollResult').classList.remove('nat20');
    document.getElementById('rollFormula').classList.remove('nat20');
    document.getElementById('rollType').classList.remove('nat20');
  }
  else {
    document.getElementById('rollResult').classList.remove('nat1');
    document.getElementById('rollFormula').classList.remove('nat1');
    document.getElementById('rollType').classList.remove('nat1');
    document.getElementById('rollResult').classList.remove('nat20');
    document.getElementById('rollFormula').classList.remove('nat20');
    document.getElementById('rollType').classList.remove('nat20');
    document.getElementById('nat20').innerHTML = '';
    document.getElementById('nat1').innerHTML = '';
  }
  document.getElementById('rollType').innerHTML = typeName;

  function showRollModal() {
    $("#rollModal").modal();
  }
  showRollModal();
}

function showBlock(value) {
  var selectedBlock = value;
  var allBlocks = document.getElementsByName('mainBlock');
  if (value == 'all'){
    for (var i = 0; i < allBlocks.length; i++) {
      allBlocks[i].style = "display:block";
    }
  }
  else {
    for (var i = 0; i < allBlocks.length; i++) {
      allBlocks[i].style = "display:none";
    }
    document.getElementById(value).style = "display:block";
  }
};



//INITIALIZE VALUES ON PAGE LOAD
$(document).ready(function lockSheet() {
  addStrProf('strSave');
  addStrProf('athletics');

  addDexProf('dexSave');
  addDexProf('acrobatics');
  addDexProf('sleight');
  addDexProf('stealth');

  addConProf('conSave');

  addIntelProf('intelSave');
  addIntelProf('arcana');
  addIntelProf('history');
  addIntelProf('investigation');
  addIntelProf('nature');
  addIntelProf('religion');

  addWisProf('wisSave');
  addWisProf('animal');
  addWisProf('insight');
  addWisProf('medicine');
  addWisProf('perception');
  addWisProf('survival');

  addChaProf('chaSave');
  addChaProf('deception');
  addChaProf('intimidation');
  addChaProf('performance');
  addChaProf('persuasion');
});
</script>

<script>

//SAVE CHARACTER
//on the click of the submit button
function saveSheet(){
      var newProf = '';
      var newSaves = '';
      var newExpert = '';
      var charID = <?php echo $charID; ?>;

  if ($('#athleticsProf').prop('checked')) {
      newProf = newProf + 'Athletics' + ' ';
  }
  if ($('#acrobaticsProf').prop('checked')) {
      newProf = newProf + 'Acrobatics' + ' ';
  }
  if ($('#sleightProf').prop('checked')) {
      newProf = newProf + 'Sleight of Hand' + ' ';
  }
  if ($('#stealthProf').prop('checked')) {
      newProf = newProf + 'Stealth' + ' ';
  }
  if ($('#arcanaProf').prop('checked')) {
      newProf = newProf + 'Arcana' + ' ';
  }
  if ($('#historyProf').prop('checked')) {
      newProf = newProf + 'History' + ' ';
  }
  if ($('#investigationProf').prop('checked')) {
      newProf = newProf + 'Investigation' + ' ';
  }
  if ($('#natureProf').prop('checked')) {
      newProf = newProf + 'Nature' + ' ';
  }
  if ($('#religionProf').prop('checked')) {
      newProf = newProf + 'Religion' + ' ';
  }
  if ($('#animalProf').prop('checked')) {
      newProf = newProf + 'Animal Handling' + ' ';
  }
  if ($('#insightProf').prop('checked')) {
      newProf = newProf + 'Insight' + ' ';
  }
  if ($('#medicineProf').prop('checked')) {
      newProf = newProf + 'Medicine' + ' ';
  }
  if ($('#perceptionProf').prop('checked')) {
      newProf = newProf + 'Perception' + ' ';
  }
  if ($('#survivalProf').prop('checked')) {
      newProf = newProf + 'Survival' + ' ';
  }
  if ($('#deceptionProf').prop('checked')) {
      newProf = newProf + 'Deception' + ' ';
  }
  if ($('#intimidationProf').prop('checked')) {
      newProf = newProf + 'Intimidation' + ' ';
  }
  if ($('#performanceProf').prop('checked')) {
      newProf = newProf + 'Performance' + ' ';
   }
  if ($('#persuasionProf').prop('checked')) {
      newProf = newProf + 'Persuasion' + ' ';
  }


//EXPERTISE
if ($('#athleticsExpert').prop('checked')) {
    newExpert = newExpert + 'Athletics' + ' ';
}
if ($('#acrobaticsExpert').prop('checked')) {
    newExpert = newExpert + 'Acrobatics' + ' ';
}
if ($('#sleightExpert').prop('checked')) {
    newExpert = newExpert + 'Sleight of Hand' + ' ';
}
if ($('#stealthExpert').prop('checked')) {
    newExpert = newExpert + 'Stealth' + ' ';
}
if ($('#arcanaExpert').prop('checked')) {
    newExpert = newExpert + 'Arcana' + ' ';
}
if ($('#historyExpert').prop('checked')) {
    newExpert = newExpert + 'History' + ' ';
}
if ($('#investigationExpert').prop('checked')) {
    newExpert = newExpert + 'Investigation' + ' ';
}
if ($('#natureExpert').prop('checked')) {
    newExpert = newExpert + 'Nature' + ' ';
}
if ($('#religionExpert').prop('checked')) {
    newExpert = newExpert + 'Religion' + ' ';
}
if ($('#animalExpert').prop('checked')) {
    newExpert = newExpert + 'Animal Handling' + ' ';
}
if ($('#insightExpert').prop('checked')) {
    newExpert = newExpert + 'Insight' + ' ';
}
if ($('#medicineExpert').prop('checked')) {
    newExpert = newExpert + 'Medicine' + ' ';
}
if ($('#perceptionExpert').prop('checked')) {
    newExpert = newExpert + 'Perception' + ' ';
}
if ($('#survivalExpert').prop('checked')) {
    newExpert = newExpert + 'Survival' + ' ';
}
if ($('#deceptionExpert').prop('checked')) {
    newExpert = newExpert + 'Deception' + ' ';
}
if ($('#intimidationExpert').prop('checked')) {
    newExpert = newExpert + 'Intimidation' + ' ';
}
if ($('#performanceExpert').prop('checked')) {
    newExpert = newExpert + 'Performance' + ' ';
 }
if ($('#persuasionExpert').prop('checked')) {
    newExpert = newExpert + 'Persuasion' + ' ';
}


//SAVE SAVING THROW PROFICIENCIES
  if ($('#strSaveProf').prop('checked')) {
      newSaves = newSaves + 'Strength' + ' ';
  }
  if ($('#dexSaveProf').prop('checked')) {
      newSaves = newSaves + 'Dexterity' + ' ';
  }
  if ($('#conSaveProf').prop('checked')) {
      newSaves = newSaves + 'Constitution' + ' ';
  }
  if ($('#intelSaveProf').prop('checked')) {
      newSaves = newSaves + 'Intelligence' + ' ';
  }
  if ($('#wisSaveProf').prop('checked')) {
      newSaves = newSaves + 'Wisdom' + ' ';
  }
  if ($('#chaSaveProf').prop('checked')) {
      newSaves = newSaves + 'Charisma' + ' ';
  }

 //get the form values
 var strScore = $('#strScore').val();
 var dexScore = $('#dexScore').val();
 var conScore = $('#conScore').val();
 var intelScore = $('#intScore').val();
 var wisScore = $('#wisScore').val();
 var chaScore = $('#chaScore').val();
 var initiative = $('#initiative').val();
 var maxhp = $('#maxHP').val();
 var speed = $('#speed').val();
 var armorclass = $('#armorClass').val();
 var charName = $('#charName').val();
 var charLevel = $('#charLevel').val();
 var charRace = $('#charRace').val();
 var charBackground = $('#charBackground').val();
 var charAlignment = $('#charAlignment').val();
 var attack1 = $('#attack1').html();
 var attack2 = $('#attack2').html();
 var charAttacks = "";
  if (attack1 !== "null") {
    charAttacks = charAttacks + attack1;
    if (attack2 !== "null") {
      charAttacks = charAttacks + "," + attack2;
    }
  }

 var at3Select = $('#attack3Select').val();
 var at3Range = $('#at3Range').val();
 var at3Damage = $('#at3Damage').val();
 var at3ToHit = $('#at3ToHit').val();
 var at4Select = $('#attack4Select').val();
 var at4Range = $('#at4Range').val();
 var at4Damage = $('#at4Damage').val();
 var at4ToHit = $('#at4ToHit').val();
 var charMultiLevel = $('#multiLevel').val();

 var at3Array = [at3Select, at3Range, at3Damage, at3ToHit];
 var at4Array = [at4Select, at4Range, at4Damage, at4ToHit];
 at3Array = at3Array.join('_');
 at4Array = at4Array.join('_');
 var customAttacks = at3Array + '_' + at4Array;

 var charClassTemp = $('#charClass').val();
 var charClassLower = charClassTemp.toLowerCase();


 var charClassNs = charClassLower.replace(/ +/g, "");
 var charSubTemp = "#" + charClassNs + "SubList";
 var charSubClass = $(charSubTemp).val();
 var charClass = charClassLower + " (" + charSubClass + ")";
 if (charClassLower == 'fighter' || charClassLower == 'paladin' || charClassLower == 'ranger' || charClassLower == 'blood hunter' || charClassLower == 'revised ranger'){
   var hitdice = 10;
 }
 else if (charClassLower == 'wizard' || charClassLower == 'sorcerer'){
   var hitdice = 6;
 }
 else if (charClassLower == 'barbarian') {
  var hitdice = 12;
 }
 else {
  var hitdice = 8;
 }
 var charMultiLevelTemp = $('#multiLevel').val();
 var charMultiClassTemp = $('#charMulti').val();
 //var charMultiSubclassTemp = $('#multiSubclass').val();

 if  (charMultiClassTemp == '0'){
   var charMultiClass = 'Ranger (Gloom Stalker)';
   charMultiLevel = '0';
 }
else {
 var charMultiClassLower = charMultiClassTemp.toLowerCase();
 var charMultiClassNs = charMultiClassLower.replace(/ +/g, "");
 var charMultiSubTemp = "#" + charMultiClassNs + "SubList1";

 var charSubClass = $(charSubTemp).val();
 var charClass = charClassLower + " (" + charSubClass + ")";
 if (charMultiClassLower == 'fighter' || charMultiClassLower == 'paladin' || charMultiClassLower == 'ranger' || charMultiClassLower == 'blood hunter' || charMultiClassLower == 'revised ranger'){
   var charHitdie2 = 10;
 }
 else if (charMultiClassLower == 'wizard' || charMultiClassLower == 'sorcerer'){
   var charHitdie2 = 6;
 }
 else if (charMultiClassLower == 'barbarian') {
  var charHitdie2 = 12;
 }
 else {
  var charHitdie2 = 8;
 }
 if (charMultiLevel == '0'){
    charHitdie2 = 0;
  }
 var charMultiSubClass = $(charMultiSubTemp).val();
 var charMultiClass = charMultiClassLower + " (" + charMultiSubClass + ")";
}

 var charSpells = $('#currentSpells').html();
 var charFeats = $('#currentFeats').html();
 var charNotes = $('#charNotes').val();
 var charItems = $('#currentItemsRaw').html();
 charSpells = charSpells.replace('\'', '_');


 //make the postdata
 //call your input.php script in the background, when it returns it will call the success function if the request was successful or the error one if there was an issue (like a 404, 500 or any other error status)

 $.ajax({
    url : 'charprocess.php',
    type: 'GET',
    data : { "charID" : charID, "proficiencies" : newProf, "title" : charName, "saves" : newSaves, "expertise" : newExpert, "strength" : strScore, "dexterity" : dexScore, "constitution" : conScore, "intelligence" : intelScore, "wisdom" : wisScore, "charisma" : chaScore, "initiative" : initiative, "maxhp" : maxhp, "hitdice" : hitdice, "speed" : speed, "armorclass" : armorclass, "charClass" : charClass,
    "charRace" : charRace, "charLevel" : charLevel, "charBackground" : charBackground, "charAlignment" : charAlignment, "attacks" : charAttacks, "spells" : charSpells, "customAttacks" : customAttacks, "charNotes" : charNotes, "charItems" : charItems, "charFeats" : charFeats, "charMultiClass" : charMultiClass, "charMultiLevel" : charMultiLevel, "hitdice2" : charHitdie2 },
    success: function()
    {
        //if success then just output the text to the status div then clear the form inputs to prepare for new data
      //  $("#favButton").addClass('disabled');
        //$('#favButton').html('In Favourites');
        var newURL = '/tools/users/characters.php?id=' + charName;
        $(location).attr('href', newURL)
    },
    error: function (jqXHR, status, errorThrown)
    {
        //if fail show error and server status
        $("#status_text").html('there was an error ' + errorThrown + ' with status ' + textStatus);
    }
});
};

    </script>
<?php
  }
  ?>

  <!-- Item Modal -->
  <div class="modal fade bd-example-modal-lg" id="rollModal" role="dialog">
    <div class="modal-dialog" style="width: 80%; max-width:1200px;">

      <!-- Modal content-->
      <div class="modal-content modalstyle bodytext" style="height:100%;">
        <div class="modal-header" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        <div class="modal-body" id="rollModalBody" style="height:100%; padding-top: 0px;">
          <div class="rollname col-centered" id="rollType"></div>
          <div class="rollnumber col-centered" id="rollResult"></div>
          <div class="rollformula col-centered" id="rollFormula"></div>
          <div class="nat20 col-centered" id="nat20"></div>
          <div class="nat1 col-centered" id="nat1"></div>

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

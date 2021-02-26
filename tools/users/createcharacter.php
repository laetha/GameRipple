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
?>
<script src="/plugins/rpg-dice-roller-master/dice-roller.js"></script>
<script>
$(document).ready(function (){
  showCharModal();
}
);

function showCharModal() {
  $("#charModal").modal({backdrop: 'static', keyboard: false});
  showCharModal();
}

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
</script>

  <!-- Item Modal -->
  <div class="modal fade bd-example-modal-lg" id="charModal" role="dialog">
    <div class="modal-dialog" style="max-width:1200px;">

      <!-- Modal content-->
      <div class="modal-content modalstyle bodytext" style="height:100%;">
        <div class="modal-header" style="padding-bottom: 0px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
        <div class="modal-body createModal" id="charModalBody" style="height:100%; padding-top: 0px;">

          <div id="charNameShow">
                <div class="col-centered">Character Name</div>
                <input class="bigInput col-centered" id="charNameAdd" value="" placeholder="Character Name..."></input>
                <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addName()">Next</button></div>
              </div>

              <div id="charRaceShow" style="display:none;">
                <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addRace()">Next</button></div>
                <div class="col-centered">Race</div>
                <div class="col-xs-12"><select class="charClassSelect sheetDrop" name="charRaceAdd" id="charRaceAdd"  onchange="showRaceDetails()">
                  <option value="">Select Race...
                  <?php
                  $racetitle = "SELECT title, raceAbility FROM `compendium` WHERE `type` LIKE 'race'";
                  $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
                  while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
                    $raceNameNoR = str_replace('(race)', '', $row1['title']);
                    $raceNameClean = preg_replace('/[^a-z\d]+/i', '', $raceNameNoR);
                    $raceNameNS = str_replace(' ', '', $raceNameClean);
                      echo ('<option value="'.$row1['title'].'">'.$raceNameNoR.'</option>');
                  }

                   ?>
                </select>
                <?php
                $racetitle = "SELECT title, raceAbility FROM `compendium` WHERE `type` LIKE 'race'";
                $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
                while($row2 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
                  $raceNameNoR = str_replace('(race)', '', $row2['title']);
                  $raceNameClean = preg_replace('/[^a-z\d]+/i', '', $raceNameNoR);
                  $raceNameNS = str_replace(' ', '', $raceNameClean);
                echo ('<div class="hide" id="'.$raceNameNS.'stats">'.$row2['raceAbility'].'</div>');
              }
                ?>
              </div>
                <div class="col-xs-12 iframe-container"><iframe class="charCreateFrame" frameBorder="0" id="raceDetails" seamless></iframe></div>
              </div>


              <div id="charClassShow" style="display:none;">
                <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addClass()">Next</button></div>
                <div class="col-centered">Class</div>
                <div class="col-xs-12"><select class="charClassSelect sheetDrop" name="charClasseAdd" id="charClassAdd"  onchange="showClassDetails()">
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


              <div id="charSubclassShow" style="display:none;">
                <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addSubclass()">Next</button></div>
                <div class="col-centered">Subclass</div>
                <div class="col-xs-12"><select class="charSubclassSelect sheetDrop" name="charSubClassAdd" id="charSubclassAdd"  onchange="showSubclassDetails()">
                  <option value="">Select Subclass...
                  <?php
                  $racetitle = "SELECT name, class FROM `subclasses` WHERE `name` NOT LIKE '%core%'";
                  $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
                  while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
                    $classns = str_replace(' ', '', $row1['class']);
                    //$classNameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
                    echo ('<option class="'.$classns.'" style="display:none;" value="'.$row1['name'].'">'.$row1['name']);
                  }
                   ?>
                </select>
              </div>
                <div class="col-xs-12 iframe-container"><iframe class="charCreateFrame" frameBorder="0" id="subclassDetails" seamless></iframe></div>
            </div>

            <div id="charBackgroundShow" style="display:none;">
              <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addBackground()">Next</button></div>
              <div class="col-centered">Background</div>
              <div class="col-xs-12"><select class="charBackgroundSelect sheetDrop" name="charBackgroundAdd" id="charBackgroundAdd"  onchange="showBackgroundDetails()">
                <option value="">Select Background...
                <?php
                $racetitle = "SELECT title FROM `compendium` WHERE `type` LIKE 'background'";
                $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
                while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
                  echo ('<option value="'.$row1['title'].'">'.$row1['title']);
                }
                 ?>
              </select>
            </div>
              <div class="col-xs-12 iframe-container"><iframe class="charCreateFrame" frameBorder="0" id="backgroundDetails" seamless></iframe></div>
            </div>

<!-- BRIAN -->
            <div id="charProfsShow" style="display:none;">
              <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addClassProfs()">Next</button></div>
              <div class="col-centered">Proficiency</div>
              <div id="profWarning"></div>
                <?php
                $racetitle = "SELECT * FROM `subclasses` WHERE `name` LIKE '%core%'";
                $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
                while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
                  $classns = str_replace(' ', '', $row1['class']);
                  $profnum = $row1['numSkills'];
                  echo ('<div id="'.$classns.'prof" style="display:none;">');
                  echo ('<div>You may now choose '.$profnum.' additional proficiencies.</div>');
                  $profarray = explode(", ", $row1['proficiency']);
                  for ($i=0; $i < $profnum; $i++) {
                    echo ('<select id="'.$classns.'prof'.$i.'" onchange="prof'.$i.'(\''.$classns.'\')">');
                    echo ('<option value="" selected>');
                    foreach ($profarray as $item) {
                      echo ('<option value="'.$item.'">'.$item);
                    }
                    echo ('</select>');
                  }
                  echo ('</div>');
                }
                 ?>
            </div>


      <div id="charStatsShow"  style="display:none;">
        <div class="col-centered">Stats</div>
        <div class="col-md-12">
          <div class="col-centered"><button class="btn btn-primary" style="margin-bottom: 8px;" onclick="rollStats()">Roll An Array For Me</button></div>
          <div class="col-sm-4 sidebartext">Stat 1
          <input class="statInput" name="stat1" id="stat1" value="" onkeyup="calcStats()"></input>
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
          <div class="col-sm-4 sidebartext">Stat 2
          <input class="statInput" name="stat2" id="stat2" value="" onkeyup="calcStats()"></input>
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
          <div class="col-sm-4 sidebartext">Stat 3
          <input class="statInput" name="stat3" id="stat3" value="" onkeyup="calcStats()"></input>
          <select class="classSelect" id="stat3drop" onchange="calcStats()">
            <option id="stat3null" value="null" selected>
            <option id="stat3str" value="str">STR
            <option id="stat3dex" value="dex">DEX
            <option id="stat3con" value="con">CON
            <option id="stat3intel" value="int">INT
            <option id="stat3wis" value="wis">WIS
            <option id="stat3cha" value="cha">CHA
          </select>
          </div>
          <div class="col-sm-4 sidebartext">Stat 4
          <input class="statInput" name="stat4" id="stat4" value="" onkeyup="calcStats()"></input>
          <select class="classSelect" id="stat4drop" onchange="calcStats()">
            <option id="stat4null" value="null" selected>
            <option id="stat4str" value="str">STR
            <option id="stat4dex" value="dex">DEX
            <option id="stat4con" value="con">CON
            <option id="stat4intel" value="int">INT
            <option id="stat4wis" value="wis">WIS
            <option id="stat4cha" value="cha">CHA
          </select>
          </div>
          <div class="col-sm-4 sidebartext">Stat 5
          <input class="statInput" name="stat5" id="stat5" value="" onkeyup="calcStats()"></input>
          <select class="classSelect" id="stat5drop" onchange="calcStats()">
            <option id="stat5null" value="null" selected>
            <option id="stat5str" value="str">STR
            <option id="stat5dex" value="dex">DEX
            <option id="stat5con" value="con">CON
            <option id="stat5intel" value="int">INT
            <option id="stat5wis" value="wis">WIS
            <option id="stat5cha" value="cha">CHA
          </select>
          </div>
          <div class="col-sm-4 sidebartext">Stat 6
          <input class="statInput" name="stat6" id="stat6" value="" onkeyup="calcStats()"></input>
          <select class="classSelect" id="stat6drop" onchange="calcStats()">
            <option id="stat6null" value="null" selected>
            <option id="stat6str" value="str">STR
            <option id="stat6dex" value="dex">DEX
            <option id="stat6con" value="con">CON
            <option id="stat6intel" value="int">INT
            <option id="stat6wis" value="wis">WIS
            <option id="stat6cha" value="cha">CHA
          </select>
          </div>
          <div style="color:red; display:none;" id="statError">ERROR: You must select each stat type once.</div>
      </div>
      <table style="width:100%;">
        <tr>
          <td>STR</td>
          <td>DEX</td>
          <td>CON</td>
          <td>INT</td>
          <td>WIS</td>
          <td>CHA</td>
        </tr>
          <td><div id="Strtotal"></div><div class="smallertext" id="strStat"></div><div class="smallertext" id="StrBonus"></div></td>
          <td><div id="Dextotal"></div><div class="smallertext" id="dexStat"></div><div class="smallertext" id="DexBonus"></div></td>
          <td><div id="Contotal"></div><div class="smallertext" id="conStat"></div><div class="smallertext" id="ConBonus"></div></td>
          <td><div id="Inttotal"></div><div class="smallertext" id="intStat"></div><div class="smallertext" id="IntBonus"></div></td>
          <td><div id="Wistotal"></div><div class="smallertext" id="wisStat"></div><div class="smallertext" id="WisBonus"></div></td>
          <td><div id="Chatotal"></div><div class="smallertext" id="chaStat"></div><div class="smallertext" id="ChaBonus"></div></td>
        </tr>
      </table>
        <div class="col-centered"><button class="btn btn-info" class="nextButton" onclick="addStats()">Create Character</button></div>
      </div>

      <div class="hide" id="applySaves">
        <?php
        $racetitle = "SELECT * FROM `subclasses` WHERE `name` LIKE '%core%'";
        $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
          $nameClean = ucwords(substr($row1['name'], 0, strpos($row1['name'], " core")));
          $namens = str_replace(' ', '', $nameClean);
          echo ('<div id="'.$namens.'saves">'.$row1['saves'].'</div>');
        }
         ?>
      </div>

      <div class="hide" id="applyProfs">
        <?php
        $racetitle = "SELECT title, backgroundProficiency FROM `compendium` WHERE `type` LIKE 'background'";
        $racedata = mysqli_query($dbcon, $racetitle) or die('error getting data');
        while($row1 =  mysqli_fetch_array($racedata, MYSQLI_ASSOC)) {
          $nameClean = $row1['title'];
          $namens = str_replace(' ', '', $nameClean);
          $namens = str_replace('(', '', $namens);
          $namens = str_replace(')', '', $namens);
          echo ('<div id="'.$namens.'profs">'.$row1['backgroundProficiency'].'</div>');
        }
         ?>
      </div>

        </div>
      </div>
    </div>
  </div>
<div class="hide">
<div class="sidebartext" id="charName"></div>
<div class="sidebartext" id="charRace"></div>
<div class="sidebartext" id="charClass"></div>
<div class="sidebartext" id="charSubclass"></div>
<div class="sidebartext" id="charBackground"></div>
<div class="sidebartext" id="charstr">1</div>
<div class="sidebartext" id="chardex">1</div>
<div class="sidebartext" id="charcon">1</div>
<div class="sidebartext" id="charint">1</div>
<div class="sidebartext" id="charwis">1</div>
<div class="sidebartext" id="charcha">1</div>
<div class="sidebartext" id="test">1</div>
<div class="sidebartext" id="charSaves"></div>
<div id="classprof1"></div>
<div id="classprof2"></div>
<div id="classprof3"></div>
<div id="classprof0"></div>
<div id="classprofs"></div>
</div>



<script>
function addName() {
  var charName = document.getElementById('charNameAdd').value;
  if (charName == ''){
  }
  else {
  document.getElementById('charName').innerHTML = charName;
  $('#charNameShow').fadeOut(500);
  $('#charRaceShow').delay(400).fadeIn(300);
}
};

function addRace() {
  var charRace = document.getElementById('charRaceAdd').value;
  if (charRace == ''){
  }
  else {
  document.getElementById('charRace').innerHTML = charRace;
  $('#charRaceShow').fadeOut(500);
  $('#charClassShow').delay(400).fadeIn(300);
}
};

function addClass() {
  var charClass = document.getElementById('charClassAdd').value;
  var charClassns = charClass.replace(' ', '');
  document.getElementById(charClassns + 'prof').style = "display:block";
  if (charClass == ''){
  }
  else {
  document.getElementById('charClass').innerHTML = charClass;
  jQuery('.' + charClassns).toggleOption(true); // show option
  $('#charClassShow').fadeOut(500);
  $('#charSubclassShow').delay(400).fadeIn(300);
}
};

function addSubclass() {
  var charSubclass = document.getElementById('charSubclassAdd').value;
  if (charSubclass == ''){
  }
  else {
  document.getElementById('charSubclass').innerHTML = charSubclass;
  $('#charSubclassShow').fadeOut(500);
  $('#charBackgroundShow').delay(400).fadeIn(300);
}
};

function addBackground() {
  var charBackground = document.getElementById('charBackgroundAdd').value;
  var charBackgroundNs = charBackground.replace(/ /g, '');
  var charBackgroundClean = charBackgroundNs.replace('(', '');
  charBackgroundClean = charBackgroundClean.replace(')', '');
  if (charBackground == ''){
  }
    else {
  document.getElementById('charBackground').innerHTML = charBackground;
  var currentRace = document.getElementById('charRace').innerHTML;
  var currentRaceStrip = currentRace.replace('(', '');
  currentRaceStrip = currentRaceStrip.replace(')', '');
  if (currentRaceStrip.endsWith("race") == true) {
      currentRaceStrip = currentRaceStrip.substring(0, currentRaceStrip.length-4);
      document.getElementById('test').innerHTML = currentRaceStrip;
  }
  var currentRaceNS = currentRaceStrip.replace(' ', '');
  var racialStats = document.getElementById(currentRaceNS + 'stats').innerHTML;
  var raceStatsArray = racialStats.split(", ");
  for (var i = 0; i < raceStatsArray.length; i++) {
    var stattype = raceStatsArray[i].slice(0,3);
    var stat = raceStatsArray[i].slice(4);
    document.getElementById(stattype + 'Bonus').innerHTML =  "+" + stat;

  }
  /*var stat1type = raceStatsArray[0].slice(0,3);
  var stat2type = raceStatsArray[1].slice(0,3);
  var stat3type = raceStatsArray[2].slice(0,3);
  var stat4type = raceStatsArray[3].slice(0,3);
  var stat5type = raceStatsArray[4].slice(0,3);
  var stat6type = raceStatsArray[5].slice(0,3);
  var stat1 = raceStatsArray[0].slice(4);
  var stat2 = raceStatsArray[1].slice(4);
  var stat3 = raceStatsArray[2].slice(4);
  var stat4 = raceStatsArray[3].slice(4);
  var stat5 = raceStatsArray[4].slice(4);
  var stat6 = raceStatsArray[5].slice(4);
  document.getElementById(stat1type + 'Bonus').innerHTML =  "+" + stat1;
  document.getElementById(stat2type + 'Bonus').innerHTML = "+" + stat2;
  document.getElementById(stat3type + 'Bonus').innerHTML = "+" + stat3;
  document.getElementById(stat4type + 'Bonus').innerHTML = "+" + stat4;
  document.getElementById(stat5type + 'Bonus').innerHTML = "+" + stat5;
  document.getElementById(stat6type + 'Bonus').innerHTML = "+" + stat6;*/

  var profs = document.getElementById(charBackgroundClean + 'profs').innerHTML;
  document.getElementById('profWarning').innerHTML = "From your background choice you are already proficient in: " + profs;
  $('#charBackgroundShow').fadeOut(500);
  $('#charProfsShow').delay(400).fadeIn(300);
  }
};

function prof1(value){
  var prof1 = $('#' + value + 'prof1').val();
  document.getElementById('classprof1').innerHTML = prof1;
};

function prof2(value){
  var prof2 = $('#' + value + 'prof2').val();
  document.getElementById('classprof2').innerHTML = prof2;
};

function prof3(value){
  var prof3 = $('#' + value + 'prof3').val();
  document.getElementById('classprof3').innerHTML = prof3;
};

function prof0(value){
  var prof0 = $('#' + value + 'prof0').val();
  document.getElementById('classprof0').innerHTML = prof0;
};

function addClassProfs(){
  var prof1 = $('#classprof1').html();
  var prof2 = $('#classprof2').html();
  var prof3 = $('#classprof3').html();
  var prof0 = $('#classprof0').html();
  var classprofs = '';
  if (prof0 !== ''){
    classprofs = prof0;
  }
  if (prof1 !== ''){
    classprofs = classprofs + ' ' + prof1;
  }
  if (prof2 !== ''){
    classprofs = classprofs + ' ' + prof2;
  }
  if (prof3 !== ''){
    classprofs = classprofs + ' ' + prof3;
  }
  document.getElementById('classprofs').innerHTML = classprofs;
  $('#charProfsShow').fadeOut(500);
  $('#charStatsShow').delay(400).fadeIn(300);
};

function calcStats() {
  var strBonus = $('#StrBonus').html();
  var dexBonus = $('#DexBonus').html();
  var conBonus = $('#ConBonus').html();
  var intBonus = $('#IntBonus').html();
  var wisBonus = $('#WisBonus').html();
  var chaBonus = $('#ChaBonus').html();
  strBonus = strBonus.replace(/[+]/g, '');
  dexBonus = dexBonus.replace(/[+]/g, '');
  conBonus = conBonus.replace(/[+]/g, '');
  intBonus = intBonus.replace(/[+]/g, '');
  wisBonus = wisBonus.replace(/[+]/g, '');
  chaBonus = chaBonus.replace(/[+]/g, '');
  var stat1Val = $('#stat1').val();
  var stat1Type = $('#stat1drop').val();
  var stat1 = stat1Type + ',' + stat1Val;
  var stat2Val = $('#stat2').val();
  var stat2Type = $('#stat2drop').val();
  var stat2 = stat2Type + ',' + stat2Val;
  var stat3Val = $('#stat3').val();
  var stat3Type = $('#stat3drop').val();
  var stat3 = stat3Type + ',' + stat3Val;
  var stat4Val = $('#stat4').val();
  var stat4Type = $('#stat4drop').val();
  var stat4 = stat4Type + ',' + stat4Val;
  var stat5Val = $('#stat5').val();
  var stat5Type = $('#stat5drop').val();
  var stat5 = stat5Type + ',' + stat5Val;
  var stat6Val = $('#stat6').val();
  var stat6Type = $('#stat6drop').val();
  var stat6 = stat6Type + ',' + stat6Val;
  var stat1Final = 0;
  var stat2Final = 0;
  var stat3Final = 0;
  var stat4Final = 0;
  var stat5Final = 0;
  var stat6Final = 0;
  //document.getElementById('test').innerHTML = stat6;
  if (stat1.includes('null') == false){
    var st1 = stat1.substring(0, stat1.indexOf(","));
    var stat1ID = st1.charAt(0).toUpperCase() + st1.slice(1) + 'total';
    var stat1stat = st1 + 'Stat';
    var stat1Bonus = st1.charAt(0).toUpperCase() + st1.slice(1) + 'Bonus';
    if (st1.includes('str') == true) {
      stat1Final = Number(strBonus) + Number(stat1Val);
    }
    if (st1.includes('dex') == true) {
      stat1Final = Number(dexBonus) + Number(stat1Val);
    }
    if (st1.includes('con') == true) {
      stat1Final = Number(conBonus) + Number(stat1Val);
    }
    if (st1.includes('int') == true) {
      stat1Final = Number(intBonus) + Number(stat1Val);
    }
    if (st1.includes('wis') == true) {
      stat1Final = Number(wisBonus) + Number(stat1Val);
    }
    if (st1.includes('cha') == true) {
      stat1Final = Number(chaBonus) + Number(stat1Val);
    }
    //document.getElementById(stat1stat).innerHTML = stat1Val;
    document.getElementById(stat1ID).innerHTML = stat1Final;
  }
  if (stat2.includes('null') == false){
    var st2 = stat2.substring(0, stat2.indexOf(","));
    var stat2ID = st2.charAt(0).toUpperCase() + st2.slice(1) + 'total';
    var stat2stat = st2.charAt(0).toUpperCase() + st2.slice(1) + 'Stat';
    if (st2.includes('str') == true) {
      stat2Final = Number(strBonus) + Number(stat2Val);
    }
    if (st2.includes('dex') == true) {
      stat2Final = Number(dexBonus) + Number(stat2Val);
    }
    if (st2.includes('con') == true) {
      stat2Final = Number(conBonus) + Number(stat2Val);
    }
    if (st2.includes('int') == true) {
      stat2Final = Number(intBonus) + Number(stat2Val);
    }
    if (st2.includes('wis') == true) {
      stat2Final = Number(wisBonus) + Number(stat2Val);
    }
    if (st2.includes('cha') == true) {
      stat2Final = Number(chaBonus) + Number(stat2Val);
    }
    document.getElementById(stat2ID).innerHTML = stat2Final;
  }
  if (stat3.includes('null') == false){
    var st3 = stat3.substring(0, stat3.indexOf(","));
    var stat3ID = st3.charAt(0).toUpperCase() + st3.slice(1) + 'total';
    var stat3stat = st3.charAt(0).toUpperCase() + st3.slice(1) + 'Stat';
    if (st3.includes('str') == true) {
      stat3Final = Number(strBonus) + Number(stat3Val);
    }
    if (st3.includes('dex') == true) {
      stat3Final = Number(dexBonus) + Number(stat3Val);
    }
    if (st3.includes('con') == true) {
      stat3Final = Number(conBonus) + Number(stat3Val);
    }
    if (st3.includes('int') == true) {
      stat3Final = Number(intBonus) + Number(stat3Val);
    }
    if (st3.includes('wis') == true) {
      stat3Final = Number(wisBonus) + Number(stat3Val);
    }
    if (st3.includes('cha') == true) {
      stat3Final = Number(chaBonus) + Number(stat3Val);
    }
    document.getElementById(stat3ID).innerHTML = stat3Final;
  }
  if (stat4.includes('null') == false){
    var st4 = stat4.substring(0, stat4.indexOf(","));
    var stat4ID = st4.charAt(0).toUpperCase() + st4.slice(1) + 'total';
    var stat4stat = st4.charAt(0).toUpperCase() + st4.slice(1) + 'Stat';
    if (st4.includes('str') == true) {
      stat4Final = Number(strBonus) + Number(stat4Val);
    }
    if (st4.includes('dex') == true) {
      stat4Final = Number(dexBonus) + Number(stat4Val);
    }
    if (st4.includes('con') == true) {
      stat4Final = Number(conBonus) + Number(stat4Val);
    }
    if (st4.includes('int') == true) {
      stat4Final = Number(intBonus) + Number(stat4Val);
    }
    if (st4.includes('wis') == true) {
      stat4Final = Number(wisBonus) + Number(stat4Val);
    }
    if (st4.includes('cha') == true) {
      stat4Final = Number(chaBonus) + Number(stat4Val);
    }
    document.getElementById(stat4ID).innerHTML = stat4Final;
  }
  if (stat5.includes('null') == false){
    var st5 = stat5.substring(0, stat5.indexOf(","));
    var stat5ID = st5.charAt(0).toUpperCase() + st5.slice(1) + 'total';
    var stat5stat = st5.charAt(0).toUpperCase() + st5.slice(1) + 'Stat';
    if (st5.includes('str') == true) {
      stat5Final = Number(strBonus) + Number(stat5Val);
    }
    if (st5.includes('dex') == true) {
      stat5Final = Number(dexBonus) + Number(stat5Val);
    }
    if (st5.includes('con') == true) {
      stat5Final = Number(conBonus) + Number(stat5Val);
    }
    if (st5.includes('int') == true) {
      stat5Final = Number(intBonus) + Number(stat5Val);
    }
    if (st5.includes('wis') == true) {
      stat5Final = Number(wisBonus) + Number(stat5Val);
    }
    if (st5.includes('cha') == true) {
      stat5Final = Number(chaBonus) + Number(stat5Val);
    }
    document.getElementById(stat5ID).innerHTML = stat5Final;
  }
  if (stat6.includes('null') == false){
    var st6 = stat6.substring(0, stat6.indexOf(","));
    var stat6ID = st6.charAt(0).toUpperCase() + st6.slice(1) + 'total';
    var stat6stat = st6.charAt(0).toUpperCase() + st6.slice(1) + 'Stat';
    if (st6.includes('str') == true) {
      stat6Final = Number(strBonus) + Number(stat6Val);
    }
    if (st6.includes('dex') == true) {
      stat6Final = Number(dexBonus) + Number(stat6Val);
    }
    if (st6.includes('con') == true) {
      stat6Final = Number(conBonus) + Number(stat6Val);
    }
    if (st6.includes('int') == true) {
      stat6Final = Number(intBonus) + Number(stat6Val);
    }
    if (st6.includes('wis') == true) {
      stat6Final = Number(wisBonus) + Number(stat6Val);
    }
    if (st6.includes('cha') == true) {
      stat6Final = Number(chaBonus) + Number(stat6Val);
    }
    document.getElementById(stat6ID).innerHTML = stat6Final;
  }
  //strTotal = parseInt(strBonus) + parseInt()
};

function addStats() {
  var charStat1 = $('#stat1').val();
  var charStat2 = $('#stat2').val();
  var charStat3 = $('#stat3').val();
  var charStat4 = $('#stat4').val();
  var charStat5 = $('#stat5').val();
  var charStat6 = $('#stat6').val();
  var charstr = $('#Strtotal').html();
  var chardex = $('#Dextotal').html();
  var charcon = $('#Contotal').html();
  var charint = $('#Inttotal').html();
  var charwis = $('#Wistotal').html();
  var charcha = $('#Chatotal').html();
  var charStat1Type = $('#stat1drop').val();
  var charStat2Type = $('#stat2drop').val();
  var charStat3Type = $('#stat3drop').val();
  var charStat4Type = $('#stat4drop').val();
  var charStat5Type = $('#stat5drop').val();
  var charStat6Type = $('#stat6drop').val();
  var a = [charStat1Type,charStat2Type,charStat3Type,charStat4Type,charStat5Type,charStat6Type];
  var countstr = 0;
  var countdex = 0;
  var countcon = 0;
  var countintel = 0;
  var countwis = 0;
  var countcha = 0;

for(var i = 0; i < a.length; ++i){
    if(a[i] == 'str')
        countstr++;
}
for(var i = 0; i < a.length; ++i){
    if(a[i] == 'dex')
        countdex++;
}
for(var i = 0; i < a.length; ++i){
    if(a[i] == 'con')
        countcon++;
}
for(var i = 0; i < a.length; ++i){
    if(a[i] == 'int')
        countintel++;
}
for(var i = 0; i < a.length; ++i){
    if(a[i] == 'wis')
        countwis++;
}
for(var i = 0; i < a.length; ++i){
    if(a[i] == 'cha')
        countcha++;
}
  if (countstr != 1 || countdex != 1 || countcon != 1 || countintel != 1 || countwis != 1 || countcha != 1) {
      document.getElementById('statError').style = "display:block";
  }
  else {
    document.getElementById('charstr').innerHTML = charstr;
    document.getElementById('chardex').innerHTML = chardex;
    document.getElementById('charcon').innerHTML = charcon;
    document.getElementById('charint').innerHTML = charint;
    document.getElementById('charwis').innerHTML = charwis;
    document.getElementById('charcha').innerHTML = charcha;
    $('#charStatsShow').fadeOut(500);
    //$('#charProfShow').delay(400).fadeIn(300);
    saveChar();
  }
};

function rollStats(){
  const roller = new DiceRoller();
  var roll1temp = roller.roll('4d6-L');
  roll1string = roll1temp.toString();
  var roll1 = roll1string.split('= ')[1];
  document.getElementById('stat1').value = roll1;

  var roll2temp = roller.roll('4d6-L');
  roll2string = roll2temp.toString();
  var roll2 = roll2string.split('= ')[1];
  document.getElementById('stat2').value = roll2;

  var roll3temp = roller.roll('4d6-L');
  roll3string = roll3temp.toString();
  var roll3 = roll3string.split('= ')[1];
  document.getElementById('stat3').value = roll3;

  var roll4temp = roller.roll('4d6-L');
  roll4string = roll4temp.toString();
  var roll4 = roll4string.split('= ')[1];
  document.getElementById('stat4').value = roll4;

  var roll5temp = roller.roll('4d6-L');
  roll5string = roll5temp.toString();
  var roll5 = roll5string.split('= ')[1];
  document.getElementById('stat5').value = roll5;

  var roll6temp = roller.roll('4d6-L');
  roll6string = roll6temp.toString();
  var roll6 = roll6string.split('= ')[1];
  document.getElementById('stat6').value = roll6;
  calcStats();
};

function showRaceDetails(){
  var selectedRace = document.getElementById('charRaceAdd').value;
  var raceFrame = document.getElementById('raceDetails');
  raceFrame.addEventListener("load", function() {
  this.contentWindow.document.getElementById('nonav').style = "display:none";
  this.contentWindow.document.getElementById('headbody').style = "background:none";
  var mainBox = this.contentWindow.document.getElementsByClassName('mainbox');
  mainBox[0].style = "background:none";
});
  raceFrame.src= "/tools/compendium/compendium.php?id=" + selectedRace;
};

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

function showBackgroundDetails(){
  var selectedBackground = document.getElementById('charBackgroundAdd').value;
  var backgroundFrame = document.getElementById('backgroundDetails');
  backgroundFrame.addEventListener("load", function() {
  this.contentWindow.document.getElementById('nonav').style = "display:none";
  this.contentWindow.document.getElementById('headbody').style = "background:none";
  var mainBox = this.contentWindow.document.getElementsByClassName('mainbox');
  mainBox[0].style = "background:none";
});
  backgroundFrame.src= "/tools/compendium/compendium.php?id=" + selectedBackground;
};

function saveChar(){
  var charName = $('#charName').html();
  var charRace = $('#charRace').html();
  var charClass = $('#charClass').html();
  var charSubclass = $('#charSubclass').html();
  var charBackground = $('#charBackground').html();
  var charstr = $('#charstr').html();
  var chardex = $('#chardex').html();
  var charcon = $('#charcon').html();
  var charint = $('#charint').html();
  var charwis = $('#charwis').html();
  var charcha = $('#charcha').html();
  var fullClass = charClass + ' (' + charSubclass + ')';
  var charUser = '<?php echo $loguser; ?>';
  var charLevel = 1;
  var charHitdie = 0;
  var charClassNs = charClass.replace(' ', '');
  var charBgNs = charBackground.replace(/ /g, '');
  charBgNs = charBgNs.replace("(","").replace(")","");
  var customAttacks = "_______";
  var charSaves = $('#' + charClassNs + 'saves').html();
  charSaves = charSaves.replace(',', '');
  var charProfs = $('#' + charBgNs + 'profs').html();
  charProfs = charProfs.replace(',', '');
  var charClassProfs = $('#classprofs').html();
  charProfs = charProfs + ' ' + charClassProfs;
  if (charClass == 'Artificer' || charClass == 'Bard' || charClass == 'Cleric' || charClass == 'Druid' || charClass == 'Monk' || charClass == 'Mystic' || charClass == 'Rogue'){
    charHitdie = 8;
  }
  else if (charClass == 'Blood Hunter' || charClass == 'Fighter' || charClass == 'Ranger' || charClass == 'Revised Ranger' || charClass == 'Paladin') {
    charHitdie = 10;
  }
  else if (charClass == 'Barbarian'){
    charHitdie = 12;
  }
  else {
    charHitdie = 6;
  }
  var conmod = Math.floor((parseInt(charcon)-10) / 2);
  var maxhp = charHitdie + conmod;
  var charMulti = 'ranger (Gloom Stalker)';
  var multiLevel = 0;


   $.ajax({
      url : 'charcreateprocess.php',
      type: 'GET',
      data : { "charName" : charName, "charRace" : charRace, "fullClass" : fullClass, "charBackground" : charBackground, "charstr" : charstr, "chardex" : chardex, "charcon" : charcon, "charint" : charint, "charwis" : charwis, "charcha" : charcha, "charUser" : charUser, "charLevel" : charLevel, "charHitdie" : charHitdie, "maxhp" : maxhp, "charSaves" : charSaves, "customAttacks" : customAttacks, "charProfs" : charProfs, "charMulti" : charMulti, "multiLevel" : multiLevel },
      success: function()
      {
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

         //Footer
         $footpath = $_SERVER['DOCUMENT_ROOT'];
         $footpath .= "/footer.php";
         include_once($footpath);
         ?>

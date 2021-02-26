<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="/tools/compendium/statblock.css" rel="stylesheet" type="text/css">
<?php
  //SQL Connect
   $pgtitle = 'Initiative - ';
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);
?>

<script src="/plugins/rpg-dice-roller-master/dice-roller.js"></script>

<script>

</script>

<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <h1 class="pagetitle">Initiative Tracker</h1>
  <!-- <p><a href="http://kobold.club/fight/#/encounter-manager" target="_BLANK">Kobold Fight Club Encounters</a></p> -->
  <div class="col-md-12" id="initiative-order" style="text-align:center;">
    <div class="initcontainer" id="initcontainer1"><div class="init" id="init1"><div class="initval" id="initValue1">-5</div></div></div>
    <div class="initcontainer" id="initcontainer2"><div class="init" id="init2"><div class="initval" id="initValue2">-5</div></div></div>
    <div class="initcontainer" id="initcontainer3"><div class="init" id="init3"><div class="initval" id="initValue3">-5</div></div></div>
    <div class="initcontainer" id="initcontainer4"><div class="init" id="init4"><div class="initval" id="initValue4">-5</div></div></div>
    <div class="initcontainer" id="initcontainer5"><div class="init" id="init5"><div class="initval" id="initValue5">-5</div></div></div>
    <div class="initcontainer" id="initcontainer6"><div class="init" id="init6"><div class="initval" id="initValue6">-5</div></div></div>
    <div class="initcontainer" id="initcontainer7"><div class="init" id="init7"><div class="initval" id="initValue7">-5</div></div></div>
    <div class="initcontainer" id="initcontainer8"><div class="init" id="init8"><div class="initval" id="initValue8">-5</div></div></div>
    <div class="initcontainer" id="initcontainer9"><div class="init" id="init9"><div class="initval" id="initValue9">-5</div></div></div>
    <div class="initcontainer" id="initcontainer10"><div class="init" id="init10"><div class="initval" id="initValue10">-5</div></div></div>
    <div class="initcontainer" id="initcontainer11"><div class="init" id="init11"><div class="initval" id="initValue11">-5</div></div></div>
  </div>
  <button onclick="sortInit()">Sort</button>
<!--  <button onclick="lastUp()"><<<</button> -->
  <button onclick="nextUp()">>>></button>

  <script>
  function nextUp(){
    var active = $(".active-init").removeClass('active-init');
  if(active.next() && active.next().length){
     active .next().addClass('active-init');
   }
   else{
     active.siblings(":first").addClass('active-init');
   }

   if(active.next().data('initiativevalue')){
   }
   else {
     active.siblings(":first").addClass('active-init');
   }
}

/* function lastUp(){
  var active = $(".active-init").removeClass('active-init');
if(active.prev() && active.prev().length){
   active .prev().addClass('active-init');
 }
 else{
   active.data('initiativevalue').last().addClass('active-init');
 }

}
*/
  function sortInit(){
    $('#initiative-order').append($('#initiative-order .initcontainer').sort(function(a,b){
     return b.getAttribute('data-initiativevalue')-a.getAttribute('data-initiativevalue');
  }));
  // $('.initcontainer').nextAll('.initcontainer:first').addClass('active');
  $(".initcontainer").removeClass('active-init');
  $(".initcontainer").first().addClass('active-init');
}

  </script>

<div class ="body bodytext">
<div class="col-md-4">
  <select form="import" name="add-monster" id="add-monster" onChange="addMonster(this)">
    <option value="" selected>Add Monster...</option>
    <?php
    $faithdrop = "SELECT title FROM compendium WHERE type LIKE 'monster'";
    $faithdata = mysqli_query($dbcon, $faithdrop) or die('error getting data');
    while($deityrow =  mysqli_fetch_array($faithdata, MYSQLI_ASSOC)) {
      $deity = $deityrow['title'];
      echo "<option value=\"$deity\">$deity</option>";
    }
    ?>
  </select>
  <script type="text/javascript">
  $('#add-monster').selectize({
create: false,
sortField: 'text'
});

  </script>

  <script type="text/javascript">
  var totalxp = 0;
  var output = new Array();
   function addMonster(selectObj) {

     var selectIndex=selectObj.selectedIndex;
     var selectValue=selectObj.options[selectIndex].text;
     //if (typeof select)
     output.push(selectValue);
     var selectValueNoBrackets = selectValue.replace(/"/g, "").replace(/'/g, "").replace(/\(|\)/g, "");
     var selectValueNs = selectValueNoBrackets.replace(/\s/g, '');
     var xpname = selectValueNs + "xp";
     var tempname = selectValueNs + "calc";
     var initname = "init" + selectValueNs;
     var initVal = document.getElementById(initname).innerHTML;
     var newxp1 = document.getElementById(xpname).innerHTML;
     var newxp = parseInt(newxp1);
     totalxp = $("#totalxp").html();
     totalxp = parseInt(totalxp.replace("Total XP = ", '')) || 0;
     totalxp = totalxp + newxp;
     var fullSelect = "show" + selectValueNs;
     document.getElementById(fullSelect).style.display = "block";
     document.getElementById("totalxp").innerHTML = "Total XP = " + totalxp;
     var newhref = "/tools/world/xp.php?id=" + totalxp;
     document.getElementById("xphref").href = newhref;

     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;

if (initDiv1 === "-5") {
       document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
       document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
       document.getElementById("init1").style = "display:block";
}
else if (initDiv2 === "-5"){
  document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init2").style = "display:block";

}
else if (initDiv3 === "-5"){
  document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init3").style = "display:block";

}
else if (initDiv4 === "-5"){
  document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init4").style = "display:block";

}
else if (initDiv5 === "-5"){
  document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init5").style = "display:block";

}
else if (initDiv6 === "-5"){
  document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init6").style = "display:block";

}
else if (initDiv7 === "-5"){
  document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init7").style = "display:block";

}
else if (initDiv8 === "-5"){
  document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init8").style = "display:block";

}
else if (initDiv9 === "-5"){
  document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init9").style = "display:block";

}
else if (initDiv10 === "-5"){
  document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init10").style = "display:block";

}
else if (initDiv11 === "-5"){
  document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
  document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
  document.getElementById("init11").style = "display:block";

}

   }

   function addPlayer1() {
     var initPlayer1 = document.getElementById("initPlayer1").value;
     var namePlayer1 = document.getElementById("namePlayer1").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer1;
     var selectValue = namePlayer1;
     if (initPlayer1 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }

   function addPlayer2() {
     var initPlayer2 = document.getElementById("initPlayer2").value;
     var namePlayer2 = document.getElementById("namePlayer2").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer2;
     var selectValue = namePlayer2;
     if (initPlayer2 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }


   function addPlayer3() {
     var initPlayer3 = document.getElementById("initPlayer3").value;
     var namePlayer3 = document.getElementById("namePlayer3").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer3;
     var selectValue = namePlayer3;
     if (initPlayer3 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }


   function addPlayer4() {
     var initPlayer4 = document.getElementById("initPlayer4").value;
     var namePlayer4 = document.getElementById("namePlayer4").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer4;
     var selectValue = namePlayer4;
     if (initPlayer4 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }


   function addPlayer5() {
     var initPlayer5 = document.getElementById("initPlayer5").value;
     var namePlayer5 = document.getElementById("namePlayer5").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer5;
     var selectValue = namePlayer5;
     if (initPlayer5 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }

   function addPlayer6() {
     var initPlayer6 = document.getElementById("initPlayer6").value;
     var namePlayer6 = document.getElementById("namePlayer6").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer6;
     var selectValue = namePlayer6;
     if (initPlayer6 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }

   function addPlayer7() {
     var initPlayer7 = document.getElementById("initPlayer7").value;
     var namePlayer7 = document.getElementById("namePlayer7").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer7;
     var selectValue = namePlayer7;
     if (initPlayer7 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }

   function addPlayer8() {
     var initPlayer8 = document.getElementById("initPlayer8").value;
     var namePlayer8 = document.getElementById("namePlayer8").value;
     var initDiv1 = document.getElementById("initValue1").innerHTML;
     var initDiv2 = document.getElementById("initValue2").innerHTML;
     var initDiv3 = document.getElementById("initValue3").innerHTML;
     var initDiv4 = document.getElementById("initValue4").innerHTML;
     var initDiv5 = document.getElementById("initValue5").innerHTML;
     var initDiv6 = document.getElementById("initValue6").innerHTML;
     var initDiv7 = document.getElementById("initValue7").innerHTML;
     var initDiv8 = document.getElementById("initValue8").innerHTML;
     var initDiv9 = document.getElementById("initValue9").innerHTML;
     var initDiv10 = document.getElementById("initValue10").innerHTML;
     var initDiv11 = document.getElementById("initValue11").innerHTML;
     var initVal = initPlayer8;
     var selectValue = namePlayer8;
     if (initPlayer8 != "") {
       if (initDiv1 === "-5") {
              document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + selectValue;
              document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
              document.getElementById("init1").style = "display:block";
       }
       else if (initDiv2 === "-5"){
         document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init2").style = "display:block";

       }
       else if (initDiv3 === "-5"){
         document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init3").style = "display:block";

       }
       else if (initDiv4 === "-5"){
         document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init4").style = "display:block";

       }
       else if (initDiv5 === "-5"){
         document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init5").style = "display:block";

       }
       else if (initDiv6 === "-5"){
         document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init6").style = "display:block";

       }
       else if (initDiv7 === "-5"){
         document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init7").style = "display:block";

       }
       else if (initDiv8 === "-5"){
         document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init8").style = "display:block";

       }
       else if (initDiv9 === "-5"){
         document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init9").style = "display:block";

       }
       else if (initDiv10 === "-5"){
         document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init10").style = "display:block";

       }
       else if (initDiv11 === "-5"){
         document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + selectValue;
         document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
         document.getElementById("init11").style = "display:block";

       }

     }

   }


  </script>
  <div id="dice">
  <script src="/plugins/rpg-dice-roller-master/dice-roller.js"></script>
  <div class="sidebartext">
  <form action="" onsubmit="return roll();">
      <input type="text" placeholder="Dice roller..." autofocus="" id="input" style="color:black; font-size: 14px; width:220px;">
      <button type="submit">Roll</button>
    </form>
    <div>
      <div style="float:left;" id="awardbutton"><a id="xphref" href="/tools/world/xp.php?id=0"><button>XP</button></a></div>
      <button style="display:inline-block; margin-left:10px;" id="showplayers">Add Players</button>
      <button style="display:inline-block; margin-left:10px;" id="showencounters">Import</button>
      <div id="totalxp">Total XP = 0</div>

      <div id="encounterAdd" class="margintop" style="display:none;">
         <?php
      $dungeontitle = "SELECT DISTINCT dungeon FROM fights WHERE worlduser LIKE '$loguser' ORDER BY encLabel ASC";
       $dungeondata = mysqli_query($dbcon, $dungeontitle) or die('error getting data');
       while($row1 =  mysqli_fetch_array($dungeondata, MYSQLI_ASSOC)) {
        $dungeonorig = $row1['dungeon'];
        $dungeonquery = str_replace("'", "''", $dungeonorig);
        $dungeon = str_replace("'", "", $dungeonorig);
        $dungeon = str_replace(" ", "", $dungeon);

               echo ('<button class="btn btn-primary margintop" id="'.$dungeon.'" onclick="plusminus()">'.$row1['dungeon'].' +</button>');
               ?>
               <script>
                $(document).ready(function showPlayers(){
        $("#<?php echo $dungeon; ?>").click(function addLog(){
            $("#<?php echo ($dungeon.'show'); ?> ").slideToggle("slow");
        });
      });

        </script>
        <?php
               echo ('<div id="'.$dungeon.'show" class="margintop" style="display:none;">');
       echo ('<table style="overflow:auto;">');
        $playercount = 1;
        $worldtitle = "SELECT * FROM fights WHERE worlduser LIKE '$loguser' AND dungeon LIKE '$dungeonquery' ORDER BY encLabel ASC";
        $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
        while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
            echo ('<tr><td><button class="btn btn-success" onclick="addEncounter(\''.$row['title'].'\')" style="margin-right: 10px; margin-top:20px;">+</button>');
            echo ('</td><td class="sidebartext" style="white-space: normal;">');
            if ($row['encLabel'] != ''){
            echo ('<div class="diff" style="display:inline-block;">');
            echo $row['encLabel'];
            echo (': </div><br>');
          }
            $EncArray = explode(",",$row['title']);
            $ArrLength = count($EncArray);
            foreach ($EncArray as $i => $item) {
              $EncName = str_replace("monster","",$EncArray[$i]);
              $EncNum  = preg_replace('/[^0-9]/', '', $EncName);
              $EncWords = preg_replace('/[0-9]/', '', $EncName);
              $EncWords = preg_replace('/(?<!\ )[A-Z][a-z]/', ' $0', $EncWords);
              echo ($EncNum.'x '.$EncWords);
              $x = $i + 1;
              if ($ArrLength != $x) {
                echo (', ');
              }
            }


            ?>
            <?php
            //echo ($EncNum.'x '.$EncName);
            echo ('</td></tr>');
          }
         
       echo ('</table>');
       echo ('</div><br>');
        }
       ?>
    </div>
<script>

function addEncounter(value) {
  var mons = value.split(",");
  var tempxp = 0;
  for (var i = 0; i < mons.length; i++) {
    var monType = mons[i].replace(/[0-9]/g, '');
    var monName = monType.replace(/([A-Z])/g, ' $1').trim();
    var monNameClean = monName.replace('monster', '');
    var monNum = mons[i].replace(/[^0-9]/g, '');

    document.getElementById("show" + monType).style = "display:block";
    
    var xpname = "#" + monType + 'xp';
    var monxp = parseInt($(xpname).html());
    tempxp = parseInt(tempxp) + monxp;

    var monDupe = parseInt(monNum) - 1;
    for (var x = 0; x < monDupe; x++) {
      $('#' + monType + '-dupe').trigger('click');
    }
    

    var initname = "init" + monType;
    var initVal = document.getElementById(initname).innerHTML;

    var initDiv1 = document.getElementById("initValue1").innerHTML;
    var initDiv2 = document.getElementById("initValue2").innerHTML;
    var initDiv3 = document.getElementById("initValue3").innerHTML;
    var initDiv4 = document.getElementById("initValue4").innerHTML;
    var initDiv5 = document.getElementById("initValue5").innerHTML;
    var initDiv6 = document.getElementById("initValue6").innerHTML;
    var initDiv7 = document.getElementById("initValue7").innerHTML;
    var initDiv8 = document.getElementById("initValue8").innerHTML;
    var initDiv9 = document.getElementById("initValue9").innerHTML;
    var initDiv10 = document.getElementById("initValue10").innerHTML;
    var initDiv11 = document.getElementById("initValue11").innerHTML;

if (initDiv1 === "-5") {
      document.getElementById("init1").innerHTML = "<div id=\"initValue1\">" + initVal + "</div>" + monNameClean;
      document.getElementById("initcontainer1").setAttribute("data-initiativevalue", initVal);
      document.getElementById("init1").style = "display:block";
}
else if (initDiv2 === "-5"){
 document.getElementById("init2").innerHTML = "<div id=\"initValue2\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer2").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init2").style = "display:block";

}
else if (initDiv3 === "-5"){
 document.getElementById("init3").innerHTML = "<div id=\"initValue3\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer3").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init3").style = "display:block";

}
else if (initDiv4 === "-5"){
 document.getElementById("init4").innerHTML = "<div id=\"initValue4\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer4").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init4").style = "display:block";

}
else if (initDiv5 === "-5"){
 document.getElementById("init5").innerHTML = "<div id=\"initValue5\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer5").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init5").style = "display:block";

}
else if (initDiv6 === "-5"){
 document.getElementById("init6").innerHTML = "<div id=\"initValue6\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer6").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init6").style = "display:block";

}
else if (initDiv7 === "-5"){
 document.getElementById("init7").innerHTML = "<div id=\"initValue7\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer7").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init7").style = "display:block";

}
else if (initDiv8 === "-5"){
 document.getElementById("init8").innerHTML = "<div id=\"initValue8\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer8").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init8").style = "display:block";

}
else if (initDiv9 === "-5"){
 document.getElementById("init9").innerHTML = "<div id=\"initValue9\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer9").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init9").style = "display:block";

}
else if (initDiv10 === "-5"){
 document.getElementById("init10").innerHTML = "<div id=\"initValue10\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer10").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init10").style = "display:block";

}
else if (initDiv11 === "-5"){
 document.getElementById("init11").innerHTML = "<div id=\"initValue11\">" + initVal + "</div>" + monNameClean;
 document.getElementById("initcontainer11").setAttribute("data-initiativevalue", initVal);
 document.getElementById("init11").style = "display:block";

}

}
  var totalxp = $("#totalxp").html();
  totalxp = parseInt(totalxp.replace("Total XP = ", '')) || 0;
  totalxp = totalxp + tempxp;
  $("#totalxp").html("Total XP = " + totalxp);
  var newhref = "/tools/world/xp.php?id=" + totalxp;
    document.getElementById("xphref").href = newhref;

}
</script>
      <div id="playeradd" style="display:none;">
        <?php
        $playercount = 1;
        $worldtitle = "SELECT title FROM world WHERE worlduser LIKE '$loguser' AND type LIKE 'player character' AND active = 1";
          $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
          while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
            echo ('<input class="textbox1" name="namePlayer'.$playercount.'" id="namePlayer'.$playercount.'" value="'.$row['title'].'"><input class="textbox1" type="text" name="initPlayer1" id="initPlayer'.$playercount.'" value="">');
            echo ('<button class="btn btn-info" onclick="addPlayer'.$playercount.'()">Add</button>');
            $playercount++;
          }
         ?>

         <input class="textbox1" name="namePlayer7" id="namePlayer7" value=""><input class="textbox1" type="text" name="initPlayer7" id="initPlayer7" value="">
         <button class="btn btn-info" onclick="addPlayer7()">Add</button>
        <input class="textbox1" name="namePlayer8" id="namePlayer8" value=""><input class="textbox1" type="text" name="initPlayer8" id="initPlayer8" value="">
        <button class="btn btn-info" onclick="addPlayer8()">Add</button>


    </div>

      <script>

</script>
<script>
      $(document).ready(function showPlayers(){
        $("#showplayers").click(function addLog(){
            $("#playeradd").slideToggle("slow");

        });
        $("#showencounters").click(function encounterLog(){
            $("#encounterAdd").slideToggle("slow");

        });
      });
      function showxp() {
        document.getElementById("totalxp").innerHTML = totalxp;
        var newhref = "/tools/world/xp.php?id=" + totalxp;
        document.getElementById("xphref").href = newhref;
      }


      </script>
    </div>
  </div>

  <?php  $worldtitle = "SELECT monsterCr, title FROM compendium WHERE type LIKE 'monster'";
    $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
    while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {

      $title1 = preg_replace('/\s+/', '', $row['title']);
      $title1 = preg_replace('/\(|\)/','', $title1);
//      $title1 = preg_replace('/\(|\)/','', $title1);
    //  $title1 = $row['title'];
      $cr = $row['monsterCr'];
      $titletemp = $title1;
      $xp = 'xp';
      ${$titletemp . $xp} = 0;
      if($cr == 0){
        ${$titletemp . $xp} = 10;
      }
      if($cr == 0.125){
        ${$titletemp . $xp} = 25;
      }
      if($cr == 0.25){
        ${$titletemp . $xp} = 50;
      }
      if($cr == 0.5){
        ${$titletemp . $xp} = 100;
      }
      if($cr == 1){
        ${$titletemp . $xp} = 200;
      }
      if($cr == 2){
        ${$titletemp . $xp} = 450;
      }
      if($cr == 3){
        ${$titletemp . $xp} = 700;
      }
      if($cr == 4){
        ${$titletemp . $xp} = 1100;
      }
      if($cr == 5){
        ${$titletemp . $xp} = 1800;
      }
      if($cr == 6){
        ${$titletemp . $xp} = 4100;
      }
      if($cr == 7){
        ${$titletemp . $xp} = 2900;
      }
      if($cr == 8){
        ${$titletemp . $xp} = 3900;
      }
      if($cr == 9){
        ${$titletemp . $xp} = 5000;
      }
      if($cr == 10){
        ${$titletemp . $xp} = 5900;
      }
      if($cr == 11){
        ${$titletemp . $xp} = 7200;
      }
      if($cr == 12){
        ${$titletemp . $xp} = 8400;
      }
      if($cr == 13){
        ${$titletemp . $xp} = 10000;
      }
      if($cr == 14){
        ${$titletemp . $xp} = 11500;
      }
      if($cr == 15){
        ${$titletemp . $xp} = 13000;
      }
      if($cr == 16){
        ${$titletemp . $xp} = 15000;
      }
      if($cr == 17){
        ${$titletemp . $xp} = 18000;
      }
      if($cr == 18){
        ${$titletemp . $xp} = 20000;
      }
      if($cr == 19){
        ${$titletemp . $xp} = 22000;
      }
      if($cr == 20){
        ${$titletemp . $xp} = 25000;
      }
      if($cr == 21){
        ${$titletemp . $xp} = 33000;
      }
      if($cr == 22){
        ${$titletemp . $xp} = 41000;
      }
      if($cr == 23){
        ${$titletemp . $xp} = 50000;
      }
      if($cr == 24){
        ${$titletemp . $xp} = 62000;
      }
      if($cr == 25){
        ${$titletemp . $xp} = 75000;
      }
      if($cr == 26){
        ${$titletemp . $xp} = 90000;
      }
      if($cr == 27){
        ${$titletemp . $xp} = 105000;
      }
      if($cr == 28){
        ${$titletemp . $xp} = 120000;
      }
      if($cr == 29){
        ${$titletemp . $xp} = 135000;
      }
      if($cr == 30){
        ${$titletemp . $xp} = 155000;
      }
    }
    ?>

  <script>

      var diceRoller  = new DiceRoller();

      function roll(){
        var value = document.getElementById('input').value;

        diceRoller.roll(value);

        document.getElementById('input').value = diceRoller.getLog().shift();

        // stop event propagation
        return false;


      }

      function clearLog(){

        diceRoller.clearLog();

        document.getElementById('input').value = diceRoller.getNotation();

        // stop event propagation
        return false;

      }

</script>
</div>
  <table>

    <?php
      $worldtitle1 = "SELECT * FROM compendium WHERE type LIKE 'monster'";
      $titledata1 = mysqli_query($dbcon, $worldtitle1) or die('error getting data');
      while($row1 =  mysqli_fetch_array($titledata1, MYSQLI_ASSOC)) {
        $stripid = str_replace("'", "", $row1['title']);
        $stripid = stripslashes($stripid);
        $rowns1 = preg_replace('/\s+/', '', $row1['title']);
        $rowns1 = preg_replace('/\(|\)/','', $rowns1);
        ?>

        <tr><td>
          <div class="init-entry sidebartext" id="show<?php echo $rowns1; ?>" style="display:none;">
          <?php echo $row1['title'];
          echo('<br /> AC: '.$row1['monsterAc']);
          $realHp = $row1['monsterHp'];
          $realHp = substr($realHp, 0, strpos($realHp, " "));
          $roll = rand(1,20);
          $init = floor((($row1['monsterDex']-10)/2));
          $initroll = $init + $roll;
          echo ('<div id="init'.$rowns1.'" style="display:none;">'.$initroll.'</div>');
          echo('<br /> Initiative: '.$initroll.'('.$roll.' + '.$init.')');
           ?>
          <a href="/tools/initiative/statblock.php?id=<?php echo $row1['title']; ?>" target="statblock"><button class=" butsm btn btn-info" id="<?php echo $rowns1; ?>-btn">></button></a>
          <button class="butsm btn btn-danger" id="<?php echo $rowns1; ?>-remove">-</button>
        <div class="<?php echo $rowns1; ?>-hptrack" id="<?php echo $rowns1; ?>-hptrack">
    <input type ="text" class="hp-track" value="<?php echo($realHp); ?>" id="<?php echo $rowns1; ?>-hp"></input>
    <button class="butsm btn btn-copy btn-success" id="<?php echo $rowns1; ?>-dupe">+</button>
    <div class="two">
  </div>
        </div>
     
      </td>
      
      </tr>
<?php      echo ('<div id="'.$rowns1.'xp" style="display:none;">'.${$rowns1 . $xp}.'</div>');
            echo ('<div id="'.$rowns1.'monnum" style="display:none;">1</div>'); ?>

<?php } ?>

</table>

</div>
<?php
$worldtitle = "SELECT * FROM compendium WHERE type LIKE 'monster'";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  $rowns = preg_replace('/\s+/', '', $row['title']);
  $rowns = preg_replace('/\(|\)/','', $rowns);
  ?>

<script>
$(document).ready(function remLog(){
  $("#<?php echo $rowns; ?>-remove").click(function remLog(){
    var remxp = parseInt(<?php echo ${$rowns . $xp}; ?>);
    var remmult = document.getElementById("<?php echo $rowns; ?>monnum").innerHTML;
    var remmultint = parseInt(remmult);
    var remtotal = remxp * remmultint;
    totalxp = $('#totalxp').html();
    totalxp = parseInt(totalxp.replace(/[^0-9]/g, ''));
    totalxp = totalxp - remtotal;
    document.getElementById("totalxp").innerHTML = "Total XP = " + totalxp;
    $("#<?php echo $rowns; ?>monnum").html("1");
    $('.<?php echo $rowns; ?>-hptrack').not(':first').remove();
    var newhref = "/tools/world/xp.php?id=" + totalxp;
    document.getElementById("xphref").href = newhref;
  document.getElementById("show<?php echo $rowns; ?>").style.display = "none";
  document.getElementById("<?php echo $rowns; ?>").style.display = "none";
});
  });

</script>
<?php } ?>

<script>
$('.one, .two, .three, .four, .five, .six, .seven').click(function() {
    this.className = {
       seven : 'one', one: 'two', two: 'three', three: 'four', four: 'five', five: 'six', six: 'seven'
    }[this.className];
});

$(function addbar(){
  $(".btn-copy").on('click', function(){
    var ele = $(this).closest('div').clone(true);
    var dupeid = $(this).closest('[id]').attr('id');
    var dupexp = dupeid.replace('-dupe', 'xp');
    var addingxp = document.getElementById(dupexp).innerHTML;
    var addxpint = parseInt(addingxp);
    var basename = dupeid.replace('-dupe', '');
    var numtrack = basename + "monnum";
    var numadd = document.getElementById(numtrack).innerHTML;
    var numaddint = parseInt(numadd);
    addednum = numaddint + 1;
    document.getElementById(numtrack).innerHTML = addednum;
    var totalxp = $("#totalxp").html();
    totalxp = parseInt(totalxp.replace("Total XP = ", '')) || 0;
    totalxp = totalxp + addxpint;
    var newhref = "/tools/world/xp.php?id=" + totalxp;
    document.getElementById("xphref").href = newhref;
    document.getElementById("totalxp").innerHTML = "Total XP = " + totalxp;
    $(this).closest('div').after(ele);
    $('.hp-track').each(function(){
      var $this = $(this);
    $(this).abacus();
    });

  });
});
$('.hp-track').each(function(){
  var $this = $(this);
$(this).abacus();
});


</script>
<div class="col-md-8 col-xs-12" style="float:right;"><iframe class="blockframe" name="statblock"></iframe></div>
</div> <!--Body -->

</div> <!-- Mainbox -->

<?php
//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath);
?>

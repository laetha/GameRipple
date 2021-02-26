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

<style>
#nonav {
  display:none;
}
</style>
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <h1 class="pagetitle">Initiative Tracker</h1>
  <p><a href="http://kobold.club/fight/#/encounter-manager" target="_BLANK">Kobold Fight Club Encounters</a></p>
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
     output.push(selectValue);
     var selectValueNoBrackets = selectValue.replace(/"/g, "").replace(/'/g, "").replace(/\(|\)/g, "");
     var selectValueNs = selectValueNoBrackets.replace(/\s/g, '');
     var xpname = selectValueNs + "xp";
     var tempname = selectValueNs + "calc";

     var newxp1 = document.getElementById(xpname).innerHTML;
     var newxp = parseInt(newxp1);
     totalxp = totalxp + newxp;
     var fullSelect = "show" + selectValueNs;
     document.getElementById(fullSelect).style.display = "block";
     document.getElementById("totalxp").innerHTML = "Total XP = " + totalxp;
     var newhref = "/tools/world/xp.php?id=" + totalxp;
     document.getElementById("xphref").href = newhref;

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
      <div id="awardbutton"><a id="xphref" href="/tools/world/xp.php?id=0"><button>Award XP</button></a></div>
      <div id="totalxp"></div>
      <script>

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
      </td></tr>
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
    totalxp = totalxp - remtotal;
    document.getElementById("totalxp").innerHTML = "Total XP = " + totalxp;
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

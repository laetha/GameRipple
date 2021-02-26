<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">
<link href="/tools/compendium/statblock.css" rel="stylesheet" type="text/css">
<?php
  //SQL Connect
   $pgtitle = 'Generator - ';
   $sqlpath = $_SERVER['DOCUMENT_ROOT'];
   $sqlpath .= "/sql-connect.php";
   include_once($sqlpath);

   //Header
   $headpath = $_SERVER['DOCUMENT_ROOT'];
   $headpath .= "/header.php";
   include_once($headpath);
?>


<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <h1 class="pagetitle">Generator</h1>
  <button class="btn btn-info col-centered" onclick="window.location.reload()">Re-generate</button>
<div class="row">
  <div class="col-md-4 sidebartext">
    <h2 class="col-centered">Magic Items</h2>
    <div class="sidebartext">
      <?php
        $itemRarity1 = rand(1,100);
        $itemRarity2 = rand(1,100);
        $itemRarity3 = rand(1,100);
       ?>
       <div class="randitem">
       <div id="item1"></div>
       <div id="item2"></div>
       <div id="item3"></div>
     </div>
    <?php
    if ($itemRarity1 <= 70) {
    $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%very rare%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
    $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
    while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
      echo ('<div id ="1stitem" class="randitem">');
      $item = $row['title'];
      echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
      echo ('<p>'.$row['itemDetail'].'</p>');
      echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
      echo ('</div>');
      $item1 = '<a href="#1stitem">'.$row['title'].'</a>';
    }
  }
  elseif ($itemRarity1 <= 90) {
    $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
    $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
    while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
      echo ('<div id ="1stitem" class="randitem">');
      $item = $row['title'];
      echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
      echo ('<p>'.$row['itemDetail'].'</p>');
      echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
      echo ('</div>');
      $item1 = '<a href="#1stitem">'.$row['title'].'</a>';
    }
  }
  else {
    $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
    $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
    while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
      echo ('<div id ="1stitem" class="randitem">');
      $item = $row['title'];
      echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
      echo ('<p>'.$row['itemDetail'].'</p>');
      echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
      echo ('</div>');
      $item1 = '<a href="#1stitem">'.$row['title'].'</a>';
    }
  }

  if ($itemRarity2 <= 70) {
  $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%very rare%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
  $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
  while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
    echo ('<div id ="2nditem" class="randitem">');
    $item = $row['title'];
    echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
    echo ('<p>'.$row['itemDetail'].'</p>');
    echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
    echo ('</div>');
    $item2 = '<a href="#2nditem">'.$row['title'].'</a>';
  }
}
elseif ($itemRarity2 <= 90) {
  $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
  $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
  while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
    echo ('<div id ="2nditem" class="randitem">');
    $item = $row['title'];
    echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
    echo ('<p>'.$row['itemDetail'].'</p>');
    echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
    echo ('</div>');
    $item2 = '<a href="#2nditem">'.$row['title'].'</a>';
  }
}
else {
  $worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
  $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
  while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
    echo ('<div id ="2nditem" class="randitem">');
    $item = $row['title'];
    echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
    echo ('<p>'.$row['itemDetail'].'</p>');
    echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
    echo ('</div>');
    $item2 = '<a href="#2nditem">'.$row['title'].'</a>';
  }
}

if ($itemRarity3 <= 70) {
$worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%very rare%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  echo ('<div id ="3rditem" class="randitem">');
  $item = $row['title'];
  echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
  echo ('<p>'.$row['itemDetail'].'</p>');
  echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
  echo ('</div>');
  $item3 = '<a href="#3rditem">'.$row['title'].'</a>';
}
}
elseif ($itemRarity3 <= 90) {
$worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%legendary%' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  echo ('<div id ="3rditem" class="randitem">');
  $item = $row['title'];
  echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
  echo ('<p>'.$row['itemDetail'].'</p>');
  echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
  echo ('</div>');
  $item3 = '<a href="#3rditem">'.$row['title'].'</a>';
}
}
else {
$worldtitle = "SELECT * FROM `compendium` WHERE `itemMagic` LIKE '1' AND itemDetail NOT LIKE '%artifact%' ORDER BY rand() LIMIT 1";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  echo ('<div id ="3rditem" class="randitem">');
  $item = $row['title'];
  echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
  echo ('<p>'.$row['itemDetail'].'</p>');
  echo nl2br('<p style="margin-bottom: 40px;">'.$row['text'].'</p>');
  echo ('</div>');
  $item3 = '<a href="#3rditem">'.$row['title'].'</a>';
}
}

    ?>
<script>
document.getElementById("item1").innerHTML = '<?php echo $item1 ?>';
document.getElementById("item2").innerHTML = '<?php echo $item2 ?>';
document.getElementById("item3").innerHTML = '<?php echo $item3 ?>';
</script>

  </div>
  </div>

  <div class="col-md-4">
    <h2>Weather</h2>
    <div class="bodytext col-centered randitem">
    <?php

    $temperature = rand(1,20);
    $wind = rand(1,20);
    $rain = rand(1,20);

    if($rain >= 1 && $rain <= 6) {
      echo ('<p style="color:#E7BF4C;">Sunny/clear.</p>');
    }
    elseif($rain >= 7 && $rain <= 12) {
      echo ('<p style="color:grey;">Overcast.</p>');
    }
    elseif ($rain >= 13 && $rain <= 17){
      echo ('<p style="color:#5499c7;">Light rain/snow.</p>');
    }
    elseif ($rain >= 18 && $rain <= 20){
      echo ('<p style="color:#3D6D8D;">Heavy rain/snow.</p>');
    }

    if($wind >= 1 && $wind <= 12) {
      echo ('<p>Calm winds.</p>');
    }
    elseif ($wind >= 13 && $wind <= 17){
      echo ('<p>Breezy.</p>');
    }
    elseif ($wind >= 18 && $wind <= 20){
      echo ('<p>Strong winds.</p>');
    }


    if($temperature >= 1 && $temperature <= 14) {
      echo ('<p>Normal Temperature for the season.</p>');
    }
    elseif ($temperature >= 15 && $temperature <= 17){
      echo ('<p style="color:#C26339;">Unseasonably warm.</p>');
    }
    elseif ($temperature >= 18 && $temperature <= 20){
      echo ('<p style="color:#3D6D8D;">Unseasonably cold.</p>');
    }

     ?>
   </div>
  </div>

  <div class="col-md-4">
    <h2>NPCs</h2>
    <div class="randitem">
    <h3 style="color:#5499c7;">Male Names:</h3>
    <div class="sidebartext col-centered">
    <?php
    $worldtitle = "SELECT * FROM `npcs` WHERE `gender` LIKE 'male' ORDER BY rand() LIMIT 5";
    $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
    while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
      echo ('<p>'.$row['name'].'</p>');
    }
     ?>
   </div>
   <h3 style="color:#5499c7;">Female Names:</h3>
   <div class="sidebartext col-centered">
   <?php
   $worldtitle = "SELECT * FROM `npcs` WHERE `gender` LIKE 'female' ORDER BY rand() LIMIT 5";
   $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
   while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
     echo ('<p>'.$row['name'].'</p>');
   }
    ?>
  </div>

  <h3 style="color:#5499c7;">Full Names:</h3>
   <div class="sidebartext col-centered">
   <?php
   $firstname = array();
   $worldtitle = "SELECT name FROM `npcs` WHERE `type` LIKE 'first' ORDER BY rand() LIMIT 5";
   $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
   while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
     array_push($firstname, $row['name']);
} 
$lastname = array();
$worldtitle = "SELECT name FROM `npcs` WHERE `type` LIKE 'last' ORDER BY rand() LIMIT 5";
$titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
  array_push($lastname, $row['name']);
}
for ($x = 0; $x <= 4; $x++) {
  echo ('<p>'.$firstname[$x].' '.$lastname[$x].'</p>');
}
    ?>
  </div>
<?php
if ($loguser == 'tarfuin') {
?>
   <h3 style="color:#5499c7;">Full NPC:</h3>
   <div class="sidebartext col-centered">
   <?php
   //$firstname = array();
   $worldtitle = "SELECT * FROM `world` WHERE `type` LIKE 'npc' ORDER BY rand() LIMIT 1";
   $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
   while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
     $npcfirst = $row['title'];
     $npcrace = $row['npc_race'];
     $npcjob = $row['npc_title'];
     $npcdeity = $row['npc_deity'];
     $npcdistrict = $row['npc_location'];
     $npcest = $row['npc_est'];

}

echo ('<p><a href="/tools/world/world.php?id='.$npcfirst.'" target="_BLANK">'.$npcfirst.'</a> is a '.$npcrace. ' '.$npcjob. '. They worship '.$npcdeity.', and live in '.$npcdistrict.'.');

if ($npcest != '') {
  echo (' They work at <a href="/tools/world/world.php?id='.$npcest.'" target="_BLANK">'.$npcest.'</a>');
}

    ?>
  </div>
<?php } ?>
  </div>

  </div>
</div>
</div>
</div> <!-- Mainbox -->

<?php
//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath);
?>

<link href="https://fonts.googleapis.com/css?family=Aladin" rel="stylesheet">
<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
  <h1 class="pagetitle">Quest Board</h1>
<div class ="body bodytext">
      <div class="toc bodytext">

      <?php
        $sqlworld = "SELECT * FROM world WHERE type LIKE 'public quest' AND quest_status LIKE 'available' ORDER BY RAND()";
        $worlddata = mysqli_query($dbcon, $sqlworld) or die('error getting data');
        while($row = mysqli_fetch_array($worlddata, MYSQLI_ASSOC)) {

        echo ('<div class="col-lg-8 col-md-12 col-centered col-sm-12 quest-text quest-bg style="float:left;"">');
        echo ('<div class="quest-pad">');
        echo ('<h2>'.$row['title'].'</h3>');
        echo ('<p style="text-align:left;">'.nl2br($row['body']).'</p>');
        echo ('<div class="row" style="margin-top:30px;">');
        echo ('<div class="col-xs-9">');
        echo ('<p>Reward: '.$row['quest_reward']);
        echo ('</div>');
        echo ('<div class="col-xs-3">');
        if ($row['quest_faction'] == "The Seekers") {
          echo ('<img class="quest-img" src="/assets/images/factions/the-seekers.png">');
        }
        elseif ($row['quest_faction'] == "The Crimson Seal") {
          echo ('<img class="quest-img align-middle" src="/assets/images/factions/crimson-seal.png">');
        }
        if ($row['quest_faction'] == "Twilight Helix") {
          echo ('<img class="quest-img" src="/assets/images/factions/twilight-helix.png">');
        }
        if ($row['quest_faction'] == "The Exchange") {
          echo ('<img class="quest-img" src="/assets/images/factions/the-exchange.png">');
        }
        if ($row['quest_faction'] == "The Blue Veterans") {
          echo ('<img class="quest-img" src="/assets/images/factions/blue-veterans.png">');
        }
        if ($row['quest_faction'] == "ForgeForge") {
          echo ('<img class="quest-img" src="/assets/images/factions/forgeforge.png">');
        }
        echo ('</div>');
        echo ('</div>');
        echo ('</div>');
        echo ('</div>');

      }
        ?>

  </div>
</div>
</div>

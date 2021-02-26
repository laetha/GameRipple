<!DOCTYPE HTML>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<link rel="stylesheet" type="text/css" href="/selectize/css/selectize.default.css" />
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="/tools/compendium/statblock.css" rel="stylesheet" type="text/css">
			<!-- This code is to prevent FOUC -->
			<script type="text/javascript">
		    $('html').addClass('hidden');
		    $(window).on('load', function () {
		    $('html').removeClass('hidden');
		     });
		   </script>
       <?php
       //SQL Connect
        $sqlpath = $_SERVER['DOCUMENT_ROOT'];
        $sqlpath .= "/sql-connect.php";
        include_once($sqlpath);
        $pgtitle = $_GET['id'];
        ?>
		<title><?php echo $pgtitle; ?>RPG Tools</title>
	</head>
	<body style="min-width: 0px;">
		<div style="background-color: #222326;">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" tpye="text/javascript"></script>
		<!--<script src="http://code.jquery.com/jquery-1.8.3.js" tpye="text/javascript"></script>-->
		<script src="/selectize/js/standalone/selectize.min.js" tpye="text/javascript"></script>
		<script src="/selectize/js/list.js" tpye="text/javascript"></script>
		<!--<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js" tpye="text/javascript"></script>-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" tpye="text/javascript"></script>
<?php
    $tmp_action = basename($_GET['id']);
          $id = $tmp_action;

          $worldtitle = "SELECT * FROM `compendium` WHERE `title` LIKE '$id'";
          $titledata = mysqli_query($dbcon, $worldtitle) or die('error getting data');
          while($row =  mysqli_fetch_array($titledata, MYSQLI_ASSOC)) {
            $stripid = str_replace("'", "", $id);
            //echo ('<h2>'.ucwords($row['type']).'</h2>');
            $type = $row['type'];

          if($type == 'monster'){
              ?>
              <div class="stat-block wide" id="statblock" style="width:92%;">
    <hr class="orange-border" />
    <div class="section-left">
      <div class="creature-heading">
        <h1><?php echo $row['title']; ?></h1>
        <h2><?php echo $row['monsterSize'].' '.$row['monsterType'].', '.$row['monsterAlignment']; ?></h2>
      </div> <!-- creature heading -->
      <svg height="5" width="100%" class="tapered-rule">
        <polyline points="0,0 400,2.5 0,5"></polyline>
      </svg>
      <div class="top-stats">
        <div class="property-line first">
          <h4>Armor Class</h4>
          <p><?php echo $row['monsterAc']; ?></p>
        </div> <!-- property line -->
        <div class="property-line">
          <h4>Hit Points</h4>
          <p><?php echo $row['monsterHp']; ?></p>
        </div> <!-- property line -->
        <div class="property-line last">
          <h4>Speed</h4>
          <p><?php echo $row['monsterSpeed']; ?></p>
        </div> <!-- property line -->
        <svg height="5" width="100%" class="tapered-rule">
        <polyline points="0,0 400,2.5 0,5"></polyline>
      </svg>
        <div class="abilities">
          <div class="ability-strength">
            <h4>STR</h4>
            <p><?php echo $row['monsterStr']; ?></p>
          </div> <!-- ability strength -->
          <div class="ability-dexterity">
            <h4>DEX</h4>
            <p><?php echo $row['monsterDex']; ?></p>
          </div> <!-- ability dexterity -->
          <div class="ability-constitution">
            <h4>CON</h4>
            <p><?php echo $row['monsterCon']; ?></p>
          </div> <!-- ability constitution -->
          <div class="ability-intelligence">
            <h4>INT</h4>
            <p><?php echo $row['monsterInt']; ?></p>
          </div> <!-- ability intelligence -->
          <div class="ability-wisdom">
            <h4>WIS</h4>
            <p><?php echo $row['monsterWis']; ?></p>
          </div> <!-- ability wisdom -->
          <div class="ability-charisma">
            <h4>CHA</h4>
            <p><?php echo $row['monsterCha']; ?></p>
          </div> <!-- ability charisma -->
        </div> <!-- abilities -->
        <svg height="5" width="100%" class="tapered-rule">
        <polyline points="0,0 400,2.5 0,5"></polyline>
      </svg>
      <?php if($row['monsterSave'] != ''){ ?>
        <div class="property-line">
          <h4><strong>Saving Throws:</strong></h4>
          <p><?php echo $row['monsterSave']; ?></p>
        </div> <!-- property line -->
      <?php } ?>
    <?php if($row['monsterSkill'] != ''){ ?>
        <div class="property-line">
          <h4><strong>Skills:</strong></h4>
          <p><?php echo $row['monsterSkill']; ?></p>
        </div> <!-- property line -->
      <?php } ?>
      <?php if($row['monsterResist'] != ''){ ?>
        <div class="property-line">
          <h4><strong>Damage Resistences:</strong></h4>
          <p><?php echo $row['monsterResist']; ?></p>
        </div> <!-- property line -->
      <?php } ?><?php if($row['monsterVulnerable'] != ''){ ?>
        <div class="property-line">
          <h4><strong>Damage Vulnerabilities:</strong></h4>
          <p><?php echo $row['monsterVulnerable']; ?></p>
        </div> <!-- property line -->
    <?php } ?><?php if($row['monsterImmune'] != ''){ ?>
      <div class="property-line">
        <h4><strong>Damage Immunities:</strong></h4>
        <p><?php echo $row['monsterImmune']; ?></p>
      </div> <!-- property line -->
  <?php } ?><?php if($row['monsterConditionImmune'] != ''){ ?>
    <div class="property-line">
      <h4><strong>Condition Immunities:</strong></h4>
      <p><?php echo $row['monsterConditionImmune']; ?></p>
    </div> <!-- property line -->
  <?php } ?><?php if($row['monsterSenses'] != ''){ ?>
    <div class="property-line">
      <h4><strong>Senses:</strong></h4>
      <p><?php echo $row['monsterSenses']; ?></p>
    </div> <!-- property line -->
  <?php } ?><?php if($row['monsterPassive'] != ''){ ?>
    <div class="property-line">
      <h4><strong>Passive Perception:</strong></h4>
      <p><?php echo $row['monsterPassive']; ?></p>
    </div> <!-- property line -->
  <?php } ?><?php if($row['monsterLanguages'] != ''){ ?>
    <div class="property-line">
      <h4><strong>Languages:</strong></h4>
      <p><?php echo $row['monsterLanguages']; ?></p>
    </div> <!-- property line -->
  <?php } ?><?php
  $cr = $row['monsterCr'];
   if($row['monsterCr'] != ''){ ?>
    <div class="property-line">
      <h4><strong>Challenge Rating:</strong></h4>
      <p><?php

      if($row['monsterCr'] ==0.125){
        echo ('1/8');

      }
      elseif($row['monsterCr'] ==0.25){
        echo ('1/4');

      }
      elseif($row['monsterCr'] ==0.5){
        echo ('1/2');
      }
      else{
      echo number_format((float)$cr, 0, '.', '');
    }
        if($cr == 0){
          echo (' (10xp)');
        }
        if($cr == 0.125){
          echo (' (25xp)');
        }
        if($cr == 0.25){
          echo (' (50xp)');
        }
        if($cr == 0.5){
          echo (' (100xp)');
        }
        if($cr == 1){
          echo (' (200xp)');
        }
        if($cr == 2){
          echo (' (450xp)');
        }
        if($cr == 3){
          echo (' (700xp)');
        }
        if($cr == 4){
          echo (' (1,100xp)');
        }
        if($cr == 5){
          echo (' (1,800xp)');
        }
        if($cr == 6){
          echo (' (4,100xp)');
        }
        if($cr == 7){
          echo (' (2,900xp)');
        }
        if($cr == 8){
          echo (' (3,900xp)');
        }
        if($cr == 9){
          echo (' (5,000xp)');
        }
        if($cr == 10){
          echo (' (5,900xp)');
        }
        if($cr == 11){
          echo (' (7,200xp)');
        }
        if($cr == 12){
          echo (' (8,400xp)');
        }
        if($cr == 13){
          echo (' (10,000xp)');
        }
        if($cr == 14){
          echo (' (11,500xp)');
        }
        if($cr == 15){
          echo (' (13,000xp)');
        }
        if($cr == 16){
          echo (' (15,000xp)');
        }
        if($cr == 17){
          echo (' (18,000xp)');
        }
        if($cr == 18){
          echo (' (20,000xp)');
        }
        if($cr == 19){
          echo (' (22,000xp)');
        }
        if($cr == 20){
          echo (' (25,000xp)');
        }
        if($cr == 21){
          echo (' (33,000xp)');
        }
        if($cr == 22){
          echo (' (41,000xp)');
        }
        if($cr == 23){
          echo (' (50,000xp)');
        }
        if($cr == 24){
          echo (' (62,000xp)');
        }
        if($cr == 25){
          echo (' (75,000xp)');
        }
        if($cr == 26){
          echo (' (90,000xp)');
        }
        if($cr == 27){
          echo (' (105,000xp)');
        }
        if($cr == 28){
          echo (' (120,000xp)');
        }
        if($cr == 29){
          echo (' (135,000xp)');
        }
        if($cr == 30){
          echo (' (155,000xp)');
        }
        ?>
      </p>
    </div> <!-- property line -->
  <?php } ?>
      </div> <!-- top stats -->
      <svg height="5" width="100%" class="tapered-rule">
        <polyline points="0,0 400,2.5 0,5"></polyline>
      </svg>
			<div id="traits">
      <?php if($row['monsterTrait1'] != ''){ ?>
        <div class="property-block">
          <p><?php echo nl2br($row['monsterTrait1']); ?></p>
        </div> <!-- property Block -->
      <?php } ?>
    <?php if($row['monsterTrait2'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait2']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait3'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait3']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait4'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait4']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait5'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait5']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait6'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait6']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait7'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait7']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
    <?php if($row['monsterTrait8'] != ''){ ?>
      <div class="property-block">
        <p><?php echo nl2br($row['monsterTrait8']); ?></p>
      </div> <!-- property Block -->
    <?php } ?>
	</div> <!-- Traits -->
    </div> <!-- section left -->
    <div class="section-right">
      <div class="actions">
        <h3>Actions<button class="btn btn-success" type="button" data-toggle="collapse" data-target="#monToken">+</button>
      <?php
      $tokenurl = $_SERVER['DOCUMENT_ROOT']."/tools/compendium/bestiary/tokens/$stripid.png";
    if (file_exists($tokenurl)){
     
     echo ('<div class="collapse"  id="monToken"><img class="monsterimg" src="/tools/compendium/bestiary/tokens/'.$stripid.'.png" /></div>'); 
   
    
     }
     ?></h3>
        
        <?php if($row['monsterAction1'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction1']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction2'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction2']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction3'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction3']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction4'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction4']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction5'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction5']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction6'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction6']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction7'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction7']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
        <?php if($row['monsterAction8'] != ''){ ?>
          <div class="property-block">
            <p><?php echo nl2br($row['monsterAction8']); ?></p>
          </div> <!-- property Block -->
        <?php } ?>
      </div> <!-- actions -->
      <div class="actions">
          <?php if($row['monsterLegendary1'] != ''){ ?>
            <h3>Legendary Actions</h3>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary1']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary2'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary2']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary3'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary3']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary4'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary4']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary5'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary5']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary6'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary6']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary7'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary7']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
          <?php if($row['monsterLegendary8'] != ''){ ?>
            <div class="property-block">
              <p><?php echo nl2br($row['monsterLegendary8']); ?></p>
            </div> <!-- property Block -->
          <?php } ?>
      </div> <!-- actions -->
      <div class="actions">
       <?php if($row['monsterReaction'] != ''){ ?>
             <h3>Reactions</h3>
           <div class="property-block">
           <p><?php echo nl2br($row['monsterReaction']); ?></p>
         </div> <!-- property Block -->
       <?php } ?>

     </div>
        <?php  

?>
    </div> <!-- section right -->
    <hr class="orange-border bottom" />
  </div> <!-- stat block -->
<?php }
}
?>

<!-- Search and add hyperlinks -->
	<?php
		$sqlworld = "SELECT * FROM compendium WHERE type LIKE 'spell' AND title NOT LIKE 'light'";
		$worlddata = mysqli_query($dbcon, $sqlworld) or die('error getting data');
		while($linkrow = mysqli_fetch_array($worlddata, MYSQLI_ASSOC)) {
		$temp = $linkrow['title'];
		?>
		<script>
		var foundlink = "<?php echo $temp ?>";
		function replace (querytext){
			var queryfix = querytext;
			var bodytext = document.getElementById("traits").innerHTML;
			var url = "<a tabindex=\"0\" href= \"javascript://\" data-html=\"true\" data-toggle=\"popover\" data-trigger=\"focus\" data-placement=\"top\" data-content=\"<iframe style='width: 400px; height: 400px;' class='blockframe' name='spellblock' src='/tools/initiative/spell.php?id=" + querytext + "'></iframe>\">" + querytext + "</a>";
			var regex = new RegExp(queryfix, 'ig');
			var newtext = bodytext.replace(regex, url)
			document.getElementById("traits").innerHTML = newtext;
		}
		replace(foundlink);
		$(function () {
  $('[data-toggle="popover"]').popover()

	$('.popover-dismiss').popover({
  trigger: 'focus'
})
})
		</script>
		<?php
	}
	?>
</div>
</body>
</html>

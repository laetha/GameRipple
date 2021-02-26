<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$prof =$_REQUEST['proficiencies'];
$title = $_REQUEST['title'];
$charID = $_REQUEST['charID'];
$saves = $_REQUEST['saves'];
$expertise = $_REQUEST['expertise'];
$str = $_REQUEST['strength'];
$dex = $_REQUEST['dexterity'];
$con = $_REQUEST['constitution'];
$intel = $_REQUEST['intelligence'];
$wis = $_REQUEST['wisdom'];
$cha = $_REQUEST['charisma'];
$maxhp = $_REQUEST['maxhp'];
$hitdice = $_REQUEST['hitdice'];
$speed = $_REQUEST['speed'];
$initiative = $_REQUEST['initiative'];
$armorclass = $_REQUEST['armorclass'];
$charClass = $_REQUEST['charClass'];
$charMultiClass = $_REQUEST['charMultiClass'];
$charMultiLevel = $_REQUEST['charMultiLevel'];
$charRace = $_REQUEST['charRace'];
$charLevel = $_REQUEST['charLevel'];
$charBackground = $_REQUEST['charBackground'];
$charAlignment = $_REQUEST['charAlignment'];
$charAttacks = $_REQUEST['attacks'];
$charSpells = $_REQUEST['spells'];
$customAttacks = $_REQUEST['customAttacks'];
$charNotes = $_REQUEST['charNotes'];
$charItems = $_REQUEST['charItems'];
$charFeats = $_REQUEST['charFeats'];
$charHitdie2 = $_REQUEST['hitdice2'];


$sql = "UPDATE characters
SET title = '$title', proficiencies = '$prof', saves = '$saves', expertise = '$expertise', str = '$str', dex = '$dex', con = '$con', intel = '$intel', wis = '$wis', cha = '$cha', maxhp = '$maxhp', hitdice = '$hitdice', speed = '$speed', initiative = '$initiative', armorclass = '$armorclass',
 race = '$charRace', level = '$charLevel', background = '$charBackground', alignment = '$charAlignment', class1 = '$charClass', attacks = '$charAttacks', spells = '$charSpells', customattacks = '$customAttacks', notes = '$charNotes', items = '$charItems', feats = '$charFeats', class2 = '$charMultiClass', class2lvl = '$charMultiLevel',
 hitdice2 = '$charHitdie2'
WHERE id = $charID;";

        if ($dbcon->query($sql) === TRUE) {

        }
				else {
        }

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

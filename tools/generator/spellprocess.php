<!-- SQL Connect -->
<?php $sqlpath = $_SERVER['DOCUMENT_ROOT'];
$sqlpath .= "/sql-connect.php";
include_once($sqlpath);

$spellClass =$_REQUEST['spellClass'];
$spellLevel = $_REQUEST['spellLevel'];

if ($spellClass !== 'all' && $spellLevel !== 'all'){
$spelltitle = "SELECT * FROM `compendium` WHERE type LIKE 'spell' AND spellClasses LIKE '%$spellClass%' AND spellLevel LIKE '$spellLevel' AND spellClasses NOT LIKE '%Eldritch Invocations%' AND spellClasses NOT LIKE '%Mystic%' ORDER BY rand() LIMIT 1";
$spelldata = mysqli_query($dbcon, $spelltitle) or die('error getting data');
}
else if ($spellClass !== 'all' && $spellLevel == 'all'){
	$spelltitle = "SELECT * FROM `compendium` WHERE type LIKE 'spell' AND spellClasses LIKE '%$spellClass%' AND spellClasses NOT LIKE '%Eldritch Invocations%' AND spellClasses NOT LIKE '%Mystic%' ORDER BY rand() LIMIT 1";
	$spelldata = mysqli_query($dbcon, $spelltitle) or die('error getting data');
}
else if ($spellClass == 'all' && $spellLevel !== 'all'){
	$spelltitle = "SELECT * FROM `compendium` WHERE type LIKE 'spell' AND spellLevel LIKE '$spellLevel' AND spellClasses NOT LIKE '%Eldritch Invocations%' AND spellClasses NOT LIKE '%Mystic%' ORDER BY rand() LIMIT 1";
	$spelldata = mysqli_query($dbcon, $spelltitle) or die('error getting data');
}
else {
	$spelltitle = "SELECT * FROM `compendium` WHERE type LIKE 'spell' AND spellClasses NOT LIKE '%Eldritch Invocations%' AND spellClasses NOT LIKE '%Mystic%' ORDER BY rand() LIMIT 1";
	$spelldata = mysqli_query($dbcon, $spelltitle) or die('error getting data');
}
while($row =  mysqli_fetch_array($spelldata, MYSQLI_ASSOC)) {

	echo ('<div class="randitem" style="text-align:left;">');
	$item = $row['title'];
	echo ('<h3 class="randitem"><a href="/tools/compendium/compendium.php?id='.$row['title'].'" target="_BLANK">'.$row['title'].'</a></h3>');
	echo ('<div class="spellDetail">');
	echo ('<strong>Level:</strong> '.$row['spellLevel'].'<br />');
	echo ('<strong>School:</strong> '.$row['spellSchool'].'<br />');
	echo ('<strong>Casting Time:</strong> '.$row['spellTime'].'<br />');
	echo ('<strong>Range:</strong> '.$row['spellRange'].'<br />');
	echo ('<strong>Components:</strong> '.$row['spellComponents'].'<br />');
	echo ('<strong>Duration:</strong> '.$row['spellDuration'].'<br />');
	echo ('<strong>Class:</strong> '.$row['spellClasses'].'<p style="margin-top:10px;">');
	echo nl2br($row['text']);
	echo ('</div>');

}

//Footer
$footpath = $_SERVER['DOCUMENT_ROOT'];
$footpath .= "/footer.php";
include_once($footpath); ?>

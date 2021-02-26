<?php session_start();
if(!isset($_COOKIE['user'])) {
	if (!isset($_SESSION["newsession"])){
		$loguser = 'null';
		//echo ('No Logged in user');
	}
	else {
	$loguser = $_SESSION["newsession"];
	$cookie_name = "user";
	$cookie_value = $loguser;
	setcookie($cookie_name, $cookie_value, time() + (86400 * 90), "/"); // 86400 = 1 day
	$cookie_name1 = "user";
	$cookie_value1 = $loguser;
	setcookie($cookie_name1, $cookie_value1, time() + (86400 * 90), "/"); // 86400 = 1 day
	//echo ('Logged in user is '.$loguser);
}
}
else {
	$loguser = $_COOKIE['user'];
	$cookiestatus = 'There was a cookie!';

}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="/style.css" />
		<link rel="stylesheet" type="text/css" href="/selectize/css/selectize.default.css" />


		<title><?php echo $pgtitle; ?>DnD Tools</title>
		<?php
		/*$handle = opendir(dirname(realpath(__FILE__)).'/assets/images/bg/');
		while( $entry = readdir($handle) )
		{
		    if( $entry != '.' && $entry != '..' )
		    {
		        $files[] = $entry;
		    }
		}

		closedir($handle);

		sort($files);

		  $i = rand(0, count($files)-1); // generate random number size of the array
		  $selectedBg = "$files[$i]"; // set variable equal to which random filename was chosen
	*/	?>
	</head>
	<!--<body id="headbody" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),  url(/assets/images/bg/<?php echo $selectedBg; ?>) no-repeat center center fixed;	-webkit-background-size: cover;	-moz-background-size: cover;	-o-background-size: cover;	background-size: cover;	opacity:0.9;"> -->
	<body id="headbody" style="background-color: #2d2d2d; opacity: 0.8;">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js" tpye="text/javascript"></script>
		<!--<script src="http://code.jquery.com/jquery-1.8.3.js" tpye="text/javascript"></script>-->
		<script src="/selectize/js/standalone/selectize.min.js" tpye="text/javascript"></script>
		<script src="/selectize/js/list.js" tpye="text/javascript"></script>
		<!--<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js" tpye="text/javascript"></script>-->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" tpye="text/javascript"></script>
		<script src="/plugins/Do-Math-Within-Input-jQuery-Abacus\jquery.abacus.min.js"></script>
		<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
		<?php
		//SQL Connect
		 $sqlpath = $_SERVER['DOCUMENT_ROOT'];
		 $sqlpath .= "/sql-connect.php";
		 include_once($sqlpath);
		 $friend = 0;
		 $usercheck = "SELECT * FROM `users` WHERE username LIKE '$loguser'";
		 $userdata = mysqli_query($dbcon, $usercheck) or die('error getting data');
		 while($row =  mysqli_fetch_array($userdata, MYSQLI_ASSOC)) {
		 	$friend = $row['friend'];
		 }
		 $friendcheck = $_SERVER['PHP_SELF'];

		 if ($friend !== '1' && $friendcheck !== '/tools/users/login.php') {
			 if ($friendcheck !== '/tools/users/loginprocess.php'){
			 echo ('<script>window.location.replace("/tools/users/login.php"); </script>');
		 }
		 }
		 ?>

		 <link rel="stylesheet" type="text/css" href="/navbar.css" />
		 <nav class="navbar navbar-default navbar-inverse" id="nonav" style="display:block;">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/index.php">DnD Tools</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
				<li class="topsearch">
					<select id="search">
					<option value=""></option>
					<?php
					//if ($loguser == 'tarfuin') {
					$searchdrop = "SELECT title FROM world WHERE worlduser LIKE '$loguser'";
					$searchdata = mysqli_query($dbcon, $searchdrop) or die('error getting data');
					while($searchrow =  mysqli_fetch_array($searchdata, MYSQLI_ASSOC)) {
						$search = $searchrow['title'];
						$searchvalue = $search.'1';
						echo "<option value=\"$searchvalue\">$search</option>";
					}
				//}
					?>
					<?php
					$searchdrop1 = "SELECT title FROM compendium";
					$searchdata1 = mysqli_query($dbcon, $searchdrop1) or die('error getting data');
					while($searchrow1 =  mysqli_fetch_array($searchdata1, MYSQLI_ASSOC)) {
						$search1 = $searchrow1['title'];
						$searchvalue1 = $search1.'2';
						echo "<option value=\"$searchvalue1\">$search1</option>";
					}
					?>
					<?php
					$searchdrop2 = "SELECT title FROM srd";
					$searchdata2 = mysqli_query($dbcon, $searchdrop2) or die('error getting data');
					while($searchrow2 =  mysqli_fetch_array($searchdata2, MYSQLI_ASSOC)) {
						$search2 = $searchrow2['title'];
						$searchvalue2 = $search2.'3';
						echo "<option value=\"$searchvalue2\">Rules: $search2</option>";
					}
					?>
					</select>
				</li>
				<?php // if ($loguser == 'tarfuin') { ?>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">World(DM)<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="/tools/campaign-log/campaign-log.php">Campaign Log</a></li>
<?php if ($loguser == 'tarfuin') { ?>
					<li><a href="/tools/world/map-region.php">Region Map</a></li>
					<li><a href="/tools/world/map.php">City Map</a></li>
					<li><a href="https://app.fantasy-calendar.com/calendars/5752f966e0418bff07ba310d8817dd86" target="_BLANK">Calendar</a></li>
					<li><a href="/tools/world/dbimport.php">Add to Compendium</a></li>
					<?php  } ?>

					<li><a href="/tools/world/import.php">Import</a></li>
					<li><a href="/tools/world/gmnotes.php">GM Notes</a></li>
					<li><a href="/tools/world/xp.php">Award XP</a></li>


					<li role="separator" class="divider"></li>
					<li><a href="/tools/world/all.php">All</a></li>
					<li><a href="/tools/world/settlement.php">Settlements</a></li>
					<li><a href="/tools/world/npc.php">NPCs</a></li>
					<li><a href="/tools/world/pc.php">Player Characters</a></li>
					<li><a href="/tools/world/faction.php">Factions</a></li>
					<li><a href="/tools/world/deity.php">Deities</a></li>
					<li><a href="/tools/world/quest.php">Quests</a></li>
					<li><a href="/tools/world/establishment.php">Establishments</a></li>
					<li><a href="/tools/world/publicquest.php">Public Quests</a></li>

				</ul>
				<li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Compenium<span class="caret"></span></a>
          <ul class="dropdown-menu">
						<li><a href="/tools/compendium/background.php">Backgrounds</a></li>
						<li><a href="/tools/compendium/class.php">Classes</a></li>
						<li><a href="/tools/compendium/feat.php">Feats</a></li>
						<li><a href="/tools/compendium/item.php">Items</a></li>
						<li><a href="/tools/compendium/monster.php">Monsters</a></li>
						<li><a href="/tools/compendium/race.php">Races</a></li>
						<li><a href="/tools/compendium/spell.php">Spells</a></li>
						<li><a href="/tools/compendium/monster-all.php">Monsters(Lookup)</a></li>

					</ul>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tools<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="/tools/world/workspace.php">Workspace</a></li>
							<li><a href="/tools/initiative/initiative.php">Initiative</a></li>
							<li><a href="/tools/generator/generator.php">Random Generator</a></li>
							<li><a href="/tools/compendium/encounter-builder.php">Encounter Builder</a></li>

							<li>
<?php if ($loguser == 'tarfuin') {
							echo ('<a href="/tools/resources/toc.php">Resources</a>');
}
	else {
		echo ('<a href="/tools/resources/player-resources.php">Resources</a>');
	}
	?>
							</li>
							<li><a href="/tools/generator/spell-generator.php">Spell Generator</a></li>

						</ul>

						<li><a href="/tools/srd/srd.php">Rules/SRD</a></li>
						<?php
						if ($friend == 1) { ?>
			<!--	<li><a href="/tools/questboard/questboard.php">Quest Board</a></li> -->
				<?php
			}
			?>
				<!-- <li><a class="navbar-toggler" type="button" data-toggle="collapse" href="#" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">Music</a></li> -->
				<?php
				if ($loguser == 'null'){

				echo ('<li><a href="/tools/users/login.php">Login</a></li>');
			}
			else {

			echo ('<li class="dropdown"><a href="#" class="dropdown-toggle" style="color: #42f486;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.ucfirst($loguser).'<span class="caret"></span></a>');
			?>
			<ul class="dropdown-menu">
				<li><a href="/tools/users/characters.php">Characters</a></li>
				<li><a href="/tools/users/notes.php">Notes</a></li>
				<li><a href="/tools/users/bookmarks.php">Bookmarks</a></li>
				<li><a href="/tools/users/logout.php">Logout</a></li>
			</ul>
			<?php
			}
			?>
		<!--			<div class="collapse" id="navbarToggleExternalContent" style="margin-top:50px;">
						<div class="row">

						<iframe src="https://open.spotify.com/embed/user/1276319948/playlist/5htGO0OUB7SsFMT3kwjBn3" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
						<iframe src="https://open.spotify.com/embed/user/1276319948/playlist/60gbvdwgY25KcXsj0uc2qb" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
						<iframe src="https://open.spotify.com/embed/user/1276319948/playlist/0oYKtwS7RH8qmFNmUg1GPp" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
						<iframe src="https://open.spotify.com/embed/user/1276319948/playlist/0nWXBUnIWBTcGjnQ9f1Qqy" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
    </div>
	</div> -->


  </div>


      </ul>



    </div><!-- /.navbar-collapse -->

				<!--<div class="col-md-2"><a href="/tools/world/import.php">Import</a></div>
				<div class="col-md-2"><a href="/login.php">Signup/Login</a></div>-->
					<!--<form method="post" id="searchdiv" action="/tools/world/world.php">-->

				<!--</form>-->

				<script type="text/javascript">
				$('#search').selectize({
				onChange: function(value){
					if(value.slice(-1) == 1) {
					window.location.href = '/tools/world/world.php?id=' + value.slice(0, -1);
				}
				else if(value.slice(-1) == 2) {

					window.location.href = '/tools/compendium/compendium.php?id=' + value.slice(0, -1);
				}
				else {

					window.location.href = '/tools/srd/rules.php?id=' + value.slice(0, -1);
				}
				},
				create: false,
				openOnFocus: false,
				maxOpions: 4,
				sortField: 'text',
				placeholder: 'search...'
				},);
				</script>
			</div><!-- /.container-fluid -->
		</nav>

		<div class="container-fluid">

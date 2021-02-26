<?php
$headpath = $_SERVER['DOCUMENT_ROOT'];
$headpath .= "/header.php";
include_once($headpath);
?>

<div class="mainbox col-lg-10 col-xs-12 col-lg-offset-1">
				<h1 class="pagetitle">Brian's RPG Tools</h1>
				<div class="menu">
					<a class="menulink" href="/tools/resources/player-resources.php"><div class="menuitem">
						<img class ="menu-icon" src="/assets/images/resources.png" />
						<h3>Player Resources</h3>
					</div></a>
					<a class="menulink" href="/tools/resources/dm/resources.php"><div class="menuitem">
						<img class ="menu-icon" src="/assets/images/resources.png" />
						<h3>DM Resources</h3>
					</div></a>
								</div>
			</div>
      <?php
      //Footer
      $footpath = $_SERVER['DOCUMENT_ROOT'];
      $footpath .= "/footer.php";
      include_once($footpath);
       ?>

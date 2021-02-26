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


		<title><?php echo $pgtitle; ?>GameRipple</title>
		
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
      <a class="navbar-brand" href="/index.php">GameRipple</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
				<li class="topsearch">
					
				</li>
				
						<?php
			if ($loguser == 'tarfuin'){
			echo ('<li class="dropdown"><a href="#" class="dropdown-toggle" style="color: #42f486;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.ucfirst($loguser).'<span class="caret"></span></a>');
			?>
			<ul class="dropdown-menu">
				<li><a href="/tools/users/logout.php">Logout</a></li>
			</ul>
			<?php
			}
			?>
  </div>
      </ul>
    </div>
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

<?php
	
	require("lib/blog_lib.php");
	require("lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();
	
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Import Google Icon Font -->
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- Import materialize.css -->
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/custom.css" />
		
		<?php 
			if(getSetting($mysql->getConnection(), "favicon") == "1")
				echo '<link rel="icon" href="../img/favicon.png" type="image/x-icon" />';
			else 
				echo '<link rel="icon" href="" type="image/x-icon" />';
		?>
		
		<title><?php echo getSetting($mysql->getConnection(), "title"); ?> - Archiv</title>
		
		<!-- Let browser know website is optimized for mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	</head>

	<body>
	<ul class="side-nav" id="mobile-nav">
		<li class="search">
			<div class="card">
				<form method="get" action="search.php">
					<div class="input-field">
						<input id="search" name="q" type="search" required>
						<label class="label-icon" for="search"><i class="material-icons">search</i></label>
						<i class="material-icons">close</i>
					</div>
				</form>
			</div>
		</li>
		<li><a href="archive.php"><span class="black-text text-darken-2">Archiv</span></a></li>
		<?php 
			session_start();
			if(isset($_SESSION['username'])) {
		?>
		<li><a href="admin/dashboard.php"><span class="black-text text-darken-2">Dashboard</span></a></li>
		<li><a href="admin/logout.php"><span class="black-text text-darken-2">Logout</span></a></li>
		<?php 
			} else {
		?>
		<li><a href="admin/login.php"><span class="black-text text-darken-2">Login</span></a></li>
		<?php 
			}
		?>
		<li><a href="impressum.html"><span class="black-text text-darken-2">Impressum</span></a></li>
	</ul>
		<header>
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper grey lighten-3">
						<a href="index.php" class="brand-logo center"><span class="black-text text-darken-2">&nbsp;<?php echo getSetting($mysql->getConnection(), "logo"); ?></span></a>
						<a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons black-text text-darken-2">menu</i></a>
						<ul class="right hide-on-med-and-down">
						<?php 
							if(isset($_SESSION['username'])) {
						?>
							<li><a href="admin/dashboard.php"><span class="black-text text-darken-2">Dashboard</span></a></li>
							<li><a href="admin/logout.php"><span class="black-text text-darken-2">Logout</span></a></li>
						<?php 
							} else {
						?>
							<li><a href="admin/login.php"><span class="black-text text-darken-2">Login</span></a></li>
						<?php 
							}
						?>
							<li><a href="impressum.html"><span class="black-text text-darken-2">Impressum</span></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<main>
			<div class="row">
				<div class="col s12">
				<!-- page content  -->
					<div class="archive-container" style="margin: 0 auto; margin-top: 15px; padding: 25px;">
					<?php
						getArchivePosts($mysql->getConnection(), 0);
					?>
					</div>
				</div>
			</div>
		</main>
		<footer>
		</footer>
		
		<!-- Import jQuery before materialize.js -->
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript">(function($){
  $(function(){

    $('.button-collapse').sideNav();

  }); // end of document ready
})(jQuery); // end of jQuery name space</script>
	</body>
</html>
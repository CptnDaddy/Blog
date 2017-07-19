<?php
	
	require("../lib/blog_lib.php");
	require("../lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();
	
	if(isset($_POST['submit'])) {
		login($mysql->getConnection(), $_POST["username"], md5($_POST["password"]));
	}
	
	session_start();
	if(isset($_SESSION['username'])) {
		header("Location: dashboard.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Import Google Icon Font -->
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<!-- Import materialize.css -->
		<link type="text/css" rel="stylesheet" href="../css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="../css/custom.css" />
		
		<?php 
			if(getSetting($mysql->getConnection(), "favicon") == "1")
				echo '<link rel="icon" href="../img/favicon.png" type="image/x-icon" />';
			else 
				echo '<link rel="icon" href="" type="image/x-icon" />';
		?>
		
		<title><?php echo getSetting($mysql->getConnection(), "title"); ?></title>
		
		<!-- Let browser know website is optimized for mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	</head>

	<body>
	<ul class="side-nav" id="mobile-nav">
		<li class="active"><a href="login.php">Login</a></li>
		<li><a href="../impressum.html">Impressum</a></li>
	</ul>
		<header>
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper grey lighten-3">
						<a href="../index.php" class="brand-logo center"><span class="black-text text-darken-2">&nbsp;<?php echo getSetting($mysql->getConnection(), "logo"); ?></span></a>
						<a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons black-text text-darken-2">menu</i></a>
						<ul class="right hide-on-med-and-down">
							<li class="active"><a href="login.php"><span class="black-text text-darken-2">Login</span></a></li>
							<li><a href="../impressum.html"><span class="black-text text-darken-2">Impressum</span></a></li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<main>
			<div class="row hide-on-med-and-down">
				<div class="col s12">
					<div class="grey lighten-3 center" style="margin: 0 auto; margin-top: 120px; padding: 15px; box-shadow: 1px 1px 2px gray; width: 27%">
						<form method="post">
							<h5>Login</h5><br>
							<?php 
								if(isset($_GET['s'])) {
									log_status($_GET['s']);
								}
							?>
							<p><label>Benutzername <input type="text" name="username"></input></label></p>
							<p><label>Passwort <input type="password" name="password"></input></label></p>
							<p><input class="btn waves-effect waves-light" type="submit" name="submit" value="Einloggen"></input></p>
						</form>
					</div>
				</div>
			</div>
			<div class="row hide-on-large-only">
				<div class="col s12">
					<div class="grey lighten-3 center" style="margin: 0 auto; margin-top: 120px; padding: 15px; box-shadow: 1px 1px 2px gray; width: 80%">
						<form method="post">
							<h5>Login</h5><br>
							<?php 
								if(isset($_GET['s'])) {
									log_status($_GET['s']);
								}
							?>
							<p><label>Benutzername <input type="text" name="username"></input></label></p>
							<p><label>Passwort <input type="password" name="password"></input></label></p>
							<p><input class="btn waves-effect waves-light" type="submit" name="submit" value="Einloggen"></input></p>
						</form>
					</div>
				</div>
			</div>
		</main>
		<footer>
		</footer>
		
		<!-- Import jQuery before materialize.js -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/materialize.min.js"></script>
		<script type="text/javascript">$(".button-collapse").sideNav();</script>
	</body>
</html>
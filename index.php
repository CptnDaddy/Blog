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
		
		
		<title><?php echo getSetting($mysql->getConnection(), "title"); ?> - Home</title>
		
		<!-- Let browser know website is optimized for mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
		
		<script>
			var offset = 10;
			var loading = false;
		</script>
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
			<div class="row hide-on-med-and-down">
				<div class="col s2">
					<!-- navigation panel -->
					<div class="grey lighten-3 navside">
						<a class="center" href=""><h5>Navigation</h5></a>
						<ul style="text-align: center;">
							<li class="search">
								<div class="nav-wrapper card">
									<form method="get" action="search.php">
										<div class="input-field">
											<input id="search" name="q" type="search" required>
											<label class="label-icon" for="search"><i class="material-icons">search</i></label>
											<i class="material-icons">close</i>
										</div>
									</form>
								</div>
							</li>
							<li>
								<div class="img">
								<?php 
									if(getSetting($mysql->getConnection(), "navpic") == "1")
										echo '<img src="img/navpic.png" height="auto" width="auto" />';
									else
										echo '<img src="img/default.png" height="auto" width="auto" />';
										
										
								?>
								</div>
							</li>
							<li><b>Kurzbeschreibung:</b></li>
							<li>
								<div class="container" style="word-break: break-word;">
									<?php echo getSetting($mysql->getConnection(), "shortbio"); ?>
								</div>
							</li>
							<hr><br>
							<li><a href="archive.php">Archiv</a></li>
						</ul>
					</div>
				</div>
				
				<div class="col s8">
				<!-- page content  -->
					<div class="postdiv" style="margin: 0 auto; margin-left: 10%; margin-top: 5px; padding: 25px; width: 85%;">
					
					<?php
						getPosts($mysql->getConnection(), 0);
					?>
					</div>
				</div>
				<div style="right: 280px; position: fixed;">
					<div class="grey lighten-3 center" style="position: fixed; right: 10px; margin-top: 15px; padding: 15px; box-shadow: 1px 1px 2px gray; width: 17%">
						<img src="img/ad.gif" width="100%" style="max-width: 240px"/>
						<p>Hier k&ouml;nnte Ihre Werbung stehen</p>
					</div>
				</div>
			</div>
			<div class="row hide-on-large-only">
				<div class="col s12">
				<!-- page content  -->
					<div class="postdiv"  style="margin: 0 auto; margin-top: 15px; padding: 5px;">
					
					<?php
						getPosts($mysql->getConnection(), 0);
					?>
					</div>
				</div>
			</div>
			
		<div class="preloader-wrapper big active" style="margin: 0 auto;">
		    <div class="spinner-layer spinner-blue-only">
		      <div class="circle-clipper left">
		        <div class="circle"></div>
		      </div><div class="gap-patch">
		        <div class="circle"></div>
		      </div><div class="circle-clipper right">
		        <div class="circle"></div>
		      </div>
		    </div>
		  </div>
		</main>
		<footer>
		</footer>
		<!-- Import jQuery before materialize.js -->
		<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript">
		(function($){
		  $(function(){
			$('.button-collapse').sideNav();
		  }); // end of document ready
		})(jQuery); // end of jQuery name space

		$(document).ready(function() {
			hidePreloader();
		});
		
		function loadPosts() {
			setTimeout(function() {
				console.log(offset);
				var elements = document.getElementsByClassName("postdiv");
				$.ajax({ url: 'ajax/loadposts.php',
			         data: {offset: offset},
			         type: 'post',
			         success: function(output) {
				         if (output) {
			                 for(var i = 0; i < elements.length; i++) {
			                     elements[i].innerHTML += output;
		                     }    
		                     loading = false;
		                     offset += 10;
				         }
				         hidePreloader();
			         }
				});
			}, 2000, offset);
		}

		var preloader = document.getElementsByClassName("preloader-wrapper");
		function showPreloader() {
			for(var i = 0; i < preloader.length; i++) {
				preloader[i].style.display = "block";
			}
		}

		function hidePreloader() {
			for(var i = 0; i < preloader.length; i++) {
				preloader[i].style.display = "none";
			}
		}
		
		window.onscroll = function(ev) {
		    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight && !loading) {		
			    loading = true;	    
			    showPreloader();
		        loadPosts();
		        //console.log(offset);
		    }
		};
		</script>
	</body>
</html>
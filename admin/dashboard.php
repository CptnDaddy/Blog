<?php
	session_start();
	if(isset($_SESSION['username'])) {
		require("../lib/blog_lib.php");
		require("../lib/mysql_lib.php");
		
		$mysql = new mysql_lib();
		
		$mysql->connectToDatabase();
		
		$_SESSION['username'] = refreshUsername($mysql->getConnection(), $_SESSION['userid']);
	} else {
		header("Location: login.php?s=1");
	}
	
	// Handling form data
	
	if($_SERVER['REQUEST_METHOD'] == "POST") {
		if(isset($_POST['submitheader'])) {
			setString($mysql->getConnection(), "settings", "title", $_POST['title']);
			setString($mysql->getConnection(), "settings", "logo", $_POST['logo']);
			$page = 1;
		} if(isset($_POST['submitpics'])) {
			
			$uploaddir = '../img/';
			
			if($_FILES['navpic']['size'] != 0) {
				$navpic = $uploaddir . "navpic.png";
				if($_FILES['navpic']['size'] < 1000000) {
					if (move_uploaded_file($_FILES['navpic']['tmp_name'], $navpic)) {
						setInt($mysql->getConnection(), "settings", "navpic", 1);
						$navpicupload = 0;
					} else
						$navpicupload = 1;
				} else {
					$navpicupload = 2;
				}
			}
			if($_FILES['favicon']['size'] != 0) {
				$favicon = $uploaddir . "favicon.png";
				if($_FILES['favicon']['size'] < 1000000) {
					if (move_uploaded_file($_FILES['favicon']['tmp_name'], $favicon)) {
						setInt($mysql->getConnection(), "settings", "favicon", 1);
						$faviconupload = 0;
					} else
						$faviconupload = 1;
				} else {
					$faviconupload = 2;
				}
			}
			
			$page = 2;
		} else if(isset($_POST['submitabout'])) {
			setString($mysql->getConnection(), "settings", "shortbio", $_POST['bio']);
			$page = 2;
		} else if(isset($_POST['submitpost'])) {
			$uploaddir = '../uploads/';
				
			if($_FILES['postpic']['size'] != 0) {
				if($_FILES['postpic']['size'] < 1000000) {
					$id = post($mysql->getConnection(), $_SESSION['userid'], $_POST['posttitle'], $_POST['posttext'], 1);
					if (move_uploaded_file($_FILES['postpic']['tmp_name'], $uploaddir . $id . ".png")) {
						$posted = 0;
					} else
						$posted = 1;
				} else {
					$posted = 2;
				}
			} else {
				post($mysql->getConnection(), $_SESSION['userid'], $_POST['posttitle'], $_POST['posttext'], 0);
				$posted = 0;
			}
			$page = 3;
		} else if(isset($_POST['submitpostchange'])) {
			$uploaddir = '../uploads/';
			$id = split(" - ", $_POST['editposts'])[0];
			
			if($_FILES['posteditpic']['size'] != 0) {
				if($_FILES['posteditpic']['size'] < 1000000) {
					if (move_uploaded_file($_FILES['posteditpic']['tmp_name'], $uploaddir . $id . ".png")) {
						editPost($mysql->getConnection(), $id, $_POST['postedittitle'], $_POST['postedittext'], 1);
						$posted = 0;
					} else
						$posted = 1;
				} else {
					$posted = 2;
				}
			} else {
				editPost($mysql->getConnection(), $id, $_POST['postedittitle'], $_POST['postedittext'], 0);
				$posted = 0;
			}
			
			$page = 4;
		} else if(isset($_POST['submitnewuser'])) {
			if(createUser($mysql->getConnection(), $_POST['username'], md5($_POST['password'])))
				$usercreated = true;
			 else
			 	$usercreated = false;
			$page = 5;
		} else if(isset($_POST['submituseredit'])) {
			editUser($mysql->getConnection(), split(" - ", $_POST['userid'])[0], $_POST['username'][1], md5($_POST['password'][1]), (!empty($_POST['password'][1])));
			$page = 6;
		} else if(isset($_POST['submituserperms'])) {
			for($i = 1; $i < 7; $i++) {
				if(isset($_POST['permission' . $i]))
					giveUserPerms($mysql->getConnection(), $_POST['userperms'], $i);
				else
					removeUserPerms($mysql->getConnection(), $_POST['userperms'], $i);
			}
			$page = 7;
		}
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
		
		<script src="editor/ckeditor.js"></script>
		
		<?php 
			if(getSetting($mysql->getConnection(), "favicon") == "1")
				echo '<link rel="icon" href="../img/favicon.png" type="image/x-icon" />';
			else 
				echo '<link rel="icon" href="" type="image/x-icon" />';
		?>
		
		<title><?php echo getSetting($mysql->getConnection(), "title"); ?> - Dashboard</title>
		
		<!-- Let browser know website is optimized for mobile -->
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	</head>

	<body>
	<ul class="side-nav" id="mobile-nav">
		<li class="search">
			<div class="card">
				<form method="get" action="../search.php">
					<div class="input-field">
						<input id="search" name="q" type="search" required>
						<label class="label-icon" for="search"><i class="material-icons">search</i></label>
						<i class="material-icons">close</i>
					</div>
				</form>
			</div>
		</li>
		<li class="active"><a href="dashboard.php">Dashboard</a></li>
		<li><a href="logout.php">Logout</a></li>
		<li><a href="../impressum.html">Impressum</a></li>
		<li><div class="divider"></div></li>
		<ul class="collapsible" data-collapsible="accordion" style="text-align: center;">
			<li><a class="center" href=""><h5>Navigation</h5></a></li>
				<li>
			      <div class="collapsible-header"><i class="material-icons">settings</i>Allgemeine Einstellungen</div>
				      <div class="collapsible-body">
				      	<ul>
				      		<li><a href="#!" onclick="display('1');">Header Einstellungen</a></li>
				      		<li><a href="#!" onclick="display('2');">"&Uuml;ber mich" bearbeiten</a></li>
				      	</ul>
				      </div>
			    </li>
			    <li>
			      <div class="collapsible-header"><i class="material-icons">view_quilt</i>Post Management</div>
				      <div class="collapsible-body">
				      	<ul>
				      		<li><a href="#!" onclick="display('3');">Post verfassen</a></li>
				      		<li><a href="#!" onclick="display('4');">Posts verwalten</a></li>
				      	</ul>
				      </div>
			    </li>
			    <li>
			      <div class="collapsible-header"><i class="material-icons">perm_identity</i>User verwalten</div>
				      <div class="collapsible-body">
				      	<ul>
				      		<li><a href="#!" onclick="display('5');">User anlegen</a></li>
				      		<li><a href="#!" onclick="display('6');">User bearbeiten</a></li>
				      		<li><a href="#!" onclick="display('7');">Rechte verwalten</a></li>
				      	</ul>
				      </div>
			    </li>
		    </ul>
	</ul>
		<header>
			<div class="navbar-fixed">
				<nav>
					<div class="nav-wrapper grey lighten-3">
						<a href="../index.php" class="brand-logo center"><span class="black-text text-darken-2">&nbsp;<?php echo getSetting($mysql->getConnection(), "logo"); ?></span></a>
						<a href="#" data-activates="mobile-nav" class="button-collapse"><i class="material-icons black-text text-darken-2">menu</i></a>
						<ul class="right hide-on-med-and-down">
							<li class="active"><a href="dashboard.php"><span class="black-text text-darken-2">Dashboard</span></a></li>
							<li><a href="logout.php"><span class="black-text text-darken-2">Logout</span></a></li>
							<li><a href="../impressum.html"><span class="black-text text-darken-2">Impressum</span></a></li>
						</ul>
					</div>
				</nav>
			</div>
			</header>
			<main>
			<div class="row">
				<div class="col s2 hide-on-med-and-down">
					<div class="grey lighten-3 navside">
						<a class="center" href=""><h5>Navigation</h5></a><br>
						<ul class="collapsible" data-collapsible="accordion" style="text-align: center;">
							<li>
						      <div class="collapsible-header"><i class="material-icons">settings</i>Allgemeine Einstellungen</div>
							      <div class="collapsible-body">
							      	<ul>
							      		<li><a href="#!" onclick="display('1');">Header Einstellungen</a></li>
							      		<li><a href="#!" onclick="display('2');">"&Uuml;ber mich" bearbeiten</a></li>
							      	</ul>
							      </div>
						    </li>
						    <li>
						      <div class="collapsible-header"><i class="material-icons">view_quilt</i>Post Management</div>
							      <div class="collapsible-body">
							      	<ul>
							      		<li><a href="#!" onclick="display('3');">Post verfassen</a></li>
							      		<li><a href="#!" onclick="display('4');">Posts verwalten</a></li>
							      	</ul>
							      </div>
						    </li>
						    <li>
						      <div class="collapsible-header"><i class="material-icons">perm_identity</i>User verwalten</div>
							      <div class="collapsible-body">
							      	<ul>
							      		<li><a href="#!" onclick="display('5');">User anlegen</a></li>
							      		<li><a href="#!" onclick="display('6');">User bearbeiten</a></li>
							      		<li><a href="#!" onclick="display('7');">Rechte verwalten</a></li>
							      	</ul>
							      </div>
						    </li>
						</ul>
					</div>
				</div>
				<div class="col s10">
					<div class="grey lighten-3" style="margin: 0 auto; margin-left: 10%; margin-top: 15px; padding: 25px; box-shadow: 1px 1px 2px gray; width: 85%;">
					<p><h4>Einstellungen:</h4></p>
						<div class="page" id="0" style="display: none;">
							<p>Hallo <b><?php echo $_SESSION['username'];?>!</b></p>
							<p>Die Navigation befindet sich auf der linken Seite.</p>
						</div>
						<div class="page" id="1" style="display: none;">
							<form method=post>
								<fieldset>
									<legend>Header Einstellungen</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 1)) {
									?>
									<p><label>Titel (Tab): <input type="text" name="title" value="<?php echo getSetting($mysql->getConnection(), "title")?>"></input></label></p>
									<p><label>Logo (Navbar): <input type="text" name="logo" value="<?php echo getSetting($mysql->getConnection(), "logo")?>"></input></label></p>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitheader" value="&Uuml;bernehmen"></input></p>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="2" style="display: none;">
							<form method=post enctype="multipart/form-data">
								<fieldset>
									<legend>Bilder bearbeiten</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 1)) {
									?>
									<div class="file-field input-field">
										<div class="btn">
											<span>Bild (Navigation):</span>
											<input type="file" name="navpic" accept="image/*">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
									<div class="file-field input-field">
										<div class="btn">
											<span>Favicon (Tab):</span>
											<input type="file" name="favicon" accept="image/*">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitpics" value="Hochladen"></input></p>
								<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
							<form method=post>
								<fieldset>
									<legend>"&Uuml;ber mich" bearbeiten</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 1)) {
									?>
									<p><label>Bio (Navigation): <input type="text" name="bio" value="<?php echo getSetting($mysql->getConnection(), "shortbio")?>" required></input></label></p>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitabout" value="&Uuml;bernehmen"></input></p>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="3" style="display: none;">
							<form method=post enctype="multipart/form-data">
								<fieldset>
									<legend>Post verfassen</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 2)) {
									?>
									<p><label>Titel: <input type="text" name="posttitle" required></input></label></p>
									<div class="file-field input-field">
										<div class="btn">
											<span>Bild anf&uuml;gen:</span>
											<input type="file" name="postpic" accept="image/*">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
									<p>
										<label for="posttext">Nachricht:</label>
										<textarea id="posttext" data-length="5000" name="posttext" required></textarea>
									</p>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitpost" value="Posten"></input></p>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="4" style="display: none;">
							<form method=post enctype="multipart/form-data">
								<fieldset>
									<legend>Posts verwalten</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 3)) {
									?>
										<label>Post:</label>
										<div class="input-field">
											<select id="editposts" name="editposts">
												<?php 
													getPostsAsOptions($mysql->getConnection());
												?>
											</select>
										</div>
									<p><label>Titel: <input type="text" name="postedittitle" id="postedittitle"></input></label></p>
									<div class="file-field input-field">
										<div class="btn">
											<span>Bild anf&uuml;gen:</span>
											<input type="file" name="posteditpic" accept="image/*">
										</div>
										<div class="file-path-wrapper">
											<input class="file-path validate" type="text">
										</div>
									</div>
									<div class="btn" id="deletepic"><span><i class="material-icons">delete</i> Bild l&ouml;schen</span></div>
									<p>
										<label for="postedittext">Nachricht:</label>
										<textarea id="postedittext" data-length="5000" name="postedittext"></textarea>
									</p>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitpostchange" value="&Uuml;bernehmen"></input></p><div class="btn" id="deletepost"><span><i class="material-icons">delete</i> Post l&ouml;schen</span></div>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="5" style="display: none;">
							<form method=post>
								<fieldset>
									<legend>User anlegen</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 4)) {
											
											if(isset($usercreated)) {
												if($usercreated)
													echo "<span style='color:green'>User erstellt!</span>";
												else
													echo "<span style='color:red'>Es ist ein Fehler aufgetreten!</span>";
											}
									?>
									<p><label>Benutzername: <input type="text" name="username" required></input></label></p>
									<p><label>Passwort: <input type="password" name="password" required></input></label></p>
									<p><input class="waves-effect waves-light btn" type="submit" name="submitnewuser" value="Registrieren"></input></p>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="6" style="display: none;">
							<form method=post autocomplete="off">
								<fieldset>
									<legend>User bearbeiten</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 5)) {
									?>
									<div class="input-field">
										<select id="editusers" name="userid" required>
											<?php 
												getUsersAsOptions($mysql->getConnection());
											?>
										</select>
									</div>
									<p><input style="display:none" type="text" class="disableAutoComplete" name="username[]" autocomplete="off"></input></p>
									<p><input style="display:none" type="password" class="disableAutoComplete" name="password[]" autocomplete="off"></input></p>
									
									<p><label>Benutzername: <input type="text" class="disableAutoComplete" id="editusername" name="username[]" autocomplete="off" required></input></label></p>
									<p><label>New Passwort: <input type="password" class="disableAutoComplete" id="editpassword" name="password[]" autocomplete="off"></input></label></p>
									<div class="btn" id="deleteuser"><span><i class="material-icons">delete</i> Benutzer l&ouml;schen</span></div>
									<p><input class="waves-effect waves-light btn" type="submit" name="submituseredit" value="&Auml;ndern"></input></p>
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
						<div class="page" id="7" style="display: none;">
							<form method=post>
								<fieldset>
									<legend>Rechte verwalten</legend>
									<?php 
										if(hasPermission($mysql->getConnection(), $_SESSION['userid'], 6)) {
									?>
										
									<div class="input-field">
										<select name="userperms" required>
											<?php 
												getUsersAsOptions($mysql->getConnection());
											?>
										</select>
									</div>
									<p>Benutzer darf:</p>
									<div class="row">
										<div class="col s3">
										
											<p>
												<input  id="permission1" type="checkbox" class="filled-in" name="permission1" />
												<label for="permission1">Einstellungen &auml;ndern</label> 
											</p>
											<p>
												<input  id="permission2" type="checkbox" class="filled-in" name="permission2" />
												<label for="permission2">Posts verfassen</label> 
											</p>
											<p>
												<input  id="permission3" type="checkbox" class="filled-in" name="permission3" />
												<label for="permission3">Posts bearbeiten</label> 
											</p>
											<p>
												<input  id="permission4" type="checkbox" class="filled-in" name="permission4" />
												<label for="permission4">User erstellen</label> 
											</p>
											<p>
												<input  id="permission5" type="checkbox" class="filled-in" name="permission5" />
												<label for="permission5">User bearbeiten</label>
											</p>
											<p>
												<input  id="permission6" type="checkbox" class="filled-in" name="permission6" />
												<label for="permission6">Rechte &auml;ndern</label> 
											</p>
										</div>
									</div>
									<p><input class="waves-effect waves-light btn" type="submit" name="submituserperms" value="&Uuml;bernehmen"></input></p>
																	
									<?php 
										} else {
											echo "<span style='color: red'>Keine Berechtigung!</span>";
										}
									?>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row hide-on-large-only">
			</div>
		</main>
		<footer>
		</footer>
		
		<!-- Import jQuery before materialize.js -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="../js/materialize.js"></script>
	    
		<script>
		$(".button-collapse").sideNav({ closeOnClick: true });
		$('.collapsible').collapsible();
		$('select').material_select();

		CKEDITOR.replace('posttext');
		CKEDITOR.replace('postedittext');

		$("#deletepost").click(function() {
			var e = document.getElementById("editposts");
			var vl = e.options[e.selectedIndex].value;
			var id = vl.split(" - ")[0];
			$.ajax({ url: '../ajax/delete.php',
		         data: {postid: id},
		         type: 'post',
		         success: function(output) {
			         if(output == "success")
				         Materialize.toast("Post erfolgreich gel&ouml;scht", 5000);
			         else
			        	 Materialize.toast("Post konnte nicht gel&ouml;scht werden", 5000);
			         setTimeout(function() {location.reload(false);}, 2000);
		         }
			});
		});

		$("#deletepic").click(function() {
			var e = document.getElementById("editposts");
			var vl = e.options[e.selectedIndex].value;
			var id = vl.split(" - ")[0];
			$.ajax({ url: '../ajax/delete.php',
		         data: {picid: id},
		         type: 'post',
		         success: function(output) {
			         if(output == "success")
				         Materialize.toast("Bild erfolgreich gel&ouml;scht", 5000);
			         else
			        	 Materialize.toast("Bild konnte nicht gel&ouml;scht werden", 5000);
			         setTimeout(function() {location.reload(false);}, 2000);
		         }
			});
		});

		$("#deleteuser").click(function() {
			var e = document.getElementById("editusers");
			var vl = e.options[e.selectedIndex].value;
			var id = vl.split(" - ")[0];
			console.log(id);
			$.ajax({ url: '../ajax/delete.php',
		         data: {userid: id},
		         type: 'post',
		         success: function(output) {
			         if(output == "success")
				         Materialize.toast("Benutzer erfolgreich gel&ouml;scht", 5000);
			         else
			        	 Materialize.toast("Benutzer konnte nicht gel&ouml;scht werden", 5000);
			         setTimeout(function() {location.reload(false);}, 2000);
		         }
			});
		});
		
		$(document).ready(function() {
			<?php 
				if(isset($page))
					echo "display('$page');";
				else 
					echo "display('0');";
				
				if(isset($navpicupload)) {
					if($navpicupload == 0){
						echo 'Materialize.toast("Die Datei wurde erfolgreich hochgeladen!", 5000);';
					} else if($navpicupload == 1){
						echo 'Materialize.toast("Die Datei konnte nicht hochgeladen werden!", 5000);';
					} else if($navpicupload == 2){
						echo 'Materialize.toast("Die hochgeladene Datei ist zu groß!", 5000);';
					}
				}
				if(isset($faviconupload)) {
					if($faviconupload == 0){
						echo 'Materialize.toast("Die Datei wurde erfolgreich hochgeladen!", 5000);';
					} else if($faviconupload == 1){
						echo 'Materialize.toast("Die Datei konnte nicht hochgeladen werden!", 5000);';
					} else if($faviconupload == 2){
						echo 'Materialize.toast("Die hochgeladene Datei ist zu groß!", 5000);';
					}
				}
				if(isset($posted)) {
					if($posted == 0){
						echo 'Materialize.toast("Dein Post wurde ver&ouml;ffentlicht!", 5000);';
					} else if($posted == 1){
						echo 'Materialize.toast("Dein Post konnte nicht ver&ouml;ffentlicht werden!", 5000);';
					} else if($posted == 2){
						echo 'Materialize.toast("Die hochgeladene Datei ist zu groß!", 5000);';
					}
				}
				
				?>

			$.ajax({ url: '../ajax/loadpostinfo.php',
		         data: {postid: "1"},
		         type: 'post',
		         success: function(output) {
		                      var str = output.split(";");
		                      $("#postedittitle").attr("value", str[0]);
		                      Materialize.updateTextFields();
		                      CKEDITOR.instances.postedittext.setData(str[1]);
		                  }
			});
			$.ajax({ url: '../ajax/loaduserinfo.php',
		         data: {userid: "1"},
		         type: 'post',
		         success: function(output) {
                    $("#editusername").attr("value", output);
                    Materialize.updateTextFields();
		         }
			});
			$.ajax({ url: '../ajax/loaduserperms.php',
		         data: {userid: "1"},
		         type: 'post',
		         success: function(output) {
		                      var options = output.split(";");
		                      for (var i = 0; i < options.length; i++) {
		                    	  $("#permission" + (i+1)).prop("checked", false);
			                      if(options[i] == "true") $("#permission" + (i+1)).prop("checked", true);
		                      }
		                  }
			});
		});
			
		function display(id) {
			var elements = document.getElementsByClassName("page");
			for(var i = 0; i < elements.length; i++) {
				elements[i].style.display = "none";
			}
			document.getElementById(id).style.display = "block";
		}
		
		$( "select[name=editposts]" ).change(function() {
			$.ajax({ url: '../ajax/loadpostinfo.php',
		         data: {postid: this.value.split(" - ")[0]},
		         type: 'post',
		         success: function(output) {
		                      var str = output.split(";");
		                      $("#postedittitle").attr("value", str[0]);
		                      Materialize.updateTextFields();
		                      CKEDITOR.instances.postedittext.setData(str[1]);
		                  }
			});
		});
		
		$( "select[name=userid]" ).change(function() {
			$.ajax({ url: '../ajax/loaduserinfo.php',
		         data: {userid: this.value.substring(0,1)},
		         type: 'post',
		         success: function(output) {
                     $("#editusername").attr("value", output);
                     Materialize.updateTextFields();
		         }
			});
		});

		$( "select[name=userperms]" ).change(function() {
			$.ajax({ url: '../ajax/loaduserperms.php',
		         data: {userid: this.value.split(" - ")[0]},
		         type: 'post',
		         success: function(output) {
		                      var options = output.split(";");
		                      for (var i = 0; i < options.length; i++) {
		                    	  $("#permission" + (i+1)).prop("checked", false);
			                      if(options[i] == "true") $("#permission" + (i+1)).prop("checked", true);
		                      }
		                  }
			});
		});

		</script>
	</body>
</html>

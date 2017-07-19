<?php

// Getter und Setter Methoden

/*
 *	Sets the int in $spalte to $v in the settings database
*/
function setInt($con, $table, $spalte, $v) {
	$stmt = $con->prepare("update $table set $spalte = ?;");
	$stmt->bind_param("i", $v);
	$stmt->execute();
	$stmt->close();
}

/*
 *	Sets the string in $spalte to $v in the settings database
 */
function setString($con, $table, $spalte, $v) {
	$stmt = $con->prepare("update $table set $spalte = ?;");
	$stmt->bind_param("s", $v);
	$stmt->execute();
	$stmt->close();
}

function editPost($con, $id, $title, $text, $haspic) {
	$stmt = $con->prepare("update posts set title = ?, post = ?, haspic = ? where id = ?;");
	$stmt->bind_param("ssii", $title, $text, $haspic, $id);
	$stmt->execute();
	$stmt->close();
}

function post($con, $userid, $posttitle, $posttext, $haspic) {
	$stmt = $con->prepare("insert into posts(title, post, fk_author, haspic) values (?, ?, ?, ?);");
	$stmt->bind_param("ssii", $posttitle, $posttext, $userid, $haspic);
	$stmt->execute();
	$i = $stmt->insert_id;
	$stmt->close();
	return $i;
}

function editUser($con, $id, $username, $password, $changepw) {
	if($changepw) {
		$stmt = $con->prepare("update users set name = ?, password = ? where id = ?");
		$stmt->bind_param("ssi", $username, $password, $id);
		$stmt->execute();
		$stmt->close();
	} else {
		$stmt = $con->prepare("update users set name = ? where id = ?");
		$stmt->bind_param("si", $username, $id);
		$stmt->execute();
		$stmt->close();
	}
}

function giveUserPerms($con, $id, $permission) {
	
	$stmt = $con->prepare("insert into user_hat_permission (userid, permissionid) values (?, ?)");
	$stmt->bind_param("ii", $id, $permission);
	$stmt->execute();
	$stmt->close();
}

function removeUserPerms($con, $id, $permission) {

	$stmt = $con->prepare("delete from user_hat_permission where userid = ? and permissionid = ?");
	$stmt->bind_param("ii", $id, $permission);
	$stmt->execute();
	$stmt->close();
}

/*
 *	Returns $spalte from the settings database
 */
function getSetting($con, $spalte) {
	if($result = $con->query("select $spalte from settings;")) {
		$r = $result->fetch_array()[$spalte];
		$result->close();
		return $r;
	}
}

/*
 *	Echos shorted post text of all posts from the posts database
 */
function getPosts($con, $offset) {
	
	if ($result = $con->query("select * from getposts order by date desc limit 10 offset " . $offset)) {
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo '<div class="grey lighten-3" style="margin-top: 15px; padding: 15px; box-shadow: 1px 1px 2px gray;">';
					echo '<table>';
						echo '<thead>';
							echo '<tr>';
								echo '<th style="padding-top: 0px; padding-bottom: 0px"><span style="font-size: 20pt; color: black;"><a class="black-text" href="posts.php?id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a></span></th>';
							echo '</tr>';
							echo '<tr>';
								echo '<td><span style="font-size: 10pt;">' . $row['name'] . ' &bull; ' . date("d.m.Y h:m:s", strtotime($row['date'])) . '</span></td>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
							echo '<tr>';
								echo '<td>' . limit_text($row['post'], 5, $row['id']) . '</td>';
							echo '</tr>';
						echo '</tbody>';
					echo '</table>';
				echo '</div> ';
			}
		}
	}
}

/*
 *	Echos complete post text of one specific post from the posts database
 */
function getPost($id, $con) {
	
	$stmt = $con->prepare("select * from getposts where id = ?");
	$stmt->bind_param("i", $id);
	
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo '<div class="grey lighten-3" style="margin-top: 15px; padding: 15px; box-shadow: 1px 1px 2px gray;">';
					echo '<table>';
						echo '<thead>';
							echo '<tr>';
								echo '<th style="padding-top: 0px; padding-bottom: 0px"><span style="font-size: 20pt; color: black;"><a class="black-text" href="posts.php?id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a></span></th>';
							echo '</tr>';
							echo '<tr>';
								echo '<td><span style="font-size: 10pt;">' . $row['name'] . ' &bull; ' . date("d.m.Y h:m:s", strtotime($row['date'])) . '</span></td>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
						if($row['haspic'] == 1) {
							echo '<tr>';
								echo '<td>';
									echo '<div class="img">';
										echo '<img src="uploads/' . $id . '.png" width="auto" height="auto" />';
									echo '</div>';
								echo '</td>';
							echo '</tr>';
						}
							echo '<tr>';
								echo '<td>' . $row['post'] . '</td>';
							echo '</tr>';
						echo '</tbody>';
					echo '</table>';
				echo '</div> ';
			}
		} else {
			echo "<span style='color: red; font-size: 15pt;'>Dieser Post konnte nicht gefunden werden</span>";
		}
	}
	$stmt->close();
}

function getArchivePosts($con) {
	
		if ($result = $con->query("select * from getposts order by date desc limit 100 ")) {
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo '<div class="grey lighten-3 archive-item" style="margin-top: 15px; padding: 15px; box-shadow: 1px 1px 2px gray;">';
						echo '<table>';
							echo '<thead>';
								echo '<tr>';
									echo '<th style="padding-top: 0px; padding-bottom: 0px"><span style="font-size: 20pt; color: black;"><a class="black-text" href="posts.php?id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a></span></th>';
								echo '</tr>';
								echo '<tr>';
									echo '<td><span style="font-size: 10pt;">' . $row['name'] . ' &bull; ' . date("d.m.Y h:m:s", strtotime($row['date'])) . '</span></td>';
								echo '</tr>';
							echo '</thead>';
							echo '<tbody>';
								echo '<tr>';
									echo '<td>' . limit_text($row['post'], 5, $row['id']) . '</td>';
								echo '</tr>';
							echo '</tbody>';
						echo '</table>';
					echo '</div> ';
				}
			}
		}
	}

function deletePost($con, $id) {
	$stmt = $con->prepare("delete from posts where id = ?");
	$stmt->bind_param("i", $id);
	
	if ($stmt->execute()) {
		echo "success";
	} else {
		echo "failed";
	}
}

function deletePic($con, $id) {
	setInt($con, "posts", "haspic", 0);
	$file = "../uploads/" . $id . ".png";
	if (file_exists($file)) { 
		unlink($file);
		echo "success";
	} else {
		echo "failed";
	}
}

function deleteUser($con, $id) {
	$stmt = $con->prepare("delete from users where id = ?");
	$stmt->bind_param("i", $id);
	
	if ($stmt->execute()) {
		echo "success";
	} else {
		echo "failed";
	}
}

function getPostInfo($con, $id) {
	$stmt = $con->prepare("select title,post from getposts where id = ?");
	$stmt->bind_param("i", $id);
	
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo $row['title'] . ";" . $row['post'];
			}
		}
	}
}

function getUserInfo($con, $id) {
	$stmt = $con->prepare("select name from users where id = ?");
	$stmt->bind_param("i", $id);

	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo $row['name'];
			}
		}
	}
}

function getPostsAsOptions($con) {
	
	$stmt = $con->prepare("select id,title from getposts order by date desc");
	
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			$c = 0;
			while ($row = $result->fetch_assoc()) {
				$c++;
				echo "<option value='" . $row['id'] . " - " . $row['title'] . "'";
				if ($c == $result->num_rows) echo " selected";
				echo  ">" . $row['id'] . " - " . $row['title'] . "</option>";
				
			}
		} else {
			echo "<option>Keine Posts</option>";
		}
	}
}

function getUsersAsOptions($con) {

	$stmt = $con->prepare("select id,name from users order by id");

	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				echo "<option value='" . $row['id'] . " - " . $row['name'] . "'>" . $row['id'] . " - " . $row['name'] . "</option>";
			}
		} else {
			echo "<option>Keine User</option>";
		}
	}
}

function hasPermission($con, $userid, $permission) {
	if($userid != "1") {
		$stmt = $con->prepare("select permissionid from getpermissions where userid = ? and permissionid = ?");
		$stmt->bind_param("ii", $userid, $permission);
		
		if ($stmt->execute()) {
			$result = $stmt->get_result();
			if($result->num_rows > 0) {
				return true;
			} else {
				return false;
			}
		}
	} else {
		return true;
	}
}

function refreshUsername($con, $userid) {
	$stmt = $con->prepare("select name from users where id = ?");
	$stmt->bind_param("i", $userid);
	
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			return $row['name'];
		} else return null;
	}
}

function createUser($con, $username, $password) {
	
	$stmt = $con->prepare("select id from users where name = ?");
	$stmt->bind_param("s", $username);
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			$result->close();
			$stmt->close();
		} else {
			$result->close();
			$stmt->close();
			$stmt = $con->prepare("insert into users (name, password) values (?, ?)");
			$stmt->bind_param("ss", $username, $password);
			if ($stmt->execute()) {
					return true;
			}
		}
	}
	return false;
}



/*
 *	Returns given $text limited to $limit words with a redirect link to post with $id
 */
function limit_text($text, $limit, $id) {
	$text = strip_tags($text);
	if (str_word_count($text, 0) > $limit) {
		$words = str_word_count($text, 2);
		$pos = array_keys($words);
		$text = substr($text, 0, $pos[$limit]) . '...&nbsp;&nbsp; <a href="posts.php?id=' . $id . '">weiterlesen</a>';
	}
	return $text;
}

/*
 *	Creates session for user if credentials are correct, otherwise redirects to fail loginpage
 */
function login($con, $username, $password) {
	$stmt = $con->prepare("select id from users where name = ? and password = ?");
	$stmt->bind_param("ss", $username, $password);
	
	$result = $stmt->execute();
	$res = $stmt->get_result();
	$row = $res->fetch_assoc();
	$id = $row["id"];
	$c = $res->num_rows;
	$stmt->close();
	
	if($c > 0) {
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['permission'] = $permission;
		$_SESSION['userid'] = $id;
		header("Location: dashboard.php");
	} else {
		header("Location: login.php?s=0");
	}
}

/*
	0 = login failed
	1 = not logged in
	2 = succ logged out
*/
function log_status($s) {
	switch($s) {
		case 0:
			echo "<span style='color: red; font-size: 12pt;'>Login fehlgeschlagen</span>";
			break;
		case 1:
			echo "<span style='color: red; font-size: 12pt;'>Nicht eingeloggt!</span>";
			break;
		case 2:
			echo "<span style='color: green; font-size: 12pt;'>Erfolgreich ausgeloggt</span>";
			break;
	}
}

function search($con, $q) {
	$q = "%" . $q . "%";
	$stmt = $con->prepare("select * from getposts where title like ? or post like ? or name like ? or date = ?");
	$stmt->bind_param("ssss", $q, $q, $q, $q);
	if ($stmt->execute()) {
		$result = $stmt->get_result();
		if($result->num_rows > 0) {
			echo "<p>" . $result->num_rows . " Treffer.</p>";
			while ($row = $result->fetch_assoc()) {
				echo '<div class="grey lighten-3" style="margin-top: 15px; padding: 15px; box-shadow: 1px 1px 2px gray;">';
					echo '<table>';
						echo '<thead>';
							echo '<tr>';
								echo '<th style="padding-top: 0px; padding-bottom: 0px"><span style="font-size: 20pt; color: black;"><a class="black-text" href="posts.php?id=' . $row['id'] . '"><b>' . $row['title'] . '</b></a></span></th>';
							echo '</tr>';
							echo '<tr>';
								echo '<td><span style="font-size: 10pt;">' . $row['name'] . ' &bull; ' . date("d.m.Y h:m:s", strtotime($row['date'])) . '</span></td>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
							echo '<tr>';
								echo '<td>' . limit_text($row['post'], 5, $row['id']) . '</td>';
							echo '</tr>';
						echo '</tbody>';
					echo '</table>';
				echo '</div> ';
			}
		} else {
			echo "<span stlye='color: red'>Keine Treffer!</span>";
		}
	}
}









?>
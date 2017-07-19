<?php 

	require("../lib/blog_lib.php");
	require("../lib/mysql_lib.php");
	
	$mysql = new mysql_lib();
	
	$mysql->connectToDatabase();

	if(isset($_POST['postid'])) {
		deletePost($mysql->getConnection(), $_POST['postid']);
	} else if(isset($_POST['picid'])) {
		deletePic($mysql->getConnection(), $_POST['picid']);
	} else if(isset($_POST['userid'])) {
		deleteUser($mysql->getConnection(), $_POST['userid']);
	}
?>